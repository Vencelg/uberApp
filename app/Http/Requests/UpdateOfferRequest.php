<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'start' => 'string|max:255',
            'finish' => 'string|max:255',
            'price' => 'int',
            'space' => 'int',
            'departure' => 'date|after_or_equal:today|date_format:Y-m-d\TH:i',
        ];
    }
}
