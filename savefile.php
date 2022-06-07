<?php
include_once('connections/tractordbcon.php');
if(!empty($_POST['data'])){
	$data = $_POST['data'];
	$compositfilename = $_POST['compositfilename'];
	$idbillboard      = $_POST['idbillboard'];   
	$iduser = $_POST['iduser'];
	$idcampaign = $_POST['idcampaign'];
	$uniquesession = $_POST['uniquesession'];

	list($type, $data) = explode(';', $data);
	list($type, $data) = explode(',', $data);
	$data = base64_decode($data);
	@unlink('usercomposits/'.$compositfilename);
	//sleep(2);
	file_put_contents('usercomposits/'.$compositfilename, $data);

	//add database entries
	$sqlupdate = "UPDATE tractorusers SET
	compositfilename='$compositfilename', 
	displayfilename='$compositfilename'
	WHERE uniquesession = '$uniquesession' ";

	if ($link->query($sqlupdate) === TRUE) {
	  echo "Record updated successfully";
	} else {
	  echo "Error updating record: " . $link->error;
	}


	echo 'Success';
}else{
	echo 'Error: missing data';
}
?>