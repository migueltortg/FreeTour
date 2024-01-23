<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionRepository::class)]
class Valoracion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nota_guia = null;

    #[ORM\Column]
    private ?int $nota_ruta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comentario = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserTour $codReserva = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotaGuia(): ?int
    {
        return $this->nota_guia;
    }

    public function setNotaGuia(int $nota_guia): static
    {
        $this->nota_guia = $nota_guia;

        return $this;
    }

    public function getNotaRuta(): ?int
    {
        return $this->nota_ruta;
    }

    public function setNotaRuta(int $nota_ruta): static
    {
        $this->nota_ruta = $nota_ruta;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getCodReserva(): ?UserTour
    {
        return $this->codReserva;
    }

    public function setCodReserva(UserTour $codReserva): static
    {
        $this->codReserva = $codReserva;

        return $this;
    }
}
