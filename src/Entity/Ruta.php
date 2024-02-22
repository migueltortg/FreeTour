<?php

namespace App\Entity;

use App\Repository\RutaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $punto_inicio = null;

    #[ORM\Column]
    private ?int $aforo = null;

    #[ORM\ManyToMany(targetEntity: Visita::class, inversedBy: 'rutas')]
    private Collection $visitas;

    #[ORM\Column(type: 'date',nullable:true)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: 'date',nullable:true)]
    private ?\DateTimeInterface $fechaFin = null;

    #[ORM\Column(type: 'json')]
    private array $programacion = [];

    public function __construct()
    {
        $this->visitas = new ArrayCollection();
    }

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

    public function getAforo(): ?int
    {
        return $this->aforo;
    }

    public function setAforo(int $aforo): static
    {
        $this->aforo = $aforo;

        return $this;
    }

    /**
     * @return Collection<int, Visita>
     */
    public function getVisitas(): Collection
    {
        return $this->visitas;
    }

    public function addVisita(Visita $visita): static
    {
        if (!$this->visitas->contains($visita)) {
            $this->visitas->add($visita);
        }

        return $this;
    }

    public function removeVisita(Visita $visita): static
    {
        $this->visitas->removeElement($visita);

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getProgramacion(): array
    {
        return $this->programacion;
    }

    public function setProgramacion(array $programacion): static
    {
        $this->programacion = $programacion;

        return $this;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getId(),
            'nombre'=> $this->getNombre(),
            'descripcion'=> $this->getDescripcion(),
            'foto' => $this->getFoto(),
            'punto_inicio' => $this->getPuntoInicio(),
            'aforo' => $this->getAforo(),
            'fecha_incio' => $this->getFechaInicio(),
            'fecha_incio' => $this->getFechaFin(),
            'programacion' => $this->getProgramacion(),
        ];
    }
}
