<?php

namespace App\Repositories;

use App\DataTransferObjects\ShippingData;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Collection;

class ShippingRepository
{
    public function all(): Collection
    {
        return Shipping::latest()->get();
    }

    public function create(int $authUserId, ShippingData $shippingData, string $labelUrl): bool
    {
        $shipping = Shipping::create([
            'user_id' => $authUserId,
            'name' => $shippingData->to->name,
            'street' => $shippingData->to->street,
            'city' => $shippingData->to->city,
            'state' => $shippingData->to->state,
            'zip' => $shippingData->to->zip,
            'country' => $shippingData->to->country,
            'phone' => $shippingData->to->phone,
            'email' => $shippingData->to->email,
            'length' => $shippingData->dimensions->length,
            'width' => $shippingData->dimensions->width,
            'height' => $shippingData->dimensions->height,
            'weight' => $shippingData->dimensions->weight,
            'label_url' => $labelUrl,
        ]);

        return (bool) $shipping->id;
    }
}
