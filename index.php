<?php
include "getconfigs.php";
include "icl/listsections.php";
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div id="header">
        <div class="cwidth">
            <!-- <button id="save_btn" class="btn btn-default">Save</button> -->
            <a href="preview.php" target="_blank" onclick="return saveConfig();"><button id="preview_btn" class="btn btn-default">Preview</button></a>
            <a href="raw.php" target="_blank" onclick="return saveConfig();"><button id="preview_btn" class="btn btn-default">Generate Code</button></a>
        </div>
    </div>
    <div id="content" class="cwidth">
        <h1>Dashboard</h1>

        <?php
        listsections();
        ?>
        
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="js/nano.js"></script>
    <script src="js/script.js"></script>
</body>
</html>