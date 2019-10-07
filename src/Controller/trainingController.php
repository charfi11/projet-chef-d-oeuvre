<?php

namespace App\Controller;

use App\Entity\ListMove;
use App\Entity\Training;
use App\Form\FormTrainingType;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class trainingController extends AbstractController
{

    /**
     * @Route("/oeuvre/training", name="training")
     */

    public function training(Request $requestTraining, ObjectManager $manager, TrainingRepository $repo) { 

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $training = new Training();

        $trainings = $repo->findAll();
 
        $formTraining = $this->createForm(FormTrainingType::class, $training);

        $formTraining->handleRequest($requestTraining);

        if ($formTraining->isSubmitted() && $formTraining->isValid()) {
            if(isset($requestTraining->request->get('form_training')['selectMove'])){
                $repm = $this->getDoctrine()->getRepository(ListMove::class);
                $moves = $requestTraining->request->get('form_training')['selectMove'];
                for($i = 0 ; $i < sizeof($moves) ; $i++){
                    $move = $repm->find($moves[$i]);
                    $training->addSelectMove($move);
                    $manager->persist($training);
                }
            }
            $user = $this->getUser();
            $user->addUserTraining($training);
            $manager->persist($user);
            $manager->flush();
           
                return $this->redirectToRoute('training');
           
        }

        return $this->render('oeuvre/training.html.twig', [
            'FormTrainingType' => $formTraining->createView(),
            'trainings' => $trainings,
        ]);
    }

    /**
     * @Route("/oeuvre/training/{id}", name="trainingedit")
     */
    public function trainingEdit(Training $training = null, Request $requestTraining, 
    ObjectManager $manager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if(!$training){

            $training = new Training();

        }

        $formTraining = $this->createForm(FormTrainingType::class, $training);

        $formTraining->handleRequest($requestTraining);

        if ($formTraining->isSubmitted() && $formTraining->isValid()) {
            if(isset($requestTraining->request->get('form_training')['selectMove'])){
                $repm = $this->getDoctrine()->getRepository(ListMove::class);
                $moves = $requestTraining->request->get('form_training')['selectMove'];
                for($i = 0 ; $i < sizeof($moves) ; $i++){
                    $move = $repm->find($moves[$i]);
                    $training->addSelectMove($move);
                    $manager->persist($training);
                }
            }
            
            $user = $this->getUser();
            $user->addUserTraining($training);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('training');
        }

        return $this->render('oeuvre/trainingEdit.html.twig', [
            'FormTrainingType' => $formTraining->createView(),
        ]);
    }

    /**
    * @Route("/oeuvre/deletetrain/{id}", name="deletetrain")
    *
    */
    public function deletetrain(Training $training, ObjectManager $manager){
        
        $manager->remove($training);
        $manager->flush();
  
        return $this->redirectToRoute('training');
      }
}

?>