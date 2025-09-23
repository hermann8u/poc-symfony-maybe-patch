<?php

declare(strict_types=1);

namespace Application\Http\Response\Content;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final readonly class ValidationErrorList
{
    /**
     * @param ValidationError[] $errors
     */
    public function __construct(
        public array $errors,
    ) {
    }

    public static function fromConstraintViolationLists(ConstraintViolationListInterface $violations): self
    {
        return new self(errors: array_map(
            ValidationError::fromConstraintViolation(...),
            iterator_to_array($violations),
        ));
    }
}
