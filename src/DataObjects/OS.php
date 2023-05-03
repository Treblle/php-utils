<?php

declare(strict_types=1);

namespace Treblle\Utils\DataObjects;

final readonly class OS
{
    /**
     * @param null|string $name The name of the server OS: Linux, Windows, etc.
     * @param null|string $release The version of the server OS.
     * @param null|string $architecture The server architecture.
     */
    public function __construct(
        public null|string $name,
        public null|string $release,
        public null|string $architecture,
    ) {
    }

    /**
     * @return array{
     *     name: null|string,
     *     release: null|string,
     *     architecture: null|string,
     * }
     */
    public function __toArray(): array
    {
        return [
            'name' => $this->name,
            'release' => $this->release,
            'architecture' => $this->architecture,
        ];
    }
}
