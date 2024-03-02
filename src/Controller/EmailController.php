<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailService;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(MailService $email): Response
    {
        return new Response($email->sendEmail());
    }
}
