<?php

namespace App\Entity;

use App\Repository\TourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourRepository::class)]
class Tour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ruta $codRuta = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_hora = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodRuta(): ?Ruta
    {
        return $this->codRuta;
    }

    public function setCodRuta(?Ruta $codRuta): static
    {
        $this->codRuta = $codRuta;

        return $this;
    }

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->fecha_hora;
    }

    public function setFechaHora(\DateTimeInterface $fecha_hora): static
    {
        $this->fecha_hora = $fecha_hora;

        return $this;
    }
}
