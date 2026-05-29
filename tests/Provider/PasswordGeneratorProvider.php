<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Provider;

/**
 * Provides datasets for {@see \PHPForge\Helper\Tests\PasswordGeneratorTest}.
 *
 * Provides representative input/output pairs for password character pool indexing.
 */
final class PasswordGeneratorProvider
{
    /**
     * @return array<string, array{int, string}>
     */
    public static function poolIndexes(): array
    {
        return [
            'digit segment starts at fifty two' => [52, '0'],
            'lowercase segment starts at zero' => [0, 'a'],
            'special segment starts at sixty two' => [62, '!'],
            'uppercase segment starts at twenty six' => [26, 'A'],
        ];
    }
}
