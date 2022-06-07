<?php
session_start();

// Look whether the page comes from the previous action - if not go to step 1
if ((!isset($_POST['formsubmitted'])) && ($_POST['formsubmitted'] <> "true")) {
  header("Location: step1.php");
} else {

?>

<?php include_once('connections/tractordbcon.php') ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://unpkg.com/konva@7.0.6/konva.min.js"></script>

<?php
$iduser = $_POST['iduser'];
$uniquesession = $_SESSION['bf2021uniquesession'];


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
      $compositfilename  = $rowuser['compositfilename'];
      $insitufilename = $rowuser['insitufilename'];
      $idbillboard = $rowuser['idbillboard'];
      $displayfilename = $rowuser['displayfilename'];
      $uniquesession = $rowuser['uniquesession'];
    }

        // Free result set
        mysqli_free_result($resultuser);
    }
}

?>


<?php

// Query Billboard based on id
$sqlbillboard = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
if($resultbillboard = mysqli_query($link, $sqlbillboard)){
    if(mysqli_num_rows($resultbillboard) > 0){
    while($rowbillboard = mysqli_fetch_array($resultbillboard)){
      $billboard_width  = $rowbillboard['billboard_width'];
      $billboard_height = $rowbillboard['billboard_height'];
      $billboardcode1  = $rowbillboard['billboardcode1'];
      $canvas_width = $rowbillboard['canvas_width'];
      $canvas_height  = $rowbillboard['canvas_height'];
      $canvas_pos_x = $rowbillboard['canvas_pos_x'];
      $canvas_pos_y = $rowbillboard['canvas_pos_y'];
      $insitu_width = $rowbillboard['insitu_width'];
      $insitu_height  = $rowbillboard['insitu_height'];
      $insitu_pos_x = $rowbillboard['insitu_pos_x'];
      $insitu_pos_y = $rowbillboard['insitu_pos_y'];
      $physicallocation = $rowbillboard['physicallocation'];
      $billboard_insitu_png = $rowbillboard['billboard_insitu_png']; //images/billboards
      $billboard_template = $rowbillboard['billboard_template']; //images/billboards/templates
      $bezel_filename = $rowbillboard['bezel_filename'];
      $bgcolor  = $rowbillboard['billboard_color'];
     }
        // Free result set
        mysqli_free_result($resultbillboard);
    }
}
  //create insitufilename
  $insitufilename = $billboardcode1 . '-loeries-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-insitu.png';
  $billboard_insitu_png_size = getimagesize('images/billboards/insitu/'. $billboard_insitu_png );
  $canvaswidth = $billboard_insitu_png_size[0];
  $canvasheight = $billboard_insitu_png_size[1];

    //echo $billboard_width . '<br/>';
    //echo $billboard_height . '<br/>';
    //echo $insitu_width . '<br/>';
    //echo $insitu_height . '<br/>';
    //echo $physicallocation . '<br/>';
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
<title>TRACTOR OUTDOOR</title>

<style>

