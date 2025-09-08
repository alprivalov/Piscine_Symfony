<?php
    include "MyException.php";

    Class Elem {
        public array $elem = [];

        function __construct(
            public string $balise,
            public string $content = "",
            public array $attribut = [],
            public array $allowedBalise = [],
        ){}

        public function setHtmlString(){
            foreach($this->elem as $child){
                $search = array_search($child->balise,$this->allowedBalise);
                // force head to have title and meta
                if($this->balise ===  "head" && count($this->elem) != 2)
                    throw new MyException();
                // force body after head in html
                if(isset($this->allowedBalise["head"]) && $this->allowedBalise["head"] === 1 && $child->balise === "body")
                    throw new MyException();
                // 
                if(!isset($this->allowedBalise[$child->balise]) || $this->allowedBalise[$child->balise] == 0)
                    throw new MyException();
                $this->allowedBalise[$child->balise]--;
                $child->setHtmlString();
            }
        }

        public function validPage(){
            try{
                $this->setHtmlString();
            } catch(MyException $e) {
                return false;
            }
            return true;
        }

        public function getHTML(){
            $file = fopen("index.html",'w');
            $this->recursiveBuild(0,$file);
        }

        function recursiveBuild($depth,$file){
            if(!method_exists($this,$this->balise))
                throw new MyException();

            for($i = 0;$i < $depth ;$i++)
                fwrite($file,"\t");
            fwrite($file,"<".$this->{$this->balise}());
            foreach($this->attribut as $item_key => $item_value){
                fwrite($file," " . $item_key . "=\"" .$item_value . "\"");
            }
            fwrite($file, ">" . $this->content . "\n");
            foreach($this->elem as $child){
                $child->recursiveBuild($depth + 1,$file);
            }
            for($i = 0;$i < $depth ;$i++)
                fwrite($file,"\t");
            fwrite($file,"</".$this->{$this->balise}(). ">\n");
        }

        function pushElement(Elem $element){
            array_push($this->elem,$element);
        }
        
        function clean(){
            foreach($this->elem as $child){
                clean();
                $this->elem = [];
            }
        }

        private function meta(){
            return("meta");
        }
        private function img(){
            return("img");
        }
        private function hr(){
            return("hr");
        }
        private function br(){
            return("br");
        }

        private function head(){
            $this->allowedBalise = ["title" => 1,"meta"=>1];
            return("head");
        }
        private function body(){
            $this->allowedBalise = ["p" => INF,"table"=> INF,"ul"=> INF,"ol"=> INF];
            return("body");
        }
        private function title(){
            return("title");
        }
        private function h1(){
            return("h1");
        }
        private function h2(){
            return("h2");
        }
        private function h3(){
            return("h3");
        }
        private function h4(){
            return("h4");
        }
        private function h5(){
            return("h5");
        }
        private function h6(){
            return("h6");
        }
        private function p(){
            return("p");
        }
        private function span(){
            return("span");
        }
        private function div(){
            return("div");
        }
        private function html(){
            $this->allowedBalise = ["body"=>1,"head"=>1];
            return("html");
        } 
        private function th(){
            return("th");
        } 

        private function table(){
            $this->allowedBalise = ["tr"=> INF];
            return("table");
        } 
        private function tr(){
            $this->allowedBalise = ["th"=> INF,"td"=> INF];
            return("tr");
        } 
        private function td(){
            return("td");
        } 
        private function ul(){
            $this->allowedBalise = ["li"=> INF];
            return("ul");
        } 
        private function ol(){
            $this->allowedBalise = ["li"=> INF];
            return("ol");
        } 
        private function li(){
            return("li");
        } 
    }

?>