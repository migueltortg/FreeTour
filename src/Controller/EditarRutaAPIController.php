<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ruta;
use App\Entity\Visita;
use DateTime;
use DateInterval;

class EditarRutaAPIController extends AbstractController
{
    #[Route('/editarRutaAPI', name: 'editarRutaAPI')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rutaArray = json_decode($_POST['ruta'], true); 

        $ruta=$entityManager->getRepository(Ruta::class)->find($_POST['id']);

        $ruta->setNombre($rutaArray['titulo']);
        $ruta->setDescripcion($rutaArray['descripcion']);

        $ruta->setPuntoInicio($rutaArray['punto_inicio']);
        $ruta->setAforo($rutaArray['aforo']);

        $fecha_inicio = DateTime::createFromFormat('d/m/Y', $rutaArray['fecha_inicio']);
        $fecha_fin = DateTime::createFromFormat('d/m/Y', $rutaArray['fecha_fin']);

        $ruta->setFechaInicio($fecha_inicio);
        $ruta->setFechaFin($fecha_fin);

        foreach ($ruta->getVisitas() as $visita) {
            $ruta->removeVisita($visita);
        }

        foreach ($rutaArray['visitas'] as $visitaId) {
            $visita = $entityManager->getRepository(Visita::class)->find($visitaId);
            if ($visita) {
                $ruta->addVisita($visita);
            } else {
                throw new \Exception('La visita con el ID ' . $visitaId . ' no existe.');
            }
        }

        $ruta->setProgramacion(json_decode($rutaArray['programacion'], true));

        if($request->files->get('foto')){
            $file = $request->files->get('foto');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('fotos_rutas'),
                $fileName
            );
            $ruta->setFoto($fileName);
        }

        $entityManager->persist($ruta);
        $entityManager->flush();

        return new Response("Ruta editada");
    }
}