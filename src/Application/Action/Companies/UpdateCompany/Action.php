<?php

declare(strict_types=1);

namespace Application\Action\Companies\UpdateCompany;

use Application\Http\Response\Content\ValidationErrorList;
use Application\Initializer;
use Application\UseCase\Company\UpdateCompany\Handler;
use Application\UseCase\Company\UpdateCompany\Input;
use Domain\Exception\EntityNotFoundException;
use Maybe\Maybe;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(
    '/companies/{id<\d+>}',
    methods: ['PATCH'],
)]
final readonly class Action
{
    public function __construct(
        private ValidatorInterface $validator,
        private Initializer $initializer,
        private Handler $handler,
    ) {
    }

    public function __invoke(Request $request, int $id): Response
    {
        $data = $request->getPayload();

        if ($violationResponse = $this->validate($data)) {
            return $violationResponse;
        }

        // With Initializer, we can easily create Input DTOs with optional fields
        $input = $this->initializer->initialize(
            Input::class,
            $data,
            id: $id,
        );

        // Manually create Input DTO without Initializer
        $input = new Input(
            id: $id,
            name: $data->has('name') ? Maybe::just($data->getString('name')) : Maybe::nothing(),
            phoneNumber: $data->has('phone_number') ? Maybe::just($data->get('phone_number')) : Maybe::nothing(),
            foundedAt: $data->has('founded_at') ? Maybe::just($data->getString('founded_at')) : Maybe::nothing(),
        );

        try {
            $this->handler->handle($input);
        } catch (EntityNotFoundException) {
            return new JsonResponse(
                data: ['error' => 'Company not found'],
                status: Response::HTTP_NOT_FOUND,
            );
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

    private function validate(InputBag $data): ?Response
    {
        $violations = $this->validator->validate($data->all(), new Assert\Collection([
            'name' => new Assert\Optional([
                new Assert\NotBlank(),
            ]),
            'phone_number' => new Assert\Optional([
                new Assert\NotBlank(allowNull: true),
                new Assert\Length(max: 15),
            ]),
            'founded_at' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Date(),
            ]),
        ]));

        if ($violations->count() === 0) {
            return null;
        }

        return new JsonResponse(
            data: ValidationErrorList::fromConstraintViolationLists($violations),
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}
