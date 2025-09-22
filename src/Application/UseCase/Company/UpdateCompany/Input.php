<?php

declare(strict_types=1);

namespace Application\UseCase\Company\UpdateCompany;

use Maybe\Maybe;

final readonly class Input
{
    /**
     * @param Maybe<string> $name
     * @param Maybe<string|null> $phoneNumber
     * @param Maybe<string> $foundedAt
     */
    public function __construct(
        public int $id,
        public Maybe $name,
        public Maybe $phoneNumber,
        public Maybe $foundedAt,
    ) {
    }
}
