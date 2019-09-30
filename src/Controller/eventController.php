<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Repository\CategorieEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class eventController extends AbstractController
{

    /**
     * @Route("/oeuvre/event", name="event")
     */
   public function event(Request $request, ObjectManager $manager)
   {

       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       $event = new Event();

       $formEvent = $this->createForm(EventFormType::class, $event);

   $formEvent->handleRequest($request);

   if ($formEvent->isSubmitted() && $formEvent->isValid()) {

       $manager->persist($event);
       $user = $this->getUser();
       $user->addUserEvent($event);
       $manager->persist($user);

   $manager->flush();
   }

       return $this->render('oeuvre/event.html.twig', [
           'EventFormType' => $formEvent->createView(),
       ]);
   }

      /**
     * @Route("oeuvre/event_show/{id}", name="eventEdit")
     */
   public function eventEdit(Event $event, Request $request, ObjectManager $manager)
   {

       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       if(!$event){

       $event = new Event();

       }

       $formEvent = $this->createForm(EventFormType::class, $event);

   $formEvent->handleRequest($request);

   if ($formEvent->isSubmitted() && $formEvent->isValid()) {

       $manager->persist($event);
       $user = $this->getUser();
       $user->addUserEvent($event);
       $manager->persist($user);

   $manager->flush();

   return $this->redirectToRoute('event');
   
   }

       return $this->render('oeuvre/eventEdit.html.twig', [
           'EventFormType' => $formEvent->createView(),
       ]);
   }

     /**
     * @Route("/oeuvre/event_show", name="event_show")
     */
    public function event_show(Request $request, EventRepository $repo, CategorieEventRepository $categorierepo)
    {
        if($request->query->get('id') != null){
            // recupere le get (id)
            $id = $request->query->get('id');
            // Cherche la catégorie d'id => $id
            $category_show = $categorierepo->find($id);
            // Affiche les evenements liés à la catégorie et à l'utilisateur
            $event_show = $repo->findBy([
                'typeEvent' => $category_show,
                'user' => $this->getUser()
            ]);
        }
        else {
            $event_show = $repo->findBy([
                'user'=> $this->getUser()
            ]);
        }

        $categorie = $categorierepo->findAll();

        return $this->render('oeuvre/event_show.html.twig', [
          'event_show' => $event_show,
          'typeEvent' => $categorie
        ]);
    }

       /**
    * @Route("/oeuvre/deleteevent/{id}", name="deleteevent")
    *
    */
    public function deleteEvent(Event $event, ObjectManager $manager){
        
        $manager->remove($event);
        $manager->flush();
  
        return $this->redirectToRoute('event');
      }

}

?>