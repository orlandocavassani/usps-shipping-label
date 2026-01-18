<?php

namespace App\Label\EasyPost;

use App\DataTransferObjects\ShippingData;
use App\Label\Generator;
use Illuminate\Support\Facades\Http;

class Client implements Generator
{
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
        private string $service,
        private array $carrierAccounts,
    ) {}

    public function generate(ShippingData $shippingData): string
    {
        $response = Http::withBasicAuth($this->apiKey, '')
            ->acceptJson()
            ->contentType('application/json')
            ->post($this->apiUrl, [
                'shipment' => [
                    'to_address' => [
                        'name' => $shippingData->to->name,
                        'street1' => $shippingData->to->street,
                        'city' => $shippingData->to->city,
                        'state' => $shippingData->to->state,
                        'zip' => $shippingData->to->zip,
                        'country' => $shippingData->to->country,
                        'phone' => $shippingData->to->phone,
                        'email' => $shippingData->to->email,
                    ],
                    'from_address' => [
                        'name' => $shippingData->from->name,
                        'street1' => $shippingData->from->street,
                        'city' => $shippingData->from->city,
                        'state' => $shippingData->from->state,
                        'zip' => $shippingData->from->zip,
                        'country' => $shippingData->from->country,
                        'phone' => $shippingData->from->phone,
                        'email' => $shippingData->from->email,
                    ],
                    'parcel' => [
                        'length' => $shippingData->dimensions->length,
                        'width' => $shippingData->dimensions->width,
                        'height' => $shippingData->dimensions->height,
                        'weight' => $shippingData->dimensions->weight,
                    ],
                    'service' => $this->service,
                    'carrier_accounts' => $this->carrierAccounts,
                ],
            ]);

        return json_decode($response->body(), true)['postage_label']['label_url'] ?? '';
    }
}
