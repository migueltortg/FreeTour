<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserTour;

class CancelarReservaController extends AbstractController
{
    #[Route('/cancelarReserva', name: 'app_cancelar_reserva')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reserva=$entityManager->getRepository(UserTour::class)->findBy(['id' => $_POST['idReserva']])[0];

        $entityManager->remove($reserva);
        $entityManager->flush();

        return new Response("RESERVA CANCELADA");
    }
}
