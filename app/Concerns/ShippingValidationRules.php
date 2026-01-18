<?php

namespace App\Concerns;

trait ShippingValidationRules
{
    /**
     * Get the validation rules used to validate shipping information.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>>
     */
    protected function shippingRules(): array
    {
        return [
            'name' => $this->stringRules(),
            'street' => $this->stringRules(),
            'city' => $this->stringRules(),
            'state' => $this->stringRules('2'),
            'zip' => $this->stringRules('10'),
            'country' => $this->countryRules(),
            'phone' => $this->phoneRules(),
            'email' => $this->emailRules(),
            'length' => $this->dimensionRules(),
            'width' => $this->dimensionRules(),
            'height' => $this->dimensionRules(),
            'weight' => $this->weightRules(),
        ];
    }

    /**
     * Get the validation rules used to validate string fields.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function stringRules(string $max = '255'): array
    {
        return ['required', 'string', "max:$max"];
    }

    /**
     * Get the validation rules used to validate phone numbers.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function phoneRules(): array
    {
        return ['required', 'string', 'max:20'];
    }

    /**
     * Get the validation rules used to validate email addresses.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function emailRules(): array
    {
        return ['required', 'string', 'email', 'max:255'];
    }

    /**
     * Get the validation rules used to validate package dimensions.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function dimensionRules(): array
    {
        return ['required', 'numeric', 'min:0.1', 'max:999.99'];
    }

    /**
     * Get the validation rules used to validate package weight.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function weightRules(): array
    {
        return ['required', 'numeric', 'min:0.01', 'max:999.99'];
    }

    /**
     * Get the validation rules used to validate country.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function countryRules(): array
    {
        return ['required', 'string', 'size:2'];
    }
}
