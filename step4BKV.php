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

$posted_idbillboard = $_POST['idbillboard'];
$uniquesession = $_SESSION['bf2021uniquesession'];

$sqlupdate = "UPDATE tractorusers SET
idbillboard='$posted_idbillboard'
WHERE uniquesession = '$uniquesession' ORDER BY id DESC LIMIT 1";

if ($link->query($sqlupdate) === TRUE) {
  echo "<p>Record updated successfully</p>";
} else {
  echo "Error updating record: " . $link->error;
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
			$userfilename = $rowuser['uploadfilename'];
			$idtemplate = $rowuser['idtemplate'];
      $compositfilename = $rowuser['compositfilename'];
			$insitufilename = $rowuser['insitufilename'];
			$displayfilename = $rowuser['displayfilename'];
			$uniquesession = $rowuser['uniquesession'];
      $billboard_logo       = $rowuser['billboard_logo'];
			$billboard_sticker1 = $rowuser['billboard_sticker1'];
		}
    //create insitufilename
    $compositfilename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $userfilename) . '-composit.png';
    $canvastext = '#'.$name;

    // Query Billboard based on id
    $sqlbillboard = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
    if($resultbillboard = mysqli_query($link, $sqlbillboard)){
        if(mysqli_num_rows($resultbillboard) > 0){
        while($rowbillboard = mysqli_fetch_array($resultbillboard)){
          $canvas_width = $rowbillboard['canvas_width'];
          $canvas_height  = $rowbillboard['canvas_height'];
         }
            // Free result set
            mysqli_free_result($resultbillboard);
        }
    }



  //calculations for bgimage (make 60 or 75% and centered horizontally)
    $bgsize = getimagesize('useruploads/'.$userfilename );
    $bgwidth = $bgsize[0];
    $bgheight = $bgsize[1];
    $canvaswidth = $canvas_width;
    $canvasheight = $canvas_height;
    if( $bgwidth >= $bgheight ){  //landscape
        $forcewidth = $canvaswidth  * (60/100);
        $forcefactor = $bgwidth / $forcewidth;
        $forceheight = $bgheight / $forcefactor;
    }else{  //portrait
        $forceheight = $canvasheight * (75/100);
        $forcefactor = $bgheight / $forceheight;
        $forcewidth = $bgwidth / $forcefactor;
    }
    $bgy = 60; // just enght for top rotator to show
    $bgx = $canvaswidth/2 - $forcewidth/2;


//question ::: get from DB
    //$logosize = getimagesize('campaignimages/'.$idcampaign.'/'.$billboard_sticker1 );
    //$logowidth = $logosize[0];
    //$logoheight = $logosize[1];
    //or
    //$logowidth = $rowuser['logo_width'];
    //$logoheight = $rowuser['logo_height'];
    //for now
    $logowidth = 300;
    $logoheight = 100;
    $sticker1width = 300;
    $sticker1height = 170;
    $bgcolor = '#440000';
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
<title>Step 4</title>

<style>


.bar-one {
  background-color: #1CBECD;
  height: 20px;
    width: 15%;
  margin-right: 4px;
  flex: 1 1 auto;
}

.bar-two{
  background-color: #1CBECD;
  height: 20px;
    width: 15%;
  margin-right: 4px;
  flex: 1 1 auto;
}


.bar-three{
  background-color: #1CBECD;
  height: 20px;
    width: 15%;
  margin-right: 4px;
  flex: 1 1 auto;
}

.bar-four{
  background-color: #1CBECD;
  height: 20px;
    width: 15%;
  margin-right: 4px;
  flex: 1 1 auto;
}

.bar-five{
  background-color: #1CBECD;
  height: 20px;
    width: 15%;
    margin-right: 4px;
  flex: 1 1 auto;
}

.bar-six{
  background-color: #F5B9D7;
  height: 20px;
    width: 15%;
  flex: 1 1 auto;
}

.step-three{
  margin-top: 70% !important;
  margin-bottom: 40px !important;
}

.maincontainer {
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


#buttonsDiv{
  max-width: 100%;
}

button{
  width: 15% !important;
  min-height: 40px;
  background-color:#444444;
    border: 4px solid #444444;
    color: white !important;
    margin-bottom: 20px;
    padding-top:40px
}



