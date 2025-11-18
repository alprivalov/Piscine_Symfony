<?php

    function mendeleiev(){

        $file_html = fopen("./index.html","w");
        $file_data = fopen("./ex06.txt","r");

        fwrite($file_html,"<!DOCTYPE html>\n");
        fwrite($file_html,"<html lang=\"fr\">\n");
        fwrite($file_html,"<table>\n");

        $data = fgets($file_data);
        $array = [[]];
        $y = 0;

        while($data){
            $lastSplitData = explode(',',$data);
            $lastPosition = (int)explode(':',$lastSplitData[0])[1];
            for($i = 0; $i < count($lastSplitData);$i++){
                $trimmed_data[$i] = trim($lastSplitData[$i]);
            }
            $array[$y][$lastPosition] = $trimmed_data;
            $lastPosition++;
            $data = fgets($file_data);
            $nextSplitData = explode(',',$data);
            $nextPosition = (int)explode(':',$nextSplitData[0])[1];
            for($lastPosition; $lastPosition < $nextPosition; $lastPosition++){
                $array[$y][$lastPosition] = ["","","",""];
            }
            if($nextPosition  == 0)
                $y++;
        }
        
        for($i =0 ; $i < count($array); $i++){
            fwrite($file_html,"\t<tr>\n");

            for($j =0 ; $j < count($array[$i]); $j++){
                fwrite($file_html,"\t\t<td style=\"border: 1px solid black; padding:10px\">\n");
                if($array[$i][$j][0] != "") {
                    $split = explode("=",$array[$i][$j][0]);
                    fwrite($file_html, "\t\t\t<h4>" . trim($split[0]) . "</h4>\n");

                    fwrite($file_html, "\t\t\t<ul>\n");

                    fwrite($file_html, "\t\t\t\t\t<li>No " . trim(explode(":", $split[1])[1]) . "</li>\n");

                    fwrite($file_html, "\t\t\t\t\t<li>" . trim(explode(":", $array[$i][$j][2])[1]) . "</li>\n");

                    fwrite($file_html, "\t\t\t\t\t<li> " .  explode(":", $array[$i][$j][3])[1] . " </li>\n");

                    fwrite($file_html, "\t\t\t\t\t<li>" .  explode(":", $array[$i][$j][4])[1] . " electron</li>\n");

                    fwrite($file_html, "\t\t\t</ul>\n");
                }
                fwrite($file_html, "\t\t</td>\n");

            }
            fwrite($file_html,"\t</tr>\n");

        }

        fwrite($file_html,"</table>\n");

        fwrite($file_html,"</html>");

        fclose($file_data);
        fclose($file_html);
    }
    mendeleiev();