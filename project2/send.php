<?php 
$r = rand(1,1000);


$json_string = file_get_contents("https://xkcd.com/${r}/info.0.json"); 

$json_array=json_decode($json_string, true);

$link =  $json_array["transcript"];

echo $link;

?>