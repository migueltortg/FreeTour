<?php

namespace App\Entity;

use App\Repository\InformeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformeRepository::class)]
class Informe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imagen = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column]
    private ?int $recaudacion = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tour $codTour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getRecaudacion(): ?int
    {
        return $this->recaudacion;
    }

    public function setRecaudacion(int $recaudacion): static
    {
        $this->recaudacion = $recaudacion;

        return $this;
    }

    public function getCodTour(): ?Tour
    {
        return $this->codTour;
    }

    public function setCodTour(Tour $codTour): static
    {
        $this->codTour = $codTour;

        return $this;
    }
}
