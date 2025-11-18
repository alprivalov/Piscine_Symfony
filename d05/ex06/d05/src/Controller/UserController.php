<?php

namespace App\Controller;

use App\Service\UserManager;
use Doctrine\DBAL\Connection;
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
    #[Route('e06',name:'e06_main')]
    public function user() {
        return $this->render('base.html.twig');
    }

    private function ft_createForm(array $default = []){
        if($default)
            $default["birthdate"] = new \DateTime($default["birthdate"]);
        return $this->createFormBuilder($default)
            ->add("username",TextType::class)
            ->add("name",TextType::class)
            ->add("email",EmailType::class)
            ->add("enable",CheckboxType::class)
            ->add("birthdate",DateType::class)
            ->add("address",TextType::class)
            ->getForm();
    }


    
    #[Route('e06/user', name: 'app_user')]
    public function index(): Response
    {
        $form = $this->ft_createForm();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
        ]);
    }

    #[Route('e06/user/create', name: 'user_create')]
    public function create(Request $request,UserManager $userManager): Response
    {
        $form = $this->ft_createForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $data = $form->getData();
                $userManager->createUser($data);
                $this->addFlash('success','Success : User created');
            } catch (\Exception $e){
                $this->addFlash('error','Error : User creation failed');
                return $this->redirectToRoute('app_user');
            }
        }
        return $this->redirectToRoute('app_user');
    }


    #[Route('e06/user/show', name: 'user_show')]
    public function show(UserManager $userManager): Response
    {
        try{
            $users = $userManager->getUsers();

            $headers = ["id", "username", "name", "email", "enable", "birthdate", "address"];
            return $this->render('user/show.html.twig', [
                'controller_name' => 'UserController',
                'headers' => $headers,
                'users' => $users,
            ]);
        } catch(\Exception $e){
            $this->addFlash( 'error','Error : user table not found');
            return $this->redirectToRoute('e06_main');
        }
    }


    #[Route('e06/user/update/{id}', name: 'user_update')]
    public function update(int $id, Request $request, UserManager $userManager): Response
    {
        $user = $userManager->getUser($id);
        $form = $this->ft_createForm($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $success = $userManager->updateUser($data);
            if($success)
                $this->addFlash('success','Success : data modified');
            else
                $this->addFlash('error','Error : data not modified');
            return $this->redirectToRoute('user_show');
        }

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
            'user'=> $user
        ]);
    }

    #[Route('e06/create/table', name: 'app_create_table')]
    public function createTable(UserManager $userManager,Connection $connection): Response
    {
        try{
            $userManager->createTable($connection);
            $this->addFlash( 'success','Success : user table create');
        } catch(\Exception $e){
            $this->addFlash( 'error','Error : user table create');
        }
        return $this->redirectToRoute('app_user',);
    }
}
