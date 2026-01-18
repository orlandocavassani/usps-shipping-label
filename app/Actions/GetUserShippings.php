<?php

namespace App\Actions;

use App\Models\Shipping;
use App\Repositories\ShippingRepository;
use Illuminate\Database\Eloquent\Collection;

class GetUserShippings
{
    public function __construct(
        private ShippingRepository $shippingRepository,
    ) {}

    /**
     * Get all shipping records for the authenticated user.
     *
     * @return Collection<int, \App\Models\Shipping>
     */
    public function get(): Collection
    {
        return $this->shippingRepository->all();
    }
}
