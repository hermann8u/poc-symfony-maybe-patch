<?php

declare(strict_types=1);

namespace Maybe;

/**
 * @see https://hackernoon.com/say-goodbye-to-null-checking-and-exceptions-using-the-maybe-monad-in-symfony
 * @see https://marcosh.github.io/post/2017/06/16/maybe-in-php.html
 * @see https://github.com/php-fp/php-fp-maybe
 *
 * @template T of mixed
 */
final readonly class Maybe
{
    /** @var T */
    private mixed $value;

    private function __construct()
    {
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
        return $this->hasValue() ? self::just($fn($this->value)) : self::nothing();
    }

    /**
     * @param callable(T): void $fn
     */
    public function do(callable $fn): void
    {
        if (!$this->hasValue()) {
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
        return $this->hasValue() ? $this->value : $defaultValue;
    }

    private function hasValue(): bool
    {
        try {
            $this->value;

            return true;
        } catch (\Error) {
            return false;
        }
    }
}
