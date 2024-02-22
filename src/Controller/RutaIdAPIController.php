<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ruta;
use App\Entity\Tour;

class RutaIdAPIController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/rutaIdAPI', name: 'app_ruta_id_a_p_i')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $tourId = $request->query->get('idRuta');
    
        $tour = $entityManagerInterface->getRepository(Tour::class)->buscarID($tourId);

        $serializedTour = $this->serializer->serialize($tour->getCodRuta(), 'json');

        return new Response($serializedTour);
    }
}