<?php

declare(strict_types=1);

namespace App\Tests\Functional\Application\Action\Company;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class PatchCompanyActionTest extends WebTestCase
{
    public function testPatchCompany(): void
    {
        $client = self::createClient();
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        $company = new Company(
            'Tiime',
            new \DateTimeImmutable('2020-01-01'),
        );

        $em->persist($company);
        $em->flush();

        $crawler = $client->request(Request::METHOD_PATCH, sprintf('/companies/%d', $company->getId()), content: json_encode([
            'name' => 'New Company Name',
            'phone_number' => '1234567890',
            'founded_at' => '2023-01-01',
        ]));

        dd($crawler->text());
    }
}
