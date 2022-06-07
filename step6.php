<?php
session_start();
if(  !$_SESSION['bf2021uniquesession'] ){
  header("Location: step1.php");
}
if(  !@$_POST['billboardmessage'] ){
  header("Location: step1.php");
}
// Look whether the page comes from the previous action - if not go to step 1
if ((!isset($_POST['formsubmitted'])) && ($_POST['formsubmitted'] <> "true")) {
  header("Location: step1.php");
} else {

include_once('connections/tractordbcon.php')  ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/konva@7.0.6/konva.min.js"></script>

<?php


$uniquesession = $_SESSION['bf2021uniquesession'];
$idcampaign = $_SESSION['idcampaign'];
$fontname = 'CocogoosePro Reg';
$fontnameLight = 'CocogoosePro Light';
$fontnameUltraLight = 'CocogoosePro UltraLight';
$fontnameSemiLight = 'CocogoosePro SemiLight';
// vauneen ::: https://konvajs.org/docs/sandbox/Custom_Font.html
//see if font is loaded 


if(@$_POST['billboardmessage']){
    $posted_billboardmessage = strtoupper( $_POST['billboardmessage'] );
    $posted_fromname = trim( strtoupper( $_POST['fromname'] ) );
    $posted_toname = trim( strtoupper( $_POST['toname'] ) );
    $sqlupdate = "UPDATE tractorusers SET
    billboardmessage = '".addslashes($posted_billboardmessage)."',
    fromname='$posted_fromname',
    toname='$posted_toname'
    WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";

    if ($link->query($sqlupdate) === TRUE) {
      //echo "<p>Record updated successfully</p>";
    } else {
      echo "Error updating record: " . $link->error;
    }

}




    // Query Campaign based on id
      $sqluser = "SELECT * FROM tractorusers INNER JOIN tractorcampaigns ON tractorusers.idcampaign = tractorcampaigns.id WHERE uniquesession = '$uniquesession' ORDER BY tractorusers.id DESC LIMIT 1";

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
      $billboardmessage = $rowuser['billboardmessage'];
      $fromname = $rowuser['fromname'];
      $toname = $rowuser['toname'];
      $idtemplate = $rowuser['idtemplate'];
      $compositfilename = $rowuser['compositfilename'];
      $insitufilename = $rowuser['insitufilename'];
      $displayfilename = $rowuser['displayfilename'];
      $uniquesession = $rowuser['uniquesession'];
      $billboard_logo = $rowuser['billboard_logo'];
      $billboard_sticker1 = $rowuser['billboard_sticker1'];
      $idcopyline = $rowuser['idcopyline'];
      $instructions = $rowuser['instructions'];
      $toggle_logo = $rowuser['billboard_logo_toggle'];
      $toggle_sticker = $rowuser['billboard_sticker1_toggle'];
      $toggle_copyline = $rowuser['copyline_toggle'];
    }
    $userfilename = $uniquesession;



    // Query Campaigns table for canvas bg color
    $sqlcampaigns = "SELECT id, campaign_backgroundcolor FROM tractorcampaigns WHERE id = '$idcampaign'";

    if($resultcampaigns = mysqli_query($link, $sqlcampaigns)) {

        if(mysqli_num_rows($resultcampaigns) > 0) {
           while ($rowcampaigns = mysqli_fetch_array($resultcampaigns)){
          $bgcolor = $rowcampaigns['campaign_backgroundcolor'];
        }
            // Free result set
            mysqli_free_result($resultcampaigns);
        }
    }


    //$canvastext = '#'.$name;
    //echo "<br/> idbillboard :: ". $idbillboard . "<br/>";

    // Query Billboard based on id
    $sqlbillboard = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
    if($resultbillboard = mysqli_query($link, $sqlbillboard)){
        if(mysqli_num_rows($resultbillboard) > 0){
        while($rowbillboard = mysqli_fetch_array($resultbillboard)){
            $billboard_width  = $rowbillboard['billboard_width'];
            $billboard_height = $rowbillboard['billboard_height'];
            $canvas_width = $rowbillboard['canvas_width'];
            $canvas_height  = $rowbillboard['canvas_height'];
            $canvasPreview_pos_x = $rowbillboard['canvas_pos_x'];
            $canvasPreview_pos_y = $rowbillboard['canvas_pos_y'];
            $physicallocation = $rowbillboard['physicallocation'];
            $billboard_insitu_png = $rowbillboard['billboard_insitu_png']; 
            $billboard_insitu_png_width = $rowbillboard['billboard_insitu_png_width']; 
            $billboard_insitu_png_height = $rowbillboard['billboard_insitu_png_height']; 
            $insitu_pos_y = $rowbillboard['insitu_pos_y']; 
            $insitu_pos_x = $rowbillboard['insitu_pos_x']; 
            $insitu_height = $rowbillboard['insitu_height']; 
            $insitu_width = $rowbillboard['insitu_width']; 
            $billboard_template = $rowbillboard['billboard_template']; //images/billboards/templates
            $bezel_filename = $rowbillboard['bezel_filename'];
            $fromtextX = $rowbillboard['fromtextX'];
            $fromtextY = $rowbillboard['fromtextY'];
            $fromtextsize = $rowbillboard['fromtextsize'];
            $totextX = $rowbillboard['totextX'];
            $totextY = $rowbillboard['totextY'];
            $totextsize = $rowbillboard['totextsize'];
            $messageX = $rowbillboard['messageX'];
            $messageY = $rowbillboard['messageY'];
            $messagesize = $rowbillboard['messagesize'];
            $messagewidth =  $rowbillboard['messagewidth'];
            $fromtextwidth =  $rowbillboard['fromtextwidth'];
            $totextwidth =  $rowbillboard['totextwidth'];
            $billboardcode1  = $rowbillboard['billboardcode1'];
         }
            // Free result set
            mysqli_free_result($resultbillboard);
        }
    }

    //create composite
    $compositfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-composit.jpg';
    //create insitufilename
    $insitufilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-insitu.png';
    //create displayfilename
    $displayfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-billboard.jpg';

    //$billboard_insitu_png_size = getimagesize('images/billboards/insitu/'. $billboard_insitu_png );
    //$canvasPreview_width = $billboard_insitu_png_size[0];
    //$canvasPreview_height = $billboard_insitu_png_size[1];

