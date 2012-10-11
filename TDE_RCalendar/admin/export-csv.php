<?php
header("Content-Disposition: attachment; filename=".$_GET["name"].".csv");
$struct[0] = array("StartDate","EndDate","Title","Description");
$fields = $struct[$_GET["type"]];
 
for ($i=0;$i<count($fields);$i++)  
    echo '"'.str_replace('"','""', $fields[$i]).'",';
echo "\n";
 
$filename = "database/eventsRCalendar".$_GET["id"].".txt";
$fd = fopen ($filename, "r");
$contents = @fread ($fd, filesize($filename));
fclose ($fd);
$items = explode("\n*-*\n", $contents); 
for ($i=0;$i<count($items);$i++) 
{
   $subitems = split ("\n", $items[$i]);
   $dates = split("-",$subitems[0]);
   echo '"'.str_replace('"','""', $dates[0]).'",';
   echo '"'.str_replace('"','""', $dates[1]).'",';
   for ($j=1;$j<count($subitems);$j++)
       echo '"'.str_replace('"','""', $subitems[$j]).'",'; 
   echo "\n";    
}
?>