<?php

use App\Actions\CreateShipping;
use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\DimensionsData;
use App\DataTransferObjects\ShippingData;
use App\Label\Generator as LabelGenerator;
use App\Repositories\ShippingRepository;

beforeEach(function () {
    $this->labelGenerator = Mockery::mock(LabelGenerator::class);
    $this->shippingRepository = Mockery::mock(ShippingRepository::class);
    $this->createShipping = new CreateShipping(
        $this->labelGenerator,
        $this->shippingRepository
    );
});

afterEach(function () {
    Mockery::close();
});

test('create shipping generates label and stores data', function () {
    $userId = 1;
    $shippingData = new ShippingData(
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

    $expectedLabelUrl = 'https://example.com/label.pdf';

    $this->labelGenerator
        ->shouldReceive('generate')
        ->once()
        ->with($shippingData)
        ->andReturn($expectedLabelUrl);

    $this->shippingRepository
        ->shouldReceive('create')
        ->once()
        ->with($userId, $shippingData, $expectedLabelUrl)
        ->andReturn(true);

    $result = $this->createShipping->create($userId, $shippingData);

    expect($result)->toBeTrue();
});

test('create shipping returns false when repository fails', function () {
    $userId = 1;
    $shippingData = new ShippingData(
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

    $this->labelGenerator
        ->shouldReceive('generate')
        ->once()
        ->andReturn('https://example.com/label.pdf');

    $this->shippingRepository
        ->shouldReceive('create')
        ->once()
        ->andReturn(false);

    $result = $this->createShipping->create($userId, $shippingData);

    expect($result)->toBeFalse();
});
