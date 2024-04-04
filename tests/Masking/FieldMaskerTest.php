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
        'Authorization' => 'Bearer *******************',
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

it('masks base64 encoded image strings', function () {
    $masker = new FieldMasker();

    $base64Image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAHElEQVQI12P4//8/w38GIAXDIBKE0DHxgljNBAAO9TXL0Y4OHwAAAABJRU5ErkJggg==';
    $data = [
        'image' => $base64Image,
    ];

    $maskedData = $masker->mask($data);

    // Assert that the base64 encoded image string is replaced with a mask or default value
    expect($maskedData['image'])->not()->toEqual($base64Image);
    expect($maskedData['image'])->toEqual('base64 encoded images are too big to process'); // Assuming 'DEFAULT_VALUE' is what you use for masking
});

it('does not mask non-base64 encoded strings', function () {
    $masker = new FieldMasker();

    $nonBase64String = 'This is a test string, not base64 encoded.';
    $data = [
        'description' => $nonBase64String,
    ];

    $maskedData = $masker->mask($data);

    // Assert that non-base64 encoded strings remain unchanged
    expect($maskedData['description'])->toEqual($nonBase64String);
});

it('masks base64 encoded image strings within nested arrays', function () {
    $masker = new FieldMasker();

    $base64Image = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJ...';
    $data = [
        'profile' => [
            'avatar' => $base64Image,
        ],
    ];

    $maskedData = $masker->mask($data);

    // Assert that the base64 encoded image string in a nested array is masked
    expect($maskedData)->toHaveKey('profile.avatar', 'base64 encoded images are too big to process');
});
