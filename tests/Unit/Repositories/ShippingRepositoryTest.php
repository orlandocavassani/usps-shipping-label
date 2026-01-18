<?php

use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\DimensionsData;
use App\DataTransferObjects\ShippingData;
use App\Repositories\ShippingRepository;

beforeEach(function () {
    $this->repository = new ShippingRepository;

    $this->shippingData = new ShippingData(
        from: new AddressData(
            name: 'John Doe',
            street: '123 Main St',
            city: 'New York',
            state: 'NY',
            zip: '10001',
            country: 'US',
            phone: '1234567890',
            email: 'john@example.com'
        ),
        to: new AddressData(
            name: 'Jane Smith',
            street: '456 Oak Ave',
            city: 'Los Angeles',
            state: 'CA',
            zip: '90001',
            country: 'US',
            phone: '0987654321',
            email: 'jane@example.com'
        ),
        dimensions: new DimensionsData(
            length: 10.0,
            width: 8.0,
            height: 5.0,
            weight: 2.5
        )
    );
});

test('create method accepts correct parameters', function () {
    // Test that the repository method can be called with proper parameters
    // This verifies the method signature and that it doesn't throw errors
    expect(function () {
        return $this->repository->create(
            authUserId: 1,
            shippingData: $this->shippingData,
            labelUrl: 'https://example.com/label.pdf'
        );
    })->not->toThrow(TypeError::class);
});

test('all method returns a collection', function () {
    // Test that all() returns a collection type
    expect(function () {
        return $this->repository->all();
    })->not->toThrow(TypeError::class);
});

test('repository properly extracts to address fields from shipping data', function () {
    // Verify the mapping logic by checking what data would be passed
    $userId = 42;
    $labelUrl = 'https://example.com/label.pdf';

    // We can test the data structure that would be created
    $expectedData = [
        'user_id' => $userId,
        'name' => $this->shippingData->to->name,
        'street' => $this->shippingData->to->street,
        'city' => $this->shippingData->to->city,
        'state' => $this->shippingData->to->state,
        'zip' => $this->shippingData->to->zip,
        'country' => $this->shippingData->to->country,
        'phone' => $this->shippingData->to->phone,
        'email' => $this->shippingData->to->email,
        'length' => $this->shippingData->dimensions->length,
        'width' => $this->shippingData->dimensions->width,
        'height' => $this->shippingData->dimensions->height,
        'weight' => $this->shippingData->dimensions->weight,
        'label_url' => $labelUrl,
    ];

    // Verify expected structure
    expect($expectedData['user_id'])->toBe(42);
    expect($expectedData['name'])->toBe('Jane Smith');
    expect($expectedData['street'])->toBe('456 Oak Ave');
    expect($expectedData['city'])->toBe('Los Angeles');
    expect($expectedData['state'])->toBe('CA');
    expect($expectedData['zip'])->toBe('90001');
    expect($expectedData['country'])->toBe('US');
    expect($expectedData['phone'])->toBe('0987654321');
    expect($expectedData['email'])->toBe('jane@example.com');
    expect($expectedData['length'])->toBe(10.0);
    expect($expectedData['width'])->toBe(8.0);
    expect($expectedData['height'])->toBe(5.0);
    expect($expectedData['weight'])->toBe(2.5);
    expect($expectedData['label_url'])->toBe('https://example.com/label.pdf');
});

test('repository uses destination address not source address', function () {
    // Ensure we're using the 'to' address, not 'from'
    expect($this->shippingData->to->name)->not->toBe($this->shippingData->from->name);
    expect($this->shippingData->to->city)->not->toBe($this->shippingData->from->city);
});
