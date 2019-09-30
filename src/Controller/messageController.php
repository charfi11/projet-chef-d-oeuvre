<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Message;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class messageController extends AbstractController {

    /**
       * @Route("/oeuvre/groupe/{message_id}/delete/{id}", name="deleteMessage")
       * @Entity("message", expr="repository.find(message_id)")
       */
      public function deleteMessage(Groupe $groupe, Message $message, ObjectManager $manager){

        $manager->remove($message);
        $groupe->removeMessage($message);
        $manager->persist($groupe);
        $manager->flush();

        return $this->redirectToRoute('show_groupe', ['id' => $groupe->getId()]);
       }
}