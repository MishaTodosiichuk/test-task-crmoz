<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Exceptions\ZohoException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZohoService
{
    private string $clientId;
    private string $clientSecret;
    private string $refreshToken;
    private string $accountsUrl;
    private string $apiBaseUrl;

    public function __construct()
    {
        $this->clientId = config('services.zoho.client_id');
        $this->clientSecret = config('services.zoho.client_secret');
        $this->refreshToken = config('services.zoho.refresh_token');
        $this->accountsUrl = config('services.zoho.accounts_url');
        $this->apiBaseUrl = config('services.zoho.api_base_url');
    }

    public function createAccountAndDeal(array $data): array
    {
        $accountId = $this->createAccount($data);

        $dealId = $this->createDeal($accountId, $data);

        return [
            'account_id' => $accountId,
            'deal_id' => $dealId,
        ];
    }

    private function createAccount(array $data): string
    {
        $record = $this->createRecord('Accounts', [
            'Account_Name' => $data['account_name'],
            'Website' => $data['website'] ?? null,
            'Phone' => $data['phone'] ?? null,
        ]);

        return $record['details']['id'];
    }

    private function createDeal(string $accountId, array $data): string
    {
        $record = $this->createRecord('Deals', [
            'Deal_Name' => $data['deal_name'],
            'Stage' => $data['stage'],
            'Account_Name' => [
                'id' => $accountId,
            ],
        ]);

        return $record['details']['id'];
    }

    private function createRecord(string $module, array $payload): array
    {
        $response = $this->client()
            ->post("{$this->apiBaseUrl}/{$module}", [
                'data' => [$payload],
            ])
            ->throw();

        $record = $response->json('data.0');

        if (empty($record) || ($record['status'] ?? null) !== 'success') {
            throw new ZohoException(
                "Failed to create {$module}: {$response->body()}"
            );
        }

        return $record;
    }

    private function client(): PendingRequest
    {
        return Http::withToken($this->getAccessToken())
            ->acceptJson()
            ->connectTimeout(10)
            ->timeout(20)
            ->retry(3, 500);
    }

    private function getAccessToken(): string
    {
        if (Cache::has(CacheEnum::CACHE_KEY->value)) {
            return Cache::get(CacheEnum::CACHE_KEY->value);
        }

        $response = Http::asForm()
            ->acceptJson()
            ->connectTimeout(10)
            ->timeout(20)
            ->retry(3, 500)
            ->post("{$this->accountsUrl}/oauth/v2/token", [
                'refresh_token' => $this->refreshToken,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'refresh_token',
            ])
            ->throw();

        $token = $response->json('access_token');

        if (!$token) {
            throw new ZohoException('Zoho did not return access token.');
        }

        $expires = max(
            60,
            (int) $response->json('expires_in', 3600) - CacheEnum::TOKEN_BUFFER
        );

        Cache::put(
            CacheEnum::CACHE_KEY->value,
            $token,
            now()->addSeconds($expires)
        );

        return $token;
    }
}
