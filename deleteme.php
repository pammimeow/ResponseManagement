<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php
$file = fopen("VIDEO0005.MP4","r") or exit("Unable to open file!");

echo $file;
?>
</body>
</html>