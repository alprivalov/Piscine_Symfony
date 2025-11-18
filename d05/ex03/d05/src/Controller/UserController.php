<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('e03',name:'e03_main')]
    public function index() {
        return $this->render('base.html.twig');
    }
    #[Route('e03/form', name: 'form')]
    public function form(Request $request,UserManager $userManager, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $request->getSession()->set("form",$form->getdata());
                $em->persist($user);
                $em->flush();
                $this->addFlash("success","User created");
            } catch (\Exception $exception){
                $this->addFlash("error",$exception->getMessage());
            }
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('e03/form/show', name: 'show_form')]
    public function formShow(UserManager $userManager):Response {
        $header = ["id","username","email","enable","birthdate","address"];

        try{
            $rows = $userManager->getTable();
            return $this->render('user/table.html.twig', [
                'controller_name' => 'UserController',
                'rows'=> $rows,
                'header' => $header,
            ]);
        } catch (\Exception $e){
            $this->addFlash( 'error','Error : table not created');
            return $this->redirectToRoute('e03_main');
        }
    }


    #[Route('e03/form/table/create', name: 'table_create_form')]
    public function handleCreateTable(EntityManagerInterface $em):Response {

        try{
            $product = [$em->getClassMetadata(User::class)];
            $schema = new schemaTool($em);
            $schema->createSchema($product);
            $this->addFlash( 'success','Success : table created');
        } catch (\Exception $e){
            $this->addFlash( 'error','Error : table already created');
        }
        return $this->redirectToRoute('form');
    }
}
