<?php
    include 'TemplateEngine.php';
    include 'Elem.php';
    $elem_d0000 = new Elem("html");
    $elem_d1000 = new Elem("head");
    $elem_d1100 = new Elem("title");
    $elem_d1110 = new Elem("div");
    $elem_d1111 = new Elem("h3");
    $elem_d1120 = new Elem("hr");
    $elem_d1130 = new Elem("br");
    $elem_d2000 = new Elem("head");
    $elem_d2200 = new Elem("span","test",['class' => 'text-muted']);
    $elem_d2300 = new Elem("h1","aurevoir");
    $elem_d2400 = new Elem("h2","salut");
    $elem_d3000 = new Elem("meta");
    $elem_d3300 = new Elem("p","bonjour");
    $elem_d4000 = new Elem("error");


    $elem_d0000->pushElement($elem_d1000);

    $elem_d1000->pushElement($elem_d1100);
    $elem_d1100->pushElement($elem_d1110);
    $elem_d1110->pushElement($elem_d1111);
    $elem_d1100->pushElement($elem_d1120);
    $elem_d1100->pushElement($elem_d1130);
    
    $elem_d0000->pushElement($elem_d2000);
    $elem_d2000->pushElement($elem_d2200);
    $elem_d2000->pushElement($elem_d2300);
    $elem_d2000->pushElement($elem_d2400);

    $elem_d0000->pushElement($elem_d3000);
    $elem_d3000->pushElement($elem_d3300);

    $elem_d0000->pushElement($elem_d4000);

    $elem_d0000->getHTML();
?>