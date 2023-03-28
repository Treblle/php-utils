<?php

declare(strict_types=1);

use Treblle\Utils\Support\PHP;

it('can get init values', function (): void {
    $php = new PHP();

    expect(
        $php->get(
            string: 'display_errors',
        ),
    )->toBeString()->toEqual('On');

    expect(
        $php->get('does not exist'),
    )->toBeString()->toEqual('<unknown>');

    expect(
        $php->get(
            string: 'memory_limit',
        ),
    )->toBeString()->toEqual(ini_get('memory_limit'));
});
