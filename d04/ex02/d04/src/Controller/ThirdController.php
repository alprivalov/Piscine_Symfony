<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


class ThirdController extends AbstractController
{

    #[Route('/e02', name: 'e02_main')]
    public function e02(Request $request): Response
    {

        $default_form = [
            'message' =>null,
            'timestamp' => false,
        ];

        $form = $this->createFormBuilder($default_form,[
            'method'=>'POST',
        ])
            ->add('message',TextType::class ,[
                'label' => 'Message',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'une erreur est survenue',
                        ])
                ]
            ])
            ->add('timestamp',ChoiceType::class, [
                'label' => 'Include timestamp',
                'choices' => ['Yes'=> true, 'No'=> false],
            ])
            ->getForm();
        
        $form->handleRequest($request);
        $dir_path = $this->getParameter("kernel.project_dir");
        $file_name = $this->getParameter("app.notes_filename");
        $path = $dir_path ."/".  $file_name;
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $message = $data["message"];
            $timestamp = $data["timestamp"];
            if(!file_exists($path)){
                touch($path);
            }
            if($timestamp == true)
                $message .= " " . (new \DateTime('now'))->format('Y-m-d H:i:s');

            file_put_contents($path, $message . PHP_EOL,FILE_APPEND);
            return $this->redirectToRoute('e02_main');
        }
        $lastline = null;
        if( file_exists($path)){
            $data = file($path);
            $lastline = $data[array_key_last($data)];
        }
        return $this->render('e02/main.html.twig',[
            'error' => null,
            'form' => $form->createView(),
            'lastline'=> $lastline,
        ]);
    }
}
