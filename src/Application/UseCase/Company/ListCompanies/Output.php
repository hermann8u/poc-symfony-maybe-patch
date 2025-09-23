<?php

declare(strict_types=1);

namespace Application\UseCase\Company\ListCompanies;

final readonly class Output
{
    /**
     * @param OutputItem[] $items
     */
    public function __construct(
        public array $items,
    ) {
    }
}
