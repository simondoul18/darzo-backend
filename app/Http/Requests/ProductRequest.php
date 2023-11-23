<?php

namespace App\Http\Requests;

use App\Http\ApiResponseBuilder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['string'],
            'categories' => ['array', 'required', 'min:1'],
            'categories.*.value' => ['exists:product_categories,id', 'required', 'min:1'],
            'quantity' => ['numeric'],
            'sku' => ['string'],
            'attributes' => ['array'],
            'attributes.color' => ['required', 'string'],
            'attributes.weight' => ['required', 'numeric'],
            'custom_attributes' => ['array'],
            'custom_attributes.*.name' => ['required', 'string'],
            'custom_attributes.*.value' => ['required', 'string'],
            'tags' => ['array'],
            'tags.*.value' => ['numeric'],
            'sell_on_crm' => ['boolean'],
            'sell_on_marketplace' => ['boolean'],
            'price' => ['numeric', 'required'],
            'currency_id' => ['exists:currencies,id'],
            'images' => ['array', 'min:1'],
            'images.*.url' => ['url', 'required'],
            'images.*.name' => ['string', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'categories.min' => 'Categories must have atleast one item.',
            'attributes.color.required' => 'The color field is required',
            'attributes.weight.required' => 'The weight field is required.',
            'custom_attributes.*.name' => 'All the custom fields are required.',
            'custom_attributes.*.value' => 'All the custom fields are required.',
            'currency_id.exists' => 'Currency must be selected from list.',
            'images.*.url' => 'Image must be a valid image URL.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponseBuilder::asError(421)->withMessage($validator->errors()->first())->withData($validator->errors())->build());
    }
}
