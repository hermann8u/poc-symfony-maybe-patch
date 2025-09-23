<?php

declare(strict_types=1);

namespace Application\Http\Response\Content;

use Symfony\Component\Validator\ConstraintViolationInterface;

final readonly class ValidationError
{
    public function __construct(
        public string $property,
        public string $message,
    ) {
    }

    public static function fromConstraintViolation(ConstraintViolationInterface $constraintViolation): self
    {
        return new self(
            self::normalizePropertyPath($constraintViolation->getPropertyPath()),
            $constraintViolation->getMessage(),
        );
    }

    /**
     * Converts property paths like "[items][0][name]" to "items.0.name"
     *
     * @param string $propertyPath
     * @return string
     */
    private static function normalizePropertyPath(string $propertyPath): string
    {
        preg_match_all('/\[(.*?)]/', $propertyPath, $matches);

        return implode('.', $matches[1]);
    }
}
