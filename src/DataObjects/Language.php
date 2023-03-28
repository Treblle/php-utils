<?php

declare(strict_types=1);

namespace Treblle\Utils\DataObjects;

final class Language
{
    /**
     * @param null|string $name The language name: PHP, Python, .NET, Ruby, JS.
     * @param null|string $version The language version installed on the server.
     * @param null|string $expose_php
     * @param null|string $display_errors
     */
    public function __construct(
        public readonly null|string $name,
        public readonly null|string $version,
        public readonly null|string $expose_php,
        public readonly null|string $display_errors,
    ) {
    }

    /**
     * @return array{
     *     name: null|string,
     *     version: null|string,
     *     expose_php: null|string,
     *     display_errors: null|string,
     * }
     */
    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'expose_php' => $this->expose_php,
            'display_errors' => $this->display_errors,
        ];
    }
}
