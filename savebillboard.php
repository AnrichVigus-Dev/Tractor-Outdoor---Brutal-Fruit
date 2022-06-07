<?php
include_once('connections/tractordbcon.php');
if(!empty($_POST['data'])){
	$data = $_POST['data'];
	$displayfilename = $_POST['displayfilename'];
	$idbillboard      = $_POST['idbillboard'];   
	$iduser = $_POST['iduser'];
	$idcampaign = $_POST['idcampaign'];
	$uniquesession = $_POST['uniquesession'];

	list($type, $data) = explode(';', $data);
	list($type, $data) = explode(',', $data);
	$data = base64_decode($data);
	//unlink('usercomposits/'.$displayfilename);
	//sleep(10);
	file_put_contents('usercomposits/'.$displayfilename, $data);
	//add database entries

	$sqlupdate = "UPDATE tractorusers SET
	displayfilename='$displayfilename'
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