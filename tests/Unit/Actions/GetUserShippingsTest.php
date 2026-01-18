<?php

use App\Actions\GetUserShippings;
use App\Models\Shipping;
use App\Repositories\ShippingRepository;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->shippingRepository = Mockery::mock(ShippingRepository::class);
    $this->getUserShippings = new GetUserShippings($this->shippingRepository);
});

afterEach(function () {
    Mockery::close();
});

test('get returns all shippings from repository', function () {
    $shippings = new Collection([
        Mockery::mock(Shipping::class),
        Mockery::mock(Shipping::class),
        Mockery::mock(Shipping::class),
    ]);

    $this->shippingRepository
        ->shouldReceive('all')
        ->once()
        ->andReturn($shippings);

    $result = $this->getUserShippings->get();

    expect($result)->toBe($shippings);
    expect($result)->toHaveCount(3);
});

test('get returns empty collection when no shippings exist', function () {
    $emptyCollection = new Collection([]);

    $this->shippingRepository
        ->shouldReceive('all')
        ->once()
        ->andReturn($emptyCollection);

    $result = $this->getUserShippings->get();

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(0);
});
