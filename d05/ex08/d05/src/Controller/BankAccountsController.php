<?php

namespace App\Controller;

use App\Service\BankAccountsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BankAccountsController extends AbstractController
{
    
    #[Route('e08/bank_accounts', name: 'app_bank_accounts')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }


    #[Route('e08/bank_accounts/table', name: 'bank_accounts_table')]
    public function table(BankAccountsManager $bankAccountsManager): Response
    {
        $bankAccountsManager->createBank_accountsTable();
        $this->addFlash( 'success',message: 'Success : bank_accounts_table created');
        return $this->redirectToRoute('home');
    }


    #[Route('e08/bank_accounts/create/{id}', name: 'bank_accounts_create')]
    public function create(BankAccountsManager $bankAccountsManager): Response
    {
        $success = $bankAccountsManager->createBank_accounts();
        if($success)
            $this->addFlash( 'success','Success : bank_accounts create');
        else
            $this->addFlash( 'error','Error : bank_accounts create');
        
        return $this->redirectToRoute('persons_show');
    }
}
