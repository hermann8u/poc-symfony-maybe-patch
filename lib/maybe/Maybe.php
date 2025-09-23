<?php

declare(strict_types=1);

namespace Maybe;

use ReflectionProperty;

/**
 * This Maybe implementation use reflection in order to check property initialization.
 *
 * @see https://hackernoon.com/say-goodbye-to-null-checking-and-exceptions-using-the-maybe-monad-in-symfony
 * @see https://marcosh.github.io/post/2017/06/16/maybe-in-php.html
 * @see https://github.com/php-fp/php-fp-maybe
 *
 * @template T of mixed
 */
final class Maybe
{
    /** @var T */
    private readonly mixed $value;
    private static ReflectionProperty $valueReflectionProperty;

    private function __construct()
    {
        // Initialize reflection property only once
        self::$valueReflectionProperty ??= new ReflectionProperty(self::class, 'value');
    }

    /**
     * @template U of mixed
     *
     * @param U $value
     *
     * @return self<U>
     */
    public static function just(mixed $value): Maybe
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }

    /**
     * @return self<T>
     */
    public static function nothing(): Maybe
    {
        return new self();
    }

    /**
     * @template U
     *
     * @param callable(T): U $fn
     *
     * @return self<U>
     */
    public function map(callable $fn): Maybe
    {
        return self::instanceHasValue($this) ? self::just($fn($this->value)) : self::nothing();
    }

    /**
     * @param callable(T): void $fn
     */
    public function do(callable $fn): void
    {
        if (!self::instanceHasValue($this)) {
            return;
        }

        $fn($this->value);
    }

    /**
     * @param T $defaultValue
     *
     * @return T
     */
    public function getOrElse(mixed $defaultValue): mixed
    {
        return self::instanceHasValue($this) ? $this->value : $defaultValue;
    }

    /**
     * @param self<T> $instance
     */
    private static function instanceHasValue(self $instance): bool
    {
        return self::$valueReflectionProperty->isInitialized($instance);
    }
}
