<?php

declare(strict_types=1);

namespace Application\Action\Companies\CreateCompany;

use Application\Http\Response\Content\ValidationErrorList;
use Application\UseCase\Company\CreateCompany\Handler;
use Application\UseCase\Company\CreateCompany\Input;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(
    '/companies',
    methods: ['POST'],
)]
final readonly class Action
{
    public function __construct(
        private ValidatorInterface $validator,
        private Handler $handler,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->getPayload();

        if ($violationResponse = $this->validate($data)) {
            return $violationResponse;
        }

        $this->handler->handle(new Input(
            name: $data->getString('name'),
            foundedAt: $data->getString('founded_at'),
            phoneNumber: $data->get('phone_number'),
        ));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

    private function validate(InputBag $data): ?Response
    {
        $violations = $this->validator->validate($data->all(), new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
            ],
            'founded_at' => [
                new Assert\NotBlank(),
                new Assert\Date(),
            ],
            'phone_number' => new Assert\Optional([
                new Assert\NotBlank(allowNull: true),
                new Assert\Length(max: 15),
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
