<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TourCalendarController extends AbstractController
{
    #[Route('/tourCalendar', name: 'tourCalendar')]
    public function index(): Response
    {
        return $this->render('tour_calendar/index.html.twig');
    }
}
