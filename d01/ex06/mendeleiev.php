<?php

    function mendeleiev(){

        $doctype = "<!DOCTYPE html>\n";
        $html_head = "<html lang=\"fr\">\n";
        $html_feat = "</html>";
        $table_head = "<table>\n\t<tr>\n";
        $table_feat = "\t<tr>\n<table>\n";
        $table_feat = "\t<tr>\n<table>\n";

        $file_html = fopen("./index.html","w");
        $file_data = fopen("./ex06.txt","r");
        fwrite($file_html,$doctype);
        fwrite($file_html,$html_head);
        fwrite($file_html,$table_head);
        $data = fgets($file_data);
        while($data){
            $splited_data = explode(',',$data);
            
            $trimmed_data = [];
            for($i = 0; $i < count($splited_data);$i++){
                $trimmed_data[$i] = trim($splited_data[$i]);
            }
            
            
            $style_top = "\t\t<td style=\"border: 1px solid black; padding:10px\">\n";
            fwrite($file_html,$style_top);
            
            
            $header = "\t\t\t<h4>" . explode(' ',$trimmed_data[0])[0] ."</h4>\n";
            fwrite($file_html,$header);

            $ul = "\t\t\t\t<ul>\n";
            fwrite($file_html,$ul);

            $number ="\t\t\t\t\t<li>No ". explode(':',$trimmed_data[1])[1] ."</li>\n";
            fwrite($file_html,$number);


            $small = "\t\t\t\t\t<li>" . trim(explode(':',$trimmed_data[2])[1]) . "</li>\n";

            fwrite($file_html,$small);

            $molar = "\t\t\t\t\t<li>". explode(':',$trimmed_data[3])[1]."</li>\n";

            fwrite($file_html,$molar);

            $elector = "\t\t\t\t\t<li>". explode(':',$trimmed_data[4])[1] . " electron</li>\n";
            
            fwrite($file_html,$elector);

            fwrite($file_html,$ul);

            $style_bottom = "\t\t</td>\n";
            fwrite($file_html,$style_bottom);

            $data = fgets($file_data);
        }
        fwrite($file_html,$table_feat);
        
        fwrite($file_html,$html_feat);

        fclose($file_data);
        fclose($file_html);
    }
    mendeleiev();