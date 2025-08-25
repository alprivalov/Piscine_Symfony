<?php
    $file = fopen("./ex01.txt","r");
    
    $line = fgets($file);

    $split = explode(',',$line);
    for($i = 0;$i < count($split);$i++){
        echo $split[$i],"\n" ;
    }
?>