<?php

namespace App\Controller;

use App\Service\PersonsManager;
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

    private function ft_createForm(array $default = []){
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
    public function home(PersonsManager $personsManager): Response
    {        
        
        return $this->render('base.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }


    #[Route('/persons/table', name: 'persons_table')]
    public function table(PersonsManager $personsManager): Response
    {        
        $personsManager->createPersonsTable();
        $this->addFlash( 'success','Success : Table created');
        return $this->redirectToRoute('home');
    }
    
    
    #[Route('/persons', name: 'app_persons')]
    public function index(): Response
    {
        $form = $this->ft_createForm();
        return $this->render('persons/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form,
        ]);
    }

    #[Route('/persons/create', name: 'persons_create')]
    public function create(Request $request,PersonsManager $personsManager): Response
    {
        $form = $this->ft_createForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $success = $personsManager->createPersons($data);
            if($success)
                $this->addFlash('success','Success : persons created');
            else
                $this->addFlash('error','Error : persons creation failed');
        }
        return $this->redirectToRoute('app_persons');
    }
    
    #[Route('/persons/show', name: 'persons_show')]
    public function show(PersonsManager $personsManager): Response
    {
        $persons = $personsManager->getPersons();
        $headers = null;

        if($persons)
            $headers = array_keys($persons[0]);
        if (!$headers)
            $this->addFlash('error', 'no users found');
        return $this->render('persons/show.html.twig', [
            'controller_name' => 'UserController',
            'headers' => $headers,
            'persons' => $persons,
        ]);
    }



    #[Route('/persons/alternate', name: 'persons_alternate')]
    public function alternate(PersonsManager $personsManager): Response
    {

        $success = $personsManager->addColumn();
        if($success)
            $this->addFlash('success','Success : add column');
        else
            $this->addFlash('error','Error : add column');
        return $this->redirectToRoute('home');
    }

    #[Route('/persons/relations', name: 'persons_relations')]
    public function relations(PersonsManager $personsManager): Response
    {
        $success =  $personsManager->addRelations();
        if($success)
            $this->addFlash('success','Success : add column');
        else
            $this->addFlash('error','Error : add column');
        return $this->redirectToRoute('home');
    }
}
