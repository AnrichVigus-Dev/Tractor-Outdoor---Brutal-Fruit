<?php
session_start();

// Look whether the page comes from the previous action - if not go to step 1
if ((!isset($_POST['formsubmitted'])) && ($_POST['formsubmitted'] <> "true")) {
  header("Location: step1.php");
} else {

include_once('connections/tractordbcon.php')  ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/konva@7.0.6/konva.min.js"></script>

<?php

//Query USER table to retreive latest updated record and update USER table

// Posted Fields

$posted_billboardmessage = $_POST['billboardmessage'];
$posted_fromname = $_POST['fromname'];
$posted_toname = $_POST['toname'];
$uniquesession = $_SESSION['bf2021uniquesession'];
$idcampaign = $_SESSION['idcampaign'];

$sqlupdate = "UPDATE tractorusers SET
billboardmessage = '$posted_billboardmessage',
fromname='$posted_fromname',
toname='$posted_toname'
WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";

if ($link->query($sqlupdate) === TRUE) {
  //echo "<p>Record updated successfully</p>";
} else {
  echo "Error updating record: " . $link->error;
}

    // Query Campaign based on id
      $sqluser = "SELECT * FROM tractorusers INNER JOIN tractorcampaigns ON tractorusers.idcampaign = tractorcampaigns.id WHERE uniquesession = '$uniquesession' ORDER BY tractorusers.id DESC LIMIT 1";
      echo $sqluser;
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
    echo $uniquesession;


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


/*
    // Query User Message to display as canvas text
    $sqlcopylines = "SELECT * FROM campaign_copylines WHERE idcopyline = '$idcopyline' ";
    if($resultcopylines = mysqli_query($link, $sqlcopylines)){
        if(mysqli_num_rows($resultcopylines) > 0){
        while($rowcopylines = mysqli_fetch_array($resultcopylines)){

        $canvastext = $rowcopylines['copyline'];

       }
            // Free result set
            mysqli_free_result($resultcopylines);
        }
    }
*/



    //$canvastext = '#'.$name;

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
            $billboard_insitu_png = $rowbillboard['billboard_insitu_png']; //images/billboards
            $billboard_template = $rowbillboard['billboard_template']; //images/billboards/templates
            $bezel_filename = $rowbillboard['bezel_filename'];
            $billboardcode1  = $rowbillboard['billboardcode1'];
         }
            // Free result set
            mysqli_free_result($resultbillboard);
        }
    }
    //create composite
    $compositfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-composit.png';
    //create insitufilename
    $insitufilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-insitu.png';
    //create displayfilename
    $displayfilename = $billboardcode1 . '-brutal-'. preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-billboard.png';

    $billboard_insitu_png_size = getimagesize('images/billboards/insitu/'. $billboard_insitu_png );
    $canvasPreview_width = $billboard_insitu_png_size[0];
    $canvasPreview_height = $billboard_insitu_png_size[1];

echo 'billboard_template :: '.$billboard_template;


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

   // $bgy = 60; // just enght for top rotator to show
   // $bgx = $canvaswidth/2 - $forcewidth/2;


//question ::: get from DB ???
    /*
    $logosize = getimagesize('campaignimages/'.$idcampaign.'/'.$billboard_logo );
    $logowidth = $logosize[0];
    $logoheight = $logosize[1];
    if( ($logowidth >= $canvaswidth) || ($logoheight >= $canvasheight) ){
        $oldlogowidth = $logowidth;
        $logowidth = $canvaswidth * (70/100);
        $forcelogofactor = $oldlogowidth / $logowidth;
        $logoheight = $logoheight / $forcelogofactor;
    }
    $stickersize = getimagesize('campaignimages/'.$idcampaign.'/'.$billboard_sticker1 );
    $sticker1width = $stickersize[0];
    $sticker1height = $stickersize[1];
    if( ($sticker1width >= $canvaswidth) || ($sticker1height >= $canvasheight) ){
        $oldsticker1width = $sticker1width;
        $sticker1width = $canvaswidth * (70/100);
        $forcestickerfactor = $oldsticker1width / $sticker1width;
        $sticker1height = $sticker1height / $forcestickerfactor;
    }
    */
    $textwidth = 300;
    if( ($textwidth >= $canvaswidth)  ){
        $oldtextwidth = $textwidth;
        $textwidth = $canvaswidth * (70/100);
    }


    //$sticker1width = 300;
    //$sticker1height = 170;
    //$bgcolor = '#440000';
    $bgmaxwidth = 30000;//$bgwidth * 1.5; //bg max width 1.5 times image
    $bgminwidth = 50;//$bgwidth / 4; //bg min width quarter image

    $img1maxwidth = $canvaswidth*2;
    $img1minwidth = 50;
    $txmaxwidth = $canvaswidth*2;
    $txminwidth = 50;

  //end: calculations for bgimage (contain and then center)

        // Free result set
        mysqli_free_result($resultuser);
    }
}


?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
<title>TRACTOR OUTDOOR</title>

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
  font-family: 'CocogoosePro Bold';
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
  	  <div class="logo-centre-small">
  		  <img src="" alt="logo" width="158" height="auto">
      </div>

  		<div class="back-btn-container">
          <a href="step4_back.php?action=back">

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


  <h1 class="steps-heading">PREVIEW BILLBOARD:</h1>

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

