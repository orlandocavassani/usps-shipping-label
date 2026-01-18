<?php

namespace App\Actions;

use App\DataTransferObjects\ShippingData;
use App\Label\Generator as LabelGenerator;
use App\Models\Shipping;
use App\Repositories\ShippingRepository;

class CreateShipping
{
    public function __construct(
        private LabelGenerator $labelGenerator,
        private ShippingRepository $shippingRepository,
    ) {}

    /**
     * Validate and create a new shipping record.
     *
     * @param  array<string, string>  $input
     */
    public function create(int $userId, ShippingData $shippingData): bool
    {
        $labelUrl = $this->labelGenerator->generate($shippingData);

        return $this->shippingRepository->create($userId, $shippingData, $labelUrl);
    }
}
