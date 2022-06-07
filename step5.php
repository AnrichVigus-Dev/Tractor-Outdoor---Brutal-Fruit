<?php session_start();
if (!isset($_SESSION['bf2021uniquesession'])) {
	header("Location: step1.php");
    header("Connection: close");

} else {
	$uniquesession = $_SESSION['bf2021uniquesession'];
	$idcampaign = $_SESSION['idcampaign'];
	@$justfirstname = $_POST['justfirstname'];
}


include_once('connections/tractordbcon.php');

if(@$_POST['justfirstname']){
	$idcampaign = $_SESSION['idcampaign'];
	$idbillboard = $_POST['idbillboard'];
	$uniquesession = $_SESSION['bf2021uniquesession'];

	$sqlupdate = "UPDATE tractorusers SET
	idbillboard='$idbillboard'
	WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";

	if ($link->query($sqlupdate) === TRUE) {
	  //echo "<p>Record updated successfully</p>";
	} else {
	  echo "Error updating record: " . $link->error;
	}

}



$sqluser = "SELECT * FROM tractorusers WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";
if($resultuser = mysqli_query($link, $sqluser)){
    if(mysqli_num_rows($resultuser) > 0){
		while($rowuser = mysqli_fetch_array($resultuser)){
			$iduser = $rowuser['id'];
			$idcampaign = $rowuser['idcampaign'];
			$name = $rowuser['name'];
			$email = $rowuser['email'];
			$idlocation = $rowuser['idlocation'];
			$savedidbillboard = $rowuser['idbillboard'];
			$posted_idlocation = $rowuser['idlocation'];
			$idtemplate = $rowuser['idtemplate'];
			$insitufilename = $rowuser['insitufilename'];
			$displayfilename = $rowuser['displayfilename'];
			$uniquesession = $rowuser['uniquesession'];
			if(!@$justfirstname){
				$arrjustfirstname = explode(" ", $name);
				$justfirstname = $arrjustfirstname[0];
			}
			if(!@$toname){
				$toname = $rowuser['toname'];
			}
			if(!@$billboardmessage){
				$billboardmessage = $rowuser['billboardmessage'];
			}
		}

        // Free result set
        mysqli_free_result($resultuser);
    }
}

