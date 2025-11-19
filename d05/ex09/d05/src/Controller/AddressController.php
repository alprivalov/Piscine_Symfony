<?php

namespace App\Controller;

use App\Service\AddressManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddressController extends AbstractController
{
    #[Route('e09/address', name: 'app_address')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

    #[Route('e09/address/table', name: 'address_table')]
    public function table(AddressManager $addressManager): Response
    {
        $success = $addressManager->createTable();
        if($success)
            $this->addFlash('success','Success : create table');
        else
            $this->addFlash('error','Error : create table');
        return $this->redirectToRoute('home');
    }

    #[Route('e09/address/create/{id}', name: 'address_create')]
    public function create(int $id): Response
    {
        return $this->redirectToRoute('home');
    }
}
