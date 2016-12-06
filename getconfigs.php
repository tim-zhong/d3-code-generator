<?php
$configs = urldecode($_GET['json']);

$file = fopen("configs.json", "r") or die("Unable to open file!");
$configs = fread($file,filesize("configs.json"));
fclose($file);
$configs = json_decode($configs);