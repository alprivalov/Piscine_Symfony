<?php

namespace App\Controller;

use App\Service\AddressesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddressesController extends AbstractController
{
    #[Route('e08/addresses', name: 'app_addresses')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }


    #[Route('e08/addresses/table', name: 'addresses_table')]
    public function table(AddressesManager $addressesManager): Response
    {
        $addressesManager->createAddressesTable();
        $this->addFlash( 'success','Success : addresses_table created');
        return $this->redirectToRoute('home');
    }


    #[Route('e08/addresses/create/{id}', name: 'addresses_create')]
    public function create(AddressesManager $addressesManager): Response
    {
        $success = $addressesManager->createAddresse();
        if($success)
            $this->addFlash( 'success','Success : addresse create');
        else
            $this->addFlash( 'error','Error : addresse create');

        return $this->redirectToRoute('persons_show');
    }
}
