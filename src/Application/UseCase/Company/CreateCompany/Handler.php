<?php

declare(strict_types=1);

namespace Application\UseCase\Company\CreateCompany;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Company;
use Domain\CompanyRepository;
use Domain\Exception\EntityNotFoundException;

final readonly class Handler
{
    public function __construct(
        private CompanyRepository $companyRepository,
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function handle(Input $input): void
    {
        $company = new Company(
            $input->name,
            \DateTimeImmutable::createFromFormat('!Y-m-d', $input->foundedAt),
        );

        if ($input->phoneNumber) {
            $company->changePhoneNumber($input->phoneNumber);
        }

        $this->companyRepository->add($company);
        $this->em->flush();
    }
}
