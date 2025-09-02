<?php

declare(strict_types=1);

namespace Application\UseCase\Company\UpdateCompany;

use Doctrine\ORM\EntityManagerInterface;
use Domain\CompanyRepository;

final readonly class Handler
{
    public function __construct(
        private CompanyRepository $companyRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function handle(Input $input): void
    {
        $company = $this->companyRepository->get($input->id);

        $input->name->do(static fn (string $name) => $company->changeName($name));

        $input->phoneNumber->do(static fn (?string $phoneNumber) => \is_string($phoneNumber)
            ? $company->changePhoneNumber($phoneNumber)
            : $company->removePhoneNumber()
        );

        $input->foundedAt
            ->map(static fn (string $foundedAt) => \DateTimeImmutable::createFromFormat('!Y-m-d', $foundedAt))
            ->do(static fn (\DateTimeImmutable $foundedAt) => $company->updateFoundedAt($foundedAt))
        ;

        $this->em->flush();
    }
}
