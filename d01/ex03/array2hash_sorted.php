<?php
    function array2hash_sorted($array){
        $new_array = [];
        for($i = 0; $i < count($array);$i++){
            $new_array[$array[$i][0]] = $array[$i][1];
        }
        krsort($new_array);
        return($new_array);
    }
?>