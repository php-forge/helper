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
    }

    public function testGetAllCount(): void
    {
        $timeZone = TimeZone::getAll();

        $this->assertGreaterThan(400, count($timeZone));
    }

    public function testGellAllNotCharacter(): void
    {
        $timeZone = TimeZone::getAll();

        foreach ($timeZone as $value) {
            $this->assertStringNotContainsString('_', $value['name']);
        }
    }

    public function testGetAllReturnsOrderedTimeZones()
    {
        $timeZones = TimeZone::getAll();
        $prevOffset = null;

        foreach ($timeZones as $timeZone) {
            // Verifica que el offset sea mayor o igual al offset anterior
            if ($prevOffset !== null) {
                $this->assertGreaterThanOrEqual($prevOffset, $timeZone['offset']);
            }

            // Verifica que el array tenga las claves correctas
            $this->assertArrayHasKey('timezone', $timeZone);
            $this->assertArrayHasKey('name', $timeZone);
            $this->assertArrayHasKey('offset', $timeZone);

            $prevOffset = $timeZone['offset'];
        }
    }
}
