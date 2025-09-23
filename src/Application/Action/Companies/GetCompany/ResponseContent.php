<?php

declare(strict_types=1);

namespace Application\Action\Companies\GetCompany;

use Application\Http\Response\Content\Date;
use Application\Http\Response\Content\DateTime;
use Application\UseCase\Company\GetCompany\Output;

final readonly class ResponseContent
{
    private function __construct(
        public int $id,
        public string $name,
        public ?string $phone_number,
        public Date $founded_at,
        public DateTime $created_at,
    ) {
    }

    public static function fromOutput(Output $output): self
    {
        return new self(
            id: $output->id,
            name: $output->name,
            phone_number: $output->phoneNumber,
            founded_at: Date::create($output->foundedAt),
            created_at: DateTime::create($output->createdAt),
        );
    }
}
