<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserManager;
use Doctrine\DBAL\Connection;
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
    #[Route('e04',name:'e04_main')]
    public function index() {
        return $this->render('base.html.twig');
    }
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

    #[Route('e04/user', name: 'app_user')]
    public function form(): Response
    {
        $form = $this->ft_createForm();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }


    #[Route('e04/user/create', name: 'create_user')]
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


    #[Route('e04/user/delete/{id}', name: 'delete_user')]
    public function delete(int $id, Request $request, UserManager $userManager): Response
    {
        $success = $userManager->deleteUser($id);
        if ($success)
            $this->addFlash('success', 'Success : user deleted');
        else
            $this->addFlash('error', 'Error : user not found');
        return $this->redirectToRoute('show_user');
    }



    #[Route('e04/user/show', name: 'show_user')]
    public function show(UserManager $userManager): Response
    {
        try{
            $users = $userManager->getUsers();

            $headers = ["id", "username", "name", "email", "enable", "birthdate", "address"];
            return $this->render('user/table.html.twig', [
                'controller_name' => 'UserController',
                'headers' => $headers,
                'users' => $users,
            ]);
        } catch(\Exception $e){
            $this->addFlash( 'error','Error : user table not found');
            return $this->redirectToRoute('e04_main');
        }
    }

    #[Route('e04/create/table', name: 'app_create_table')]
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
