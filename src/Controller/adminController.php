<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ListMove;
use App\Form\FormMoveType;
use App\Repository\UserRepository;
use App\Repository\ListMoveRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class adminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     * @Route("admin/{id}/edit", name ="move_edit")
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     */

    public function admin(ListMove $move = null, Request $request, ObjectManager $manager, UserRepository $userrepo)
    {

        $user = $userrepo->findAll();
        
        if(!$move)
        {

        $move = new ListMove();

        }

        $formCreate = $this->createForm(FormMoveType::class, $move);

    $formCreate->handleRequest($request);

        if ($formCreate->isSubmitted() && $formCreate->isValid()) {

            $this->addFlash('success', 'Le mouvement a bien été ajouté!');
            
                $create = $formCreate->getData();

                $manager->persist($create);
            $manager->flush();

            return $this->redirectToRoute('admin', ['id' => $move->getId()]);
        }
        return $this->render('oeuvre/admin.html.twig',[
            'CreateType' => $formCreate->createView(),
            'user' => $user
        ]);
   } 

    /**
    * @Route("/admin/deleteUser/{id}", name="deleteUser")
    */
    public function deleteUser(User $user, ObjectManager $manager){
        foreach($user->getModerateur() as $userGroup){
            $userGroup->removeUser($user);
            $manager->persist($userGroup);
            if(sizeof($userGroup->getUsers()) > 0){
                foreach($userGroup->getUsers() as $userC){
                    $userGroup->setUser($userC);
                    break;
                }
                $manager->persist($userGroup);
            } 
            else {
                $manager->remove($userGroup);
            }
        }
            
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('admin');
    }

   /**
    * @Route("/admin/editM", name="moveshow")
    */

    public function editMove(ListMoveRepository $repoM){

        $lmove = $repoM->findAll();

        return $this->render('oeuvre/editM.html.twig',[
            'move' => $lmove
        ]);
    }

    /**
    * @Route("/admin/{id}/editM", name="deleteMove")
    *
    */
    public function deleteMove(ListMove $move, ObjectManager $manager){

        $manager->remove($move);
        $manager->flush();
  
        return $this->redirectToRoute('moveshow');
      }
    }
?>