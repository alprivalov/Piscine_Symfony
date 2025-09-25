<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{

    private function ft_createForm(){
        $user = new User();

        return $this->createFormBuilder($user)
        ->add("username" ,TextType::class)
        ->add("name" ,TextType::class)
        ->add("email" ,EmailType::class)
        ->add("enable", CheckboxType::class)
        ->add("birthdate", DateType::class)
        ->add("address", TextType::class)
        ->getForm();
    }

    #[Route('/user', name: 'app_user', methods:['GET'])]
    public function index(): Response
    {
        $form = $this->ft_createForm();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form'=> $form->createView(),
        ]);
    }


    #[Route('/user/create', name: 'user_create', methods:['POST'])]
    public function create(Request $request, UserManager $userManager): Response
    {
        $form = $this->ft_createForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $success = $userManager->createUser($data);
            if($success)
                $this->addFlash('success','Success : User created');
            else
                $this->addFlash('error','Error : User creation failed');
        } 
        return $this->redirectToRoute('app_user');
    }
    
    #[Route('/user/show', name: 'user_show', methods:['GET'])]
    public function show(UserManager $userManager): Response
    {
        $headers = ["id", "username", "name", "email", "enable", "birthdate", "address"];

        $users = $userManager->getTable();
        return $this->render('user/show.html.twig', [
            'controller_name' => 'UserController',
            'users'=> $users,
            'headers' => $headers,
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(int $id, UserManager $userManager): Response
    {
        $userManager->deleteUser($id);
        return $this->redirectToRoute('user_show');
    }
}
