<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'minPrice' => 'required|numeric|min:0|max:10000',
            'maxPrice' => 'required|numeric|min:0|max:10000',
            'minReviews' => 'required|numeric|min:0|max:1000',
            'maxReviews' => 'required|numeric|min:0|max:1000',
            'minDate' => 'required|date_format:d/m/Y',
            'maxDate' => 'required|date_format:d/m/Y',
        ];
    }
}
