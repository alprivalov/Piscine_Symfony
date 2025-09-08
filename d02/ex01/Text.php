
<?php
    class Text{
        public $text = [];

        function __construct($param){
            $this->text = $param;
        }

        function append($string){
            array_push($this->text,$string);
        }

        function readData(){
            return $this->text;
        }
    }
?>