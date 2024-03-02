<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\User;
use App\Entity\Valoracion;

class ValoracionGUIASController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/valoracionGUIAS', name: 'app_valoracion_g_u_i_a_s')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $guias=$entityManager->getRepository(User::class)->findByRoles(['ROLE_GUIDE']);

        $resultados=[];

        foreach($guias as $guia){
            $query = $entityManager->createQuery('
                SELECT DISTINCT v, us.email
                FROM App\Entity\Valoracion v
                JOIN v.codReserva u
                JOIN u.codTour t
                JOIN t.guia us
                WHERE t.guia = :guiaId
            ')->setParameter('guiaId', $guia->getId());

            $resultado = $query->getResult();
            array_push($resultados,$resultado);
        }
        
        $json=json_encode($resultados);

        return new Response($json);
    }
}
