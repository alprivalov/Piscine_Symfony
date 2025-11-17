<?php
    function array2hash($array){
        $new_array = [];
        for($i = 0; $i < count($array);$i++){
            $new_array[$array[$i][1]] = $array[$i][0];
        }
        return($new_array);
    }
?>