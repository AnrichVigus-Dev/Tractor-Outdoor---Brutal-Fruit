<?php
session_start();

// Look whether the page comes from the previous action - if not go to step 1
if ((!isset($_POST['formsubmitted'])) && ($_POST['formsubmitted'] <> "true")) {
	header("Location: step1.php");
} else {
	
?>

<?php include_once('connections/tractordbcon.php')?>

<?php

//Query USER table to retreive latest updated record and update USER table

// Posted Fields

$posted_idbillboard = $_POST['idbillboard'];
$uniquesession = $_SESSION['bf2021uniquesession'];

$sqlupdate = "UPDATE tractorusers SET
idbillboard='$posted_idbillboard'
WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";

if ($link->query($sqlupdate) === TRUE) {
  echo "<p>Record updated successfully</p>";
} else {
  echo "Error updating record: " . $link->error;
}

$sqluser = "SELECT * FROM tractorusers WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";
if($resultuser = mysqli_query($link, $sqluser)){
    if(mysqli_num_rows($resultuser) > 0){
		while($rowuser = mysqli_fetch_array($resultuser)){
			$iduser = $rowuser['id'];
			$idcampaign = $rowuser['idcampaign'];
			$name = $rowuser['name'];
			$email = $rowuser['email'];
			$location = $rowuser['location'];
			$idlocation = $rowuser['idlocation'];
			$idbillboard = $rowuser['idbillboard'];
			$userfilename = $rowuser['uploadfilename'];
			$idtemplate = $rowuser['idtemplate'];
			$insitufilename = $rowuser['insitufilename'];
			$displayfilename = $rowuser['displayfilename'];
			$uniquesession = $rowuser['uniquesession'];
		}
        
        // Free result set
        mysqli_free_result($resultuser);
    } 
}

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
	
<style>
	
body {font-family:  Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif"}

.maincontainer {
	margin: auto;
	width: 80%;
	}
	
.sectionshidden {
	padding:25px 25px;
	text-align: center;
	background-color: #BABABA;
	}
	
.sections {
	padding:25px 0;
	text-align: center;
	}
	

	
</style>	
	
</head>

<body>

	
<div class="maincontainer">
<p>
<strong>VARIABLES SAVED TO USER TABLE:</strong>
</p>

USER ID: <?php echo $iduser;?>
<br>
CAMPAIGN ID: <?php echo $idcampaign;?>
<br>
NAME: <?php echo $name;?>
<br>
EMAIL: <?php echo $email;?>
<br>
SENDING FROM LOCATION: <?php echo $location;?>
<br>
SENDING TO IDLOCATION: <?php echo $idlocation;?>
<br>
UPLOADED FILENAME: <?php echo $userfilename;?>
<br>
BILLBOARD TEMPLATE ID: <?php echo $idbillboard;?>
<br>
IN SITU FILENAME: <font color="red">UNDEFINED</font>
<br>
BILLBOARD DISPLAY FILENAME: <font color="red">UNDEFINED</font>
<br>
UNIQUE SESSION: <?php echo $uniquesession;?>

	
</div>
</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>