<?php

declare(strict_types=1);

namespace Treblle\Utils\DataObjects;

final class Language
{
    /**
     * @param null|string $name The language name: PHP, Python, .NET, Ruby, JS.
     * @param null|string $version The language version installed on the server.
     */
    public function __construct(
        public null|string $name,
        public null|string $version,
    ) {
    }

    /**
     * @return array{
     *     name: null|string,
     *     version: null|string,
     * }
     */
    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
        ];
    }
}
