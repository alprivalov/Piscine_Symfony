<?php
    include 'TemplateEngine.php';
    include 'HotBeverage.php';
    include 'Tea.php';
    include 'Coffee.php';
    $TemplateEngine = new TemplateEngine();
    
    $Coffee = new Coffee();
    $Tea = new Tea();
    $TemplateEngine->createFile($Coffee);
    $TemplateEngine->createFile($Tea);
?>