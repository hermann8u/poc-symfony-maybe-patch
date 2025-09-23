<?php

declare(strict_types=1);

namespace Application\Action\Companies\ListCompanies;

final readonly class ResponseContentItem
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
