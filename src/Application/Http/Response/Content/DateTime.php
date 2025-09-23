<?php

declare(strict_types=1);

namespace Application\Http\Response\Content;

use DateTimeInterface;

final readonly class DateTime implements \JsonSerializable
{
    private function __construct(public DateTimeInterface $dateTime)
    {
    }

    public static function create(DateTimeInterface $dateTime): self
    {
        return new self($dateTime);
    }

    public static function createOrNull(?DateTimeInterface $dateTime): ?self
    {
        return $dateTime !== null ? new self($dateTime) : null;
    }

    public function jsonSerialize(): string
    {
        return $this->dateTime->format(DateTimeInterface::ATOM);
    }
}
