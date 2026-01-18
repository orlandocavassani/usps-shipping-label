<?php

use App\DataTransferObjects\DimensionsData;

test('dimensions data can be instantiated with all properties', function () {
    $dimensions = new DimensionsData(
        length: 10.5,
        width: 8.2,
        height: 5.7,
        weight: 2.3
    );

    expect($dimensions->length)->toBe(10.5);
    expect($dimensions->width)->toBe(8.2);
    expect($dimensions->height)->toBe(5.7);
    expect($dimensions->weight)->toBe(2.3);
});

test('dimensions data properties are readonly', function () {
    $dimensions = new DimensionsData(
        length: 10.5,
        width: 8.2,
        height: 5.7,
        weight: 2.3
    );

    expect(fn () => $dimensions->weight = 5.0)
        ->toThrow(Error::class);
});

test('dimensions data accepts integer values', function () {
    $dimensions = new DimensionsData(
        length: 10,
        width: 8,
        height: 5,
        weight: 2
    );

    expect($dimensions->length)->toBe(10.0);
    expect($dimensions->width)->toBe(8.0);
    expect($dimensions->height)->toBe(5.0);
    expect($dimensions->weight)->toBe(2.0);
});
