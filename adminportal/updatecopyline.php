<?php
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

$copyline = $_POST['copyline'];
$idcopyline = $_POST['idcopyline'];
$idcampaign = $_POST['idcampaign'];

$sqlupdate = "UPDATE campaign_copylines SET
copyline = '$copyline'

WHERE idcopyline = '$idcopyline' ";

if(mysqli_query($link, $sqlupdate)){
      header("Location: editcampaign.php?idcampaign=$idcampaign");
} else{
echo "ERROR: Could not able to execute $sqlupdate. " . mysqli_error($link);
}
?>
