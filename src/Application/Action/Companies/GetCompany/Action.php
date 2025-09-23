<?php

declare(strict_types=1);

namespace Application\Action\Companies\GetCompany;

use Application\UseCase\Company\GetCompany\Handler;
use Application\UseCase\Company\GetCompany\Input;
use Domain\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    '/companies/{id<\d+>}',
    methods: ['GET'],
)]
final readonly class Action
{
    public function __construct(
        private Handler $handler,
    ) {
    }

    public function __invoke(int $id): Response
    {
        try {
            $output = $this->handler->handle(new Input($id));
        } catch (EntityNotFoundException) {
            return new JsonResponse(
                data: ['error' => 'Company not found'],
                status: Response::HTTP_NOT_FOUND,
            );
        }

        return new JsonResponse(ResponseContent::fromOutput($output), json: false);
    }
}