button#selectBg{
    background: #444444 url('useruploads/<?php echo $userfilename;?>') no-repeat  top center;
    background-size: contain;
}
button#selectObject1{
    background: #444444 url('campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_logo;?>') no-repeat  top center;
    background-size: contain;
}
button#selectObject2{
    background: #444444 url('campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_sticker1;?>') no-repeat  top center;
    background-size: contain;
}
button#selectText{
    background: #444444 ;
    background-size: contain;
}
button#preview{
}




</style>

</head>

<body id="canvaspage" >  <div class="progress-bar">
    <div class="bar-one"></div>
    <div class="bar-two"></div>
    <div class="bar-three"></div>
    <div class="bar-four"></div>
    <div class="bar-five"></div>
    <div class="bar-six"></div>
  </div>

<div class="center-no-img">

  <div class="logo-centre-small" >
    <img src="images/jive-logo.png" alt="logo" width="158" height="auto">


      <a href="step3.php">
      <img src="images/arrow.svg" alt="back-btn" width="30" height="auto" class="back-btn">
      </a>
  </div>

  <div>
<h1 class="campaign-heading-small">Jive X - Flash Comp</h1>
  </div>

  <h1 class="steps-heading">EDIT YOUR IMAGE:</h1>
  <br>
  <br>


