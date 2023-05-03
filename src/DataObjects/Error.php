<?php

declare(strict_types=1);

namespace Treblle\Utils\DataObjects;

final readonly class Error
{
    /**
     * @param null|string $source The reason an error is thrown, onException, onError, onShutdown.
     * @param null|string $type The error type for the language.
     * @param null|string $message The error message give.
     * @param null|string $file The name of the file that caused the error.
     * @param null|int $line The exact line of code where the error happened.
     */
    public function __construct(
        public null|string $source,
        public null|string $type,
        public null|string $message,
        public null|string $file,
        public null|int $line,
    ) {
    }

    /**
     * @return array{
     *     source: null|string,
     *     type: null|string,
     *     message: null|string,
     *     file: null|string,
     *     line: null|int,
     * }
     */
    public function __toArray(): array
    {
        return [
            'source' => $this->source,
            'type' => $this->type,
            'message' => $this->message,
            'file' => $this->file,
            'line' => $this->line,
        ];
    }
}
