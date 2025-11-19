<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
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
    #[Route('e07',name:'e07_main')]
    public function index() {
        return $this->render('base.html.twig');
    }

    private function ft_createForm(User $user = null){
        if($user === null)
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
    public function user(): Response
    {
        $form = $this->ft_createForm();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form'=> $form->createView(),
        ]);
    }


    #[Route('e07/user/create', name: 'user_create')]
    public function create(Request $request, UserManager $userManager): Response
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

    #[Route('e07/user/show', name: 'user_show')]
    public function show(UserManager $userManager): Response
    {
        try{
            $headers = ["id", "username", "name", "email", "enable", "birthdate", "address"];

            $users = $userManager->getTable();
            return $this->render('user/show.html.twig', [
                'controller_name' => 'UserController',
                'users'=> $users,
                'headers' => $headers,
            ]);
        } catch (\Exception $e){
            $this->addFlash( 'error', 'Error : table not created');
            return $this->redirectToRoute('e07_main');
        }
    }

    #[Route('e07/user/update/{id}', name: 'user_update')]
    public function update(User $user,Request $request, UserManager $userManager): Response
    {
        $form = $this->ft_createForm($user);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $userManager->updateUser();
            $this->addFlash('success','Success : user modified');
            return $this->redirectToRoute('user_show');
        }
        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form'=> $form->createView(),
            'user'=>$user,
        ]);
    }


    #[Route('e07/user/table/create', name: 'table_create_user')]
    public function handleCreateTable(EntityManagerInterface $em):Response {

        try{
            $product = [$em->getClassMetadata(User::class)];
            $schema = new schemaTool($em);
            $schema->createSchema($product);
            $this->addFlash( 'success','Success : table created');
        } catch (\Exception $e){
            $this->addFlash( 'error','Error : table already created');
        }
        return $this->redirectToRoute('app_user');
    }
}
