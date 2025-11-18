<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
class SecondController extends AbstractController {

    #[Route('e01/create',name:'e01_create')]
    public function create_user(EntityManagerInterface $em,Request $request) {
        try {
            $product = [$em->getClassMetadata(Product::class)];
            $schema = new schemaTool($em);
            $schema->createSchema($product);
                $this->addFlash( 'success','Success : user table create');
            } catch(\Exception $e){
                $this->addFlash( 'error','Error : user table already created');
            }
        return $this->redirectToRoute('e01_main');
    }
}