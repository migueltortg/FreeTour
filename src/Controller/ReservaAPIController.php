<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Tour;
use App\Entity\UserTour;
use DateTime;
use DateTimeInterface;

class ReservaAPIController extends AbstractController
{
    #[Route('/reservarAPI', name: 'app_reserva_a_p_i')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tour=$entityManager->getRepository(Tour::class)->find($_POST['idTour']);
        $aforo=$tour->getCodRuta()->getAforo();

        $query = $entityManager->createQuery('
            SELECT SUM(u.numGenteReserva) AS totalGente
            FROM App\Entity\UserTour u
            WHERE u.codTour = :tourId
        ')->setParameter('tourId', $_POST['idTour']);

        $result = $query->getOneOrNullResult();
        $genteApuntada = $result['totalGente'];

        if($_POST['numAsistentes']<= ($aforo-$genteApuntada)){
            $fechaReservaString = substr($_POST['fechaReserva'], 0, strpos($_POST['fechaReserva'], 'GMT'));
            $fechaReserva = new DateTime($fechaReservaString);
    
            $reserva=new UserTour();
            $reserva->setCodUser($entityManager->getRepository(User::class)->find($_POST['idUser']));
            $reserva->setCodTour($tour);
            $reserva->setFechaReserva($fechaReserva);
            $reserva->setNumGenteReserva($_POST['numAsistentes']);
    
            $entityManager->persist($reserva);
            $entityManager->flush();
    
            return new Response("RESERVA HECHA");
        }else{
            return new Response("AFORO COMPLETO");
        }
    }
}