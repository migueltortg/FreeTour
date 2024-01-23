<?php

namespace App\Entity;

use App\Repository\RutaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RutaRepository::class)]
class Ruta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localidad $codLocalidad = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $punto_inicio = null;

    #[ORM\Column]
    private array $Horario = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodLocalidad(): ?Localidad
    {
        return $this->codLocalidad;
    }

    public function setCodLocalidad(?Localidad $codLocalidad): static
    {
        $this->codLocalidad = $codLocalidad;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getPuntoInicio(): ?string
    {
        return $this->punto_inicio;
    }

    public function setPuntoInicio(string $punto_inicio): static
    {
        $this->punto_inicio = $punto_inicio;

        return $this;
    }
}
