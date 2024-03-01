<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class ProrrogarRutaController extends AbstractController
{
    #[Route('/prorrogarRuta', name: 'prorrogarRuta')]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        return $this->render('prorrogar_ruta/index.html.twig', [
            'guias' => $entityManager->getRepository(User::class)->findByRoles(['ROLE_GUIDE']),
        ]);
    }
}