if(	(strlen($savedidbillboard) <= 0) || ($savedidbillboard == 0 )	){//if billboard id not in databse
	header("Location: step4.php");
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
<title>BRUTAL FRUIT YOU BELONG</title>

<style>


.bar-five {
	background-color: #ff7d70;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#f7b1a9;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy ExtraBold';
}

</style>

</head>

<body>
<section class="page-container">

		<div class="progress-bar">
	    <div class="bar-one">1</div>
	    <div class="bar-two">2</div>
	    <div class="bar-three">3</div>
	    <div class="bar-four">4</div>
	    <div class="bar-five">5</div>
		<div class="bar-six">6</div>
    	<div class="bar-seven">7</div>
	  </div>

	<div class="center-no-img">

 <!-- Header - start  -->
 <div class="header-container">
  		<div class="back-btn-container">
          <a href="step4.php" class="bfback" ><</a>
      </div>
  </div>
 <!-- Header - End -->
        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">

	<h1 class="steps-heading">CELEBRATING</h1>

<form method="post" action="step6.php">

<!-- hidden fields - dont delete -->
<input type="hidden" name="iduser" id="textfield" value="<?php echo $iduser;?>">
<input type="hidden" name="formsubmitted" id="textfield" value="true">
<input type="hidden" name="idcampaign" id="textfield" value="<?php echo $idcampaign;?>">


  	<div class="sections">
  		<label class="step5label" >Friend's Name:</label>
			<?php if (empty($toname)) { ?>
      <input class="input-field-step-two" type="text" id="toname" name="toname" value="<?php echo @$toname; ?>"  maxlength="15" minlength="2" placeholder="To name" required="required" autofocus  pattern=".*\S+.*" oninvalid="setCustomValidity('Please enter your friend\'s name ')" oninput="setCustomValidity('')" />
			<?php } else { ?>
			<input class="input-field-step-two" type="text" id="toname" name="toname" value="<?php echo $toname; ?>"  maxlength="15" minlength="2"  placeholder="To name" required="required" autofocus  pattern=".*\S+.*" oninvalid="setCustomValidity('Please enter your friend\'s name ')" oninput="setCustomValidity('')"  />
			<?php }?>

  		<label class="step5label" style="padding-top: 15px;" >Display Message:</label><div style="clear: both;">&nbsp;</div>
		<style>
		.dropdown{
		 		font-size: 16px;
		 		background: white;
		 		border:none;
		 		position: relative;
		 		-webkit-appearance: none;
		        padding-right: 10px;
		 	}
		 	.dropdown:focus{
		 		outline: none;
		 	}
		 	.plain-selector{
		 		margin: 0 3px;
		 	}
		 	.plain-selector::after{
			 	content: "";
			    position: absolute;
			    z-index: 2;
			    bottom: 30%;
			    margin-top: -3px;
			    height: 0;
			    width: 0;
			    right: 15px;
			    border-top: 6px solid black;
			    border-left: 6px solid transparent;
			    border-right: 6px solid transparent;
			    pointer-events: none;
		 	}

		 	.out-selector{
		 		position: relative;
		 	}
		     .outter-selection{
		     	width: 100%;
		     }
		     .selection{
		   	display: block;
		 	margin: auto;
		 	border-radius: 50px;
		 	background: white;
		 	padding: 0;
		 	max-width: 360px;
		 	text-align: center;
		 	width: 90%;
		 	position: relative;
		 }

		  </style>


		<div class="outter-selection">

			<span class="out-selector">
				<span class="plain-selector">


				<select id="billboardmessage" name="billboardmessage" class="dropdown" required>
					<option value="" selected >MESSAGE:</option>

					<?php
					$sql = "SELECT id, billboardmessages FROM tractorcampaigns WHERE id = $idcampaign";
					if($result = mysqli_query($link, $sql)){
					    if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_array($result)){ 
								//split messages
								$arraybillboardmessages = explode("\n", $row['billboardmessages'] );
								foreach( array_filter($arraybillboardmessages) as $x){
								?>
									<option value="<?php echo trim($x) ?>" <?php if ( (trim(strtoupper($x)) == trim(strtoupper($billboardmessage)) )) { ?> selected="selected"<?php } ?>><?php echo trim($x); ?></option>

							<?php 
								}
							}

					        // Free result set
					        mysqli_free_result($result);
					    }
					}
					// Close connection
					mysqli_close($link);
					?>

				</select>
			</span>
		</span>

		</div>

  		<label class="step5label" >Your name, as displayed on the Billboard:</label>
			<?php if (empty($fromname)) { ?>
      <input class="input-field-step-two" type="text" id="fromname" name="fromname" value="<?php echo $justfirstname; ?>" maxlength="15" minlength="2" placeholder="From name" required="required" autofocus  pattern=".*\S+.*" oninvalid="setCustomValidity('Please enter your name ')" oninput="setCustomValidity('')" />
			<?php } else { ?>
			<input class="input-field-step-two" type="text" id="fromname" name="fromname" value="<?php echo $fromname; ?>"  maxlength="15" minlength="2" placeholder="From name" required="required" autofocus  pattern=".*\S+.*" oninvalid="setCustomValidity('Please enter your name ')" oninput="setCustomValidity('')"   />
			<?php }?>



  	</div>





  <div class="sections" >
  <input type="submit" value="NEXT STEP" id="submit" style="-webkit-appearance: none;" />
  </div>

</form>

</div>



<div class="footer-container">
  <p class="footer-text">Powered by DOOHSHARE</p>
</div>

</section>

</body>
</html>
