<?php

declare(strict_types=1);

namespace Application\Action\Companies\ListCompanies;

use Application\UseCase\Company\ListCompanies\Output;
use Application\UseCase\Company\ListCompanies\OutputItem;

final readonly class ResponseContent
{
    /**
     * @param ResponseContentItem[] $companies
     */
    private function __construct(
        public array $companies,
    ) {
    }

    public static function fromOutput(Output $output): self
    {
        return new self(companies: array_map(
            static fn (OutputItem $item) => new ResponseContentItem(
                id: $item->id,
                name: $item->name,
            ),
            $output->items,
        ));
    }
}
