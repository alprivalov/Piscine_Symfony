<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class E02Controller extends AbstractController
{
    #[Route('/e02', name: 'app_e02', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $defaultData = $session->get('form_data',[
            'username'=>'',
            'name'=>'',
            'email'=>'',
            'enable'=>false,
            'birthdate'=> new \DateTime(),
            'address'=>'',
        ]);
    
        $form = $this->createForm(UserType::class,$defaultData);
        
        return $this->render('e02/e02.html.twig',[
            'error' => null,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/e02/create', name: 'create', methods: ['POST'])]
    public function handleForm(Request $request,UserManager $userManager): Response{
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->addFlash('message', $userManager->createUser($data));
            return $this->redirectToRoute('app_e02');
        }

        return $this->render('e02/e02.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
