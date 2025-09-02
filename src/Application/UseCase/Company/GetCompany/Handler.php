<?php

declare(strict_types=1);

namespace Application\UseCase\Company\GetCompany;

use Domain\CompanyRepository;

final readonly class Handler
{
    public function __construct(
        private CompanyRepository $companyRepository,
    ) {
    }

    public function handle(Input $input): Output
    {
        $company = $this->companyRepository->get($input->id);

        return new Output($company);
    }
}
