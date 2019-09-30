<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Groupe;
use App\Entity\Message;
use App\Entity\ListMove;
use App\Entity\Training;
use App\Form\EventFormType;
use App\Form\InviteGrpType;
use App\Form\EditGrpImgType;
use App\Form\FormGroupeType;
use App\Form\FormTrainingType;
use App\Form\MessageGroupeType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\GroupeRepository;
use App\Repository\MessageRepository;
use App\Repository\TrainingRepository;
use App\Controller\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class groupeController extends AbstractController
{

    /**
     * @Route("/oeuvre/groupe", name="groupe")
     */
    public function groupe(ContactNotification $userNotif, Groupe $Grpe = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $recupUser = $this->getUser();

        $group = new Groupe();

        $formGroup = $this->createForm(FormGroupeType::class, $group);

    $formGroup->handleRequest($request);

    $imagee = $formGroup->get('img')->getData();
                if($imagee != NULL) {
                    $namee = $group->getId().''.mt_rand(0,1000000);
                    $imageNamee = $namee.'.'. $imagee->guessExtension();
                    $imagee->move(
                        $this->getParameter('image_directory'),
                        $imageNamee
                    );
                    $group->setImg($imageNamee);
                } else {
                    $group->setImg('default.png');
                }

   if ($formGroup->isSubmitted() && $formGroup->isValid()) {

    $this->addFlash('success', 'votre groupe est crée, vous pouvez vous y aller!');

    $userNotif->notifyGroupe($recupUser);

     $group->addUser($recupUser);
    
        $group = $formGroup->getData();
        $group->setUser($recupUser);
        $manager->persist($group);
    $manager->flush();

    return $this->redirectToRoute('groupe');
   }
        return $this->render('oeuvre/groupe.html.twig', [
            'FormGroupeType' => $formGroup->createView(),
            'groupes' => $Grpe,
        ]);
    }


     /**
    * @Route("/oeuvre/groupe/{id}", name="show_groupe")
    */
    public function showGroup($id, ObjectManager $manager, GroupeRepository $repoGrp, Groupe $groupe, Request $request){
        
        $message = new Message();
    
       // $today = new \DateTime();

        $groupes = $repoGrp->find($id);

        $user = $groupe->getUsers();

        $training = $groupe->getTrainings();

        $messages = $groupe->getMessages();

       $formMess = $this->createForm(MessageGroupeType::class, $message);

        $formMess->handleRequest($request);

        if($formMess->isSubmitted() && $formMess->isValid()){
            $message->setMessGroupe($groupes);
            $groupe->addMessage($message);
            $manager->persist($message);
            $manager->flush();
                
            return $this->redirectToRoute('show_groupe', ['id' => $groupe->getId()]);
            
        }


    /*$grpEvent = $events->findAll();
        foreach($grpEvent as $event){
            $search = $event->getDate();
            $calc = $today->diff($search);
            $result = $calc->format('%d');
            if($result > 1){
                $manager->remove($event);
                $manager->flush();
            }
        }
            
            $grpTrain = $trainingsrepo->findAll();
        foreach($grpTrain as $t){
            $search = $t->getDate();
            $calc = $today->diff($search);
            $result = $calc->format('%m');
            if($result > 1){
                $manager->remove($event);
                $manager->flush();
            }

        }*/

        return $this->render('oeuvre/show_groupe.html.twig',[ 
            'messages' => $formMess->createview(),
            'showgroupe' => $groupes,
            'user' => $user,
            'trainings' => $training,
            'groupId' => $id,
            'message' => $messages,
        ]);
       }      

     /**
     * @Route("/oeuvre/groupe/{id}/grpEdit", name="grpEdit")
     * 
     */
    public function grpEdit(Groupe $grp = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $formGroupeType = $this->createForm(formGroupeType::class, $grp);

        $formGroupeType->handleRequest($request);

    if($formGroupeType->isSubmitted()){
        $manager->persist($grp);
        $manager->flush();
        $this->addFlash(
            'success',
            'Le groupe a bien été mis à jour.'
        );

        return $this->redirectToRoute('groupe');
    }

        return $this->render('oeuvre/editGroupe.html.twig', [
            'FormGroupeType' => $formGroupeType->createView(),
            'grp' => $grp,
        ]);
    }

      /**
       * @Route("/oeuvre/groupe/{id}/deletemember/{user_id}", name="deleteMember")
       * @Entity("user", expr="repository.find(user_id)")
       */
       public function deleteMember(Groupe $groupe, User $user, ObjectManager $manager){

        $groupe->removeUser($user);
        $manager->persist($groupe);
        $manager->flush();

        return $this->redirectToRoute('show_groupe', ['id' => $groupe->getId()]);
       }

    /**
     * @Route("oeuvre/groupe/{id}/event", name="groupeevent")
     */
   public function event(Groupe $grp = null, Request $request, ObjectManager $manager, ContactNotification $userNotif)
   {

       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

       $event = new Event();

       $formEvent = $this->createForm(EventFormType::class, $event);

   $formEvent->handleRequest($request);

   if ($formEvent->isSubmitted() && $formEvent->isValid()) {
   
           foreach($grp->getUsers() as $user){
              $userNotif->notifyGroupeEvent($user);
           }
       $event->setEventgroupe($grp);
       $manager->persist($event);
       $user = $this->getUser();
       $user->addUserEvent($event);
       $manager->persist($user);

   $manager->flush();

   return $this->redirectToRoute('show_groupe', ['id' => $grp->getId()]);
   
   }

       return $this->render('oeuvre/event.html.twig', [
           'EventFormType' => $formEvent->createView(),
       ]);
   }

        /**
     * @Route("oeuvre/groupe/{id}/training", name="groupetrain")
     */

    public function trainingGrp(ContactNotification $userNotif, Groupe $grp = null, GroupeRepository $repogrp, Request $requestTraining, 
        ObjectManager $manager, TrainingRepository $repo) { 

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $training = new Training();

        $trainings = $repo->findAll();
 
        $formTraining = $this->createForm(FormTrainingType::class, $training);

        $formTraining->handleRequest($requestTraining);

        if ($formTraining->isSubmitted() && $formTraining->isValid()) {
            foreach($grp->getUsers() as $user){
                $userNotif->notifyGroupeTraining($user);
            }
            if(isset($requestTraining->request->get('form_training')['selectMove'])){
                $repm = $this->getDoctrine()->getRepository(ListMove::class);
                $moves = $requestTraining->request->get('form_training')['selectMove'];
                for($i = 0 ; $i < sizeof($moves) ; $i++){
                    $move = $repm->find($moves[$i]);
                    $training->addSelectMove($move);
                    $manager->persist($training);
                }
            }
            $training->setGroupe($grp);
            $user = $this->getUser();
            $user->addUserTraining($training);
            $manager->persist($user);
            $manager->flush();

                return $this->redirectToRoute('show_groupe', ['id' => $grp->getId()]);

        }

        return $this->render('oeuvre/training.html.twig', [
            'FormTrainingType' => $formTraining->createView(),
            'trainings' => $trainings,
        ]);
    }

    /**
     * @Route("oeuvre/groupe/{id}/AjoutAmis/", name="ajoutamis")
     */
    public function addMember(ContactNotification $userNotif, Groupe $groupe, Request $request, 
    ObjectManager $manager, UserRepository $userrepo)
    {
       $formMember = $this->createForm(InviteGrpType::class, $groupe);

       $formMember->handleRequest($request);

       if($formMember->isSubmitted() && $formMember->isValid()){
           $users = $request->request->get('invite_grp')['users'];
           foreach($users as $user_id){
              $user = $userrepo->find($user_id);
              $groupe->addUser($user);
              $userNotif->notifyInvite($user, $groupe);
           }

           $manager->persist($groupe);
           $manager->flush();

           return $this->redirectToRoute('groupe');
       }

       return $this->render('oeuvre/AjoutAmis.html.twig', [
           'InviteGrpType' => $formMember->createView(),
       ]);

    }

       /**
       * @Route("/oeuvre/show_groupe/{id}/deleteeventgrp/{event_id}", name="deleteeventgrp")
       * @Entity("event", expr="repository.find(event_id)")
       */
      public function deleteEventGrp(Groupe $groupe, Event $event, ObjectManager $manager){

        $manager->remove($event);
        $groupe->removeEvent($event);
        $manager->persist($groupe);
        $manager->flush();

        return $this->redirectToRoute('show_groupe', ['id' => $groupe->getId()]);
       }

       /**
       * @Route("/oeuvre/show_groupe/{id}/deletetraingrp/{train_id}", name="deletetraingrp")
       * @Entity("training", expr="repository.find(train_id)")
       */
      public function deleteTrainGrp(Groupe $groupe, Training $training = null, ObjectManager $manager){

        $manager->remove($training);
        $groupe->removeTraining($training);
        $manager->persist($groupe);
        $manager->flush();

        return $this->redirectToRoute('show_groupe', ['id' => $groupe->getId()]);
       }

}

?>