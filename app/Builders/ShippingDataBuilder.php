<?php

namespace App\Builders;

use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\DimensionsData;
use App\DataTransferObjects\ShippingData;
use App\Models\User;

class ShippingDataBuilder
{
    public static function fromCreateShippingRequest(array $data, User $authUser): ShippingData
    {
        return new ShippingData(
            from: self::buildFromAddress($authUser),
            to: self::buildToAddress($data),
            dimensions: self::buildDimensions($data),
        );
    }

    private static function buildFromAddress(User $authUser): AddressData
    {
        return new AddressData(
            name: $authUser->name,
            street: $authUser->street,
            city: $authUser->city,
            state: $authUser->state,
            zip: $authUser->zip,
            country: $authUser->country,
            phone: $authUser->phone,
            email: $authUser->email,
        );
    }

    private static function buildToAddress(array $data): AddressData
    {
        return new AddressData(
            name: $data['name'],
            street: $data['street'],
            city: $data['city'],
            state: mb_strtoupper($data['state']),
            zip: $data['zip'],
            country: mb_strtoupper($data['country']),
            phone: preg_replace('/\D/', '', $data['phone']),
            email: $data['email'],
        );
    }

    private static function buildDimensions(array $data): DimensionsData
    {
        return new DimensionsData(
            weight: $data['weight'],
            length: $data['length'],
            width: $data['width'],
            height: $data['height'],
        );
    }
}
