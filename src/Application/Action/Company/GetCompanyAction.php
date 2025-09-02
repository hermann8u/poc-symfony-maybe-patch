<?php

declare(strict_types=1);

namespace Application\Action\Company;

use Application\UseCase\Company\GetCompany\Handler;
use Application\UseCase\Company\GetCompany\Input;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    '/companies/{id<\d+>}',
    methods: ['GET'],
)]
final readonly class GetCompanyAction
{
    public function __construct(
        private SerializerInterface $serializer,
        private Handler $handler,
    ) {
    }

    public function __invoke(Request $request, int $id): Response
    {
        $output = $this->handler->handle(new Input($id));

        return new JsonResponse(
            $this->serializer->serialize(
                $output->company,
                'json',
            ),
            json: true,
        );
    }
}
