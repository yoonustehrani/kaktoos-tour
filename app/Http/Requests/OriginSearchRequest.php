<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OriginSearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'term' => ['string', 'max:20', 'min:3'],
            'limit' => ['numeric', 'min:1', 'max:50']
        ];
    }
}
