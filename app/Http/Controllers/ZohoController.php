<?php

namespace App\Http\Controllers;

use App\Exceptions\ZohoException;
use App\Http\Requests\Zoho\StoreRequest;
use App\Services\ZohoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ZohoController extends Controller
{
    public function store(StoreRequest $request, ZohoService $zohoService): JsonResponse
    {
        try {
            $result = $zohoService->createAccountAndDeal($request->validated());

            return response()->json([
                'message' => 'Угоду та Обліковий запис успішно створено у Zoho CRM!',
                'data' => $result
            ], 201);
        } catch (ZohoException $e) {
            Log::error('Zoho CRM Integration Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Не вдалося створити записи у Zoho CRM. Спробуйте пізніше.'
            ], 500);
        }
    }
}
