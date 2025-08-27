<?php
    class Tea extends HotBeverage{
        private $description;
        private $comment;
        function get_description(){
            return $this->description;
        }
        
        function get_comment(){
            return $this->comment;
        }
        
        function __construct(){
            parent::__construct("Tea",1.2,10);
            $this->description = "bonjour Tea";
            $this->comment = "aurevoir Tea";
        }
    }
?>