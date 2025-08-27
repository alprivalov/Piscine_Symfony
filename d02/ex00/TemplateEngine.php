<?php
    class TemplateEngine{
        public $file;
        
        function get_file(){
            return $this->file;
        }

        function createFile($fileName, $templateName, $parameters){
            $this->file = fopen($fileName,'r');
            
            $line = fgets($this->get_file());
            while($line){
                $line = str_replace("{nom}",$parameters[0],$line);
                $line = str_replace("{auteur}",$parameters[1],$line);
                $line = str_replace("{description}",$parameters[2],$line);
                $line = str_replace("{prix}",$parameters[3],$line);
                print($line);
                $line = fgets($this->get_file());
            }
        }

    }
?>