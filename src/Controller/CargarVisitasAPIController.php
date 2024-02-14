<?php

namespace App\Controller;

use App\Entity\Visita;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class CargarVisitasAPIController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/cargar_visitasAPI', name: 'cargar_visitasAPI')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if($_GET['localidad']==0){
            $visitas = $entityManager->getRepository(Visita::class)->findAll();
        }else{
            $visitas = $entityManager->getRepository(Visita::class)->findBy(['codLocalidad' => $_GET['localidad']]);
        }

        $json = new Response($this->serializer->serialize($visitas,"json"));
        
        return $json;
    }
}
