<?php

namespace App\Entity;

use App\Enum\ToyRequestStatus;
use App\Repository\ToyRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyRequestRepository::class)]
class ToyRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'toyRequests')]
    private ?User $kid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: ToyRequestStatus::class)]
    private array $status = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKid(): ?User
    {
        return $this->kid;
    }

    public function setKid(?User $kid): static
    {
        $this->kid = $kid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ToyRequestStatus[]
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    public function setStatus(array $status): static
    {
        $this->status = $status;

        return $this;
    }
}
