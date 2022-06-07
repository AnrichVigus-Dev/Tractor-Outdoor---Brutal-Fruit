<?php
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

$rejectline = mysqli_real_escape_string($link, $_POST['rejectline']);
$id = $_POST['id'];
$idcampaign = $_POST['idcampaign'];

$sqlupdate = "UPDATE campaign_rejectlines SET
rejectline = '$rejectline'

WHERE id = '$id' ";

if(mysqli_query($link, $sqlupdate)){
      header("Location: editcampaign.php?idcampaign=$idcampaign");
} else{
echo "ERROR: Could not able to execute $sqlupdate. " . mysqli_error($link);
}
?>
