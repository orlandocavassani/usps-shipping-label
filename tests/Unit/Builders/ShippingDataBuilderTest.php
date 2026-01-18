<?php

use App\Builders\ShippingDataBuilder;
use App\DataTransferObjects\ShippingData;
use App\Models\User;

test('fromCreateShippingRequest builds shipping data correctly', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'street' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '10001',
        'country' => 'US',
        'phone' => '1234567890',
    ]);

    $requestData = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'street' => '456 Oak Ave',
        'city' => 'Los Angeles',
        'state' => 'ca',
        'zip' => '90001',
        'country' => 'us',
        'phone' => '(098) 765-4321',
        'length' => 10.0,
        'width' => 8.0,
        'height' => 5.0,
        'weight' => 2.5,
    ];

    $shippingData = ShippingDataBuilder::fromCreateShippingRequest($requestData, $user);

    expect($shippingData)->toBeInstanceOf(ShippingData::class);

    // Verify from address (user data)
    expect($shippingData->from->name)->toBe('John Doe');
    expect($shippingData->from->email)->toBe('john@example.com');
    expect($shippingData->from->street)->toBe('123 Main St');
    expect($shippingData->from->city)->toBe('New York');
    expect($shippingData->from->state)->toBe('NY');
    expect($shippingData->from->zip)->toBe('10001');
    expect($shippingData->from->country)->toBe('US');
    expect($shippingData->from->phone)->toBe('1234567890');

    // Verify to address (request data)
    expect($shippingData->to->name)->toBe('Jane Smith');
    expect($shippingData->to->email)->toBe('jane@example.com');
    expect($shippingData->to->street)->toBe('456 Oak Ave');
    expect($shippingData->to->city)->toBe('Los Angeles');
    expect($shippingData->to->state)->toBe('CA'); // Should be uppercase
    expect($shippingData->to->zip)->toBe('90001');
    expect($shippingData->to->country)->toBe('US'); // Should be uppercase
    expect($shippingData->to->phone)->toBe('0987654321'); // Should remove non-digits

    // Verify dimensions
    expect($shippingData->dimensions->length)->toBe(10.0);
    expect($shippingData->dimensions->width)->toBe(8.0);
    expect($shippingData->dimensions->height)->toBe(5.0);
    expect($shippingData->dimensions->weight)->toBe(2.5);
});

test('phone number is sanitized correctly', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'street' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '10001',
        'country' => 'US',
        'phone' => '1234567890',
    ]);

    $requestData = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'street' => '456 Oak Ave',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'zip' => '90001',
        'country' => 'US',
        'phone' => '+1 (555) 123-4567',
        'length' => 10.0,
        'width' => 8.0,
        'height' => 5.0,
        'weight' => 2.5,
    ];

    $shippingData = ShippingDataBuilder::fromCreateShippingRequest($requestData, $user);

    expect($shippingData->to->phone)->toBe('15551234567');
});

test('state and country are converted to uppercase', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'street' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '10001',
        'country' => 'US',
        'phone' => '1234567890',
    ]);

    $requestData = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'street' => '456 Oak Ave',
        'city' => 'Los Angeles',
        'state' => 'tx',
        'zip' => '90001',
        'country' => 'br',
        'phone' => '1234567890',
        'length' => 10.0,
        'width' => 8.0,
        'height' => 5.0,
        'weight' => 2.5,
    ];

    $shippingData = ShippingDataBuilder::fromCreateShippingRequest($requestData, $user);

    expect($shippingData->to->state)->toBe('TX');
    expect($shippingData->to->country)->toBe('BR');
});
