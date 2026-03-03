<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use InvalidArgumentException;
use PHPForge\Helper\Exception\Message;
use PHPForge\Helper\Reflector;
use PHPForge\Helper\Tests\Support\Attribute\{Label, Marker};
use PHPForge\Helper\Tests\Support\Contract\{LeftContract, Status, UsesTimestamp};
use PHPForge\Helper\Tests\Support\Model\ReflectionFixture;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use stdClass;

/**
 * Unit tests for the {@see Reflector} helper.
 *
 * Test coverage.
 * - Caches reflection class instances for repeated lookups and evicts the oldest entry at cache-size limit.
 * - Detects whether a property exists on the reflection target.
 * - Extracts class and property attributes, including filtered lookups.
 * - Resolves first matching property attribute instances or returns `null` when no match exists.
 * - Resolves property type names for mixed, untyped, named, nullable, union, and intersection declarations.
 * - Returns reflection properties and throws {@see InvalidArgumentException} for missing properties.
 * - Returns short names for class, enum, interface, trait, and anonymous targets and throws
 *   {@see InvalidArgumentException} for invalid targets.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ReflectorTest extends TestCase
{
    public function testCacheSizeReturnsNumberOfCachedReflectionClasses(): void
    {
        Reflector::clearCache();

        Reflector::shortName(ReflectionFixture::class);

        self::assertSame(
            1,
            Reflector::cacheSize(),
            'Should return one cached class after first reflection lookup.',
        );

        Reflector::shortName(stdClass::class);

        self::assertSame(
            2,
            Reflector::cacheSize(),
            'Should increase cache size when reflecting a different class.',
        );
    }

    public function testClassAttributesReturnsAllClassAttributes(): void
    {
        $attributes = Reflector::classAttributes(ReflectionFixture::class);

        self::assertCount(
            1,
            $attributes,
            'Should return all class-level attributes when no filter is passed.',
        );

        $firstAttribute = null;

        foreach ($attributes as $attribute) {
            $firstAttribute = $attribute;
            break;
        }

        self::assertNotNull(
            $firstAttribute,
            'Should return at least one attribute instance for the class.',
        );
        self::assertSame(
            Label::class,
            $firstAttribute->getName(),
            'Should return the expected attribute class name.',
        );
    }

    public function testClassAttributesWithFilterReturnsMatchingAttributesOnly(): void
    {
        $attributes = Reflector::classAttributes(ReflectionFixture::class, Label::class);

        self::assertCount(
            1,
            $attributes,
            'Should return only matching class attributes for the requested filter.',
        );
    }

    public function testClearCacheEmptiesReflectionClassCache(): void
    {
        Reflector::clearCache();
        Reflector::shortName(ReflectionFixture::class);

        self::assertGreaterThan(
            0,
            Reflector::cacheSize(),
            'Should populate cache after reflection usage.',
        );

        Reflector::clearCache();

        self::assertSame(
            0,
            Reflector::cacheSize(),
            'Should clear all cached reflection classes.',
        );
    }

    public function testFirstPropertyAttributeReturnsFirstMatchingAttributeInstance(): void
    {
        $attribute = Reflector::firstPropertyAttribute(ReflectionFixture::class, 'name', Label::class);

        if (!$attribute instanceof Label) {
            self::fail('Should return an instantiated attribute object when the attribute exists.');
        }

        self::assertSame(
            'primary',
            $attribute->value,
            'Should return the first declared repeatable attribute instance.',
        );
    }

    public function testFirstPropertyAttributeReturnsNullWhenAttributeDoesNotExist(): void
    {
        self::assertNull(
            Reflector::firstPropertyAttribute(ReflectionFixture::class, 'name', self::class),
            "Should return 'null' when the requested attribute is not present.",
        );
    }

    public function testHasPropertyReturnsExpectedResult(): void
    {
        self::assertTrue(
            Reflector::hasProperty(ReflectionFixture::class, 'name'),
            "Should return 'true' for existing properties.",
        );
        self::assertFalse(
            Reflector::hasProperty(ReflectionFixture::class, 'missing'),
            "Should return 'false' for missing properties.",
        );
    }

    public function testPropertiesReturnsAllPropertiesWhenFilterIsNull(): void
    {
        $allProperties = Reflector::properties(ReflectionFixture::class);
        $allPropertyNames = [];

        foreach ($allProperties as $property) {
            $allPropertyNames[] = $property->getName();
        }

        self::assertContains(
            'name',
            $allPropertyNames,
            'Should include public properties when no filter is provided.',
        );
        self::assertContains(
            'hidden',
            $allPropertyNames,
            'Should include private properties when no filter is provided.',
        );
    }

    public function testPropertiesReturnsFilteredListWhenVisibilityFilterIsProvided(): void
    {
        $publicProperties = Reflector::properties(ReflectionFixture::class, ReflectionProperty::IS_PUBLIC);

        $publicPropertyNames = [];

        foreach ($publicProperties as $publicProperty) {
            $publicPropertyNames[] = $publicProperty->getName();
        }

        self::assertContains(
            'name',
            $publicPropertyNames,
            'Should include public properties when a public filter is used.',
        );
        self::assertNotContains(
            'hidden',
            $publicPropertyNames,
            'Should exclude private properties when a public filter is used.',
        );
    }

    public function testPropertyAttributeInstancesReturnsInstantiatedAttributes(): void
    {
        $instances = Reflector::propertyAttributeInstances(ReflectionFixture::class, 'name', Label::class);

        self::assertCount(
            2,
            $instances,
            'Should instantiate all matching repeatable attributes.',
        );

        foreach ($instances as $instance) {
            self::assertInstanceOf(Label::class, $instance);
        }

        /** @phpstan-var list<Label> $instances */
        $instanceValues = [];

        foreach ($instances as $instance) {
            $instanceValues[] = $instance->value;
        }

        self::assertSame(
            [
                'primary',
                'secondary',
            ],
            $instanceValues,
            'Should preserve declaration order for instantiated repeatable attributes.',
        );
    }

    public function testPropertyAttributesReturnsPropertyAttributes(): void
    {
        $attributes = Reflector::propertyAttributes(ReflectionFixture::class, 'name');

        self::assertCount(
            3,
            $attributes,
            'Should return every attribute declared on the property.',
        );
    }

    public function testPropertyAttributesWithFilterReturnsMatchingAttributesOnly(): void
    {
        $attributes = Reflector::propertyAttributes(ReflectionFixture::class, 'name', Marker::class);

        self::assertCount(
            1,
            $attributes,
            'Should return only matching attributes when a property filter is passed.',
        );

        $firstAttribute = null;

        foreach ($attributes as $attribute) {
            $firstAttribute = $attribute;
            break;
        }

        self::assertNotNull($firstAttribute);
        self::assertSame(
            Marker::class,
            $firstAttribute->getName(),
            'Should return the expected attribute class for filtered lookup.',
        );
    }

    public function testPropertyReturnsReflectionProperty(): void
    {
        self::assertInstanceOf(
            ReflectionProperty::class,
            Reflector::property(ReflectionFixture::class, 'name'),
            'Should return a reflection property instance for existing properties.',
        );
    }

    public function testPropertyThrowsInvalidArgumentExceptionWhenPropertyDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::REFLECTOR_PROPERTY_NOT_FOUND->getMessage('missing', ReflectionFixture::class),
        );

        Reflector::property(ReflectionFixture::class, 'missing');
    }

    public function testPropertyTypeNamesReturnsEmptyArrayForUntypedProperty(): void
    {
        self::assertSame(
            [],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'untyped'),
            'Should return an empty list for untyped properties.',
        );
    }

    public function testPropertyTypeNamesReturnsExpectedNamesForIntersectionProperty(): void
    {
        self::assertSame(
            [
                'PHPForge\\Helper\\Tests\\Support\\Contract\\LeftContract',
                'PHPForge\\Helper\\Tests\\Support\\Contract\\RightContract',
            ],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'intersection'),
            'Should include all named intersection members.',
        );
    }

    public function testPropertyTypeNamesReturnsExpectedNamesForNamedProperty(): void
    {
        self::assertSame(
            ['int'],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'id'),
            'Should return one type name for named property types.',
        );
    }

    public function testPropertyTypeNamesReturnsExpectedNamesForNullableProperty(): void
    {
        self::assertSame(
            ['string', 'null'],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'nullable'),
            "Should append 'null' for nullable named property types.",
        );
    }

    public function testPropertyTypeNamesReturnsExpectedNamesForUnionProperty(): void
    {
        self::assertSame(
            ['string', 'int'],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'union'),
            'Should include all named union members.',
        );
    }

    public function testPropertyTypeNamesReturnsMixedWithoutExplicitNull(): void
    {
        self::assertSame(
            ['mixed'],
            Reflector::propertyTypeNames(ReflectionFixture::class, 'payload'),
            "Should return only 'mixed' without appending an explicit null type.",
        );
    }

    public function testReflectionClassCacheEvictsOldestEntryWhenCacheSizeLimitIsReached(): void
    {
        $reflectorClass = new ReflectionClass(Reflector::class);

        $cacheProperty = $reflectorClass->getProperty('reflectionClassCache');
        /** @phpstan-var int $cacheLimit */
        $cacheLimit = $reflectorClass->getConstant('MAX_REFLECTION_CLASS_CACHE_SIZE');

        $filledCache = [];
        $reflection = new ReflectionClass(stdClass::class);

        for ($index = 0; $index < $cacheLimit; $index++) {
            $filledCache['cached-' . $index] = $reflection;
        }

        $cacheProperty->setValue(null, $filledCache);

        Reflector::shortName(ReflectionFixture::class);

        /** @phpstan-var array<string, ReflectionClass<object>> $cacheAfterInsert */
        $cacheAfterInsert = $cacheProperty->getValue();

        self::assertCount(
            $cacheLimit,
            $cacheAfterInsert,
            'Should keep cache size at the configured limit after inserting a new class.',
        );
        self::assertArrayNotHasKey(
            'cached-0',
            $cacheAfterInsert,
            'Should evict the oldest cached entry when cache size limit is reached.',
        );
        self::assertArrayHasKey(
            ReflectionFixture::class,
            $cacheAfterInsert,
            'Should cache the newly reflected class after evicting the oldest entry.',
        );
    }

    public function testReflectionClassIsCachedForRepeatedLookups(): void
    {
        $cacheProperty = (new ReflectionClass(Reflector::class))->getProperty('reflectionClassCache');

        $cacheProperty->setValue(null, []);

        Reflector::shortName(ReflectionFixture::class);

        /** @var array<string, ReflectionClass<object>> $firstCache */
        $firstCache = $cacheProperty->getValue();

        self::assertArrayHasKey(
            ReflectionFixture::class,
            $firstCache,
            'Should cache reflection class instances after first lookup.',
        );

        $firstInstance = $firstCache[ReflectionFixture::class] ?? null;

        Reflector::hasProperty(ReflectionFixture::class, 'name');

        /** @phpstan-var array<string, ReflectionClass<object>> $secondCache */
        $secondCache = $cacheProperty->getValue();

        $secondInstance = $secondCache[ReflectionFixture::class] ?? null;

        self::assertCount(
            1,
            $secondCache,
            'Should keep a single cached entry for repeated lookups of the same class.',
        );
        self::assertInstanceOf(
            ReflectionClass::class,
            $firstInstance,
            'Should keep a reflection class instance in cache.',
        );
        self::assertSame(
            $firstInstance,
            $secondInstance,
            'Should reuse the same reflection class instance between calls.',
        );
    }

    public function testShortNameReturnsEmptyStringForAnonymousClass(): void
    {
        self::assertSame(
            '',
            Reflector::shortName(new class {}),
            'Should return an empty short name for anonymous classes.',
        );
    }

    public function testShortNameReturnsShortNameForEnumTarget(): void
    {
        self::assertSame(
            'Status',
            Reflector::shortName(Status::class),
            'Should return the short name for enum targets.',
        );
    }

    public function testShortNameReturnsShortNameForInterfaceTarget(): void
    {
        self::assertSame(
            'LeftContract',
            Reflector::shortName(LeftContract::class),
            'Should return the short name for interface targets.',
        );
    }

    public function testShortNameReturnsShortNameForNamedClass(): void
    {
        self::assertSame(
            'ReflectionFixture',
            Reflector::shortName(ReflectionFixture::class),
            'Should return the short name for named classes.',
        );
    }

    public function testShortNameReturnsShortNameForTraitTarget(): void
    {
        self::assertSame(
            'UsesTimestamp',
            Reflector::shortName(UsesTimestamp::class),
            'Should return the short name for trait targets.',
        );
    }

    public function testThrowsInvalidArgumentExceptionForInvalidReflectionTarget(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::REFLECTOR_TARGET_INVALID->getMessage('missing\\class\\Name'),
        );

        Reflector::shortName('missing\\class\\Name');
    }
}
