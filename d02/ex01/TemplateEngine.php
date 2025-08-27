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

    class TemplateEngine{
        public $file;
        
        function get_file(){
            return $this->file;
        }

        function createFile($fileName, $text){
            $this->file = fopen($fileName,'w');
            $data = $text->readData();
            print_r($data);
            foreach($data as $str){
                fwrite($this->file,"<p>" . $str. "<p>\n");
            }
        }

    }
?>