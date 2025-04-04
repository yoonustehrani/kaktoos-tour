<?php

namespace App\Http\Requests;

use App\Enums\TourSearchOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourSearchRequest extends FormRequest
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
            'origins' => 'nullable|array|min:1',
            'origins.*' => 'integer|gte:1',
            'destinations' => 'nullable|array|min:1',
            'destinations.*' => 'integer|gte:1',
            'countries' => 'missing_with:destinations|nullable|array|min:1',
            'countries.*' => 'regex:/[A-Z]{2}/',
            'start_date' => ['date', 'after:today', Rule::date()->format('Y-m-d')],
            'end_date' => ['date', 'after:start_date', Rule::date()->format('Y-m-d')],
            'per_page' => ['required', 'integer', Rule::in([10, 20, 50])],
            'order_by' => ['string', Rule::enum(TourSearchOrder::class)],
            'sort' => ['string', Rule::in('asc', 'desc')],
            'term' => ['string', 'min:3', 'max:30'],
            'min_price' => ['integer', 'min_digits:5', 'max_digits:10'],
            'max_price' => ['integer', 'min_digits:5', 'max_digits:10'],
            'nights' => 'nullable|numeric|min:1|max:20',
            // 'nights' => 'nullable|array|min:1',
            // 'nights.*' => ['integer', 'min:1', 'max:20']
        ];
    }
}
