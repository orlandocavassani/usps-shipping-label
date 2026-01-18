<?php

namespace App\Http\Controllers;

use App\Actions\CreateShipping;
use App\Actions\GetUserShippings;
use App\Http\Requests\CreateShippingRequest;
use Inertia\Inertia;

class ShippingController extends Controller
{
    public function __construct(
        private CreateShipping $createShipping,
        private GetUserShippings $getUserShippings
    ) {}

    public function index()
    {
        $shippings = $this->getUserShippings->get();

        return Inertia::render('shippings/shippings', [
            'shippings' => $shippings,
        ]);
    }

    public function create()
    {
        return Inertia::render('shippings/create');
    }

    public function store(CreateShippingRequest $request)
    {
        $this->createShipping->create($request->user()->id, $request->toShippingData());

        return redirect()->route('shippings');
    }
}
