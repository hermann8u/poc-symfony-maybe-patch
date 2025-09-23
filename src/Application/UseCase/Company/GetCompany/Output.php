<?php

declare(strict_types=1);

namespace Application\UseCase\Company\GetCompany;

final readonly class Output
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $phoneNumber,
        public \DateTimeImmutable $foundedAt,
        public \DateTimeImmutable $createdAt,
    ) {
    }
}
