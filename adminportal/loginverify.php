<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
unset($_SESSION['verified']);
include_once('../connections/tractordbcon.php');
$_SESSION['login_time'] = time();
$usrnmlookup = mysqli_real_escape_string($link, $_POST['tractorusrnm']);
$pswrdlookup = mysqli_real_escape_string($link, $_POST['tractorpswrd']);
$sqlcampaign = "SELECT * FROM admns WHERE (usrnm = '$usrnmlookup' AND pswrd = '$pswrdlookup') ";
if($resultcampaign = mysqli_query($link, $sqlcampaign)){
    if(mysqli_num_rows($resultcampaign) > 0){
		while($rowcampaign = mysqli_fetch_array($resultcampaign)){
			$_SESSION['verified'] = "tractoradmnverified";
		}
        // Free result set
        mysqli_free_result($resultcampaign);
    }
}
if ((!isset($_SESSION['verified'])) || (time() - $_SESSION['login_time'] > 600)) {header("Location: adminlogin.php?verified=false");} else {header("Location: campaigns.php");}
?>
