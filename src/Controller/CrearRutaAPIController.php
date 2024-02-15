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

class CrearRutaAPIController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/crearRutaAPI', name: 'crearRutaAPI')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
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

        $diasSemana = array(
            '1' => 'L',
            '2' => 'M',
            '3' => 'X',
            '4' => 'J',
            '5' => 'V',
            '6' => 'S',
            '7' => 'D'
        );

        if($_POST['tour']){
            //ARRAY DE OBJETOS CON PROGRAMACIONES
            foreach ($ruta->getProgramacion() as $programacion) {
                $rangoFechas = explode(" - ", $programacion['rangoFecha']);
                $fecha = DateTime::createFromFormat('d/m/Y', str_replace('\/', '/', $rangoFechas[0]));
                $fechaFin = DateTime::createFromFormat('d/m/Y', str_replace('\/', '/', $rangoFechas[1]));
                $intervalo = new DateInterval('P1D'); 
                $dias=explode(",", $programacion['dias']);

                while ( $fecha<= $fechaFin) {
                    if(array_search($diasSemana[$fecha->format('N')],$dias)!==false){

                        $tour=new Tour();
                        $tour->setCodRuta($ruta);
                        $fechaHora = DateTime::createFromFormat('Y-m-d H:i', $fecha->format('Y-m-d') . " " . $programacion['hora']);
                        $tour->setFechaHora($fechaHora);
                        $tour->setGuia($entityManager->getRepository(User::class)->findById("7")[0]);
                        $entityManager->persist($tour);
                    }
                    $fecha->add($intervalo);
                }
                $entityManager->flush();
            }
            return new Response("Tours generados");
        }else{
            return new Response("RUTA SOLO");
        }
    }
}