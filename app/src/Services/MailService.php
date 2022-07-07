<?php 
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailService
{

    private $mailer; 

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function sendEmail($from, $subject, $text)
    {
        $email = (new Email())
            ->from($from)
            ->to('jacksoncurt11@gmail.com')
            ->subject($subject)
            ->text($text)
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}