<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use InvalidArgumentException;
use PHPForge\Helper\Exception\Message;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

use function array_map;
use function array_shift;
use function class_exists;
use function count;
use function enum_exists;
use function interface_exists;
use function is_object;
use function trait_exists;

/**
 * Provides lightweight reflection utilities for classes and properties.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class Reflector
{
    /**
     * Maximum number of cached reflection classes.
     */
    private const MAX_REFLECTION_CLASS_CACHE_SIZE = 512;

    /**
     * Stores reflection instances keyed by class name.
     *
     * @var array<string, ReflectionClass<object>>
     */
    private static array $reflectionClassCache = [];

    /**
     * Returns the current number of cached reflection classes.
     *
     * Usage example:
     * ```php
     * $cacheSize = \PHPForge\Helper\Reflector::cacheSize();
     * ```
     *
     * @return int Number of cached reflection classes.
     */
    public static function cacheSize(): int
    {
        return count(self::$reflectionClassCache);
    }

    /**
     * Returns class attributes, optionally filtered by attribute class.
     *
     * Usage example:
     * ```php
     * $attributes = \PHPForge\Helper\Reflector::classAttributes(
     *     SomeClass::class,
     *     SomeAttribute::class,
     *     ReflectionAttribute::IS_INSTANCEOF,
     * );
     * ```
     *
     * @return array Class attributes.
     *
     * @phpstan-return list<ReflectionAttribute<object>>
     */
    public static function classAttributes(object|string $class, string|null $attribute = null, int $flags = 0): array
    {
        $reflectionClass = self::reflectionClass($class);

        if ($attribute === null) {
            return $reflectionClass->getAttributes();
        }

        return $reflectionClass->getAttributes($attribute, $flags);
    }

    /**
     * Clears the internal reflection class cache.
     *
     * Usage example:
     * ```php
     * \PHPForge\Helper\Reflector::clearCache();
     * ```
     */
    public static function clearCache(): void
    {
        self::$reflectionClassCache = [];
    }

    /**
     * Returns the first matching instantiated property attribute.
     *
     * Usage example:
     * ```php
     * $attributeInstance = \PHPForge\Helper\Reflector::firstPropertyAttribute(
     *     SomeClass::class,
     *     'someProperty',
     *     SomeAttribute::class,
     *     ReflectionAttribute::IS_INSTANCEOF,
     * );
     * ```
     *
     * @return object|null First matching instantiated attribute, or `null` if no matching attribute is found.
     */
    public static function firstPropertyAttribute(
        object|string $class,
        string $property,
        string $attribute,
        int $flags = 0,
    ): object|null {
        $attributes = self::propertyAttributes($class, $property, $attribute, $flags);

        if ($attributes === []) {
            return null;
        }

        return $attributes[0]->newInstance();
    }

    /**
     * Checks whether a property exists on the class.
     *
     * Usage example:
     * ```php
     * $hasProperty = \PHPForge\Helper\Reflector::hasProperty(SomeClass::class, 'someProperty');
     * ```
     *
     * @return bool `true` if the property exists, `false` otherwise.
     */
    public static function hasProperty(object|string $class, string $property): bool
    {
        return self::reflectionClass($class)->hasProperty($property);
    }

    /**
     * Returns reflected properties, optionally filtered by visibility flags.
     *
     * Usage example:
     * ```php
     * $publicProperties = \PHPForge\Helper\Reflector::properties(SomeClass::class, ReflectionProperty::IS_PUBLIC);
     * ```
     *
     * @return array Reflected properties.
     *
     * @phpstan-return list<ReflectionProperty>
     */
    public static function properties(object|string $class, int|null $filter = null): array
    {
        $reflectionClass = self::reflectionClass($class);

        if ($filter !== null) {
            return $reflectionClass->getProperties($filter);
        }

        return $reflectionClass->getProperties();
    }

    /**
     * Returns a reflected property.
     *
     * Usage example:
     * ```php
     * $property = \PHPForge\Helper\Reflector::property(SomeClass::class, 'someProperty');
     * ```
     *
     * @throws InvalidArgumentException if the property does not exist.
     *
     * @return ReflectionProperty Reflected property.
     */
    public static function property(object|string $class, string $property): ReflectionProperty
    {
        $reflectionClass = self::reflectionClass($class);

        if (!$reflectionClass->hasProperty($property)) {
            throw new InvalidArgumentException(
                Message::REFLECTOR_PROPERTY_NOT_FOUND->getMessage($property, $reflectionClass->getName()),
            );
        }

        return $reflectionClass->getProperty($property);
    }

    /**
     * Returns instantiated property attributes.
     *
     * Usage example:
     * ```php
     * $attributeInstances = \PHPForge\Helper\Reflector::propertyAttributeInstances(
     *     SomeClass::class,
     *     'someProperty',
     *     SomeAttribute::class,
     *     ReflectionAttribute::IS_INSTANCEOF,
     * );
     * ```
     *
     * @return array Instantiated property attributes.
     *
     * @phpstan-return list<object>
     */
    public static function propertyAttributeInstances(
        object|string $class,
        string $property,
        string|null $attribute = null,
        int $flags = 0,
    ): array {
        $attributes = self::propertyAttributes($class, $property, $attribute, $flags);

        return array_map(
            static fn(ReflectionAttribute $reflectionAttribute): object => $reflectionAttribute->newInstance(),
            $attributes,
        );
    }

    /**
     * Returns property attributes, optionally filtered by attribute class.
     *
     * Usage example:
     * ```php
     * $attributes = \PHPForge\Helper\Reflector::propertyAttributes(
     *     SomeClass::class,
     *     'someProperty',
     *     SomeAttribute::class,
     *     ReflectionAttribute::IS_INSTANCEOF,
     * );
     * ```
     *
     * @return array Property attributes.
     *
     * @phpstan-return list<ReflectionAttribute<object>>
     */
    public static function propertyAttributes(
        object|string $class,
        string $property,
        string|null $attribute = null,
        int $flags = 0,
    ): array {
        $reflectionProperty = self::property($class, $property);

        if ($attribute === null) {
            return $reflectionProperty->getAttributes();
        }

        return $reflectionProperty->getAttributes($attribute, $flags);
    }

    /**
     * Returns property type names.
     *
     * For nullable named types, the list includes `'null'` as an extra element.
     *
     * Usage example:
     * ```php
     * $typeNames = \PHPForge\Helper\Reflector::propertyTypeNames(SomeClass::class, 'someProperty');
     * ```
     *
     * @return list<string> Type names of the property, or an empty list if the property has no type declaration.
     *
     * @phpstan-return list<string>
     */
    public static function propertyTypeNames(object|string $class, string $property): array
    {
        $type = self::property($class, $property)->getType();

        if ($type instanceof ReflectionNamedType) {
            $typeName = $type->getName();

            if ($type->allowsNull() && $typeName !== 'null' && $typeName !== 'mixed') {
                return [$typeName, 'null'];
            }

            return [$typeName];
        }

        if ($type instanceof ReflectionUnionType || $type instanceof ReflectionIntersectionType) {
            return self::collectNestedTypeNames($type);
        }

        return [];
    }

    /**
     * Returns the short class name.
     *
     * Usage example:
     * ```php
     * $shortName = \PHPForge\Helper\Reflector::shortName(SomeClass::class);
     * ```
     *
     * @return string Short name of the class, or an empty string for anonymous classes.
     */
    public static function shortName(object|string $class): string
    {
        $reflectionClass = self::reflectionClass($class);

        return $reflectionClass->isAnonymous() ? '' : $reflectionClass->getShortName();
    }

    /**
     * Collects all named type names from nested union/intersection type structures.
     *
     * @return array Type names collected from the nested type structure.
     *
     * @phpstan-return list<string>
     */
    private static function collectNestedTypeNames(ReflectionIntersectionType|ReflectionUnionType $type): array
    {
        $typeNames = [];

        $queue = $type->getTypes();

        while ($queue !== []) {
            $nestedType = array_shift($queue);

            if ($nestedType instanceof ReflectionNamedType) {
                $typeNames[] = $nestedType->getName();

                continue;
            }

            if ($nestedType instanceof ReflectionUnionType || $nestedType instanceof ReflectionIntersectionType) {
                foreach ($nestedType->getTypes() as $innerType) {
                    $queue[] = $innerType;
                }
            }
        }

        return $typeNames;
    }

    /**
     * Creates a reflection class from an object or class name.
     *
     * @param object|string $class Object instance or class name to reflect.
     *
     * @throws InvalidArgumentException if the class target is invalid.
     *
     * @return ReflectionClass<object> Reflection class instance.
     */
    private static function reflectionClass(object|string $class): ReflectionClass
    {
        $className = is_object($class) ? $class::class : $class;

        if (
            !class_exists($className)
            && !interface_exists($className)
            && !trait_exists($className)
            && !enum_exists($className)
        ) {
            throw new InvalidArgumentException(
                Message::REFLECTOR_TARGET_INVALID->getMessage($className),
            );
        }

        if (isset(self::$reflectionClassCache[$className])) {
            return self::$reflectionClassCache[$className];
        }

        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isAnonymous()) {
            if (count(self::$reflectionClassCache) >= self::MAX_REFLECTION_CLASS_CACHE_SIZE) {
                array_shift(self::$reflectionClassCache);
            }

            self::$reflectionClassCache[$className] = $reflectionClass;
        }

        return $reflectionClass;
    }
}
