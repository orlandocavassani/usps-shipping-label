<?php

use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\DimensionsData;
use App\DataTransferObjects\ShippingData;

test('shipping data can be instantiated with all properties', function () {
    $from = new AddressData(
        name: 'John Doe',
        street: '123 Main St',
        city: 'New York',
        state: 'NY',
        zip: '10001',
        country: 'US',
        phone: '1234567890',
        email: 'john@example.com'
    );

    $to = new AddressData(
        name: 'Jane Smith',
        street: '456 Oak Ave',
        city: 'Los Angeles',
        state: 'CA',
        zip: '90001',
        country: 'US',
        phone: '0987654321',
        email: 'jane@example.com'
    );

    $dimensions = new DimensionsData(
        length: 10.0,
        width: 8.0,
        height: 5.0,
        weight: 2.5
    );

    $shippingData = new ShippingData(
        from: $from,
        to: $to,
        dimensions: $dimensions
    );

    expect($shippingData->from)->toBe($from);
    expect($shippingData->to)->toBe($to);
    expect($shippingData->dimensions)->toBe($dimensions);
});

test('shipping data properties are readonly', function () {
    $from = new AddressData(
        name: 'John Doe',
        street: '123 Main St',
        city: 'New York',
        state: 'NY',
        zip: '10001',
        country: 'US',
        phone: '1234567890',
        email: 'john@example.com'
    );

    $to = new AddressData(
        name: 'Jane Smith',
        street: '456 Oak Ave',
        city: 'Los Angeles',
        state: 'CA',
        zip: '90001',
        country: 'US',
        phone: '0987654321',
        email: 'jane@example.com'
    );

    $dimensions = new DimensionsData(
        length: 10.0,
        width: 8.0,
        height: 5.0,
        weight: 2.5
    );

    $shippingData = new ShippingData(
        from: $from,
        to: $to,
        dimensions: $dimensions
    );

    expect(fn () => $shippingData->from = $to)
        ->toThrow(Error::class);
});
