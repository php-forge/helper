<?php

declare(strict_types=1);

namespace PHPForge\Helpers\Tests;

use PHPForge\Helpers\TimeZone;
use PHPUnit\Framework\TestCase;

final class TimeZoneTest extends TestCase
{
    public function testGetAll(): void
    {
        $timeZone = TimeZone::getAll();

        $this->assertIsArray($timeZone);
        $this->assertSame('Pacific/Midway', $timeZone[0]['timezone']);
        $this->assertSame('Pacific/Midway (UTC -11:00)', $timeZone[0]['name']);
        $this->assertSame(-39600, $timeZone[0]['offset']);

        $this->assertSame('Africa/Addis_Ababa', $timeZone[253]['timezone']);
        $this->assertSame('Africa/Addis Ababa (UTC +03:00)', $timeZone[253]['name']);
        $this->assertSame(10800, $timeZone[253]['offset']);
    }
}
