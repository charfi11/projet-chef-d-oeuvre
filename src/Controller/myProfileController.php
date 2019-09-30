<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Form\EditImgType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class myProfileController extends AbstractController
{
    /**
     * @Route("/oeuvre/profil", name="user_profil")
     * 
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $formImg = $this->createForm(EditImgType::class, $user);
        $form = $this->createForm(AccountType::class, $user);

                $formImg->handleRequest($request);
                $form->handleRequest($request);

                if($formImg->isSubmitted() && $formImg->isValid()){
                $img = $formImg->get('img')->getData();
                if($img != null){
                    $imageName = $user->getAvatarName().'.'.$img->guessExtension();
                    $img->move(
                        $this->getParameter(('image_directory')),
                        $imageName
                    );
                    $user->setImg($imageName);
                }
                    }
        
        if($form->isSubmitted()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'utilisateur a bien été mis à jour.'
            );
        }
   
        return $this->render('oeuvre/myProfile.html.twig', [
            'Formprofil' => $form->createView(),
            'FormImg' => $formImg->createView(),
            'user' => $user,
        ]);
    }
}

?>