<?php

    $states = [
        'Oregon' => 'OR',
        'Alabama' => 'AL',
        'New Jersey' => 'NJ',
        'Colorado' => 'CO',
    ];

    $capitals = [
        'OR' => 'Salem',
        'AL' => 'Montgomery',
        'NJ' => 'trenton',
        'KS' => 'Topeka',
    ];

    function get_state_value($split_string) {
        global $capitals, $states;
        foreach($capitals as $capital_key => $capital_value){
            if($capital_value == $split_string){
                foreach($states as $states_key => $states_value){
                    if($capital_key == $states_value)
                        return print($split_string. " is the capital of " . $states_key . "\n");
                }
            }
        }
        return 1;
    }

    function search_by_states($string) {
        global $capitals, $states;
        $split_string = explode(',',$string);
        for($i = 0;$i < count($split_string);$i++){
            $split_string[$i] = trim($split_string[$i]);
        }
        
        for($i = 0;$i < count($split_string);$i++){
            if(isset($states[$split_string[$i]])){
                print($capitals[$states[$split_string[$i]]] ." is the capital of ". $split_string[$i] . "\n");
                continue;
            }
            elseif(!get_state_value($split_string[$i]))
                continue;
            print($split_string[$i] ." is neither a capital nor a state.\n");
        }
    }