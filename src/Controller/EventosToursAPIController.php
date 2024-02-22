<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Tour;

class EventosToursAPIController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/eventosToursAPI', name: 'app_eventos_tours_a_p_i')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tours = $entityManager->getRepository(Tour::class)->findAll();
        $jsonData = $this->serializer->serialize($tours, 'json');

        return new Response($jsonData, 200, ['Content-Type' => 'application/json']);
    }
}
