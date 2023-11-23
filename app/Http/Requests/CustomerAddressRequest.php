<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressRequest extends FormRequest
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
            'full_name' => ['required', 'string'],
            'phone' => ['required_without:email', 'string', 'nullable'],
            'email' => ['required_without:phone', 'email', 'nullable'],
            'address_name' => ['required', 'string'],
            'address_line_1' => ['required', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'region' => ['required', 'string'],
            'zip' => ['required', 'string'],
            'country_id' => ['required', 'exists:countries,id'],
        ];
    }
}
