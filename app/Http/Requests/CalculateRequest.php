<?php

namespace App\Http\Requests;

use App\Traits\Sanitise;
use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
{
    use Sanitise;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $this->replace($this->sanitise($this->all()));

        return [
            'currency_select_a' => "required",
            'currency_select_b' => "required",
            'currency_value_a' =>  "required|regex:/^\d*(\.\d{1,2})?$/",
            'currency_value_b' =>  "required|regex:/^\d*(\.\d{1,2})?$/",
        ];
    }
}