<div id="step4">
    &nbsp;<br/>

    <div id="canvaswrap">
      <div id="container"></div>
    </div>

    <div class="sections"  id="submitpreview"  style="display:block">
      <input type="button" id="preview" value="GENERATE"   class="main-cta" style="-webkit-appearance: none;" />
    </div>
</div>

<div id="step5" style="display: none" >
  <form method="post" id="step4form" name="step4form" action="step5.php">
    <input type="hidden" name="formsubmitted" id="textfield" value="true">
    <input type="hidden" name="uniquesession" id="uniquesession" value="<?php  echo $uniquesession  ?>">
    <input type="hidden" name="iduser" id="iduser" value="<?php  echo $iduser  ?>">
    <input type="submit" value="NEXT STEP" id="btnsubmit" style="display: none" />
  </form>

  <div id="canvaspreviewwrap">
    <div id="containerPreview"></div>
  </div>

<div class="preview-back-btn-container">
  <div class="preview-back-btn">
    <input type="button" id="return" value="<<" style="-webkit-appearance: none;" />
  </div>

  <div class="preview-btn">
    <input type="submit" id="submit" value="Preview" style="-webkit-appearance: none;"  />
  </div>

</div>
</div>




</div>



  <div class="footer-container">
    <p class="footer-text">Powered by TRACTOR OUTDOOR</p>
</div>

</section>

</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>
    <script>



      //if page relaoded from reset button
      hashname = window.location.hash.replace('#', '');
      elem = $('#' + hashname);
      if(hashname.length > 1) {
          if(hashname == 'reset') {
            $('html, body').animate({ scrollTop: $("#buttonsDiv").offset().top }, 200);
          }
      }

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
        console.log(phonewidth);
        $('#container').css('transform', 'scale( ' + phonewidth + ' )');
        $('#container').css('transform-origin', '0% 0%');
      }
      if( height >= screenHeight) { //for very port canvases
        phoneheight = screenHeight / (height);
        phoneheight = phoneheight * (70/100);
        console.log('phoneheight ::: ' + phoneheight);
        $('#container').css('transform', 'scale( ' + phoneheight + ' )');
        $('#container').css('transform-origin', '0% 0%');
      }


      //resize the canvas container so page isnt distorted after scale
      $(document).ready(function() {
        var canvasheight = $("#container")[0].getBoundingClientRect().height;
        $("#canvaswrap").css("max-height",canvasheight);
        var canvaswidth = $("#container")[0].getBoundingClientRect().width;
        $("#canvaswrap").css("max-width",canvaswidth);
      });




//billboard_template

      var stage = new Konva.Stage({
        container: 'container',
        width: width,
        height: height,
      });

      var layer = new Konva.Layer();
      layer.draw();
      stage.add(layer);

/*
      //background colour
      //-------------------------------------------
      var bgcolour = new Konva.Rect({
        x: 0,
        y: 0,
        width: width,
        height: height,
        fill: '<?php echo $bgcolor; ?>',
        name: 'bgcol',
        id: 'bgcol',
      });
      layer.add(bgcolour);
      bgcolour.moveToBottom();

      var MAX_WIDTH = <?php echo $canvaswidth; ?>;
      var MIN_WIDTH = 200;
      layer.draw();

      */



















