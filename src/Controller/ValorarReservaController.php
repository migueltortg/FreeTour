<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Valoracion;
use App\Entity\UserTour;

class ValorarReservaController extends AbstractController
{
    #[Route('/valorarReserva', name: 'app_valorar_reserva')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $query = $entityManager->createQuery('
            SELECT COUNT(v.id) AS numValoracion
            FROM App\Entity\Valoracion v
            WHERE v.codReserva = :idReserva
        ')->setParameter('idReserva', $_POST['idReserva']);

        $resultado = $query->getOneOrNullResult();
        $numValoracion = $resultado['numValoracion'];

        if($numValoracion<1){
            $valoracion=new Valoracion();
            $valoracion->setCodReserva($entityManager->getRepository(UserTour::class)->findBy(['id' => $_POST['idReserva']])[0]);
            $valoracion->setNotaGuia($_POST['notaGuia']);
            $valoracion->setNotaRuta($_POST['notaRuta']);
            $valoracion->setComentario($_POST['comentarios']);
    
            $entityManager->persist($valoracion);
            $entityManager->flush();
    
            return new Response("VALORACION HECHA");
        }else{
            return new Response("YA EXISTE UNA VALORACION");
        }
    }
}
