<?php

declare(strict_types=1);

use Treblle\Utils\DataObjects\Data;
use Treblle\Utils\DataObjects\Error;
use Treblle\Utils\DataObjects\Language;
use Treblle\Utils\DataObjects\OS;
use Treblle\Utils\DataObjects\Request;
use Treblle\Utils\DataObjects\Response;
use Treblle\Utils\DataObjects\Server;
use Treblle\Utils\Http\Method;
use Treblle\Utils\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);


function createData(string $string): Data
{
    return new Data(
        server: new Server(
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
            encoding: $string
        ),
        language: new Language(
            name: $string,
            version: $string,
            expose_php: $string,
            display_errors: $string,
        ),
        request: new Request(
            timestamp: $string,
            ip: $string,
            url: $string,
            route_path: $string,
            user_agent: $string,
            method: Method::GET,
            headers: [
                $string => $string,
            ],
            body: [
                $string => $string,
            ],
            raw: [
                $string => $string,
            ],
        ),
        response: new Response(
            headers: [
                $string => $string,
            ],
            code: 123,
            size: 123,
            load_time: 12.3,
            body: [
                $string => $string,
            ],
        ),
        errors: [
            new Error(
                source: $string,
                type: $string,
                message: $string,
                file: $string,
                line: 123,
            ),
        ],
    );
}
