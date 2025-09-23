<?php

declare(strict_types=1);

namespace Application\UseCase\Company\CreateCompany;

final readonly class Input
{
    public function __construct(
        public string $name,
        public string $foundedAt,
        public ?string $phoneNumber,
    ) {
    }
}
