<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function senEmail(MailerInterface $mailer): Response
    {

        $email = (new Email())
                    ->from('crudprodut@crud.com')
                    ->to('danieldeveloper@example.com')
                    ->subject('Tu produto esta en proceso')
                    ->html('<p>Gracias por realizar la compra</p>');

        $transport = Transport::fromDsn('smtp://mailhog:1025');

        $mailer = new Mailer($transport);

        $mailer->send($email);

        return new Response('Email enviado');
    }
}
