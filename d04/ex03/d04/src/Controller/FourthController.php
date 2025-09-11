<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FourthController extends AbstractController
{

    #[Route('/e03', name: 'e03_main')]
    public function e03(Request $request): Response
    {
        $get_number_colons = $this->getParameter('e03.number_of_colors');
        $rows = [
        ];
        $headers = [
            0 => "black",
            1 => "red",
            2 => "green",
            3 => "blue",
        ];
        for ($i = 1; $i < $get_number_colons + 1;$i++){
            $add = 255 - ($i * 255 / $get_number_colons);
            $black = ($i * 255 / $get_number_colons);
            $rows[$i]["black"] = "rgb(". $black . ",". $black . ",".  $black . ")";
            $rows[$i]["red"] =  "rgb(". $add . ",0,0)";
            $rows[$i]["green"] = "rgb(0," . $add . ",0)";
            $rows[$i]["blue"] = "rgb(0,0,".  $add . ")";
        }
        return $this->render('e03/main.html.twig',[
            'error' => null,
            'headers' => $headers,
            'rows' => $rows,
        ]);
    }
}
