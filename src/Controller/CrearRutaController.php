<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Localidad;
use App\Entity\User;
use App\Repository\UserRepository; 
use Symfony\Component\Routing\Annotation\Route;

class CrearRutaController extends AbstractController
{
    #[Route('/crearRuta', name: 'crearRuta')]
    public function index(EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        return $this->render('crear_ruta/index.html.twig', [
            'localidades' => $entityManager->getRepository(Localidad::class)->findAll(),
            'guias' => $entityManager->getRepository(User::class)->findByRoles(['ROLE_GUIDE'])
        ]);
    }

    
}
