<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

$copyline = "Update with real copy";
$idcampaign = $_GET['idcampaign'];

// Attempt insert query execution

$sql = "INSERT INTO campaign_copylines (copyline, idcampaign) VALUES
('$copyline', '$idcampaign')";
			if(mysqli_query($link, $sql)){

			header("Location: editcampaign.php?idcampaign=$idcampaign");
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

?>
