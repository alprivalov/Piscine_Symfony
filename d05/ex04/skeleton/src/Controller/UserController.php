<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserController extends AbstractController
{
    private function ft_createForm(){

        return $this->createFormBuilder()
            ->add('username',TextType::class)
            ->add('email',EmailType::class)
            ->add('name', TextType::class)
            ->add('enable', CheckboxType::class)
            ->add('birthdate',DateType::class)
            ->add('address', TextType::class)
            ->getForm();
    }

    #[Route('/user', name: 'app_user', methods: ['GET'])]
    public function form(): Response
    {
        $form = $this->ft_createForm();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/user/create', name: 'create_user', methods: ['POST'])]
    public function create(Request $request, UserManager $userManager): Response
    {

        $form = $this->ft_createForm();

        $form->handleRequest($request);
        $data = $form->getData();

        $success = $userManager->createUser($data);
        if ($success)
            $this->addFlash('success', 'Success : user created');
        else
            $this->addFlash('error', 'Error : user already exist');
        return $this->redirectToRoute('app_user');
    }


    #[Route('/user/delete/{id}', name: 'delete_user')]
    public function delete(int $id, Request $request, UserManager $userManager): Response
    {
        $success = $userManager->deleteUser($id);
        if ($success)
            $this->addFlash('success', 'Success : user deleted');
        else
            $this->addFlash('error', 'Error : user not found');
        return $this->redirectToRoute('show_user');
    }



    #[Route('/user/show', name: 'show_user')]
    public function show(UserManager $userManager): Response
    {
        $users = $userManager->getUsers();
        
        $headers = ["id", "username", "name", "email", "enable", "birthdate", "address"];
        return $this->render('user/table.html.twig', [
            'controller_name' => 'UserController',
            'headers' => $headers,
            'users' => $users,
        ]);
    }
}
