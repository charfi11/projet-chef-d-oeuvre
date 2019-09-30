<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FormInscriptionType;
use App\Controller\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class OeuvreController extends AbstractController
{

    /**
     * @Route("/oeuvre", name="index")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('oeuvre/index.html.twig', [
          'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/", name="user")
     */
    public function User(ContactNotification $userNotif, Request $requestInscription, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $formInscription = $this->createForm(FormInscriptionType::class, $user);

    $formInscription->handleRequest($requestInscription);

    $imagee = $formInscription->get('img')->getData();
    if($imagee != NULL) {
        $namee = $user->getName().''.mt_rand(0,1000000);
        $imageNamee = $namee.'.'. $imagee->guessExtension();
        $imagee->move(
            $this->getParameter('image_directory'),
            $imageNamee
        );
        $user->setImg($imageNamee);
    } else {
        $user->setImg('default.png');
    }

    if ($formInscription->isSubmitted() && $formInscription->isValid()) {

        $this->addFlash('success', 'vous êtes désormais inscrit, vous pouvez vous connecter!');

        $userNotif->notify($user);
        $hash = $encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($hash);
        $user = $formInscription->getData();

        $manager->persist($user);
    $manager->flush();

    return $this->redirectToRoute('login');

    }

        return $this->render('security/connexion_user.html.twig', [
            'FormInscriptionType' => $formInscription->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils) {

        $error = $utils->getLastAuthenticationError();

        $lastUsername = $utils->getLastUsername();

        return $this->render('security/login.html.twig',[
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */

     public function logout() {
         
     }
}
