<?php
  error_reporting(7);
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Pragma: no-cache");  
  
  
$filename = "admin/database/events".$_GET["id"].".txt";
$fd = fopen ($filename, "r");
$contents = @fread ($fd, filesize ($filename));
fclose ($fd);
echo $contents;
?>