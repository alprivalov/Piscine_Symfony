<?php
    include 'TemplateEngine.php';

    $TemplateEngine = new TemplateEngine();
    $TemplateEngine->createFile("test.html","book_description.html",["nom1","auteur2","description3","prix4"]);
?>