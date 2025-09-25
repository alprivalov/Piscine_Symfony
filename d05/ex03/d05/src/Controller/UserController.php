<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/form', name: 'form',methods:["GET"])]
    public function index(Request $request,UserManager $userManager): Response
    {
        $user = $request->getSession()->get("form") ;
        if(!$user)
            $user = new User();
        $form = $this->createForm(UserType::class,$user);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/form/create', name: 'create_form',methods:["POST"])]
    public function handleForm(Request $request,UserManager $userManager): Response
    {


        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $request->getSession()->set("form",$form->getdata());
            return $this->redirectToRoute('form');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/show', name: 'show_form')]
    public function handleRenderForm(UserManager $userManager):Response {
        $header = ["id","username","email","enable","birthdate","address"];


        $rows = $userManager->getTable();
        return $this->render('user/table.html.twig', [
            'controller_name' => 'UserController',
            'rows'=> $rows,
            'header' => $header,
        ]);
    }
}
