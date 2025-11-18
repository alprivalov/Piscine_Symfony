<?php
    class TemplateEngine{
        public $file;
        
        function get_file(){
            return $this->file;
        }

        function createFile($fileName, $text){
            $this->file = fopen($fileName,'w');
            $data = $text->readData();
            foreach($data as $str){
                fwrite($this->file, $str . "\n");
            }
        }

    }
?>