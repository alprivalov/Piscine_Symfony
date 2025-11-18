
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
            $result = [];
            foreach($this->text as $value){
                array_push($result,"<p>".$value."</p>");
            }
            return $result;
        }
    }
?>