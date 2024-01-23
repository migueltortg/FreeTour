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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserTour $codReserva = null;

    #[ORM\Column]
    private ?int $notaGuia = null;

    #[ORM\Column]
    private ?int $notaRuta = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comentario = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNotaGuia(): ?int
    {
        return $this->notaGuia;
    }

    public function setNotaGuia(int $notaGuia): static
    {
        $this->notaGuia = $notaGuia;

        return $this;
    }

    public function getNotaRuta(): ?int
    {
        return $this->notaRuta;
    }

    public function setNotaRuta(int $notaRuta): static
    {
        $this->notaRuta = $notaRuta;

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
}
