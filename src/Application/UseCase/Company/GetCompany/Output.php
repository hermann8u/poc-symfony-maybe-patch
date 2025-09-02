<?php

declare(strict_types=1);

namespace Application\UseCase\Company\GetCompany;

use Domain\Company;

final readonly class Output
{
    public function __construct(
        public Company $company
    ) {
    }
}
