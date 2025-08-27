<?php
    class Coffee extends HotBeverage{
        private $description;
        private $comment;
        function get_description(){
            return $this->description;
        }
        
        function get_comment(){
            return $this->comment;
        }
        
        function __construct(){
            parent::__construct("Coffee",1.2,10);
            $this->description = "bonjour Coffee";
            $this->comment = "aurevoir Coffee";
        }
    }
?>