<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserTour;
use App\Entity\User;

class PasarListaAPIController extends AbstractController
{
    #[Route('/pasarListaAPI', name: 'app_pasar_lista_a_p_i')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $asistentes=explode(",",$_POST['arrayAsistentes']);
        
        $reservas=$entityManager->getRepository(UserTour::class)->findBy(['codTour' => $_POST['idTour']]);

        for($i=0;$i<count($reservas);$i++){
            if($reservas[$i]->getNumGenteReserva()>=$asistentes[$i]){
                $reservas[$i]->setAsistentes($asistentes[$i]);
            }
        }

        $entityManager->flush();

        return new Response("SE HA PASADO LISTA");
    }
}
