<?php

namespace App\Label;

use App\DataTransferObjects\ShippingData;

interface Generator
{
    public function generate(ShippingData $shippingData): string;
}
