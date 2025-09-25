<?php

namespace App\Controller;

use App\Entity\Persons;
use App\Service\MigrationManager;
use App\Service\PersonsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonsController extends AbstractController
{
    // php bin/console doctrine:migrations:sync-metadata-storage
    private function ft_createForm(array $default = null){

        if($default)
            $default["birthdate"] = new \DateTime($default["birthdate"]);
        
        return $this->createFormBuilder($default)
            ->add("username",TextType::class)
            ->add("name",TextType::class)
            ->add("email",EmailType::class)
            ->add("enable",CheckboxType::class)
            ->add("birthdate",DateType::class)
            ->getForm();
    }

    #[Route('/', name: 'home')]
    public function home(MigrationManager $migrationManager): Response
    {
        $migrationManager->initialise();
        
        return $this->render('persons/home.html.twig', [
            'controller_name' => 'PersonsController',
        ]);
    }


    #[Route('/persons/create', name: 'persons_create')]
    public function create(Request $request, PersonsManager $personsManager): Response
    {
        $form = $this->ft_createForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $success = $personsManager->createPersons($data);
            if($success)
                $this->addFlash( 'success','Success : create');
            else
                $this->addFlash( 'error','Error : create');
        }
        return $this->render('persons/index.html.twig', [
            'controller_name' => 'PersonsController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/persons/show', name: 'persons_show')]
    public function show(PersonsManager $personsManager): Response
    {
        
        $persons = $personsManager->getTable();
        $headers = [];
        if(!$persons)
           $this->addFlash('error', 'no users found');
        else{
            $headers = $persons[1];
            $persons = $persons[0];
        }
        return $this->render('persons/show.html.twig', [
            'controller_name' => 'PersonsController',
            'headers' => $headers,
            'persons' => $persons,
        ]);
    }

    #[Route('/persons/table', name: 'persons_table')]
    public function table(PersonsManager $personsManager): Response
    {
        
        $success = $personsManager->createTable();
        if($success)
            $this->addFlash('success','Success : create table');
        else
            $this->addFlash('error','Error : create table');
        return $this->redirectToRoute('home');
    }
    
    

    #[Route('/alternate', name: 'alternate')]
    public function alternate(PersonsManager $personsManager): Response
    {
        $success = $personsManager->alternate();
        if($success)
            $this->addFlash('success','Success : create table');
        else
            $this->addFlash('error','Error : create table');
        return $this->redirectToRoute('home');
    }
}
