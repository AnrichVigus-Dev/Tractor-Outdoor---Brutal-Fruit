<?php
session_start();
//if ((!isset($_POST['formsubmitted'])) && ($_POST['formsubmitted'] <> "true")) {
if (!isset($_SESSION['bf2021uniquesession'])) {
	header("Location: step3.php");
} else {

?>

<?php include_once('connections/tractordbcon.php')?>

<?php
$idcampaign = $_SESSION['idcampaign'];
$uniquesession = $_SESSION['bf2021uniquesession'];
if(@$_POST['name']){
	$posted_name = trim(mysqli_real_escape_string($link, $_POST['name']));
	$posted_email = mysqli_real_escape_string($link, $_POST['email']);
	$posted_idlocation = $_POST['idlocation'];
	$justfirstname = explode(' ',$posted_name);

	$sqlupdate = "UPDATE tractorusers SET
	name='$posted_name',
	email='$posted_email',
	idlocation='$posted_idlocation'
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
			$posted_idlocation = $rowuser['idlocation'];
			$idtemplate = $rowuser['idtemplate'];
			$insitufilename = $rowuser['insitufilename'];
			$displayfilename = $rowuser['displayfilename'];
			$uniquesession = $rowuser['uniquesession'];
			$justfirstname = explode(' ',$name);
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


.bar-four {
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

<link rel="stylesheet" href="css/swiper-bundle.min.css">

<style>
/* SWIPER OVERRIDES */
.swiper-container {
	width: 100%;
	height: 330px;
	margin-top:-20px;
}

.swiper-slide {
	margin-top:-20px;
	text-align: center;
	font-size: 18px;
	background: transparent;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}

.swiper-button-next, .swiper-button-prev {
	 top: 42% !important;
}

/* HIDE RADIO */
[type=radio] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
[type=radio]:checked + img {
  outline: 2px solid #fff;
}

.radio-btn-text{
	position: absolute;
	top: 290px;
	font-size: 16px !important;
	color:#fff;
	width:80%;
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
          <a href="step3.php" class="bfback" ><</a>
            </a>
      </div>
  </div>
 <!-- Header - End -->

  <h1 class="steps-heading">PLEASE TAP THE BILLBOARD YOU WANT TO APPEAR ON:</h1>

<form method="post" action="step5.php">
<input type="hidden" name="formsubmitted" id="textfield" value="true">

<!-- Swiper -->

<div class="swiper-container">
	<div class="swiper-wrapper">

		<?php
		// Query Billboards based on location

		$rownumber = 0;

		$sqlbillboards = "SELECT * FROM billboards WHERE (locationid = '$posted_idlocation' AND campaignid = '$idcampaign') AND archive = 0";
		if($resultbillboards = mysqli_query($link, $sqlbillboards)){
		    if(mysqli_num_rows($resultbillboards) > 0){
				while($rowbillboards = mysqli_fetch_array($resultbillboards)){
		$rownumber = $rownumber + 1;
		?>


	      <div class="swiper-slide">

				<label>
				<input type="radio" name="idbillboard" id="billboard" class="radio-btn" value="<?php echo $rowbillboards['idbillboard']?>" >
				<img src="images/billboards/<?php echo $rowbillboards['billboard_insitu_example']; ?>" style="width:300px;" />
				</label>

				<div class="radio-btn-text">
				 <?php echo $rowbillboards['physicallocation']; ?>
				</div>

				</div>


		<?php }

		        // Free result set
		        mysqli_free_result($resultbillboards);
		    }
		}
		?>

		</div>

		<!-- Add Arrows -->
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>


	<!-- Swiper JS -->
  <script src="jspath/swiper-bundle.min.js"></script>

	<!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>



  <div class="sections" >
	<span id="msg" class="content-description" style="color:#fff; padding-bottom:20px; font-size:15px;"></span>
          <input type="hidden" name="justfirstname" id="justfirstname" value="<?php  echo $justfirstname[0] ; ?>">
  <input type="submit" value="NEXT STEP" id="submit" style="-webkit-appearance: none;" onclick="return radioValidation();" />
  </div>

</form>

<script type="text/javascript">
    function radioValidation(){

        var billboard = document.getElementsByName('idbillboard');
        var genValue = false;

        for(var i=0; i<billboard.length;i++){
            if(billboard[i].checked == true){
                genValue = true;
            }
        }
        if(!genValue){
					document.getElementById('msg').innerHTML = '<p><strong>Please tap the billboard you want to appear on!</strong></p>';
            return false;
        }

    }
</script>

</div>


<div class="footer-container">
  <p class="footer-text">Powered by DOOHSHARE</p>
</div>

</section>

</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>
