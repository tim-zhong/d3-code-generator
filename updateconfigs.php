<?php
$configs = urldecode($_GET['json']);

$file = fopen("configs.json", "w") or die("Unable to open file!");
fwrite($file, $configs);
fclose($file);