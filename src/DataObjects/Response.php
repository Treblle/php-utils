<?php

declare(strict_types=1);

namespace Treblle\Utils\DataObjects;

final class Response
{
    /**
     * @param array<string,string> $headers The Response headers in key:value format.
     * @param int|null $code The HTTP Status Code.
     * @param int|null $size The Response size in bytes.
     * @param float|null $load_time The load time of the Response in microseconds.
     * @param string|array<int|string,mixed> $body The complete JSON respinse returned by the server.
     */
    public function __construct(
        public array $headers,
        public null|int $code,
        public null|int $size,
        public null|float $load_time,
        public string|array $body,
    ) {
    }

    /**
     * @return array{
     *     headers: array,
     *     code: null|int,
     *     size: null|int,
     *     load_time: null|float,
     *     body: string|array,
     * }
     */
    public function __toArray(): array
    {
        return [
            'headers' => $this->headers,
            'code' => $this->code,
            'size' => $this->size,
            'load_time' => $this->load_time,
            'body' => $this->body,
        ];
    }
}
