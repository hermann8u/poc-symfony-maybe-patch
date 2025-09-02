<?php

declare(strict_types=1);

namespace Application\UseCase\Company\GetCompany;

final readonly class Input
{
    public function __construct(
        public int $id,
    ) {
    }
}
