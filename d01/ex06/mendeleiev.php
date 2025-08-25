<?php
        
    $file = "";
    function write_file($string){
        global $file;
        fwrite($file,$string);
    }
    function create_file(){
        $file = fopen("index.html","w");
    }
    function close_file(){
        fclose($file);
    }

    function create_html(){
        create_file();
        write_file("test");
        close_file();
    }