<?php
    include 'TemplateEngine.php';
    include 'HotBeverage.php';
    include 'Tea.php';
    include 'Coffee.php';
    $TemplateEngine = new TemplateEngine();
    $Text = new Text(["nom1","auteur2","description3","prix4"]);
    $Coffee = new Coffee();
    $Tea = new Tea();
    $TemplateEngine->createFile($Coffee);
    $TemplateEngine->createFile($Tea);
?>