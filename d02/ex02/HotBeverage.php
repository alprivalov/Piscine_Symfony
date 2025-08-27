<?php
    class HotBeverage {

        function __construct(
            public string $name,
            public float $price,
            public int $resistence,
        ) {}

        function get_name(){
            return $this->name;
        }
        function get_price(){
            return $this->price;
        }
        function get_resistence(){
            return $this->resistence;
        }
        
    }
?>