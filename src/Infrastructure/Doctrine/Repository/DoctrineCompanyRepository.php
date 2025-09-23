<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Domain\Company;
use Domain\CompanyRepository;
use Domain\Exception\EntityNotFoundException;

final readonly class DoctrineCompanyRepository implements CompanyRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function get(int $id): Company
    {
        $qb = $this->qb()
            ->where('c.id = :id')
            ->setParameter('id', $id)
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException) {
            throw new EntityNotFoundException(\sprintf('Company with ID %d not found.', $id));
        }
    }

    public function all(): array
    {
        $qb = $this->qb()
            ->orderBy('c.createdAt', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    private function qb(): QueryBuilder
    {
        return $this->em->createQueryBuilder()
            ->select('c')
            ->from(Company::class, 'c');
    }

    public function add(Company $company): void
    {
        $this->em->persist($company);
    }
}
