<?php

declare(strict_types=1);

namespace Treblle\Utils\Support;

final class PHP
{
    /**
     * @param string $string The INI value to look for.
     * @return string The string version of the INI value.
     */
    public function get(string $string): string
    {
        $value = ini_get(option: $string);

        if (! $value) {
            return '<unknown>';
        }

        $isBool = filter_var(
            value: $value,
            filter: FILTER_VALIDATE_BOOLEAN,
            options: FILTER_NULL_ON_FAILURE,
        );

        if (is_bool($isBool)) {
            return 'On';
        }

        return $value;
    }
}
