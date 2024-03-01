<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Localidad;

class ObtenerlocAPIController extends AbstractController
{
    #[Route('/obtenerlocAPI', name: 'app_obtenerloc_a_p_i')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $loc = $entityManager->getRepository(Localidad::class)->findOneBy(['nombre' => $_POST['nombreloc']]);

        return new Response($loc->getId());
    }
}
