<?php

declare(strict_types=1);

use Treblle\Utils\DataObjects\OS;
use Treblle\Utils\DataObjects\Server;

it('can cast an object to an array', function (string $string): void {
    $server = new Server(
        ip: $string,
        timezone: $string,
        software: $string,
        signature: $string,
        protocol: $string,
        os: new OS(
            name: $string,
            release: $string,
            architecture: $string,
        ),
        encoding: $string,
        hostname: $string,
    );

    expect(
        (array) $server,
    )->toBeArray()->toHaveKeys(
        keys: ['ip', 'timezone', 'software', 'signature', 'protocol', 'os', 'encoding', 'hostname'],
    );
})->with('strings');

it('can map the object to the correct array format', function (string $string): void {
    $server = new Server(
        ip: $string,
        timezone: $string,
        software: $string,
        signature: $string,
        protocol: $string,
        os: new OS(
            name: $string,
            release: $string,
            architecture: $string,
        ),
        encoding: $string,
        hostname: $string,
    );

    expect(
        $server->__toArray(),
    )->toBeArray()->toEqual([
        'ip' => $string,
        'timezone' => $string,
        'software' => $string,
        'signature' => $string,
        'protocol' => $string,
        'os' => [
            'name' => $string,
            'release' => $string,
            'architecture' => $string,
        ],
        'encoding' => $string,
        'hostname' => $string,
    ]);
})->with('strings');
