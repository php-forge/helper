<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use PHPForge\Helper\WordFormatter;
use PHPUnit\Framework\TestCase;

final class WordFormatterTest extends TestCase
{
    public function testCapitalize(): void
    {
        $this->assertSame('Foo', WordFormatter::capitalizeToWords('foo'));
        $this->assertSame('Foo', WordFormatter::capitalizeToWords('Foo'));
        $this->assertSame('Foo bar', WordFormatter::capitalizeToWords('foo bar'));
        $this->assertSame('Foo bar', WordFormatter::capitalizeToWords('Foo Bar'));
        $this->assertSame('Created', WordFormatter::capitalizeToWords('created'));
        $this->assertSame('Created', WordFormatter::capitalizeToWords('CREATED'));
        $this->assertSame('Created At', WordFormatter::capitalizeToWords('created_at'));
        $this->assertSame('Created At', WordFormatter::capitalizeToWords('CREATED_AT'));
        $this->assertSame('Date Birth', WordFormatter::capitalizeToWords('dateBirth'));
        $this->assertSame('Date Of Message', WordFormatter::capitalizeToWords('dateOfMessage'));
    }

    public function testCamelCaseToSnakeCase(): void
    {
        $this->assertSame('foo', WordFormatter::camelCaseToSnakeCase('foo'));
        $this->assertSame('foo', WordFormatter::camelCaseToSnakeCase('Foo'));
        $this->assertSame('foo_bar', WordFormatter::camelCaseToSnakeCase('fooBar'));
        $this->assertSame('foo_bar', WordFormatter::camelCaseToSnakeCase('FooBar'));
        $this->assertSame('created', WordFormatter::camelCaseToSnakeCase('created'));
        $this->assertSame('created_at', WordFormatter::camelCaseToSnakeCase('createdAt'));
        $this->assertSame('date_birth', WordFormatter::camelCaseToSnakeCase('dateBirth'));
        $this->assertSame('date_of_message', WordFormatter::camelCaseToSnakeCase('dateOfMessage'));
    }

    public function testSnakeCaseToCamelCase(): void
    {
        $this->assertSame('foo', WordFormatter::snakeCaseToCamelCase('foo'));
        $this->assertSame('fooBar', WordFormatter::snakeCaseToCamelCase('foo_bar'));
        $this->assertSame('created', WordFormatter::snakeCaseToCamelCase('created'));
        $this->assertSame('createdAt', WordFormatter::snakeCaseToCamelCase('created_at'));
        $this->assertSame('dateBirth', WordFormatter::snakeCaseToCamelCase('date_birth'));
        $this->assertSame('dateOfBirth', WordFormatter::snakeCaseToCamelCase('date_of_birth'));
    }
}
