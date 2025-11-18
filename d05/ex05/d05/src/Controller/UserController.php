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
    #[Route('e05',name:'e05_main')]
    public function index() {
        return $this->render('base.html.twig');
    }

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

    #[Route('e05/user', name: 'app_user')]
    public function user(): Response
    {
        $form = $this->ft_createForm();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form'=> $form->createView(),
        ]);
    }


    #[Route('e05/user/create', name: 'user_create')]
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
    
    #[Route('e05/user/show', name: 'user_show')]
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
            return $this->redirectToRoute('e05_main');
        }
    }

    #[Route('e05/user/delete/{id}', name: 'delete_user')]
    public function delete(int $id, UserManager $userManager): Response
    {
        try{
            $userManager->deleteUser($id);
            $this->addFlash( 'error', 'Success : user deleted');
            return $this->redirectToRoute('user_show');
        } catch (\Exception $e){
            $this->addFlash( 'error', 'Error : user not exist');
            return $this->redirectToRoute('user_show');
        }
    }

    #[Route('e05/user/table/create', name: 'table_create_user')]
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
