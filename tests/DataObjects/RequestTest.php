<?php

declare(strict_types=1);

use JustSteveKing\Tools\Http\Enums\Method;
use Treblle\Utils\DataObjects\Request;

it('can cast an object to an array', function (string $string): void {
    $request = new Request(
        timestamp: $string,
        ip: $string,
        url: $string,
        user_agent: $string,
        method: Method::DELETE,
        headers: [
            $string => $string,
        ],
        body: [
            $string => $string,
        ],
        raw: [
            $string => $string,
        ],
    );

    expect(
        (array) $request,
    )->toBeArray()->toHaveKeys(
        keys: ['timestamp', 'ip', 'url', 'user_agent', 'method', 'headers', 'body', 'raw'],
    );
})->with('strings');

it('can map the object to the correct array format', function (string $string): void {
    $request = new Request(
        timestamp: $string,
        ip: $string,
        url: $string,
        user_agent: $string,
        method: Method::GET,
        headers: [
            $string => $string,
        ],
        body: [
            $string => $string,
        ],
        raw: [
            $string => $string
        ]
    );

    expect(
        $request->__toArray(),
    )->toBeArray()->toEqual([
        'timestamp' => $string,
        'ip' => $string,
        'url' => $string,
        'user_agent' => $string,
        'method' => Method::GET->value,
        'headers' => [
            $string => $string,
        ],
        'body' => [
            $string => $string,
        ],
        'raw' => [
            $string => $string
        ]
    ]);
})->with('strings');
