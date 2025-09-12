<?php

namespace App\Controller;

use App\Service\ShowTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController
{
    #[Route('e02/show', name: 'app_show')]
    public function index(ShowTable $showTable): Response
    {
        $header = ['id','username','email','enable','birthdate','address'];
        $rows = $showTable->getData();
        if(!$rows)
            return new Response("data not found");
        return $this->render('show/index.html.twig', [
            'controller_name' => 'ShowController',
            'header' => $header,
            'rows' => $rows
        ]);
    }
}
