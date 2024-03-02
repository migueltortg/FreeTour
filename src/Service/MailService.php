<?php
// src/Service/MailService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;


class MailService
{

    public function sendEmail($dest,$ruta,$fechaRuta): void
    {
        $email = (new Email())
            ->from('FreeTour@reserva.com')
            ->to($dest)
            ->subject('Reserva FreeTour')
            ->text('FreeTour')
            ->html('<p>Has realizado una reserva para la ruta "'.$ruta.'" el '.$fechaRuta.'</p>');

        $dsn = 'smtp://localhost:1025';

        $transport = Transport::fromDsn($dsn);

        $mailer = new Mailer($transport);

        $mailer->send($email);
    }
}