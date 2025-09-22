<?php

declare(strict_types=1);

namespace Maybe;

use ReflectionProperty;

/**
 * @see https://hackernoon.com/say-goodbye-to-null-checking-and-exceptions-using-the-maybe-monad-in-symfony
 * @see https://marcosh.github.io/post/2017/06/16/maybe-in-php.html
 * @see https://github.com/php-fp/php-fp-maybe
 *
 * @template T of mixed
 */
final class MaybeStaticReflection
{
    /** @var T */
    private readonly mixed $value;
    private static ReflectionProperty $reflectionProperty;

    private function __construct()
    {
    }

    /**
     * @param T $value
     *
     * @return Maybe<T>
     */
    public static function just(mixed $value): MaybeStaticReflection
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }

    /**
     * @return Maybe<T>
     */
    public static function nothing(): MaybeStaticReflection
    {
        return new self();
    }

    /**
     * @template U
     *
     * @param callable(T): U $fn
     *
     * @return Maybe<U>
     */
    public function map(callable $fn): MaybeStaticReflection
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

    private static function instanceHasValue(self $instance): bool
    {
        $valuePropertyReflection = self::$reflectionProperty ??= new ReflectionProperty(self::class, 'value');

        return $valuePropertyReflection->isInitialized($instance);
    }
}
