<?php

declare(strict_types=1);

namespace Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $foundedAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $name,
        \DateTimeImmutable $foundedAt,
    ) {
        $this->name = $name;
        $this->phoneNumber = null;
        $this->foundedAt = $foundedAt;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function changePhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function removePhoneNumber(): void
    {
        $this->phoneNumber = null;
    }

    public function getFoundedAt(): \DateTimeImmutable
    {
        return $this->foundedAt;
    }

    public function updateFoundedAt(\DateTimeImmutable $foundedAt): void
    {
        $this->foundedAt = $foundedAt;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
