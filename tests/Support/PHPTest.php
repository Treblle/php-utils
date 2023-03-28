<?php

declare(strict_types=1);

use Treblle\Utils\Support\PHP;

it('can get init values', function (): void {
    $php = new PHP();

    ini_set('display_errors', true);
    ini_set('memory_limit', '128M');

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
    )->toBeString()->toEqual('128M');
});
