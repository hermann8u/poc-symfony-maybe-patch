<?php

declare(strict_types=1);

namespace Application\UseCase\Company\ListCompanies;

final readonly class OutputItem
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
