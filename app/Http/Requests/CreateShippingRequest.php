<?php

namespace App\Http\Requests;

use App\Builders\ShippingDataBuilder;
use App\Concerns\ShippingValidationRules;
use App\DataTransferObjects\ShippingData;
use Illuminate\Foundation\Http\FormRequest;

class CreateShippingRequest extends FormRequest
{
    use ShippingValidationRules;

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
        return $this->shippingRules();
    }

    public function toShippingData(): ShippingData
    {
        return ShippingDataBuilder::fromCreateShippingRequest(
            data: $this->validated(),
            authUser: $this->user(),
        );
    }
}
