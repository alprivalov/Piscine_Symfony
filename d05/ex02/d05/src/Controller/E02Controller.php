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
    #[Route('e02',name:'e02_main')]
    public function user() {
        return $this->render('base.html.twig');
    }

    #[Route('/e02/form', name: 'create')]
    public function handleForm(Request $request,UserManager $userManager): Response{
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $data = $form->getData();
                $userManager->createUser($data);
                $this->addFlash( 'success','Success : user created');
                return $this->redirectToRoute('e02_main');
            } catch(\Exception $e){
                $this->addFlash( 'error','Error : user create');
            }
        }

        return $this->render('e02/e02.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
