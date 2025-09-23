<?php

declare(strict_types=1);

namespace Application\Action\Companies\ListCompanies;

use Application\UseCase\Company\ListCompanies\Handler;
use Application\UseCase\Company\ListCompanies\Input;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    '/companies',
    methods: ['GET'],
)]
final readonly class Action
{
    public function __construct(
        private Handler $handler,
    ) {
    }

    public function __invoke(): Response
    {
        $output = $this->handler->handle(new Input());

        return new JsonResponse(ResponseContent::fromOutput($output));
    }
}
