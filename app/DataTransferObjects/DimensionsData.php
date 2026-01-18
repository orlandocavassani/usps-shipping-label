<?php

namespace App\DataTransferObjects;

class DimensionsData
{
    public function __construct(
        public readonly float $length,
        public readonly float $width,
        public readonly float $height,
        public readonly float $weight,
    ) {}
}
