<?php session_start();
if (!isset($_SESSION['bf2021uniquesession'])) {
	header("Location: step1.php");
} else {
	$uniquesession = $_SESSION['bf2021uniquesession'];
}
?>

<?php include_once('connections/tractordbcon.php')?>

<?php

// Query Users Table with new user just inserted belonging to unique sessionid

$sqluser = "SELECT * FROM tractorusers WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";
if($resultuser = mysqli_query($link, $sqluser)){
    if(mysqli_num_rows($resultuser) > 0){
		while($rowuser = mysqli_fetch_array($resultuser)){
			$iduser = $rowuser['id'];
			$idcampaign = $rowuser['idcampaign'];
			$name = $rowuser['name'];
			$email = $rowuser['email'];
			$mylocation = $rowuser['location'];
			$tolocation = $rowuser['idlocation'];
		}

        // Free result set
        mysqli_free_result($resultuser);
    }
}


// Query campaign against short link - not sure if this will work yet
$sql = "SELECT * FROM tractorcampaigns WHERE id = '$idcampaign'";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
			$message = $row['message'];
			$message_brief = $row['message_brief'];
			$message_more = $row['message_more'];
			$campaign = $row['campaign'];
			$exiturl = $row['exiturl'];
			$exiturltoggle = $row['exiturl_toggle'];
		}

        // Free result set
        mysqli_free_result($result);
    }
}




?>

<!doctype html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50882076-25"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-50882076-25');
</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
<title>BRUTAL FRUIT YOU BELONG</title>

</head>



<body>



  <section class="page-container">

<div class="center">

        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">

	<div class="campaign-heading-container">
	<h1 class="campaign-heading"><?php echo $campaign; ?></h1>
	</div>


	<div class="thankyou-name-container">
		<h2 class="thankyou-name-text"><?php echo $name?>, thank you!</h2>
	</div>

  <p class="content-description">
		Your billboard artwork has been submitted for approval.<br>
		You will be notified via email once approved.
	</p>


<?php if ($exiturltoggle <> 0) { ?>
	<div class="main-cta-container">
		<a href="<?php echo $exiturl; ?>" class="main-cta">FINISH</a>
	</div>
<?php } ?>

</div>




<div class="footer-container">
  <p class="footer-text">Powered by DOOHSHARE</p>
</div>


</section>
<?php
session_destroy();
?>

</body>
</html>
