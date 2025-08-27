<?php
    class TemplateEngine{
        public $file;
        public $template;

        function createFile(HotBeverage $text){
            $this->file = fopen($text->get_name() . ".html",'w');
            $this->template = fopen("template.html",'r');

            $line = fgets($this->template);
            while($line){
                $line = str_replace("{nom}",$text->get_name(),$line);
                $line = str_replace("{price}",$text->get_price(),$line);
                $line = str_replace("{resistance}",$text->get_resistence(),$line);
                $line = str_replace("{description}",$text->get_description(),$line);
                $line = str_replace("{comment}",$text->get_comment(),$line);
                fwrite($this->file,$line);
                $line = fgets($this->template);
            }
            fclose($this->file);
            fclose($this->template);
        }

    }
?>