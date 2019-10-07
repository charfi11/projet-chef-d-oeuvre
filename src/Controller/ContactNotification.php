<?php

namespace App\Controller;

use App\Entity\User;
use Twig\Environment;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;
     
    public function __construct(\Swift_Mailer $mailer, Environment $renderer){

        $this->mailer = $mailer;
        $this->renderer = $renderer;

    }

    public function notify(User $user){

    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('charfi1108@gmail.com')
        ->setTo($user->getMail())
        ->setReplyTo($user->getMail())
        ->setBody(
            $this->renderer->render(
                'registration.html.twig',
                ['user' => $user]
            ),
            'text/html'
        );

    $this->mailer->send($message);
}

public function notifyGroupe(User $user){

    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('charfi1108@gmail.com')
        ->setTo($user->getMail())
        ->setReplyTo($user->getMail())
        ->setBody(
            $this->renderer->render(
                'registrationGroupe.html.twig',
                ['user' => $user]
            ),
            'text/html'
        );

    $this->mailer->send($message);
}

public function notifyInvite(User $user){
   
    $message = (new \Swift_Message('Hello Email'));

        $message->setTo($user->getMail())
                ->setReplyTo($user->getMail())
        ->setFrom('charfi1108@gmail.com')
        ->setBody(
            $this->renderer->render(
                'registrationInvite.html.twig',
                ['user' => $user]
            ),
            'text/html'
        );

    $this->mailer->send($message);
    
}

public function notifyGroupeTraining(User $user){
    $message = (new \Swift_Message('Hello Email'));
        $message->setTo($user->getMail())
                ->setReplyTo($user->getMail())
        ->setFrom('charfi1108@gmail.com')
        ->setBody(
            $this->renderer->render(
                'registrationGroupeTraining.html.twig',
                ['user' => $user]
            ),
            'text/html'
        );

    $this->mailer->send($message);
}

public function notifyGroupeEvent(User $user){
    $message = (new \Swift_Message('Hello Email'));


        $message->setTo($user->getMail())
                ->setReplyTo($user->getMail())
        ->setFrom('charfi1108@gmail.com')
        ->setBody(
            $this->renderer->render(
                'registrationGroupeEvents.html.twig',
                ['user' => $user]
            ),
            'text/html'
        );

    $this->mailer->send($message);
}

}

?>