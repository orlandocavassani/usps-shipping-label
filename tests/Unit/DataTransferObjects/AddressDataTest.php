<?php

use App\DataTransferObjects\AddressData;

test('address data can be instantiated with all properties', function () {
    $address = new AddressData(
        name: 'John Doe',
        street: '123 Main St',
        city: 'New York',
        state: 'NY',
        zip: '10001',
        country: 'US',
        phone: '1234567890',
        email: 'john@example.com'
    );

    expect($address->name)->toBe('John Doe');
    expect($address->street)->toBe('123 Main St');
    expect($address->city)->toBe('New York');
    expect($address->state)->toBe('NY');
    expect($address->zip)->toBe('10001');
    expect($address->country)->toBe('US');
    expect($address->phone)->toBe('1234567890');
    expect($address->email)->toBe('john@example.com');
});

test('address data properties are readonly', function () {
    $address = new AddressData(
        name: 'John Doe',
        street: '123 Main St',
        city: 'New York',
        state: 'NY',
        zip: '10001',
        country: 'US',
        phone: '1234567890',
        email: 'john@example.com'
    );

    expect(fn () => $address->name = 'Jane Doe')
        ->toThrow(Error::class);
});
