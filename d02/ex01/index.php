<?php
    include 'TemplateEngine.php';
    include 'Text.php';

    $TemplateEngine = new TemplateEngine();
    $Text = new Text(["nom1","auteur2","description3","prix4"]);
    
    $TemplateEngine->createFile("index.html",$Text);
?>