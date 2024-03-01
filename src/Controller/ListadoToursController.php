<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ruta;
use Doctrine\ORM\EntityManagerInterface;


class ListadoToursController extends AbstractController
{
    #[Route('/listadoTours', name: 'listado_tours')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('listado_tours/index.html.twig', [
            'controller_name' => 'ListadoToursController',
            'rutas' => $entityManager->getRepository(Ruta::class)->findAll(),
        ]);
    }

    #[Route('/listadoTours/localidad/{loc}', name: 'listado_toursLoc')]
    public function porLoc(EntityManagerInterface $entityManager,$loc): Response
    {
        $query = $entityManager->createQuery(
            'SELECT DISTINCT r FROM App\Entity\Ruta r
            JOIN r.visitas v
            WHERE v.codLocalidad = :localidad'
        );

        $query->setParameter('localidad', $loc);

        $rutas = $query->getResult();

        return $this->render('listado_tours/index.html.twig', [
            'controller_name' => 'ListadoToursController',
            'rutas' => $rutas,
        ]);
    }
}
