<?php
    include "MyException.php";

    Class Elem {
        public array $elem = [];

        function __construct(
            public string $balise,
            public string $content = "",
            public array $attribut = [],
        ){}

        public function getHTML(){
            $file = fopen("index.html",'w');
            $this->recursive_tree(0,$file);
        }

        function recursive_tree($depth,$file){
            try{
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
                    $child->recursive_tree($depth + 1,$file);
                }
                for($i = 0;$i < $depth ;$i++)
                    fwrite($file,"\t");
                fwrite($file,"</".$this->{$this->balise}(). ">\n");

            } catch(MyException $e) {
                print("Balise doesnt exist");
            }
        }

        function pushElement(Elem $element){
            array_push($this->elem,$element);
        }
        
        private function meta(){
            return("meta" . $this->content);
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
            return("head");
        }
        private function body(){
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
            return("html");
        } 
        private function th(){
            return("th");
        } 
        private function tr(){
            return("tr");
        } 
        private function td(){
            return("td");
        } 
        private function ul(){
            return("ul");
        } 
        private function ol(){
            return("ol");
        } 
        private function li(){
            return("li");
        } 
    }

?>