//echo 'billboard_template :: '.$billboard_template;


  //calculations for bgimage (make 60 or 75% and centered horizontally)
    $canvaswidth = $canvas_width;
    $canvasheight = $canvas_height;
    $canvasaspectratio = 'land';
    if( $canvaswidth <= $canvasheight ){  //canvas port
      $canvasaspectratio = 'port';
    }
    if( $canvasaspectratio == '' ){  //port port
        $forceheight = $canvasheight * (70/100);
        $forcefactor = $canvasheight / $forceheight;
        $forcewidth = $canvaswidth / $forcefactor;
    }else{  //photo land
        $forcewidth = $canvaswidth * (70/100);
        $forcefactor = $canvaswidth / $forcewidth;
        $forceheight = $canvasheight / $forcefactor;
    }
        // Free result set
        mysqli_free_result($resultuser);
    }
}


?>

<!doctype html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"  />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
<title>BRUTAL FRUIT YOU BELONG</title>

<style>

.bar-six { 
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
.maincontainer-build-billboard {
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





.edit-image-container-one{
  width: 12%;
  flex: 1 1 auto;
  text-align: center;
}

.edit-image-container-two{

  width: 12%;
  flex: 1 1 auto;
  text-align: center;
}

.edit-image-container-three{
  width: 12%;
  flex: 1 1 auto;
  text-align: center;
}

.edit-image-container-four{
  width: 12%;
  flex: 1 1 auto;
  text-align: center;
}

.edit-image-container-five{
  width: 12%;
  flex: 1 1 auto;
  text-align: center;

}

.reset-img{
  margin-top: -5px;
}

.step-no{
  margin-top: -10px;
}



.edit-img-instructions{
  width: 80%;
  text-align: left;
    padding-left: 10%;
    font-size: 16px;
}

.canvaspreviewwrap{
  padding-bottom: 400px;
}

/*
#canvaswrap,
#canvaspreviewwrap{
    margin-left: auto;
    margin-right: auto;
  }
*/
</style>

</head>

<body id="canvaspage" >

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
          <a href="step5.php" class="bfback" ><</a>
      </div>
  </div>
 <!-- Header - End -->
        <img src="images/BFLogoOnly.png" alt="logo" width="158" height="auto">

  <h1 class="steps-heading" style="text-align: center;" >PREVIEW BILLBOARD</h1>

  <div class="edit-img-instructions">
  <p><?php echo $instructions; ?></p>
  </div>



<div class="maincontainer-build-billboard">
<!--FOR TESTING PURPOSE
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
COMPOSITE FILENAME: <font color="red">UNDEFINED</font>
<br>
BILLBOARD DISPLAY FILENAME: <font color="red">UNDEFINED</font>
<br>
IN SITU FILENAME: <font color="red">UNDEFINED</font>
<br>
UNIQUE SESSION: <?php echo $uniquesession;?>
<br>
LOGO STICKER : <?php echo $billboard_logo;?>
<br>
BILLBOARD STICKER 1: <?php echo $billboard_sticker1;?>

-->

<div id="step6">
    &nbsp;<br/>

    <div id="canvaswrap" style="margin-left: auto;margin-right: auto; ">
      <div id="container"></div>
    </div>


    <div id="canvaswrapInsitu" style="display: none;">
      <div id="containerInsitu"></div>
    </div>

    <div class="sections"  id="submitpreview"  style="display:block; text-align: ">
  <form method="post" id="step6form" name="step6form" action="thankyou.php">
    <input type="hidden" name="formsubmitted" id="textfield" value="true">
    <input type="hidden" name="uniquesession" id="uniquesession" value="<?php  echo $uniquesession  ?>">
    <input type="hidden" name="iduser" id="iduser" value="<?php  echo $iduser  ?>">
    <input type="submit" value="NEXT STEP" id="btnsubmit" style="display: none" />
  </form>
      <div id='progressmessage' style="font-size: 1.2em; color: red; font-weight: bold;" ></div>
      <input type="button" id="preview" value="GENERATE"   class="" />
    </div>
</div>
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
    <script>

var thecanvaswidth = <?php echo $canvaswidth; ?>;

$("#preview").attr("disabled", "disabled");
$("#preview").css("cursor", "progress");
$("#preview").css("backgroundColor", "#f8b1aa");
$("#preview").css("color", "#ffffff");
$("#progressmessage").html("");
var width = <?php echo $canvaswidth; ?>;
var height = <?php echo $canvasheight; ?>;
          console.log('comp ::: ' + width);
          console.log('comp ::: ' + height);
$('#container').css('width', width);
//$('#buttonsDiv').css('width', width);

var screenWidth = window.innerWidth;
var screenHeight = window.innerHeight;
if( window.innerWidth >= 600) { screenWidth = 600; } //(on desktop, css limits to 600px)
screenWidth = screenWidth * (80/100); // 80% of screen width
console.log(screenWidth + "   ----    " + <?php echo $canvaswidth; ?>);

if( width >= screenWidth) {  //zoom to fit - this causes gaps
  phonewidth = screenWidth / (width);
  phoneheight = screenHeight / (height);
  console.log(phonewidth);
  $('#container').css('transform', 'scale( ' + phonewidth + ' )');
  $('#container').css('transform-origin', '0% 0%');
  console.log('phonewidth' + phonewidth);
}
if( height >= screenHeight) { //for very port canvases
  phoneheight = screenHeight / (height);
  phoneheight = phoneheight * (70/100);
  console.log('phoneheight ::: ' + phoneheight);
  $('#container').css('transform', 'scale( ' + phoneheight + ' )');
  $('#container').css('transform-origin', '0% 0%');
  console.log('phoneheight' + phoneheight);
  var theratio =  Math.min(phoneheight, phonewidth);
  $('#container').css('transform', 'scale( ' + theratio + ' )');
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
    height: height
});

var layer = new Konva.Layer();
      stage.add(layer);

// main image:
var imageObj = new Image();
imageObj.onload = function () {
  var yoda = new Konva.Image({
    x: 0,
    y: 0,
    image: imageObj,
    width: width,
    height: height,
  });

  // add the shape to the layer
  layer.add(yoda);
  layer.draw();
};
imageObj.src = 'images/billboards/templates/<?php echo $bezel_filename; ?>';


/*
YOU DESERVE TO CELEBRATE THAT PROMOTION.
CONGRATS, GRAD! YOU DID IT.
YOU'RE A HOME OWNER NOW. CONGRATS SIS!
YOU BELIEVED IN YOURSELF AND YOU DID IT!
HERE’S TO YOU FOR DREAMING BIG!

*/




function scaledFontsize( text,fontface,desiredWidth ){
    desiredWidth = desiredWidth - 20;
    var c=document.createElement('canvas');
    var cctx=c.getContext('2d');
    var testFontsize=18;
    cctx.font=testFontsize+'px '+fontface;
    var textWidth=cctx.measureText(text).width;
    return((testFontsize*desiredWidth/textWidth));
}
var scaledSizeTo = scaledFontsize( '<?php echo $toname; ?>' ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $totextwidth; ?>' );
var scaledSizeFrom = scaledFontsize( '<?php echo $fromname; ?>' ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $fromtextwidth; ?>' );
var messageheight = 70;
//var maxToTextSIze = '<?php echo $totextsize;?>';
//if (scaledSize >= maxToTextSIze) {  scaledSize = maxToTextSIze; }

if (thecanvaswidth >= 1200){
  if(scaledSizeTo >= 91){ scaledSizeTo = 91; }
  if(scaledSizeFrom >= 51){ scaledSizeFrom = 51; }
  messageheight = 140;
}else{
  if(scaledSizeTo >= 51){ scaledSizeTo = 51; }
  if(scaledSizeFrom >= 24){ scaledSizeFrom = 24; }
}



//Billboardmessage
var layertext = new Konva.Layer();
stage.add(layertext);


const textHolder = new Konva.Text({
    x: <?php echo $messageX;?>,
    y: <?php echo $messageY;?>,
    text: "<?php echo $billboardmessage;?>",
//    text: "YOU BELIEVED IN YOURSELF AND YOU DID IT!",
//    text: "YOU'RE A HOME OWNER NOW. CONGRATS SIS!",
//    text: "YOU DESERVE TO CELEBRATE THAT PROMOTION.",
//    text: "CONGRATS, GRAD! YOU DID IT.",
//    text: "HERE’S TO YOU FOR DREAMING BIG!",
    fontSize: <?php echo $messagesize;?>,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    letterSpacing: 1,
    lineHeight: 1.1,
    fill: 'white',
    keepRatio:false,
    width: <?php echo $messagewidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: messageheight,
    verticalAlign: 'middle'
});

//Fromtext
var layertextFrom = new Konva.Layer();
stage.add(layertextFrom);
const textHolderFrom = new Konva.Text({
    x: <?php echo $fromtextX;?>,
    y: <?php echo $fromtextY;?>,
    text: "<?php echo $fromname;?>",
//    fontSize: <?php echo $fromtextsize;?>,
    fontSize: scaledSizeFrom,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    fill: '#c16566',
    keepRatio:false,
    width: <?php echo $fromtextwidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: 50,
    verticalAlign: 'top'
});


//Totext
var layertextTo = new Konva.Layer();
stage.add(layertextTo);
const textHolderTo = new Konva.Text({
    x: <?php echo $totextX;?>,
    y: <?php echo $totextY;?>,
    text: "<?php echo $toname;?>",
////    fontSize: <?php echo $totextsize;?>,
    fontSize: scaledSizeTo,
    fontFamily: '<?php echo $fontnameUltraLight; ?>',
    fontWeight: 'Normal',
    fill: 'white',
    keepRatio:false,
    width: <?php echo $totextwidth; ?>,
    align: 'center',
    name: 'nameTx',
    id: 'nameTx',
    height: 50,
    verticalAlign: 'bottom'
});



const groupWithText = new Konva.Group();
setTimeout( function(){
  groupWithText.add(textHolder);
  groupWithText.add(textHolderTo);
  groupWithText.add(textHolderFrom);
  //activate Text
  layertext.add(groupWithText);
  layertext.draw();
  layertext.draw();
  layertext.moveToTop();

  $("#preview").removeAttr("disabled");
  $("#preview").css("cursor", "pointer");
  $("#preview").css("backgroundColor", "#f8b1aa");
  $("#preview").css("color", "#ffffff");
},1000)

      document.getElementById('preview').addEventListener(
        'click',
        function () {
          $("#preview").attr("disabled", "disabled");
          $("#preview").css("backgroundColor", "#c4c4c4");
          $("#preview").css("color", "#ffffff");
          $("#preview").css("cursor", "progress");
          $("html, body").css("cursor", "progress");
          $("#preview").val("GENERATING...");
          $("#progressmessage").html("Generating image, please don't close your browser or move away from the page.<br>&nbsp;");

          console.log('get approval');
          var dataURL = stage.toDataURL({ pixelRatio: 1 });
          $.ajax({
            url: "savefile.php",
            type: "post",
            data: {"data":dataURL, "compositfilename":'<?php echo $compositfilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
            success: function (response) {
              console.log(response);
              //$("#submitstep4").css('display', 'block');
              //$("#save").css('display', 'block');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            },
            async: false
          });
          //create insitu image
          setTimeout(function(){
                  makeInsitu();
            },4000
          )


        },
        false
      );


function makeInsitu(){
  widthinsitu = <?php echo $billboard_insitu_png_width; ?>;
  heightinsitu= <?php echo $billboard_insitu_png_height; ?>;
  insitu_width= <?php echo $insitu_width; ?>;
  insitu_height= <?php echo $insitu_height; ?>;
  insitu_pos_x= <?php echo $insitu_pos_x; ?>;
  insitu_pos_y= <?php echo $insitu_pos_y; ?>;

  var stageInsitu = new Konva.Stage({
      container: 'containerInsitu',
      width: widthinsitu,
      height: heightinsitu
  });

  // main image:
  var layerInsitu = new Konva.Layer();
  stageInsitu.add(layerInsitu);
  var imageObjInsitu = new Image();
  imageObjInsitu.onload = function () {
    var bginsit = new Konva.Image({
      x: 0,
      y: 0,
      image: imageObjInsitu,
      width: widthinsitu,
      height: heightinsitu,
    });
    layerInsitu.add(bginsit);
    layerInsitu.draw();
  };
  imageObjInsitu.src = 'images/billboards/insitu/<?php echo $billboard_insitu_png; ?>';

  // bill image:
  var layerBB = new Konva.Layer();
  stageInsitu.add(layerBB);
  var imageObjBB = new Image();
  imageObjBB.onload = function () {
    var bbinsit = new Konva.Image({
      x: insitu_pos_x,
      y: insitu_pos_y,
      image: imageObjBB,
      width: insitu_width,
      height: insitu_height,
    });
    // add the shape to the layer
    layerBB.add(bbinsit);
    layerBB.draw();
  };
  imageObjBB.src = 'usercomposits/<?php echo $compositfilename; ?>';
  var iscomplete = 0;
    setTimeout(function(){
      var dataURLInsitu = stageInsitu.toDataURL({ pixelRatio: 1 });
      $.ajax({
        url: "saveinsitu.php",
        type: "post",
        data: {"data":dataURLInsitu, "insitufilename":'<?php echo $insitufilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
        success: function (response) {
          iscomplete = 1;
          console.log('1. ' +response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        },
        async: false
      });
      console.log('2. usercomposits/<?php echo $compositfilename; ?>');
      console.log('3. ' + iscomplete);
      if(iscomplete == 1) {
        document.getElementById('step6form').submit();
      }
    },2000)

}
</script>
