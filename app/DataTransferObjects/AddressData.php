<?php

namespace App\DataTransferObjects;

class AddressData
{
    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $city,
        public readonly string $state,
        public readonly string $zip,
        public readonly string $country,
        public readonly string $phone,
        public readonly string $email,
    ) {}
}
