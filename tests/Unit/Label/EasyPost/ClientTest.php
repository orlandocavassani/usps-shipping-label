<?php

use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\DimensionsData;
use App\DataTransferObjects\ShippingData;
use App\Label\EasyPost\Client;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new Client(
        apiUrl: 'https://api.easypost.com/v2/shipments',
        apiKey: 'test_api_key',
        service: 'USPS_PRIORITY',
        carrierAccounts: ['ca_123456']
    );

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

test('generate sends correct request to easypost api', function () {
    Http::fake([
        'https://api.easypost.com/v2/shipments' => Http::response([
            'postage_label' => [
                'label_url' => 'https://example.com/label.pdf',
            ],
        ], 200),
    ]);

    $labelUrl = $this->client->generate($this->shippingData);

    expect($labelUrl)->toBe('https://example.com/label.pdf');

    Http::assertSent(function ($request) {
        $body = $request->data();

        return $request->url() === 'https://api.easypost.com/v2/shipments'
            && $request->hasHeader('Authorization')
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json')
            && $body['shipment']['to_address']['name'] === 'Jane Smith'
            && $body['shipment']['from_address']['name'] === 'John Doe'
            && $body['shipment']['parcel']['weight'] === 2.5
            && $body['shipment']['service'] === 'USPS_PRIORITY'
            && $body['shipment']['carrier_accounts'] === ['ca_123456'];
    });
});

test('generate returns empty string when label url is missing', function () {
    Http::fake([
        'https://api.easypost.com/v2/shipments' => Http::response([
            'postage_label' => [],
        ], 200),
    ]);

    $labelUrl = $this->client->generate($this->shippingData);

    expect($labelUrl)->toBe('');
});

test('generate returns empty string when postage label is missing', function () {
    Http::fake([
        'https://api.easypost.com/v2/shipments' => Http::response([], 200),
    ]);

    $labelUrl = $this->client->generate($this->shippingData);

    expect($labelUrl)->toBe('');
});

test('generate includes all address fields in request', function () {
    Http::fake([
        'https://api.easypost.com/v2/shipments' => Http::response([
            'postage_label' => [
                'label_url' => 'https://example.com/label.pdf',
            ],
        ], 200),
    ]);

    $this->client->generate($this->shippingData);

    Http::assertSent(function ($request) {
        $body = $request->data();
        $toAddress = $body['shipment']['to_address'];
        $fromAddress = $body['shipment']['from_address'];

        return $toAddress['name'] === 'Jane Smith'
            && $toAddress['street1'] === '456 Oak Ave'
            && $toAddress['city'] === 'Los Angeles'
            && $toAddress['state'] === 'CA'
            && $toAddress['zip'] === '90001'
            && $toAddress['country'] === 'US'
            && $toAddress['phone'] === '0987654321'
            && $toAddress['email'] === 'jane@example.com'
            && $fromAddress['name'] === 'John Doe'
            && $fromAddress['street1'] === '123 Main St'
            && $fromAddress['city'] === 'New York'
            && $fromAddress['state'] === 'NY'
            && $fromAddress['zip'] === '10001'
            && $fromAddress['country'] === 'US'
            && $fromAddress['phone'] === '1234567890'
            && $fromAddress['email'] === 'john@example.com';
    });
});

test('generate includes all dimension fields in request', function () {
    Http::fake([
        'https://api.easypost.com/v2/shipments' => Http::response([
            'postage_label' => [
                'label_url' => 'https://example.com/label.pdf',
            ],
        ], 200),
    ]);

    $this->client->generate($this->shippingData);

    Http::assertSent(function ($request) {
        $body = $request->data();
        $parcel = $body['shipment']['parcel'];

        return $parcel['length'] === 10.0
            && $parcel['width'] === 8.0
            && $parcel['height'] === 5.0
            && $parcel['weight'] === 2.5;
    });
});
