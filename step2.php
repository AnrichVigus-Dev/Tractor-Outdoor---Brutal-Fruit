<?php
session_start();
if (!isset($_POST['start'])) {
  header("Location:step1.php");
}
$idcampaign = $_SESSION['idcampaign'];
include_once('connections/tractordbcon.php');
$dateofbirth = $_POST['birthYear'] . "-" .$_POST['birthMonth'] . "-" .$_POST['birthDay'];

// Query campaign to get t&cs

$sql = "SELECT * FROM tractorcampaigns WHERE id = '$idcampaign' LIMIT 1";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
			$termsconditions = $row['terms_conditions'];
		}
        // Free result set
        mysqli_free_result($result);
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
.bar-two {
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


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
		  var x = document.getElementById("tscs");
        $("#validateterms").click(function () {
            if ($(this).is(":checked")) {
                $("#btn-submit").removeAttr("disabled");
                $("#btn-submit").focus();
				if (x.style.display === "none") {x.style.display = "block";}
            } else {
                $("#btn-submit").attr("disabled", "disabled");
                x.style.display = "none";
            }
        });
    });
</script>




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
          <a href="step1.php" class="bfback" ><</a>
      </div>
  </div>
 <!-- Header - End -->

        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">

<form id="frm-image-upload" action="step3.php" name='img' method="post" >

		<div>









        <div class="sections">
					<div class="accept-text">
					<div style="width: 80%; float: left">By ticking this box you accept our terms and conditions of use:</div>
					<div style="width: 20%; float: right; text-align: center;">

					<label class="checkboxcontainer">
					<input type="checkbox" id="validateterms" name="check" />
					<span class="checkmark"></span>
					</label>

					</div>
					</div>
				</div>



					<div class="accept-text" style="margin-bottom:-40px;">
		        <div id="tscs" style="display: none;"><?php echo "<p>" . $termsconditions . "</p>";?></div>
					</div>


					<div class="main-cta-container">
            
          <input type="hidden" name="dateofbirth" id="dateofbirth" value="<?php  echo $dateofbirth ; ?>">
					<input class="inputfile inputfile-1" type="submit" id="btn-submit" name="terms" value="Next Step" hidden disabled="disabled">
					<label for="btn-submit" class="" >NEXT STEP</label>
					</div>


    </div>



</form>

<?php if(!empty($response)) { ?>
		<div class="response <?php echo $response["type"]; ?>">
    <p class="scampaign-heading-small"><?php echo $response["message"]; ?></p>
		</div>
<?php } ?>

</div>

<div class="footer-container">
<p class="footer-text">Powered by DOOHSHARE</p>
</div>


</div>
</body>
</html>
