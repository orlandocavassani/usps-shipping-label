<?php

namespace App\DataTransferObjects;

class ShippingData
{
    public function __construct(
        public readonly AddressData $from,
        public readonly AddressData $to,
        public readonly DimensionsData $dimensions,
    ) {}
}
