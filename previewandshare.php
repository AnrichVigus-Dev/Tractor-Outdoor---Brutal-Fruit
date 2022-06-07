<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['fbclid']) ) { // came from facebook share
  header("Location: step1.php");
}
if( @$_SERVER['HTTP_REFERER'] == "https://t.co/" ){ // came from twitter share
  header("Location: step1.php");
}
$userid = $_GET['id'];
$fromname = $_GET['name'];
include_once('connections/tractordbcon.php');

$sqluser = "SELECT tractorusers.id, tractorusers.idcampaign, tractorusers.name, tractorusers.fromname, tractorusers.email, tractorusers.location, tractorusers.datetime, tractorusers.idbillboard, tractorusers.compositfilename, tractorusers.insitufilename, tractorusers.status, locations.location AS locations FROM tractorusers INNER JOIN locations ON tractorusers.idlocation = locations.id WHERE tractorusers.id = '$userid' AND tractorusers.fromname LIKE '$fromname'";
if($resultuser = mysqli_query($link, $sqluser)) {

    if(mysqli_num_rows($resultuser) > 0) {
		while($rowuser = mysqli_fetch_array($resultuser)){
      $status = $rowuser['status'];
      $idcampaign = $rowuser['idcampaign'];
      $name = $rowuser['name'];
      $submitted = $rowuser['datetime'];
      $insitufilename = $rowuser['insitufilename'];
      $compositfilename = $rowuser['compositfilename'];
    }

}
    // Free result set
    mysqli_free_result($resultuser);
}


      // Query campaign against short link - not sure if this will work yet
      $sqlcampaign = "SELECT * FROM tractorcampaigns WHERE id = $idcampaign";
      if($resultcampaign = mysqli_query($link, $sqlcampaign)){
          if(mysqli_num_rows($resultcampaign) > 0){
      		while($row = mysqli_fetch_array($resultcampaign)){
      			$share_description = $row['share_description'];
      			$share_url = $row['share_url'];
      			$campaign = $row['campaign'];
      		}
}
// Free result set
mysqli_free_result($resultcampaign);
}

?><!doctype html>
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
<title>BRUTAL FRUIT YOU BELONG</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<?php
echo '<meta name="twitter:card" content="summary_large_image" />';
echo '<meta name="twitter:site" content="@brutalfruit" />';
echo '<meta name="twitter:creator" content="@brutalfruit" />';
echo '<meta name="twitter:title" content="'.$campaign.'" />';
echo '<meta name="twitter:description" content="'.$share_description.'" />';
echo '<meta name="twitter:image" content="https://app-cm.azurewebsites.net/usercomposits/'.$insitufilename.'" />';
echo '<meta property="og:url" content="https://app-cm.azurewebsites.net/previewandshare.php?id='.$userid.'%26name='.$fromname.'"/>';
echo '<meta property="og:title" content="' . $campaign . '"/>';
echo '<meta property="og:type" content="website"/>';
echo '<meta property="og:image" content="https://app-cm.azurewebsites.net/usercomposits/'.$insitufilename.'"/>';
echo '<meta property="og:image:width" content="600"/>';
echo '<meta property="og:image:height" content="400"/>';
echo '<meta property="og:site_name" content="'.$campaign.'"/>';
echo '<meta property="og:description" content="' . $share_description . '"/>';
?>
<!--  <meta property="og:url" content="https://app-cm.azurewebsites.net/previewandshare.php?id=<?php echo $userid; ?>%26name=Daniesha"/> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/fa.css">
</head>
<body>
<section class="page-container">
  <div class="center-no-img">
      &nbsp;<br/>
        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">


  	<h1 class="campaign-heading"><?php echo $campaign; ?></h1>


    <p class="content-description">
  	<h2>Thank you for creating your billboard with DOOHshare™ <br>
      Attached is your image to share via social media. <br><br>
      Please remember to use the following hashtags and handle when sharing socially: <strong>#YouBelongToCelebrate, #BrutalFruitZA and @brutalfruitsa</strong>.
    </h2>
  	</p>


    <div style="max-width:400px; margin:auto;padding: 0 10px">
    <img src="usercomposits/<?php echo $insitufilename; ?>" width="100%">
    </div>
<br/>
    <div class="main-cta-container" style="margin-top: 0px !important; color: white" >
<h1 class="campaign-heading">Share to</h1>&nbsp;<br/>
<a class="js-social-share main-cta"  style="font-size: 20px;padding: 8px 15px 6px;white-space: nowrap; border-radius: 2px !important" href="http://www.twitter.com/share?url=https%3A%2F%2Fapp-cm.azurewebsites.net%2Fpreviewandshare.php%3Fid%3D<?php echo $userid; ?>%26name%3D<?php echo str_replace(' ', '%2520', $fromname); ?>" target="_blank" ><i class="fa fa-twitter" style="color: white; font-size: 20px" ></i>  Twitter</a>
&nbsp;
<a class="js-social-share main-cta"  style="font-size: 20px;padding: 8px 15px 6px;white-space: nowrap; border-radius: 2px !important"  href="https://www.facebook.com/sharer/sharer.php?u=https://app-cm.azurewebsites.net/previewandshare.php?id=<?php echo $userid; ?>%26name=<?php echo $fromname; ?>" target="_blank"><i class="fa fa-facebook" style="color: white; font-size: 20px" ></i> Facebook</a><br/>&nbsp;<br/>
Tap and hold share button required on some devices

  	</div>

  </div>


  <div class="footer-container">
    <p class="footer-text">Powered by DOOHSHARE</p>
  </div>


</section>

<?php

// Close connection
mysqli_close($link);
?>

<script type="text/javascript">

  //jQuery
$(".js-social-share").on("click", function(e) {
  e.preventDefault();
    windowPopup($(this).attr("href"), 500, 400);
});

function windowPopup(url, width, height) {
  // Calculate the position of the popup so
  // it’s centered on the screen.
  var left = (screen.width / 2) - (width / 2),
      top = (screen.height / 2) - (height / 2);

  setTimeout( function(){
      window.open(
        url,
        "",
        "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
      );
    },1500
  )
}



</script>

</body>
</html>
