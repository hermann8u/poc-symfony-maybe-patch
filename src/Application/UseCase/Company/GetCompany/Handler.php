<?php

declare(strict_types=1);

namespace Application\UseCase\Company\GetCompany;

use Domain\CompanyRepository;
use Domain\Exception\EntityNotFoundException;

final readonly class Handler
{
    public function __construct(
        private CompanyRepository $companyRepository,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function handle(Input $input): Output
    {
        $company = $this->companyRepository->get($input->id);

        return new Output(
            id: $company->getId(),
            name: $company->getName(),
            phoneNumber: $company->getPhoneNumber(),
            foundedAt: $company->getFoundedAt(),
            createdAt: $company->getCreatedAt(),
        );
    }
}
