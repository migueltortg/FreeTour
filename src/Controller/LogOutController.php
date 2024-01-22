<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogOutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout')]
    public function logout():Response
    {
        return new RedirectResponse($this->generateUrl('home'));
    }
}
