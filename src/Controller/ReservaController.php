<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ruta;
use App\Entity\Tour;

class ReservaController extends AbstractController
{
    #[Route('/reservar/{id}', name: 'app_reserva')]
    public function index(int $id,EntityManagerInterface $entityManager,Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('reserva/index.html.twig', [
            'controller_name' => 'ReservaController',
            'user' => $user,
            'ruta' => $entityManager->getRepository(Ruta::class)->findById($id)[0],
            'tours' => $entityManager->getRepository(Tour::class)->findBy(['codRuta' => $id],['fecha_hora' => 'ASC']),
        ]);
    }
}