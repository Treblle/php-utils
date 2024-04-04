<?php

declare(strict_types=1);

namespace Treblle\Utils\Masking;

final class FieldMasker
{
    public function __construct(
        public array $fields = [],
    ) {
    }

    public function mask(array $data): array
    {
        $collector = [];
        foreach ($data as $key => $value) {
            $collector[$key] = match (true) {
                is_array($value) => $this->mask(
                    data: $value,
                ),
                is_string($value) => $this->handleString(
                    key: $key,
                    value: $value,
                ),
                default => $value,
            };
        }

        return $collector;
    }

    private function handleString(string $key, string $value): string
    {
        static $lowerFields = null;
        if ($lowerFields === null) {
            $lowerFields = array_map('strtolower', $this->fields);
        }

        $lowerKey = strtolower($key);

        if (in_array($lowerKey, $lowerFields, true)) {
            return $this->star($value);
        }

        if ($this->isSensitiveHeader($lowerKey)) {
            return $this->maskAuthorization($value);
        }

        if ($this->isBase64($value)) {
            return 'base64 encoded images are too big to process';
        }

        return $value;
    }

    private function maskAuthorization(string $value): string
    {
        $parts = explode(' ', $value, 2);
        if (isset($parts[1])) {
            $authTypeLower = strtolower($parts[0]);
            if (in_array($authTypeLower, ['bearer', 'basic', 'digest'])) {
                return $parts[0].' '.$this->star($parts[1]);
            }
        }

        return $this->star($value);
    }

    private function isSensitiveHeader(string $key): bool
    {
        return in_array($key, ['authorization', 'x-api-key'], true);
    }

    public function star(string $string): string
    {
        return str_repeat('*', strlen($string));
    }

    private function isBase64(string $string): bool
    {
        return str_starts_with($string, 'data:image/') && str_contains($string, ';base64,');
    }
}
