<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ruta;

class RutaIdController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/rutaId', name: 'app_ruta_id')]
    public function index(EntityManagerInterface $entityManagerInterface): Response
    {
    
        $ruta = $entityManagerInterface->getRepository(Ruta::class)->find($_POST['id']);

        $rutaJSON = $this->serializer->serialize($ruta, 'json');

        return new Response($rutaJSON);
    }
}
