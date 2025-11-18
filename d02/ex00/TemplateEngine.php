<?php
    class TemplateEngine{
        private $template;
        private $file;

        function getTemplate(){
            return $this->template;
        }

        function getFile(){
            return $this->file;
        }


        function createFile($fileName, $templateName, $parameters){
            $this->template = fopen($templateName,'r');
            $this->file = fopen($fileName,'w');
            $line = fgets($this->getTemplate());
            while($line){
                $line = str_replace("{nom}",$parameters[0],$line);
                $line = str_replace("{auteur}",$parameters[1],$line);
                $line = str_replace("{description}",$parameters[2],$line);
                $line = str_replace("{prix}",$parameters[3],$line);
                fwrite($this->file,$line);
                $line = fgets($this->getTemplate());
            }
            fclose($this->file);
            fclose($this->template);
        }

    }
?>