<?php

namespace App\Entity;

use App\Repository\RutaVisitaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RutaVisitaRepository::class)]
class RutaVisita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ruta $codRuta = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Visita $codVisita = null;

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

    public function getCodVisita(): ?Visita
    {
        return $this->codVisita;
    }

    public function setCodVisita(?Visita $codVisita): static
    {
        $this->codVisita = $codVisita;

        return $this;
    }
}
