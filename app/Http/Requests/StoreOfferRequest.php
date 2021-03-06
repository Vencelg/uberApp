<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start' => 'required|string|max:255',
            'finish' => 'required|string|max:255',
            'price' => 'required|int',
            'space' => 'required|int',
            'departure' => 'required|date|after_or_equal:today|date_format:Y-m-d\TH:i',
        ];
    }
}
