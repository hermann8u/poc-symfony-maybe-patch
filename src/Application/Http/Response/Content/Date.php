<?php

declare(strict_types=1);

namespace Application\Http\Response\Content;

use DateTimeInterface;

final readonly class Date implements \JsonSerializable
{
    private function __construct(public DateTimeInterface $date)
    {
    }

    public static function create(DateTimeInterface $date): self
    {
        return new self($date);
    }

    public static function createOrNull(?DateTimeInterface $date): ?self
    {
        return $date !== null ? new self($date) : null;
    }

    public function jsonSerialize(): string
    {
        return $this->date->format('Y-m-d');
    }
}
