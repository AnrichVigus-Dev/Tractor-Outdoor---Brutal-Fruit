<?php
$link = mysqli_connect("localhost:8889", "root", "root", "brutalfruitdb");
//$link = mysqli_connect("app-cm-mysql.mysql.database.azure.com", "appcmadmin", "keax!thuy1thet0GOOL", "brutalfruitdb");
if($link === false){
die("ERROR ::: Could not connect. " . mysqli_connect_error());
}
?>
