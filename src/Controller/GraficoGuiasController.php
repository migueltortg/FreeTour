<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraficoGuiasController extends AbstractController
{
    #[Route('/graficoGuias', name: 'app_grafico_guias')]
    public function index(): Response
    {
        return $this->render('grafico_guias/index.html.twig', [
            'controller_name' => 'GraficoGuiasController',
        ]);
    }
}
