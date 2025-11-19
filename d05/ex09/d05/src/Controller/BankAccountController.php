<?php

namespace App\Controller;

use App\Service\BankAccountManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BankAccountController extends AbstractController
{
    #[Route('e09/bankaccount', name: 'app_bankaccount')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }


    #[Route('e09/bankaccount/table', name: 'bankaccount_table')]
    public function table(BankAccountManager $bankManager): Response
    {
        $success = $bankManager->createTable();
        if($success)
            $this->addFlash('success','Success : create table');
        else
            $this->addFlash('error','Error : create table');
        return $this->redirectToRoute('home');
    }

    #[Route('e09/bankaccount/create{id}', name: 'bank_accounts_create')]
    public function create(int $id): Response
    {
        return $this->redirectToRoute('home');
    }
}
