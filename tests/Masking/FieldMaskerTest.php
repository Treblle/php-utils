<?php

declare(strict_types=1);

use Treblle\Utils\Masking\FieldMasker;

it('can mask a simple payload', function (): void {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect(
        $masker->mask(
            data: [
                'password' => 'password',
                'api_key' => 'test',
                'cc' => '1234-1234-1234-1234',
                'foo' => 'bar',
            ],
        ),
    )->toBeArray()->toEqual([
        'password' => '********',
        'api_key' => '****',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});

it('can mask an recursive array', function (): void {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect(
        $masker->mask(
            data: [
                'form' => [
                    'password' => 'password',
                    'api_key' => 'test',
                ],
                'Authorization' => 'Bearer 123123123123123',
                'X-API-KEY' => '1234-1234-4321',
                'cc' => '1234-1234-1234-1234',
                'foo' => 'bar',
            ],
        ),
    )->toBeArray()->toEqual([
        'form' => [
            'password' => '********',
            'api_key' => '****',
        ],
        'Authorization' => 'Bearer ***************',
        'X-API-KEY' => '**************',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});

it('can handle a single Authorization entry', function () {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect($masker->mask(
        data: [
            'form' => [
                'password' => 'password',
                'api_key' => 'test',
            ],
            'Authorization' => '123123123123123',
            'X-API-KEY' => '1234-1234-4321',
            'cc' => '1234-1234-1234-1234',
            'foo' => 'bar',
        ],
    ))->toBeArray()->toEqual([
        'form' => [
            'password' => '********',
            'api_key' => '****',
        ],
        'Authorization' => '***************',
        'X-API-KEY' => '**************',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});

it('can handle a two Authorization entries', function () {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect($masker->mask(
        data: [
            'form' => [
                'password' => 'password',
                'api_key' => 'test',
            ],
            'Authorization' => 'Bearer 123123123123123',
            'X-API-KEY' => '1234-1234-4321',
            'cc' => '1234-1234-1234-1234',
            'foo' => 'bar',
        ],
    ))->toBeArray()->toEqual([
        'form' => [
            'password' => '********',
            'api_key' => '****',
        ],
        'Authorization' => 'Bearer ***************',
        'X-API-KEY' => '**************',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});


it('can handle a multiple Authorization entries', function () {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect($masker->mask(
        data: [
            'form' => [
                'password' => 'password',
                'api_key' => 'test',
            ],
            'Authorization' => 'Bearer 123123123123123 123',
            'X-API-KEY' => '1234-1234-4321',
            'cc' => '1234-1234-1234-1234',
            'foo' => 'bar',
        ],
    ))->toBeArray()->toEqual([
        'form' => [
            'password' => '********',
            'api_key' => '****',
        ],
        'Authorization' => 'Bearer *************** ***',
        'X-API-KEY' => '**************',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});

it('can handle a malformed Authorization entry', function () {
    $masker = new FieldMasker(
        fields: ['password', 'api_key', 'cc'],
    );

    expect($masker->mask(
        data: [
            'form' => [
                'password' => 'password',
                'api_key' => 'test',
            ],
            'Authorization' => 'Alien',
            'X-API-KEY' => '1234-1234-4321',
            'cc' => '1234-1234-1234-1234',
            'foo' => 'bar',
        ],
    ))->toBeArray()->toEqual([
        'form' => [
            'password' => '********',
            'api_key' => '****',
        ],
        'Authorization' => '*****',
        'X-API-KEY' => '**************',
        'cc' => '*******************',
        'foo' => 'bar',
    ]);
});