.bar-one {
	background-color: #6dcddd;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}

.bar-two{
	background-color: #6dcddd;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}


.bar-three{
	background-color: #6dcddd;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}

.bar-four{
	background-color: #6dcddd;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}

.bar-five{
  background-color: #6dcddd;
	height: 20px;
	width: 15%;
	margin-right: 4px;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}

.bar-six{
  background-color: #6dcddd;
	height: 20px;
	width: 15%;
	flex: 1 1 auto;
  color:#ea214f;
  text-align: center;
  padding-top: 2px;
  font-family: 'Gilroy-Bold ☞';
}

.step-three{
  margin-top: 70% !important;
  margin-bottom: 40px !important;
}

#submit:disabled + label {
    background-color: #c4c4c4 !important;
    color: #a1a1a1;
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
  </div>

<div class="center-no-img">

  <div class="logo-centre-small" >
		<img src="images/DOOHSHARE-LOERIES-LOGO-01.png" alt="logo" width="158" height="auto">


	</div>

  <div class="fame-heading-container">
	<h1 class="fame-heading"><span class="fame-underline">15 SECONDS</span> OF FAME</h1>
	</div>

  <h1 class="steps-heading">A PREVIEW OF YOUR <?php echo strtoupper($physicallocation); ?> IN SITU BILLBOARD:</h1>
  <br>
  <br>


<div class="centre">

<!--FOR TESTING PURPOSE
<p>
<strong>VARIABLES SAVED TO USER TABLE:</strong>
</p>

USER ID: <?php //echo $iduser;?>
<br>
CAMPAIGN ID: <?php //echo $idcampaign;?>
<br>
NAME: <?php //echo $name;?>
<br>
EMAIL: <?php //echo $email;?>
<br>
SENDING FROM LOCATION: <?php //echo $location;?>
<br>
SENDING TO IDLOCATION: <?php //echo $idlocation;?>
<br>
UPLOADED FILENAME: <?php //echo $userfilename;?>
<br>
BILLBOARD TEMPLATE ID: <?php echo $idbillboard;?>
<br>
COMPOSITE FILENAME: <?php echo $compositfilename;?>
<br>
BILLBOARD DISPLAY FILENAME: <?php echo $displayfilename;?>
<br>
IN SITU FILENAME: <font color="red">UNDEFINED</font>
<br>
UNIQUE SESSION: <?php //echo $uniquesession;?>
-->


<p>


    <div id="canvaswrap" style="margin:auto;">
    <div id="container"></div>
    </div>


  <div class="sections">
  <input type="submit" value="GET APPROVAL" id="submit" class="main-cta" style="-webkit-appearance: none;"  />
  </div>

<form method="post" id="step5form" name="step5form" action="thankyou.php">
<input type="hidden" name="formsubmitted" id="textfield" value="true">
<input type="hidden" name="uniquesession" id="uniquesession" value="<?php  echo $uniquesession  ?>">
<input type="hidden" name="iduser" id="iduser" value="<?php  echo $iduser  ?>">
<input type="submit" value="NEXT STEP" id="btnsubmit" style="display: none" />
</form>





</div>

<div class="footer-container">
  <p class="footer-text">Powered by TRACTOR OUTDOOR</p>
</div>

</section>


    <script>

      //Konva.hitOnDragEnabled = true;

      var width = <?php echo $canvaswidth; ?>;//window.innerWidth;
      var height = <?php echo $canvasheight; ?>;//window.innerHeight;
      $('#container').css('width', width);
      $('#buttonsDiv').css('width', width);

      var screenWidth = window.innerWidth;
      if( window.innerWidth >= 600) { screenWidth = 600; } //(on desktop, css limits to 600px)
      screenWidth = screenWidth * (80/100); // 80% of screen width
      console.log(screenWidth + "   ----    " + <?php echo $canvaswidth; ?>);

    if( width >= screenWidth) {  //mostly for phones when canvas is larger than the screen
            //ff ::: question ff on phone giving issues
            /*
            $('body').css('MozTransform','scale(20%)');
            $('body').css('position','absolute');
            $('body').css('top','0');
            $('body').css('left','0');
            */
            phonewidth = screenWidth / (width);
            console.log(phonewidth);
            $('#container').css('transform', 'scale( ' + phonewidth + ' )');
            $('#container').css('transform-origin', '0% 0%');
      }



      //resize the canvas container so page isnt distorted after scale
      $(document).ready(function() {
        var canvasheight = $("#container")[0].getBoundingClientRect().height;
        $("#canvaswrap").css("max-height",canvasheight);
        var canvaswidth = $("#container")[0].getBoundingClientRect().width;
        $("#canvaswrap").css("max-width",canvaswidth);
      });


      var stage = new Konva.Stage({
        container: 'container',
        width: width,
        height: height,
      });

      var layer = new Konva.Layer();
      stage.add(layer);

      //background colour
      //-------------------------------------------
      var bgcolour = new Konva.Rect({
        x: 0,
        y: 0,
        width: width,
        height: height,
        fill: '<?php echo $bgcolor; ?>',
      });
      layer.add(bgcolour);
      layer.draw();
      bgcolour.moveToBottom();

      //background image
      //this is where the template will go
      //-------------------------------------------
      /*
      var bgimage = new Image();
      bgimage.onload = function () {
        var backgroundImage = new Konva.Image({
          x: 0,
          y: 0,
          width: width , //window.innerWidth,
          height: height, //window.innerHeight,
          image: bgimage,
          draggable: true,
          name: 'bg',
          id: 'bg',
        });
        layer.add(backgroundImage);
        layer.draw();
        backgroundImage.moveToBottom();
        bgcolour.moveToBottom();
      };
      bgimage.src = 'usercomposits/<?php echo $insitufilename;?>';
      */

      //template image
      //-------------------------------------------
      var templateimage = new Image();
      templateimage.onload = function () {
        var templateImage = new Konva.Image({
          x: 0,
          y: 0,
          width: width , //window.innerWidth,
          height: height, //window.innerHeight,
          image: templateimage,
          name: 'templateimage',
          id: 'templateimage',
        });
        layer.add(templateImage);
        layer.draw();
        templateImage.moveToTop();
        //bgcolour.moveToBottom();
      };

      templateimage.src = 'images/billboards/insitu/<?php echo $billboard_insitu_png;?>';


      //composite image
      //-------------------------------------------
      var compimage = new Image();
      compimage.onload = function () {
        var compImage = new Konva.Image({
          x: <?php echo $insitu_pos_x; ?>,
          y: <?php echo $insitu_pos_y; ?>,
          width: <?php echo $insitu_width; ?> , //window.innerWidth,
          height: <?php echo $insitu_height; ?>, //window.innerHeight,
          image: compimage,
          name: 'compimg',
          id: 'compimg',
        });
        layer.add(compImage);
        layer.draw();
        compImage.moveToTop();
        //bgcolour.moveToBottom();
      };

      compimage.src = 'usercomposits/<?php echo $displayfilename;?>?<?php echo date("His"); ?>';






      //save button
      function downloadURI(uri, name) {
        var link = document.createElement('a');
        link.download = name;
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        delete link;
      }

      document.getElementById('submit').addEventListener(
        'click',
        function () {
          $("#submit").attr("disabled", "disabled");
          $("#submit").css("backgroundColor", "#c4c4c4");
          $("#submit").css("color", "#a1a1a1");
          $("#submit").css("cursor", "progress");

          console.log('get approval');
          var dataURL = stage.toDataURL({ pixelRatio: 1 });
          //download image for troubleshooting
          //downloadURI(dataURL, '<?php echo $insitufilename; ?>');

        $.ajax({
          url: "saveinsitu.php",
          type: "post",
          data: {"data":dataURL, "insitufilename":'<?php echo $insitufilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
          success: function (response) {
            //allert response for troubleshooting
            //alert(response);
            console.log(response);
            document.getElementById('step5form').submit();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            //alert(textStatus, errorThrown);
          }
        });

        },
        false
      );



      </script>


</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>