<div class="maincontainer">
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
BILLBOARD TEMPLATE ID: <?php //echo $idbillboard;?>
<br>
COMPOSITE FILENAME: <font color="red">UNDEFINED</font>
<br>
BILLBOARD DISPLAY FILENAME: <font color="red">UNDEFINED</font>
<br>
IN SITU FILENAME: <font color="red">UNDEFINED</font>
<br>
UNIQUE SESSION: <?php //echo $uniquesession;?>
<br>
LOGO STICKER : <?php //echo $billboard_logo;?>
<br>
BILLBOARD STICKER 1: <?php //echo $billboard_sticker1;?>
&nbsp;<br/>
&nbsp;<br/>
-->



    <div id="buttonsDiv" >
    <button id="selectBg" >Step 1</button>
    <button id="selectObject1" >Step 2</button>
    <button id="selectObject2" >Step 3</button>
    <button id="selectText" >"<?php echo $canvastext; ?>"<br/>Step 4</button>
    <button id="preview" >Preview</button>
    <button id="save">Save </button>
    </div>
    <div id="container"></div>


    <script>



      var width = <?php echo $canvaswidth; ?>;
      var height = <?php echo $canvasheight; ?>;
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



      Konva.hitOnDragEnabled = true;


      var stage = new Konva.Stage({
        container: 'container',
        width: width,
        height: height,
      });

      var layer = new Konva.Layer();
      stage.add(layer);


      //background colour ( question :::: must be a var)
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


      //background image
      //-------------------------------------------
      var bgimage = new Image();
      bgimage.onload = function () {
        var backgroundImage = new Konva.Image({
          x: <?php echo $bgx; ?>,
          y: <?php echo $bgy; ?>,
          width: <?php echo $forcewidth; ?> , //window.innerWidth,
          height: <?php echo $forceheight; ?>, //window.innerHeight,
          image: bgimage,
          //draggable: true,
          name: 'bg',
          id: 'bg',
        });
        layer.add(backgroundImage);
        layer.draw();
        backgroundImage.moveToBottom();
        bgcolour.moveToBottom();
      };

      bgimage.src = 'useruploads/<?php echo $userfilename;?>';


      //  logo
      //-------------------------------------------------
      //get bounds for logo dragboundFunc
      minX = 0;
      maxX = <?php echo $canvaswidth; ?> - <?php echo $logowidth; ?> ;
      minY = 0;
      maxY = <?php echo $canvasheight; ?> - <?php echo $logoheight; ?> ;
      Konva.Image.fromURL('campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_logo;?>', function (logoNode) {
        logoNode.setAttrs({
          dragBoundFunc: function(pos) {
            var X = pos.x;
            var Y = pos.y;
            if (X < minX) { X = minX; }
            if (X > maxX) { X = maxX; }
            if (Y < minY) { Y = minY; }
            if (Y > maxY) { Y = maxY; }
            return ({
              x: X,
              y: Y
            });
          },
          x: 30,
          y: 30,
          keepRatio:true,
          width: <?php echo $logowidth; ?>,
          height: <?php echo $logoheight; ?>,
          draggable: false,
          name: 'logo',
          id: 'logo',
        });
        layer.add(logoNode);
        logoNode.moveToBottom();
        layer.batchDraw();
      });

      // sicker2:
      //---------------------------------------------------
      //get bounds for sticker dragboundFunc ( question ::: after zoom, reset bounds )
      minXs = 0;
      maxXs = <?php echo $canvaswidth; ?> - <?php echo $sticker1width; ?> ;
      minYs = 0;
      maxYs = <?php echo $canvasheight; ?> - <?php echo $sticker1height; ?> ;
      Konva.Image.fromURL('campaignimages/<?php echo $idcampaign;?>/<?php echo $billboard_sticker1;?>', function (sticker1Node) {
        sticker1Node.setAttrs({
          dragBoundFunc: function(pos) {
            var X = pos.x;
            var Y = pos.y;
            if (X < minXs) { X = minXs; }
            if (X > maxXs) { X = maxXs; }
            if (Y < minYs) { Y = minYs; }
            if (Y > maxYs) { Y = maxYs; }
            return ({
              x: X,
              y: Y
            });
          },
          x: 350,
          y: 100,
          keepRatio:true,
          width: <?php echo $sticker1width; ?>,
          height: <?php echo $sticker1height; ?>,
          draggable: false,
          name: 'sicker1',
          id: 'sicker1',
        });
        layer.add(sticker1Node);
        sticker1Node.moveToBottom();
        bgcolour.moveToBottom();
        layer.batchDraw();
      });


      // text:
      //---------------------------------------------------

      var nameText = new Konva.Text({
        x: width /2 - 150,
        y: 10,
        text: "<?php echo $canvastext;?>",
        fontSize: 60,
        fontFamily: 'Calibri',
        fill: '#black',
        width: 300,
        padding: 10,
        align: 'center',
        shadowColor: 'white',
        shadowBlur: 2,
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        shadowOpacity: 1,
        draggable: false,
        name: 'nameTx',
        id: 'nameTx',
      });

      layer.add(nameText);
      layer.batchDraw();


          //create the transformers
          //----------------------------------------------------------------
          var trbg = new Konva.Transformer({
            boundBoxFunc: function (oldBoundBox, newBoundBox) {
              if ( (newBoundBox.rotation >= 0.5) || (newBoundBox.rotation <= -0.5)  ){   return oldBoundBox;}
              if (Math.abs(newBoundBox.width) < MIN_WIDTH) {
                return oldBoundBox;
              }
              return newBoundBox;
            },
            anchorStroke: '#00ff00',
            anchorFill: 'rgba(0,255,0,0.5)',
            anchorSize: 30,
            borderStroke: 'cyan',
            borderStrokeWidth: 4,
            borderDash: [6, 4],
            enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
            rotateEnabled: true,
            keepRatio:true
          });






          var trlogo = new Konva.Transformer({
            boundBoxFunc: function (oldBoundBox, newBoundBox) {
              if (Math.abs(newBoundBox.width) > MAX_WIDTH) {
                return oldBoundBox;
              }
              if (Math.abs(newBoundBox.width) < MIN_WIDTH) {
                return oldBoundBox;
              }
              return newBoundBox;
            },
            borderStrokeWidth: 4,
            borderDash: [6, 4],
            borderStroke: 'yellow',
            enabledAnchors: [],
            rotateEnabled: false,
            keepRatio:true
          });
          var trimg1 = new Konva.Transformer({
            boundBoxFunc: function (oldBoundBox, newBoundBox) {
              if ( (newBoundBox.rotation >= 0.5) || (newBoundBox.rotation <= -0.5)  ){   return oldBoundBox;}
              if (Math.abs(newBoundBox.width) > MAX_WIDTH) {
                return oldBoundBox;
              }
              if (Math.abs(newBoundBox.width) < MIN_WIDTH) {
                return oldBoundBox;
              }
              return newBoundBox;
            },
            anchorStroke: '#0000ff',
            anchorFill: 'rgba(0,0,255,0.5)',
            anchorSize: 30,
            borderStroke: 'blue',
            borderStrokeWidth: 4,
            borderDash: [6, 4],
            enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
            rotateEnabled: true,
            anchorCornerRadius: 15,
            padding: 0,
            keepRatio:true
          });

          var trtx = new Konva.Transformer({
            boundBoxFunc: function (oldBoundBox, newBoundBox) {
              if (Math.abs(newBoundBox.width) < MIN_WIDTH) {
                return oldBoundBox;
              }
              return newBoundBox;
            },
            anchorStroke: '#00ff00',
            anchorFill: 'rgba(0,255,0,0.5)',
            anchorSize: 30,
            borderStroke: 'pink',
            borderStrokeWidth: 4,
            borderDash: [6, 4],
            enabledAnchors: ['top-right', 'top-left', 'bottom-right', 'bottom-left'],
            rotateEnabled: false,
            keepRatio:true
          });


          //update the transformers to add icon
          trbg.update = function() {
            for (var button in buttons) {
                Konva.Transformer.prototype.update.call(trbg);
                var shape = buttons[button].shape;
                var rot = this.findOne('.rotater');
                rot.fill('red');
                rot.width(60);
                rot.height(60);
                var icon = new Konva.Path({
                  fill:"cyan",
                  data: buttons[button].path,
                  name: 'rotater-icon'
                });
                icon.position(shape.position());
                forcewidth = stage.find('#bg')[0].width();
                icon.x( forcewidth /2  - 10) ; icon.y(-70);
                trbg.add(icon);
            }
          }
          trimg1.forceUpdate();
          layer.add(trimg1);

          trimg1.update = function() {
            for (var button in buttons) {
                Konva.Transformer.prototype.update.call(trimg1);
                var shape = buttons[button].shape;
                var rot = this.findOne('.rotater');
                rot.fill('blue');
                rot.width(60);
                rot.height(60);

                var icon = new Konva.Path({
                  fill:"white",
                  data: buttons[button].path,
                  name: 'rotater-icon'
                });
                icon.position(shape.position());
                stickerWidth = stage.find('#sicker1')[0].width();
                //console.log( stickerWidth /2 );
                //icon.x( stickerWidth /2 ) - 200 ; icon.y(-70);
                icon.x( stickerWidth /2  - 10) ; icon.y(-70);
                trimg1.add(icon);
            }
          }
          trimg1.forceUpdate();
          layer.add(trimg1);




      document.getElementById('selectBg').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          var bgshape = stage.find('#bg')[0];
          bgshape.draggable(true);
          var logoshape = stage.find('#logo')[0];
          logoshape.draggable(false);
          var s1shape = stage.find('#sicker1')[0];
          s1shape.draggable(false);
          var textshape = stage.find('#nameTx')[0];
          textshape.draggable(false);
          trlogo.detach();
          trimg1.detach();
          trbg.detach();
          trtx.detach();
          layer.draw();
          // or var shape = stage.findOne('#myRect');
          layer.add(trbg);
          trbg.nodes([bgshape]);
          textshape.moveToBottom();
          logoshape.moveToBottom();
          s1shape.moveToBottom();
          bgcol.moveToBottom();
          bgshape.moveToTop();
          layer.draw();
        },
        false
      );

      document.getElementById('selectObject1').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          var bgshape = stage.find('#bg')[0];
          bgshape.draggable(false);
          var logoshape = stage.find('#logo')[0];
          logoshape.draggable(true);
          var s1shape = stage.find('#sicker1')[0];
          s1shape.draggable(false);
          var textshape = stage.find('#nameTx')[0];
          textshape.draggable(false);
          trlogo.detach();
          trimg1.detach();
          trbg.detach();
          trtx.detach();
          layer.draw();
          layer.add(trlogo);
          trlogo.nodes([logoshape]);
          textshape.moveToBottom();
          s1shape.moveToBottom();
          bgshape.moveToBottom();
          bgcol.moveToBottom();
          logoshape.moveToTop();
          layer.draw();
        },
        false
      );

      document.getElementById('selectObject2').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          var bgshape = stage.find('#bg')[0];
          bgshape.draggable(false);
          var logoshape = stage.find('#logo')[0];
          logoshape.draggable(false);
          var s1shape = stage.find('#sicker1')[0];
          s1shape.draggable(true);
          var textshape = stage.find('#nameTx')[0];
          textshape.draggable(false);
          trlogo.detach();
          //trimg2.detach();
          trtx.detach();
          trbg.detach();
          layer.draw();
          layer.add(trimg1);
          trimg1.nodes([s1shape]);
          textshape.moveToBottom();
          logoshape.moveToBottom();
          bgshape.moveToBottom();
          bgcol.moveToBottom();
          s1shape.moveToTop();
          layer.draw();
        },
        false
      );

      document.getElementById('selectText').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          var bgshape = stage.find('#bg')[0];
          bgshape.draggable(false);
          var logoshape = stage.find('#logo')[0];
          logoshape.draggable(false);
          var s1shape = stage.find('#sicker1')[0];
          s1shape.draggable(false);
          var textshape = stage.find('#nameTx')[0];
          textshape.draggable(true);
          trlogo.detach();
          trimg1.detach();
          trbg.detach();
          layer.draw();
          layer.add(trtx);
          trtx.nodes([textshape]);
          logoshape.moveToBottom();
          s1shape.moveToBottom();
          bgshape.moveToBottom();
          bgcol.moveToBottom();
          textshape.moveToTop();
          layer.draw();
        },
        false
      );


      document.getElementById('preview').addEventListener(
        'click',
        function () {
          var bgcol = stage.find('#bgcol')[0];
          var bgshape = stage.find('#bg')[0];
          bgshape.draggable(false);
          var logoshape = stage.find('#logo')[0];
          logoshape.draggable(false);
          var s1shape = stage.find('#sicker1')[0];
          s1shape.draggable(false);
          var txshape = stage.find('#nameTx')[0];
          txshape.draggable(false);
          trlogo.detach();
          trimg1.detach();
          trtx.detach();
          trbg.detach();
          s1shape.moveToTop();
          txshape.moveToTop();
          logoshape.moveToTop();
          layer.draw();
        },
        false
      );


      //onload mage bg transformer active, move stickers to back
      window.addEventListener('DOMContentLoaded',
        function () {
          setTimeout( function(){
            console.log("here");

            var bgcol = stage.find('#bgcol')[0];
            var bgshape = stage.find('#bg')[0];
            bgshape.draggable(true);
            var logoshape = stage.find('#logo')[0];
            logoshape.draggable(false);
            var s1shape = stage.find('#sicker1')[0];
            s1shape.draggable(false);
            var textshape = stage.find('#nameTx')[0];
            textshape.draggable(false);
            trlogo.detach();
            trimg1.detach();
            trbg.detach();
            trtx.detach();
            layer.draw();
            // or var shape = stage.findOne('#myRect');
            layer.add(trbg);
            trbg.nodes([bgshape]);
            textshape.moveToBottom();
            logoshape.moveToBottom();
            s1shape.moveToBottom();
            bgcol.moveToBottom();
            bgshape.moveToTop();
            layer.draw();
          }, 2000);
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

    //icon for rotator
    var buttons = {
      rotater: {
        path:'<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path data-name="layer1" d="M60.693 22.023a3 3 0 0 0-4.17.784l-2.476 3.622A27.067 27.067 0 0 0 28 6C13.443 6 2 18.036 2 32.584a26.395 26.395 0 0 0 45.066 18.678 3 3 0 1 0-4.244-4.242A20.395 20.395 0 0 1 8 32.584C8 21.344 16.752 12 28 12a21.045 21.045 0 0 1 20.257 16.059l-4.314-3.968a3 3 0 0 0-4.062 4.418l9.737 8.952c.013.013.03.02.043.033.067.06.143.11.215.163a2.751 2.751 0 0 0 .243.17c.076.046.159.082.24.12a3.023 3.023 0 0 0 .279.123c.08.03.163.05.246.071a3.045 3.045 0 0 0 .323.07c.034.006.065.017.1.022.051.006.102-.002.154.002.063.004.124.017.187.017.07 0 .141-.007.212-.012l.08-.004.05-.003c.06-.007.118-.03.179-.04a3.119 3.119 0 0 0 .387-.087c.083-.027.16-.064.239-.097a2.899 2.899 0 0 0 .314-.146 2.753 2.753 0 0 0 .233-.151 2.944 2.944 0 0 0 .263-.2c.07-.06.135-.124.199-.19a3.013 3.013 0 0 0 .224-.262c.03-.04.069-.073.097-.114l7.352-10.752a3.001 3.001 0 0 0-.784-4.17z" fill="#ff0000"></path></svg>',
        shape: trbg.findOne('.rotater')
      }
    };

    </script>

	<form method="post" id="step4form" name="step4form" action="step5.php">
	<input type="hidden" name="formsubmitted" id="textfield" value="true">
	<input type="hidden" name="uniquesession" id="uniquesession" value="<?php  echo $uniquesession  ?>">
	<input type="hidden" name="iduser" id="iduser" value="<?php  echo $iduser  ?>">
	<input type="submit" value="NEXT STEP" id="btnsubmit" style="display: none" />
	</form>


	<div class="covid-banner">
	  <p class="covid-hashtag"> #COVID19</p>
	</div>

</div>


</body>
</html>

<?php
// Close connection
mysqli_close($link);
} ?>
