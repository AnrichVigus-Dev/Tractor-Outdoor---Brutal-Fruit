<?php

include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

$idcopyline = $_GET['idcopyline'];
$idcampaign = $_GET['idcampaign'];

// Attempt delete query execution
$sql = "DELETE FROM campaign_copylines WHERE idcopyline = $idcopyline";
if(mysqli_query($link, $sql)){
			header("Location: editcampaign.php?idcampaign=$idcampaign");
} else{
   echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);


?>