var layerbgphoto = new Konva.Layer();
stage.add(layerbgphoto);
const bgPhotoHolder = new Konva.Image({
    x: 30,
    y: 30,
    keepRatio:true,
    width: <?php echo $forcewidth; ?>,
    height: <?php echo $forceheight; ?>,
    draggable: false,
    name: 'bg',
    id: 'bg',
});
const bgPhotoObj = new Image();
bgPhotoObj.onload = function() {
  bgPhotoHolder.image(bgPhotoObj);
};
bgPhotoObj.src = 'images/billboards/templates/<?php echo $bezel_filename;?>';
const groupWithBgPhoto = new Konva.Group({
  draggable:true,
  fill:"#29A9E5" ,
});
const bgBgPhoto = new Konva.Rect({
  fill: '#29A9E5',
  name: 'backgroundPhoto',
  id: 'backgroundPhoto',
  x: (stage.width() / 2) - ((bgPhotoHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((bgPhotoHolder.height() + 32) / 2),
  width: bgPhotoHolder.width() + 32,
  height: bgPhotoHolder.height() + 32,
  opacity:1,
 // draggable:false,
  position: bgPhotoHolder.position(),
  offsetX: (bgPhotoHolder.width() + 32) / 2,
  offsetY: (bgPhotoHolder.height() + 32) / 2,
});
groupWithBgPhoto.add(bgPhotoHolder);
const trbg = new Konva.Transformer({
  borderStroke:"#29A9E5",
  borderDash: [4, 3],
  anchorFill:"#29A9E5",
  anchorStroke:"#29A9E5",
  anchorCornerRadius: 15,
  anchorStrokeWidth: 30,
  anchorSize:16,
  borderStrokeWidth: 3,
  padding:0,
  keepRatio:true,
  opacity:0.6,
  enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
  rotationSnaps:[0, 90, 180, 270],
  rotateAnchorOffset: 0,
});
trbg.attachTo(bgPhotoHolder);
layerbgphoto.add(groupWithBgPhoto);
layerbgphoto.draw();
/*  end: background photo one  */

var bgshape = new Konva.Shape();
// get fill pattern image
var fillPatternImage = bgshape.fillPatternImage();

/*

var poly0 = new Konva.Line({
    name: 'DrawLine',
    points: [5, 70, 140, 23, 250, 60, 300, 20],
    fill: startFill,
    stroke: 'red',
    strokeWidth: 2,
    lineJoin: 'round',
    lineCap: 'round',        
    closed : true
});
//mouse over event
poly0.on('mouseover', function() {
    if (this.fill() == startFill) {
        this.fill(mouseoverFill);
        layer.draw();
    }
});
poly0.on('mouseout', function() {
    if (this.fill() == mouseoverFill) {
        this.fill(startFill);
        layer.draw();
    }
});
poly0.on('mousedown', function() {
    this.fill(newFill);
    layer.draw();
});

var poly1 = new Konva.Line({
    name: 'Poly1',
    points: [5, 70, 140, 23, 250, 60, 300, 20],
    stroke: 'blue',
    strokeWidth: 10,
    lineCap: 'round',
    lineJoin: 'round'    
})
// mouse over events
poly1.on('mouseover', function() {
    if (this.fill() == startFill) {
        this.fill(mouseoverFill);
        layer.draw();
    }
});
poly1.on('mouseout', function() {
    if (this.fill() == mouseoverFill) {
        this.fill(startFill);
        layer.draw();
    }
});
poly1.on('mousedown', function() {
    this.fill(newFill);
    layer.draw();
});

// add everything to the layer
layer.add(poly0);
layer.add(poly1);    

// add the layer to the stage
stage.add(layer);

// set fill pattern image
var imageObj = new Image();
imageObj.onload = function() {
  bgshape.fillPatternImage(imageObj);
};
imageObj.src = 'images/billboards/templates/<?php echo $bezel_filename;?>';

    layerPreview.add(imageObj);
    // add the layer to the stage
    stagePreview.add(layerPreview);

/*
var layer = new Konva.Layer();

var imageObj = new Image();
imageObj.src = 'images/billboards/templates/<?php echo $bezel_filename;?>';
imageObj.onload = function() {
    var map = new Konva.Image({
        x: 0,
        y: 0,
        image: imageObj,
        width: width,
        height: height
    });
    // add the image to the layer
    layer.add(imageObj);
    // add the layer to the stage
    stage.add(layer);
};
*/


//Billboardmessage
var layertext = new Konva.Layer();
stage.add(layertext);
const textHolder = new Konva.Text({
    x: 30,
    y: 30,
    text: "<?php echo $billboardmessage;?>",
    fontSize: 60,
    fontFamily: 'CocogoosePro',
    fontWeight: 'Normal',
    fill: '#black',
    keepRatio:false,
    width: <?php echo $textwidth;?>,
    //height: 100,
    padding: 10,
    align: 'center',
    shadowColor: 'white',
    shadowBlur: 3,
    shadowOffsetX: 0,
    shadowOffsetY: 0,
    shadowOpacity: 1,
    //draggable: true, //????
    name: 'nameTx',
    id: 'nameTx',
});
const groupWithText = new Konva.Group({
  draggable:false,
  fill:"#A929E5",
});
const bgText = new Konva.Rect({
  fill: '#A9E592',
  name: 'backgroundText',
  x: (stage.width() / 2) - ((textHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((textHolder.height() + 32) / 2),
  width: textHolder.width() + 32,
  height: textHolder.height() + 32,
  opacity:1,
  position: textHolder.position(),
  offsetX: (textHolder.width() + 32) / 2,
  offsetY: (textHolder.height() + 32) / 2
});

setTimeout( function(){
  groupWithText.add(textHolder);
  //activate Text
  layertext.add(groupWithText);
  layertext.draw();
  layertext.draw();
  layertext.moveToTop();
  bgcolour.moveToBottom();
},5000)



//fromname
var layertextFrom = new Konva.Layer();
stage.add(layertextFrom);
const textHolderFrom = new Konva.Text({
    x: 30,
    y: 30,
    text: "<?php echo $fromname;?>",
    fontSize: 20,
    fontFamily: 'CocogoosePro',
    fontWeight: 'Normal',
    fill: '#black',
    keepRatio:false,
    width: <?php echo $textwidth;?>,
    //height: 100,
    padding: 10,
    align: 'center',
    shadowColor: 'white',
    shadowBlur: 3,
    shadowOffsetX: 0,
    shadowOffsetY: 0,
    shadowOpacity: 1,
    //draggable: true, //????
    name: 'nameTx',
    id: 'nameTx',
});
const groupWithTextFrom = new Konva.Group({
  draggable:false,
  fill:"#A929E5",
});
const bgTextFrom = new Konva.Rect({
  fill: '#A9E592', 
  name: 'backgroundText',
  x: (stage.width() / 2) - ((textHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((textHolder.height() + 32) / 2),
  width: textHolder.width() + 32,
  height: textHolder.height() + 32,
  opacity:1,
  position: textHolder.position(),
  offsetX: (textHolder.width() + 32) / 2,
  offsetY: (textHolder.height() + 32) / 2
});

setTimeout( function(){
  groupWithTextFrom.add(textHolderFrom);
  //activate Text
  layertextFrom.add(groupWithTextFrom);
  layertextFrom.draw();
  layertextFrom.draw();
  layertextFrom.moveToTop();
  bgcolour.moveToBottom();
},5000)

//fromname
var layertextTo = new Konva.Layer();
stage.add(layertextTo);
const textHolderTo = new Konva.Text({
    x: 30,
    y: 30,
    text: "<?php echo $toname;?>",
    fontSize: 20,
    fontFamily: 'CocogoosePro',
    fontWeight: 'Normal',
    fill: '#black',
    keepRatio:false,
    width: <?php echo $textwidth;?>,
    //height: 100,
    padding: 10,
    align: 'center',
    shadowColor: 'white',
    shadowBlur: 3,
    shadowOffsetX: 0,
    shadowOffsetY: 0,
    shadowOpacity: 1,
    //draggable: true, //????
    name: 'nameTx',
    id: 'nameTx',
});
const groupWithTextTo = new Konva.Group({
  draggable:false,
  fill:"#A929E5",
});
const bgTextTo = new Konva.Rect({
  fill: '#A9E592',
  name: 'backgroundText',
  x: (stage.width() / 2) - ((textHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((textHolder.height() + 32) / 2),
  width: textHolder.width() + 32,
  height: textHolder.height() + 32,
  opacity:1,
  position: textHolder.position(),
  offsetX: (textHolder.width() + 32) / 2,
  offsetY: (textHolder.height() + 32) / 2
});

setTimeout( function(){
  groupWithTextTo.add(textHolderTo);
  //activate Text
  layertextTo.add(groupWithTextTo);
  layertextTo.draw();
  layertextTo.draw();
  layertextTo.moveToTop();
  bgcolour.moveToBottom();
},5000)


/*





*/

/* edit button 
      document.getElementById('return').addEventListener(
        'click',
        function () {
            //$("#step4").fadeIn(600);
            $("#step5").fadeOut(600);
            $("#step4").css('opacity','1');
            layerPreview.destroyChildren();
            layerPreview.draw();
            $("#step5").css('display','none');
            $("#step4").css('display','block');
        },
        false
      );





      document.getElementById('preview').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          if( bgcol != undefined){    bgcol.draggable(false);   }
          var bgshape = stage.find('#bg')[0];
          if( bgshape != undefined){    bgshape.draggable(false);   }
          var logoshape = stage.find('#logo')[0];
          if( logoshape != undefined){    logoshape.draggable(false); logoshape.moveToTop();   }
          var s1shape = stage.find('#sticker1')[0];
          if( s1shape != undefined){    s1shape.draggable(false); s1shape.moveToTop();   }
          var txshape = stage.find('#nameTx')[0];
          if( txshape != undefined){    txshape.draggable(false); txshape.moveToTop();   }
          trlogo.detach();
          trimg1.detach();
          trtx.detach();
          trbg.detach();
          layer.draw();
          layerbgphoto.draw();
          layerimageone.draw();
          layerlogo.draw();
          layertext.draw();

          //change content of heading
          $(".steps-heading").text('PREVIEW YOUR IMAGE');
          $(".edit-img-instructions").css('display','none');

          //save image:
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
            }
          });


                ///trying 2nd canvas on page to merge step 4 and 5
                //unsuccessfully
                //get saved image
                console.log('usercomposits/<?php echo $compositfilename; ?>');

                //$("#step4").css('opacity','0.5');
                $("#step4").css('display','none');
                $("#step5").css('display','block');
                $("#step5").fadeIn(100);

              $("#compositimage").attr('src', 'usercomposits/<?php echo $compositfilename; ?>?<?php echo date("His"); ?>');
              //$("#compositimage").css('display', 'block');

              //resize the canvas container so page isnt distorted after scale
              var canvaspreviewheight = $("#containerPreview")[0].getBoundingClientRect().height;
              $("#canvaspreviewwrap").css("max-height",canvaspreviewheight);
              var canvaspreviewwidth = $("#containerPreview")[0].getBoundingClientRect().width;
              $("#canvaspreviewwrap").css("max-width",canvaspreviewwidth);

                //background colour
                //-------------------------------------------
                var bgcolourPreview = new Konva.Rect({
                  x: 0,
                  y: 0,
                  width: widthPreview,
                  height: heightPreview,
                  fill: '<?php echo $bgcolor; ?>',
                  name: 'bgcol',
                  id: 'bgcol'
                });
                layerPreview.add(bgcolourPreview);
                bgcolourPreview.moveToBottom();
                layerPreview.draw();

                /*  start: loading copy  
                var layerloadingtext = new Konva.Layer();
                stagePreview.add(layerloadingtext);
                const textGenerateHolder = new Konva.Text({
                    x: 30,
                    y: 10,
                    text: "Generating:",
                    fontSize: 35,
                    fontFamily: 'Calibri',
                    fontWeight: 'Bold',
                    fill: 'pink',
                    width: 300,
                    //height: 100,
                    padding: 10,
                    align: 'center',
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: 1,
                    shadowOffsetY: 1,
                    shadowOpacity: 1,
                    draggable: true,
                    name: 'loadingGenTx',
                    id: 'loadingGenTx',
                });
                const textloadingHolder = new Konva.Text({
                    x: 30,
                    y: 40,
                    text: "8",
                    fontSize: 180,
                    fontFamily: 'Calibri',
                    fontWeight: 'Bold',
                    fill: 'pink',
                    width: 300,
                    //height: 100,
                    padding: 10,
                    align: 'center',
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: 1,
                    shadowOffsetY: 1,
                    shadowOpacity: 1,
                    draggable: true,
                    name: 'loadingTx',
                    id: 'loadingTx',
                });
                  layerPreview.add(textGenerateHolder);
                  layerPreview.add(textloadingHolder);
                  layerPreview.draw();
                  //force update by destroying is exists
                  var compimgFind = stage.find('#compimg')[0];
                  if( compimgFind != undefined){    compimgFind.destroy();   }

                  //set this delay according to server speed
                  var theDelay = 8000;
                  //setTimeout( function(){   textloadingHolder.text("9");  layerPreview.draw();  }, 1000);
                  //setTimeout( function(){   textloadingHolder.text("8");  layerPreview.draw();  }, 2000);
                  setTimeout( function(){   textloadingHolder.text("7");  layerPreview.draw();  }, 1000);
                  setTimeout( function(){   textloadingHolder.text("6");  layerPreview.draw();  }, 2000);
                  setTimeout( function(){   textloadingHolder.text("5");  layerPreview.draw();  }, 3000);
                  setTimeout( function(){   textloadingHolder.text("4");  layerPreview.draw();  }, 4000);
                  setTimeout( function(){   textloadingHolder.text("3");  layerPreview.draw();  }, 5000);
                  setTimeout( function(){   textloadingHolder.text("2");  layerPreview.draw();  }, 6000);
                  setTimeout( function(){   textloadingHolder.text("1");  layerPreview.draw();  }, 7000);
                  setTimeout( function(){
                    textloadingHolder.text("0");
                    layerPreview.draw();
                    $("#submitstep4").css('display', 'block');
                    $("#save").css('display', 'block');
                    textGenerateHolder.text("");
                    textloadingHolder.text("");
                    layerPreview.draw();
                    }, 8000);



                //loader image
                //-------------------------------------------
                /*
                var loaderimage = new Image();
                loaderimage.onload = function () {
                  var loaderImage = new Konva.Image({
                    x: 0,
                    y: 0,
                    width: widthPreview ,
                    //height: height,
                    image: loaderimage,
                    name: 'loaderimage',
                    id: 'loaderimage',
                  });
                  layerPreview.add(loaderImage);
                  //layerPreview.draw();
                  loaderImage.moveToTop();
                  //bgcolour.moveToBottom();
                };
                loaderimage.src = 'images/loading.gif';
                */
/*
                setTimeout( function(){
                    //template image
                    //-------------------------------------------
                    var templateimage = new Image();
                    templateimage.onload = function () {
                      var templateImage = new Konva.Image({
                        x: 0,
                        y: 0,
                        width: widthPreview ,
                        height: heightPreview,
                        image: templateimage,
                        name: 'templateimage',
                        id: 'templateimage',
                      });
                      layerPreview.add(templateImage);
                      layerPreview.draw();
                      templateImage.moveToTop();
                    };
                    templateimage.src = 'images/billboards/templates/<?php echo $bezel_filename;?>';

                    //composite image
                    //-------------------------------------------
                    var compimage = new Image();
                    compimage.onload = function () {
                      var compImage = new Konva.Image({
                        x: <?php echo $canvasPreview_pos_x; ?>,
                        y: <?php echo $canvasPreview_pos_y; ?>,
                        width: <?php echo $canvaswidth; ?> ,
                        height: <?php echo $canvasheight; ?>,
                        image: compimage,
                        name: 'compimg',
                        id: 'compimg',
                      });
                      layerPreview.add(compImage);
                      layerPreview.draw();
                      compImage.moveToTop();
                      //templateImage.moveToBottom();
                      //bgcolour.moveToBottom();
                    };
                    //compimage.src = 'images/loading.gif';
                    thisrand = Math.random();
                    //console.log('usercomposits/<?php echo $compositfilename;?>?'+thisrand+'<?php echo date("His") ?>');
                    compimage.src = 'usercomposits/<?php echo $compositfilename;?>?'+thisrand+'<?php echo date("His") ?>';
                    //$("#submitstep4").css('display', 'block');
                    //$("#submit").css('display', 'block');

                }, theDelay)







        },
        false
      );


      //onload image bg transformer active, no stickers
      window.addEventListener('DOMContentLoaded',
        function () {
          setTimeout( function(){
            //activate bg Photo
            layerbgphoto.add(groupWithBgPhoto);
            layerbgphoto.add(trbg);
            trbg.attachTo(bgPhotoHolder);
            layerbgphoto.draw();
            groupWithBgPhoto.draggable(true);
            layerbgphoto.draw();
            bgcolour.moveToBottom();
          }, 2000);
        },
        false
      );



      document.getElementById('reload').addEventListener(
        'click',
        function () {
          //remove hashes if any

          var url = window.location.href; //.hash.replace('#', '');
          var onlyurl = url.split('#')[0];
          var resetvar = url.split('#')[1];
          if(resetvar == 'reset'){
            location.reload();
          }else{
            window.location.href += "#reset";
            location.reload();
          }
        },
        false
      );


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
      /*
      old save button
      document.getElementById('save').addEventListener(
        'click',
        function () {
              trlogo.detach();
              trimg1.detach();
              trbg.detach();
              trtx.detach();
              layer.draw();

              var dataURL = stage.toDataURL({ pixelRatio: 1 });
              //download image for troubleshooting
              downloadURI(dataURL, '<?php echo $compositfilename; ?>');

              //$("#compositimage").attr('src', 'images/loading.gif');
              //$("#compositimage").css('display', 'block');
              //$("#submitstep4").css('display', 'none');
              //$("#save").css('display', 'none');
            $.ajax({
              url: "savefile.php",
              type: "post",
              data: {"data":dataURL, "compositfilename":'<?php echo $compositfilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
              success: function (response) {
                //allert response for troubleshooting
                //alert(response);
                console.log(response);
                document.getElementById('step4form').submit();

              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
              }
            });
        },
        false
      );
      */

      /*
      // merge steps 4 and 5
      //second save button
      document.getElementById('submit').addEventListener(
        'click',
        function () {
          var dataURL = stagePreview.toDataURL({ pixelRatio: 1 });
          //download image for troubleshooting
          //downloadURI(dataURL, '<?php echo $displayfilename; ?>');
          $.ajax({
            url: "savebillboard.php",
            type: "post",
            data: {"data":dataURL, "displayfilename":'<?php echo $displayfilename; ?>', "idbillboard":'<?php  echo $idbillboard  ?>', "iduser":'<?php  echo $iduser  ?>', "idcampaign":'<?php  echo $idcampaign  ?>', "uniquesession":'<?php  echo $uniquesession  ?>' } ,
            success: function (response) {
              //allert response for troubleshooting
              //alert(response);
              console.log(response);
              document.getElementById('step4form').submit();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
          });
        },
        false
      );


//reset buttons


        /*  start : reset bgphoto 
      document.getElementById('reset-bg').addEventListener(
        'click',
        function () {
          var isbg = stage.find('#bg')[0];
          if( isbg != undefined){
            //groupWithBgPhoto.remove();
            bgPhotoHolder.rotation(0);
            bgPhotoHolder.scaleX(1);
            bgPhotoHolder.scaleY(1);
            bgPhotoHolder.x(1);
            bgPhotoHolder.y(1);
            trbg.rotation(0);
            groupWithBgPhoto.rotation(0);
            groupWithBgPhoto.x(30);
            groupWithBgPhoto.y(30);
            groupWithBgPhoto.width(<?php echo $forcewidth; ?>);
            groupWithBgPhoto.height(<?php echo $forceheight; ?>);
            //groupWithBgPhoto.show();
            //get icons back in postion
            trbg.update();
            for (var button in buttonsbg) {
              var selector = button.replace('_', '-');
              var shape = trbg.findOne('.' + selector);
              var icon = trbg.findOne('.' + selector + '-icon');
              icon.position(shape.position());
              icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
              layerbgphoto.batchDraw();
            }
            groupWithBgPhoto.draw();
            layerbgphoto.draw();
            trbg.update();
            layerbgphoto.batchDraw();
            groupWithBgPhoto.add(trbg);
          }
        })
        /*  end : reset bgphoto */

        /*  start : reset logo 
      document.getElementById('reset-logo').addEventListener(
        'click',
        function () {
          var islogo = stage.find('#logo')[0];
          if( islogo != undefined){
            //groupWithLogo.remove();
            logoHolder.rotation(0);
            logoHolder.scaleX(1);
            logoHolder.scaleY(1);
            logoHolder.x(1);
            logoHolder.y(1);
            trlogo.rotation(0);
            groupWithLogo.rotation(0);
            groupWithLogo.x(30);
            groupWithLogo.y(30);
            groupWithLogo.width(<?php echo $logowidth; ?>);
            groupWithLogo.height(<?php echo $logoheight; ?>);
            groupWithLogo.draw();
            layerlogo.draw();
            trlogo.update();
            layerlogo.batchDraw();
            groupWithLogo.add(trbg);
          }
        })
        /*  end : reset logo */

        /*  start : reset image one 
      document.getElementById('reset-sticker').addEventListener(
        'click',
        function () {
          var issticker = stage.find('#sticker1')[0];
          if( issticker != undefined){
            firstImageHolder.rotation(0);
            firstImageHolder.scaleX(1);
            firstImageHolder.scaleY(1);
            firstImageHolder.x(1);
            firstImageHolder.y(1);
            trimg1.rotation(0);
            groupWithImageOne.rotation(0);
            groupWithImageOne.x(30);
            groupWithImageOne.y(30);
            groupWithImageOne.width(<?php echo $forcewidth; ?>);
            groupWithImageOne.height(<?php echo $forceheight; ?>);
            //get icons back in postion
            trbg.update();
            for (var button in buttonsbg) {
              var selector = button.replace('_', '-');
              var shape = trimg1.findOne('.' + selector);
              var icon = trimg1.findOne('.' + selector + '-icon');
              icon.position(shape.position());
              icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
              layerimageone.batchDraw();
            }
            groupWithImageOne.draw();
            layerimageone.draw();
            trimg1.update();
            layerimageone.batchDraw();
            groupWithImageOne.add(trimg1);
          }
        })
        /*  end : reset image 1  */


        /*  start : reset text 
      document.getElementById('reset-tx').addEventListener(
        'click',
        function () {
          console.log('reset' + textHolder.rotation() );
          var isnameTx = stage.find('#nameTx')[0];
          if( isnameTx != undefined){
            textHolder.rotation(0);
            textHolder.scaleX(1);
            textHolder.scaleY(1);
            textHolder.x(1);
            textHolder.y(1);
            textHolder.width(<?php echo '300'; ?>);
            textHolder.height(<?php echo '200'; ?>);
            textHolder.rotation(0);
            trtx.rotation(0);
            groupWithText.rotation(0);
            groupWithText.x(30);
            groupWithText.y(30);
            groupWithText.width(<?php echo '300'; ?>);
            groupWithText.height(<?php echo '200'; ?>);
            //get icons back in postion
            trtx.update();
            for (var button in buttonsbg) {
              var selector = button.replace('_', '-');
              var shape = trtx.findOne('.' + selector);
              var icon = trtx.findOne('.' + selector + '-icon');
              icon.position(shape.position());
              icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
              layertext.batchDraw();
            }
            groupWithText.draw();
            layertext.draw();
            trtx.update();
            layertext.batchDraw();
            groupWithText.add(trtx);
          }
        })
        /*  end : reset text  */

//end: reset buttons







//-------------------------------------
/*  start: all background photo one  
var layerbgphoto = new Konva.Layer();
stage.add(layerbgphoto);
const bgPhotoHolder = new Konva.Image({
    x: 30,
    y: 30,
    keepRatio:true,
    width: <?php echo $forcewidth; ?>,
    height: <?php echo $forceheight; ?>,
    draggable: false,
    name: 'bg',
    id: 'bg',
});
const bgPhotoObj = new Image();
bgPhotoObj.onload = function() {
  bgPhotoHolder.image(bgPhotoObj);
};
bgPhotoObj.src = 'useruploads/<?php echo $userfilename;?>';
const groupWithBgPhoto = new Konva.Group({
  draggable:true,
  fill:"#29A9E5" ,
});
const bgBgPhoto = new Konva.Rect({
  fill: '#29A9E5',
  name: 'backgroundPhoto',
  id: 'backgroundPhoto',
  x: (stage.width() / 2) - ((bgPhotoHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((bgPhotoHolder.height() + 32) / 2),
  width: bgPhotoHolder.width() + 32,
  height: bgPhotoHolder.height() + 32,
  opacity:1,
 // draggable:false,
  position: bgPhotoHolder.position(),
  offsetX: (bgPhotoHolder.width() + 32) / 2,
  offsetY: (bgPhotoHolder.height() + 32) / 2,
});
groupWithBgPhoto.add(bgPhotoHolder);
const trbg = new Konva.Transformer({
  boundBoxFunc: function (oldBoundBox, newBoundBox) {
    if ( (newBoundBox.rotation >= 0.5) || (newBoundBox.rotation <= -0.5)  ){   return oldBoundBox;}
    if (Math.abs(newBoundBox.width) < <?php echo $bgminwidth;?>) {  return oldBoundBox;    }
    if (Math.abs(newBoundBox.width) > <?php echo $bgmaxwidth;?>) {  return oldBoundBox; }
    return newBoundBox;
  },
  borderStroke:"#29A9E5",
  borderDash: [4, 3],
  anchorFill:"#29A9E5",
  anchorStroke:"#29A9E5",
  anchorCornerRadius: 15,
  anchorStrokeWidth: 30,
  anchorSize:16,
  borderStrokeWidth: 3,
  padding:0,
  keepRatio:true,
  opacity:0.6,
  enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
  rotationSnaps:[0, 90, 180, 270],
  rotateAnchorOffset: 0,
});
trbg.attachTo(bgPhotoHolder);
layerbgphoto.add(groupWithBgPhoto);
layerbgphoto.draw();
/*  end: background photo one  */




//----------------------------------------
/*  start: logo  
var layerlogo = new Konva.Layer();
stage.add(layerlogo);
const logoHolder = new Konva.Image({
    x: 30,
    y: 30,
    keepRatio:true,
    width: <?php echo $logowidth; ?>,
    height: <?php echo $logoheight; ?>,
    draggable: true,
    name: 'logo',
    id: 'logo',
});
const logoObj = new Image();
logoObj.onload = function() {
  logoHolder.image(logoObj);
};
logoObj.src = 'campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_logo;?>';
const groupWithLogo = new Konva.Group({
  draggable:true,
  fill:"#A929E5"
});
const bgLogo = new Konva.Rect({
  fill: '#A9E529',
  name: 'backgroundLogo',
  x: (stage.width() / 2) - ((logoHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((logoHolder.height() + 32) / 2),
  width: logoHolder.width() + 32,
  height: logoHolder.height() + 32,
  opacity:1,
  position: logoHolder.position(),
  offsetX: (logoHolder.width() + 32) / 2,
  offsetY: (logoHolder.height() + 32) / 2
});
groupWithLogo.add(logoHolder);
const trlogo = new Konva.Transformer({
  boundBoxFunc: function (oldBoundBox, newBoundBox) {
    if ( (newBoundBox.rotation >= 0.5) || (newBoundBox.rotation <= -0.5)  ){   return oldBoundBox;}
  },
  rotateEnabled: false,
  borderStroke:"#A9E529",
  borderDash: [4, 3],
  borderStrokeWidth: 3,
  padding:0,
  keepRatio:true,
  opacity:0.6,
  //enabledAnchors: [''],
  anchorFill:"#A9E529"
});
trlogo.attachTo(logoHolder);
//layerlogo.add(groupWithLogo);
//layerlogo.draw();
/*  end: logo  */




//----------------------------------------
/*  start: all image one  
var layerimageone = new Konva.Layer();
stage.add(layerimageone);
const firstImageHolder = new Konva.Image({
    x: 30,
    y: 30,
    keepRatio:true,
    width: <?php echo $sticker1width; ?>,
    height: <?php echo $sticker1height; ?>,
    draggable: true,
    name: 'sticker1',
    id: 'sticker1',
});
const firstImageObj = new Image();
firstImageObj.onload = function() {
  firstImageHolder.image(firstImageObj);
};
firstImageObj.src = 'campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_sticker1;?>';
const groupWithImageOne = new Konva.Group({
  draggable:true,
  fill:"#A929E5"
});
const bgImageOne = new Konva.Rect({
  fill: '#29A9E5',
  name: 'backgroundImageOne',
  x: (stage.width() / 2) - ((firstImageHolder.width() + 32) / 2),
  y: (stage.height() / 2)  - ((firstImageHolder.height() + 32) / 2),
  width: firstImageHolder.width() + 32,
  height: firstImageHolder.height() + 32,
  opacity:1,
  position: firstImageHolder.position(),
  offsetX: (firstImageHolder.width() + 32) / 2,
  offsetY: (firstImageHolder.height() + 32) / 2
});
groupWithImageOne.add(firstImageHolder);
const trimg1 = new Konva.Transformer({
  boundBoxFunc: function (oldBoundBox, newBoundBox) {
    if ( (newBoundBox.rotation >= 0.5) || (newBoundBox.rotation <= -0.5)  ){   return oldBoundBox;}
    console.log(newBoundBox.width);
    if (Math.abs(newBoundBox.width) < <?php echo $img1minwidth;?>) {  return oldBoundBox;    }
    if (Math.abs(newBoundBox.width) > <?php echo $img1maxwidth;?>) {  return oldBoundBox; }
    return newBoundBox;
  },
  borderStroke:"#A929E5",
  borderDash: [4, 3],
  anchorFill:"#A929E5",
  anchorStroke:"#A929E5",
  anchorCornerRadius: 15,
  anchorStrokeWidth: 30,
  anchorSize:16,
  borderStrokeWidth: 3,
  padding:0,
  keepRatio:true,
  opacity:0.6,
  enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
  anchorFill:"#A929E5",
  rotationSnaps:[0, 90, 180, 270],
  rotateAnchorOffset: 0,
});
trimg1.attachTo(firstImageHolder);
//layerimageone.add(groupWithImageOne);
//layerimageone.draw();
/*  end: all image one  */




//----------------------------------------
/*  start: copy from db  */



/*  start: buttons for bg photo  
for (var button in buttonsbg) {
  var shape = buttonsbg[button].shape;
  var selector = button.replace('_', '-');
  var icon = new Konva.Path({
    fill:"black",
    data: buttonsbg[button].path,
    name: selector + '-icon'
  });
  icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
  trbg.add(icon);
}
//reposition icon on transform
bgPhotoHolder.on('transform', function(){
  trbg.update();
  for (var button in buttonsbg) {
    var selector = button.replace('_', '-');
    var shape = trbg.findOne('.' + selector);
    var icon = trbg.findOne('.' + selector + '-icon');
    icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
    layerbgphoto.batchDraw();
  }
});
groupWithBgPhoto.add(trbg);
/*  end: buttons for bgphoto  */



/*  start: buttons for image one  
for (var button in buttons) {
  var shape = buttons[button].shape;
  var selector = button.replace('_', '-');
  var icon = new Konva.Path({
    fill:"black",
    data: buttons[button].path,
    name: selector + '-icon'
  });
  icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
  trimg1.add(icon);
}
//reposition icon on transform
firstImageHolder.on('transform', function(){
  trimg1.update();
  for (var button in buttons) {
    var selector = button.replace('_', '-');
    var shape = trimg1.findOne('.' + selector);
    var icon = trimg1.findOne('.' + selector + '-icon');
    icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
    layerimageone.batchDraw();
  }
});
groupWithImageOne.add(trimg1);
/*  end: buttons for image one  */


/*  start: buttons for text  
for (var button in buttonstx) {
  var shape = buttonstx[button].shape;
  var selector = button.replace('_', '-');
  var icon = new Konva.Path({
    fill:"black",
    data: buttonstx[button].path,
    name: selector + '-icon'
  });
  icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
  trtx.add(icon);
}
//reposition icon on transform
textHolder.on('transform', function(){
  trtx.update();
  for (var button in buttonstx) {
    var selector = button.replace('_', '-');
    var shape = trtx.findOne('.' + selector);
    var icon = trtx.findOne('.' + selector + '-icon');
    icon.position(shape.position());
  icon.x(shape.x() - 10.25); icon.y(shape.y() - 10.25);
    layertext.batchDraw();
  }
});
groupWithText.add(trtx);
/*  end: buttons for image one  */

//alternative to resizing text???
/*
trtx.on('transform', function() {
     textHolder.setAttrs({
         width: textHolder.width() * textHolder.scaleX(),
         height: textHolder.height() * textHolder.scaleY(),
         scaleX: 1,
         scaleY: 1,
     });
})
*/




    </script>
