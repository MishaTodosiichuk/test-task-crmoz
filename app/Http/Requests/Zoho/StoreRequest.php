<?php

namespace App\Http\Requests\Zoho;

use App\Enums\Stage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deal_name' => ['required', 'string', 'max:255'],
            'stage' => ['required', new Enum(Stage::class)],
            'account_name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/']
        ];
    }
}
