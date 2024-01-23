<?php

namespace App\Entity;

use App\Repository\UserTourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserTourRepository::class)]
class UserTour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $codUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tour $codTour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodUser(): ?User
    {
        return $this->codUser;
    }

    public function setCodUser(?User $codUser): static
    {
        $this->codUser = $codUser;

        return $this;
    }

    public function getCodTour(): ?Tour
    {
        return $this->codTour;
    }

    public function setCodTour(?Tour $codTour): static
    {
        $this->codTour = $codTour;

        return $this;
    }
}
