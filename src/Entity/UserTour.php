<?php

namespace App\Entity;

use App\Repository\UserTourRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaReserva = null;

    #[ORM\Column(nullable: true)]
    private ?int $asistentes = null;

    #[ORM\Column]
    private ?int $numGenteReserva = null;

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

    public function getFechaReserva(): ?\DateTimeInterface
    {
        return $this->fechaReserva;
    }

    public function setFechaReserva(\DateTimeInterface $fechaReserva): static
    {
        $this->fechaReserva = $fechaReserva;

        return $this;
    }

    public function getAsistentes(): ?int
    {
        return $this->asistentes;
    }

    public function setAsistentes(int $asistentes): static
    {
        $this->asistentes = $asistentes;

        return $this;
    }

    public function getNumGenteReserva(): ?int
    {
        return $this->numGenteReserva;
    }

    public function setNumGenteReserva(int $numGenteReserva): static
    {
        $this->numGenteReserva = $numGenteReserva;

        return $this;
    }
}
