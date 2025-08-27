<?php
    Class Elem {
        public array $elem = [];
        public string $balise;
        public string $content;

        function __construct(string $balise,string $content = "" ){
            $this->balise = $balise;
            $this->content = $content;
        }

        public function getHTML(){
            $file = fopen("index.html",'w');
            $this->recursive_tree(0,$file);
        }

        function recursive_tree($depth,$file){
            if(method_exists($this,$this->balise)){
                for($i = 0;$i < $depth ;$i++)
                    fwrite($file,"\t");
                fwrite($file,"<".$this->{$this->balise}() .$this->content . "\n");
            }
            foreach($this->elem as $child){
                $child->recursive_tree($depth + 1,$file);
            }
            if(method_exists($this,$this->balise)){
                for($i = 0;$i < $depth ;$i++)
                    fwrite($file,"\t");
                fwrite($file,"</".$this->{$this->balise}() . "\n");
            }
        }

        function pushElement(Elem $element){
            array_push($this->elem,$element);
        }
        
        public function meta(){
            return("meta>\n" . $this->content);
        }
        public function img(){
            return("img>");
        }
        public function hr(){
            return("hr>");
        }
        public function br(){
            return("br>");
        }
        public function head(){
            return("head>");
        }
        public function body(){
            return("body>");
        }
        public function title(){
            return("title>");
        }
        public function h1(){
            return("h1>");
        }
        public function h2(){
            return("h2>");
        }
        public function h3(){
            return("h3>");
        }
        public function h4(){
            return("h4>");
        }
        public function h5(){
            return("h5>");
        }
        public function h6(){
            return("h6>");
        }
        public function p(){
            return("p>");
        }
        public function span(){
            return("span>");
        }
        public function div(){
            return("div>");
        }

        public function html(){
            return("html>");
        } 
    }

?>