<?php 
session_start();
if (!isset($_SESSION['bf2021uniquesession'])) {
	header("Location: step1.php");
    header("Connection: close");

} else {
	$uniquesession = $_SESSION['bf2021uniquesession'];
	$idcampaign = $_SESSION['idcampaign'];
	$dateofbirth = $_POST['dateofbirth'];
}

include_once('connections/tractordbcon.php');

if (isset($_POST["check"])) {
  // Attempt insert query execution
  $today = date("Y-m-d H:i:s");
  $sql = "INSERT INTO tractorusers ( uniquesession, idcampaign, dateofbirth, datetime) VALUES
  ( '$uniquesession', '$idcampaign', '$dateofbirth', '$today')";
  if(mysqli_query($link, $sql)){
  	//
  } else{
    echo "ERROR:  Unable to execute $sql. " . mysqli_error($link);
  }
}

// Query Users Table with new user just inserted belonging to unique sessionid

$sqluser = "SELECT * FROM tractorusers WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";
if($resultuser = mysqli_query($link, $sqluser)){
    if(mysqli_num_rows($resultuser) > 0){
		while($rowuser = mysqli_fetch_array($resultuser)){
			$iduser = $rowuser['id'];
			$idcampaign = $rowuser['idcampaign'];
			$name = $rowuser['name'];
			$email = $rowuser['email'];
			$company = $rowuser['company'];
			$mylocation = $rowuser['location'];
			$tolocation = $rowuser['idlocation'];
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
<title>BRUTAL FRUIT YOU BELONG</title>

<style>


.bar-three {
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
          <a href="step2.php" class="bfback" ><</a>
      </div>
  </div>
 <!-- Header - End -->
        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">


	<h1 class="steps-heading">INSERT YOUR DETAILS</h1>

<form method="post" action="step4.php">

<!-- hidden fields - dont delete -->
<input type="hidden" name="iduser" id="textfield" value="<?php echo $iduser;?>">
<input type="hidden" name="formsubmitted" id="textfield" value="true">
<input type="hidden" name="filename" id="textfield" value="<?php echo $userfilename;?>">
<input type="hidden" name="idcampaign" id="textfield" value="<?php echo $idcampaign;?>">


  	<div class="sections">

			<?php if (empty($name)) { ?>
      <input class="input-field-step-two" type="text" id="name" name="name" value="" placeholder="Your name" required="required" autofocus pattern=".*\S+.*"  oninvalid="setCustomValidity('Please enter your name ')" oninput="setCustomValidity('')"  />
			<?php } else { ?>
			<input class="input-field-step-two" type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Your name" required="required" autofocus pattern=".*\S+.*" oninvalid="setCustomValidity('Please enter your name ')" oninput="setCustomValidity('')"   />
			<?php }?>

			<?php if (empty($email)) { ?>
      <input class="input-field-step-two" type="email" id="email" name="email" value="" placeholder="your@email.com" required="required" />
			<?php } else { ?>
			<input class="input-field-step-two" type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="your@email.com" required="required" />
			<?php }?>

  	</div>
<div class="outter-selection">

			<span class="out-selector">
				<span class="plain-selector">


				<select id="idlocation" name="idlocation" class="dropdown" required>
					<option value="" selected >BILLBOARD MAIN LOCATION:</option>

					<?php
					// Query and display Locations
					$sql = "SELECT * FROM locations WHERE active = 1";
					if($result = mysqli_query($link, $sql)){
					    if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_array($result)){ ?>

							<option value="<?php echo $row['id']?>" <?php if ((!empty($tolocation)) && ($row['id'] == $tolocation)) { ?> selected="selected"<?php } ?>><?php echo $row['location'] ?></option>

							<?php }

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
