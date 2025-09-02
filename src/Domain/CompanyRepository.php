<?php

declare(strict_types=1);

namespace Domain;

use Domain\Exception\EntityNotFoundException;

interface CompanyRepository
{
    /**
     * @throws EntityNotFoundException
     */
    public function get(int $id): Company;
}
