<?php

    function capital_city_from($string) {
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
        if(isset($states[$string]) && $capitals[$states[$string]])
            return($capitals[$states[$string]] . "\n");
        return("Unknown\n");
    }