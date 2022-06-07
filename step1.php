<?php
session_start();
//$_SESSION = array();
session_destroy();
session_start();
session_regenerate_id();
include_once('connections/tractordbcon.php')?>
<?php
$key = "brutalfruit2021";
$_SESSION['bf2021uniquesession'] = session_id();

// Query campaign against short link - not sure if this will work yet
$sql = "SELECT * FROM tractorcampaigns WHERE modrewritename LIKE '%".$key."%' ORDER BY id DESC LIMIT 1";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
			$message = $row['message'];
			$message_brief = $row['message_brief'];
			$message_more_toggle = $row['message_more_toggle'];
			$message_more = $row['message_more'];
			$campaign = $row['campaign'];
			$_SESSION['idcampaign'] = $row['id'];
		}

        // Free result set
        mysqli_free_result($result);
    }
}
// Close connection
mysqli_close($link);
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
<link rel="stylesheet" href="css/agegatestyle.css">

<title>BRUTAL FRUIT YOU BELONG</title>

</head>

<style>

.bar-one {
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

<script type="text/javascript">
</script>

<script>
function myFunction() {
  var x = document.getElementById("tscs");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>



<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js" ></script>
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



<div class="center">
 <!-- Header - start  -->
 <div class="header-container">
      <div class="back-btn-container">
      </div>
  </div>
 <!-- Header - End -->

        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">

<!-- Write your comments here
	<h1 class="campaign-heading" ><?php echo $campaign; ?></h1>
-->

<!-- Write your comments here
	<div>
		<h2><?php echo $message; ?></h2>
	</div>
    -->

  <p class="content-description">
		<?php echo $message_brief; ?>
	</p>



<?php if ($message_more_toggle <> 0) { ?>
  <div class="sub-cta-container">
		<button class="accordion">READ MORE</button>
    <div class="panel">
    <p class="read-more-text"><?php echo $message_more; ?></p>
    </div>
	</div>
<?php } ?>



&nbsp;
<div class="ageWrap ageGateActive">
<div id="ageGate" style="display: block; opacity: 1; visibility: visible; top: 10px;">

<div class="border_wrap">
  <form name="ageGateForm" id="ageGateForm" class="cf" method="post" action="step2.php" >
        <input type="hidden" name="requiredAge" id="requiredAge" value="18">
        <input type="hidden" name="start" id="start" value="start">
        <h3 style="text-transform: uppercase;">Enter your details to confirm that you are over 18.</h3>
  <ul>
     <li>
       <input type="tel" class="ageInput input-field-step-one" name="birthDay" id="birthDay" maxlength="2" placeholder="DD" required="required" ><label></label></li>
    <li>
          <input type="tel" class="ageInput input-field-step-one" name="birthMonth" id="birthMonth" maxlength="2" placeholder="MM"  required="required" ></li>

     <li>
         <input type="tel" class="ageInput input-field-step-one" name="birthYear" id="birthYear" maxlength="4" placeholder="YYYY"  required="required" ></li>
      <li id="ageGateMess"></li>
  </ul>
        <input id="ageGateButton" type="submit" value="LET'S GO" id="submit"  />
        </form>
</div>
</div>
  </div>


  <div class="footer-container">
    <p class="footer-text">Powered by DOOHSHARE</p>
  </div>


</div>


</section>


<?php if ($message_more_toggle <> 0) { ?>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });

}
</script>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery.validator.setDefaults({
        debug: false,
        success: "valid"
    });
  var dateFields = ["#birthDay","#birthMonth","#birthYear"];
  jQuery('#ageGateForm').validate({

    groups: {
      date: dateFields.join("")
    },
    rules: {
      "birthDay": {
        required: true,
        minlength: 1,
        maxlength: 2,
        number: true,
        lessThan31: true
      },
      "birthMonth": {
        required: true,
        minlength: 1,
        maxlength: 2,
        number: true,
        lessThan12: true
      },
      "birthYear": {
        required: true,
        minlength: 4,
        maxlength: 4,
        number: true,
        greaterThan101: true,
        ageGatePass: dateFields
      }
    },
    messages: {
      "birthDay": {
        lessThan31: "Invalid day"
      },
      "birthMonth": {
        lessThan12: "Invalid month"
      },
      "birthYear": {
        greaterThan101: "Invalid year",
        ageGatePass: ""
      }
    },
    submitHandler: function(form) {
      form.submit();
      //alert("boo")
      //$("#ageGateButton").focus();
    }

  });






})

$.validator.addMethod('lessThan31', function(value, element, param) {
    if (this.optional(element)) return true;
    var i = parseInt(value);
    var j = 31;
    return i <= j;
});

$.validator.addMethod('lessThan12', function(value, element, param) {
    if (this.optional(element)) return true;
    var i = parseInt(value);
    var j = 12;
    return i <= j;
});


$.validator.addMethod('greaterThan101', function(value, element, param) {
    if (this.optional(element)) return true;
    var i = parseInt(value);
    var currdate = new Date();
    var j = currdate.getFullYear() - 100;
    return i >= j;
});


function isValidDate(value) {
    var dateWrapper = new Date(value);
    return !isNaN(dateWrapper.getDate());
}


$.validator.addMethod("ageGatePass", function (value, element, params) {
//alert(params[0]);
  var daySelector = params[0]
      , monthSelector = params[1]
      , yearSelector = params[2]
      , day = parseInt($(daySelector).val(), 10)
      , month = parseInt($(monthSelector).val(), 10)
      , year = parseInt($(yearSelector).val(), 10)
      , date = new Date(year, month, day)
      , passfail = true;
     // alert(date);
     if( isValidDate(date) ){
            var mydate = new Date();
            mydate.setFullYear(year, month-1, day);

            var currdate = new Date();
            currdate.setFullYear(currdate.getFullYear() - 18);
            if ((currdate - mydate) < 0){
              $('#ageGateMess').html("<p class='message' style='color: red;margin:0;font-weight:bold' >Sorry, only persons over the age of 18 may enter this site</p>");
              $('#ageGateButton').css("cursor", 'progress');
              return false;
             }else{
              $('#ageGateMess').html("");
              $('#ageGateButton').css("cursor", 'pointer');
              return true;
             }

      }else{
        return false;
      }
});


</script>
</body>
</html>
