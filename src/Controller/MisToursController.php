<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserTour;
use App\Entity\Tour;

class MisToursController extends AbstractController
{
    #[Route('/mis_tours', name: 'mis_tours')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('mis_tours/index.html.twig', [
            'reservas' => $entityManager->getRepository(UserTour::class)->findBy(['codUser' => $this->getUser()->getId()]),
            'tourGuias' => $entityManager->getRepository(Tour::class)->findBy(['guia' => $this->getUser()->getId()])
        ]);
    }
}