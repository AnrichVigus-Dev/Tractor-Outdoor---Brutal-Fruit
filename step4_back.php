<?php
session_start();

// Look whether the page comes from the previous action - if not go to step 1
if ((!isset($_GET['action'])) && ($_GET['action'] <> "back")) {
	header("Location: step1.php");
} else {

?>

<?php include_once('connections/tractordbcon.php')?>

<?php
$idcampaign = $_SESSION['idcampaign'];
$uniquesession = $_SESSION['bf2021uniquesession'];
echo $uniquesession;

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
			$userfilename = $rowuser['uploadfilename'];
			$idtemplate = $rowuser['idtemplate'];
			$insitufilename = $rowuser['insitufilename'];
			$displayfilename = $rowuser['displayfilename'];
			$uniquesession = $rowuser['uniquesession'];
			$idmybillboard = $rowuser['idbillboard'];
			$idmycopyline = $rowuser['idcopyline'];
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

<title>TRACTOR OUTDOOR</title>

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
  font-family: 'CocogoosePro Bold';
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
  	  <div class="logo-centre-small">
  		  <img src="" alt="logo" width="158" height="auto">
      </div>

  		<div class="back-btn-container">
          <a href="step3.php">

              <!-- Generator: Adobe Illustrator 25.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  viewBox="0 0 447.2 447.2" style="enable-background:new 0 0 447.2 447.2;" xml:space="preserve"  width="30px"  height="30px">

                <g>
                  <g>
                    <path class="st0" d="M420.4,192.2c-1.8-0.3-3.7-0.4-5.5-0.4H99.3l6.9-3.2c6.7-3.2,12.8-7.5,18.1-12.8l88.5-88.5
                      c11.7-11.1,13.6-29,4.6-42.4C207,30.6,186.9,27.5,172.7,38c-1.2,0.8-2.2,1.8-3.3,2.8l-160,160c-12.5,12.5-12.5,32.8,0,45.3l0,0
                      l160,160c12.5,12.5,32.8,12.5,45.3-0.1c1-1,1.9-2,2.7-3.1c9-13.4,7-31.3-4.6-42.4l-88.3-88.6c-4.7-4.7-10.1-8.6-16-11.7l-9.6-4.3
                      h314.2c16.3,0.6,30.7-10.8,33.8-26.9C449.7,211.5,437.8,195.1,420.4,192.2z"/>
                  </g>
                </g>
                </svg>
            </a>
      </div>
  </div>
 <!-- Header - End -->


		<div class="fame-heading-container">
		<h1 class="fame-heading">Brutal Fruit</h1>
		</div>

	  <h1 class="steps-heading">CHOOSE AND TAP ON WHICH DIGITAL BILLBOARD YOU WANT TO APPEAR ON</h1>

	<form method="post" action="step5.php">
	<input type="hidden" name="formsubmitted" id="textfield" value="true">

<!-- Swiper -->

	<div class="swiper-container">
		<div class="swiper-wrapper">

				<?php

				// Query Billboards based on location

				$rownumber = 0;

				$sqlbillboards = "SELECT * FROM billboards WHERE (locationid = '$idlocation' AND campaignid = '$idcampaign') AND archive = 0";
				if($resultbillboards = mysqli_query($link, $sqlbillboards)){
				    if(mysqli_num_rows($resultbillboards) > 0){
						while($rowbillboards = mysqli_fetch_array($resultbillboards)){

				$rownumber = $rownumber + 1;
				$idbillboard = $rowbillboards['idbillboard'];
				?>


				<div class="swiper-slide">

				<label>
				<input type="radio" name="idbillboard" id="idbillboard" class="radio-btn" value="<?php echo $rowbillboards['idbillboard']?>">
				<img src="images/billboards/<?php echo $rowbillboards['billboard_insitu_example']; ?>"  style="width:300px;" />
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


	<style>
	/* Custom Dropdown CSS */
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





	<div class="sections" >
	<span id="msg" class="content-description" style="color:#fff; padding-bottom:20px; font-size:15px;"></span>
	<input type="submit" value="NEXT STEP" id="submit" style="-webkit-appearance: none;" onclick="return radioValidation();" />
	</div>

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

	</form>


</div>

<div class="footer-container">
  <p class="footer-text">Powered by TRACTOR OUTDOOR</p>
</div>

</div>


</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>
