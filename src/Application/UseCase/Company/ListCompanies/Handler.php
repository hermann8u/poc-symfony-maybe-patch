<?php

declare(strict_types=1);

namespace Application\UseCase\Company\ListCompanies;

use Domain\Company;
use Domain\CompanyRepository;

final readonly class Handler
{
    public function __construct(
        private CompanyRepository $companyRepository,
    ) {
    }

    public function handle(Input $input): Output
    {
        $companies = $this->companyRepository->all();

        return new Output(array_map(
            static fn (Company $company) => new OutputItem(
                id: $company->getId(),
                name: $company->getName(),
            ),
            $companies,
        ));
    }
}
