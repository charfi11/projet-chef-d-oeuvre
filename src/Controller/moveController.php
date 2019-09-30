<?php

namespace App\Controller;

use App\Repository\ListMoveRepository;
use App\Repository\CategorieMoveRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class moveController extends AbstractController
{
     /**
     * @Route("/oeuvre/moves", name="move")
     */
    public function move(Request $request, ListMoveRepository $moveRepo, CategorieMoveRepository $categorieMoveRepo)
    {
        if($request->query->get('id') != null){
            $id = $request->query->get('id');
            $categorieMoveShow = $categorieMoveRepo->find($id);
        $moveShow = $moveRepo->findBy([
            'typeMove' =>  $categorieMoveShow
        ]);
    }

    else {

        $moveShow = $moveRepo->findAll();

    }
       $categorieM = $categorieMoveRepo->findAll();
                return $this->render('oeuvre/move.html.twig', [
                  'moveshow' => $moveShow,
                  'typeMove' => $categorieM,
                ]);
    }

}

?>