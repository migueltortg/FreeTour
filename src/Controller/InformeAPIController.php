<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Informe;
use App\Entity\Tour;


class InformeAPIController extends AbstractController
{
    #[Route('/informeAPI', name: 'app_informe_a_p_i')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $idTour= substr($_POST['idTour'], 4);

        $query = $entityManager->createQuery('
            SELECT COUNT(i.id) as numInformes
            FROM App\Entity\Informe i
            WHERE i.codTour = :tourid
        ')->setParameter('tourid', $idTour);

        $resultado = $query->getOneOrNullResult();
        $numInformes = $resultado['numInformes'];

        if($numInformes<1){
            $informe=new Informe();
    
            $informe->setCodTour($entityManager->getRepository(Tour::class)->find($idTour));

            $file = $request->files->get('foto');

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('fotos_tours'),
                $fileName
            );
            $informe->setImagen($fileName);

            $informe->setObservaciones($_POST['observaciones']);

            $informe->setRecaudacion($_POST['recaudacion']);

            $entityManager->persist($informe);
            $entityManager->flush();

            return new Response("INFORME HECHO");
        }else{
            return new Response("YA HAY UN INFORME");
        }
        
    }
}
