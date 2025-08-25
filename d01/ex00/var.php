<?php
    $a = 10;
    $b = "10";
    $c = "ten";
    $d = 10.0;
    echo "My first variables:", "\n";
    echo "a ","contains : ",$a," and has type : " ,gettype($a), "\n";
    echo "b ","contains : ",$b," and has type : " ,gettype($b), "\n";
    echo "c ","contains : ",$c," and has type : " ,gettype($c), "\n";
    echo "d ","contains : ",$d," and has type : " ,gettype($d), "\n";

    // a contains : 10 and has type : integer
    // b contains : 10 and has type : string
    // c contains : ten and has type : string
    // d contains : 10 and has type : double
?>