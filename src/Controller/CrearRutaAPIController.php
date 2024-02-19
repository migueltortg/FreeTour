<?php

namespace App\Controller;

use App\Entity\Visita;
use App\Entity\Ruta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use DateInterval;
use App\Entity\Tour;
use App\Entity\User;
use App\Service\crearTour;

class CrearRutaAPIController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/crearRutaAPI', name: 'crearRutaAPI')]
    public function index(Request $request, EntityManagerInterface $entityManager, crearTour $crearTour): Response
    {
        $rutaArray = json_decode($_POST['ruta'], true); 

        $ruta = new Ruta();
        $ruta->setNombre($rutaArray['titulo']);
        $ruta->setDescripcion($rutaArray['descripcion']);

        $ruta->setPuntoInicio($rutaArray['punto_inicio']);
        $ruta->setAforo($rutaArray['aforo']);

        $fecha_inicio = DateTime::createFromFormat('d/m/Y', $rutaArray['fecha_inicio']);
        $fecha_fin = DateTime::createFromFormat('d/m/Y', $rutaArray['fecha_fin']);

        $ruta->setFechaInicio($fecha_inicio);
        $ruta->setFechaFin($fecha_fin);

        foreach ($rutaArray['visitas'] as $visitaId) {
            $visita = $entityManager->getRepository(Visita::class)->find($visitaId);
            if ($visita) {
                $ruta->addVisita($visita);
            } else {
                throw new \Exception('La visita con el ID ' . $visitaId . ' no existe.');
            }
        }

        // Set programación
        $ruta->setProgramacion(json_decode($rutaArray['programacion'], true));

        $file = $request->files->get('foto');
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move(
            $this->getParameter('fotos_rutas'),
            $fileName
        );
        $ruta->setFoto($fileName);
        
        $entityManager->persist($ruta);
        $entityManager->flush();


        if($_POST['tour']=="true"){
            return $crearTour->crear($ruta,$_POST['guia']);
        }else{
            return new Response("RUTA SOLO");
        }
    }
}