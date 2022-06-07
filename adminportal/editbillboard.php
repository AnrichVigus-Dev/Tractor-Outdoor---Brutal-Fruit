<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://unpkg.com/konva@7.0.6/konva.min.js"></script>

<?php

if ((!isset($_POST["upload"])) && (!isset($_POST["uploadexample"]))) {
 $idcampaign = $_GET['idcampaign'];
 $idbillboard = $_GET['idbillboard'];
}

//UPLOAD BILLBOARD EXAMPLE

if (isset($_POST["uploadexample"])) {
    $idbillboard = $_POST['idbillboard'];
    $idcampaign = $_POST['idcampaign'];
    //echo $idbillboard ;

    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

    $allowed_image_extension = array(
        "jpg",
        "PNG",
        "png"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valid images. Only PNG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 4000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 4MB"
        );
    //}    // Validate image file dimension
    //else if ($width > "300" || $height > "200") {
      //  $response = array(
        //    "type" => "error",
          //  "message" => "Image dimension should be within 300X200"
       // );
    } else {
    $newfilename = time();
    //$target = "useruploads/" . basename($_FILES["file-input"]["name"]);
    $target = "../images/billboards/" . $newfilename.".".$file_extension;
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {

// Attempt update query execution

$insituexample_filename = $newfilename.".".$file_extension;

$sqlupdate = "UPDATE billboards SET
billboard_insitu_example = '$insituexample_filename'

WHERE idbillboard = '$idbillboard' ";

      if(mysqli_query($link, $sqlupdate)){

      //header("Location: editbillboardinsitu.php?idbillboard=$idbillboard");
} else{
    echo "ERROR: Could not able to execute $sqlupdate. " . mysqli_error($link);
}


            $response = array(
                "type" => "success",
                "message" => "Your photo uploaded successfully."
            );
        } else {
            $response = array(
                "type" => "error",
                "message" => "There was a problem in uploading your photo"
            );
        }
    }
}




//UPLOAD BEZEL PNG

if (isset($_POST["upload"])) {
    $idbillboard = $_POST['idbillboard'];
    $idcampaign = $_POST['idcampaign'];
    //echo $idbillboard ;

    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

    $allowed_image_extension = array(
        "jpg",
        "PNG",
        "png"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valid images. Only PNG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 4000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 4MB"
        );
    //}    // Validate image file dimension
    //else if ($width > "300" || $height > "200") {
      //  $response = array(
        //    "type" => "error",
          //  "message" => "Image dimension should be within 300X200"
       // );
    } else {
    $newfilename = time();
    //$target = "useruploads/" . basename($_FILES["file-input"]["name"]);
    $target = "../images/billboards/templates/" . $newfilename.".".$file_extension;
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {

// Attempt insert query execution

$bezelfilename = $newfilename.".".$file_extension;

$sqlupdate = "UPDATE billboards SET
bezel_filename = '$bezelfilename'

WHERE idbillboard = '$idbillboard' ";

      if(mysqli_query($link, $sqlupdate)){

      //header("Location: editbillboardinsitu.php?idbillboard=$idbillboard");
} else{
    echo "ERROR: Could not able to execute $sqlupdate. " . mysqli_error($link);
}


            $response = array(
                "type" => "success",
                "message" => "Your photo uploaded successfully."
            );
        } else {
            $response = array(
                "type" => "error",
                "message" => "There was a problem in uploading your photo"
            );
        }
    }
}
?>



<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>BRUTAL FRUIT OUTDOOR CAMPAIGNS</title>

<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


<style>
body, table, th, td, h1, div .sansserif {
  font-family: Arial, Helvetica, sans-serif;
}
h1 {font-size: 22px;}

.container {
  margin: auto;
  width: 50vw;
}

.footer {
  border-bottom: 1px dotted;
  margin: auto;
  padding:0 25px;
  width: 100%;
  height: 130px;
}

.breadcrumbs {
  padding: 0 25px;
  text-align: left;
}

.mycolgroup {
  display: inline-block;
  width: 100%;
}

.center {
  border: 0px solid #fff;
  padding: 25px;
  text-align: center;
  width: 100%;
}

.left {
  border: 0px solid #fff;
  min-height: 50px;
  padding: 25px;
  text-align: left;
  width: 100%;
  float: left;
}

.center {
  border: 0px solid #fff;
  min-height: 50px;
  padding: 25px;
  text-align: center;
  width: 100%;
}

.splitleft {
  border: 0px solid #fff;
  min-height: 50px;
  padding: 25px 25px 0 25px;
  text-align: left;
  width: 50%;
  float: left;
}

.splitright {
  border: 0px solid #fff;
  min-height: 50px;
  padding: 25px 25px 0 25px;
  text-align: right;
  width: 50%;
  float: right;
}

.darkrow {
  background-color: #777;
  color: white;
  border-bottom: 1px solid #fff;
}

.lightrow {
  background-color: #ddd;
  border-bottom: 1px solid #fff;
}

.altrow {
  background-color: #f5f5f5;
  border-bottom: 1px solid #fff;
}

canvas {
    border: 1px solid black;
}

input[type=text] {
  color: #777;
}

input[type=button], input[type=submit], input[type=reset] {
  background-color: #4879b2;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}


</style>

</head>

<body>

  <section>
    <div class="container left">
          <h1>EDIT BILLBOARD</h1>
    </div>

    <div class="breadcrumbs">

      <a href="billboards.php?idcampaign=<?php echo $idcampaign; ?>">< BACK TO BILLBOARDS</a> | <a href="editbillboardinsitu.php?idcampaign=<?php echo $idcampaign;?>&idbillboard=<?php echo $idbillboard; ?>">MANAGE IN SITU IMAGE</a>
    </div>

  </section>

  <?php

  // 2 Query Campaigns table


  $sqlbillboards = "SELECT * FROM billboards WHERE idbillboard = $idbillboard";

  if($resultbillboards = mysqli_query($link, $sqlbillboards)) {

      if(mysqli_num_rows($resultbillboards) > 0) { ?>

  		<?php while ($rowbillboards = mysqli_fetch_array($resultbillboards)){ ?>

        <?php
        $idbillboard = $rowbillboards['idbillboard'];
        $idcampaign = $rowbillboards['campaignid'];
        $locationid = $rowbillboards['locationid'];
        $physicallocation = $rowbillboards['physicallocation'];
        $billboardcanvaswidth = $rowbillboards['billboard_width'];
        $billboardcanvasheight = $rowbillboards['billboard_height'];
        $innercanvas_X = $rowbillboards['canvas_pos_x'];
        $innercanvas_Y = $rowbillboards['canvas_pos_y'];
        $innercanvas_W = $rowbillboards['canvas_width'];
        $innercanvas_H = $rowbillboards['canvas_height'];
        $elementsswitch = $rowbillboards['elementsswitch'];
        $bezelfilename = $rowbillboards['bezel_filename'];
        $bezel = $rowbillboards['bezel'];
        $textfont = $rowbillboards['text_font'];
        $textcolor = $rowbillboards['text_color'];
        $billboard_color = $rowbillboards['billboard_color'];
        $billboardcode1 = $rowbillboards['billboardcode1'];
        $totextX = $rowbillboards['totextX'];
        $totextY = $rowbillboards['totextY'];
        $totextsize = $rowbillboards['totextsize'];
        $totextwidth = $rowbillboards['totextwidth'];
        $messageX = $rowbillboards['messageX'];
        $messageY = $rowbillboards['messageY'];
        $messagesize = $rowbillboards['messagesize'];
        $messagewidth = $rowbillboards['messagewidth'];
        $fromtextX = $rowbillboards['fromtextX'];
        $fromtextY = $rowbillboards['fromtextY'];
        $fromtextsize = $rowbillboards['fromtextsize'];
        $fromtextwidth = $rowbillboards['fromtextwidth'];
        $archive = $rowbillboards['archive'];
        ?>

<div class="mycolgroup">

          <div class="container left">

            <div class="center darkrow" style="min-height: 80px;">

            MANAGE <?php echo strtoupper($physicallocation); ?> BILLBOARD ARTWORK & DIMENSIONS

            </div>



            <div class="center lightrow">
            <form id="frm-image-upload" action="editbillboard.php" name='img' method="post" enctype="multipart/form-data">
                <div style="text-align: center; width:300px; margin:auto;">
                    UPLOAD BILLBOARD EXAMPLE:

                    <br><br>
                    <img src="../images/billboards/<?php echo $rowbillboards['billboard_insitu_example']; ?>" style="width:330px;" />
                    <br><br>

                    <input type="file" class="" name="file-input" id="myfile"><br><br>
                    <input name="idbillboard" type="hidden" id="idbillboard" value="<?php echo $idbillboard ;?>">
                    <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">
                    <input class="" type="submit" id="btn-submit" name="uploadexample" value="UPLOAD JPG"><br><br>
                </div>
            </form>
          </div>





            <div class="center lightrow">
            <form id="frm-image-upload" action="editbillboard.php" name='img' method="post" enctype="multipart/form-data">
                <div style="text-align: center; width:300px; margin:auto;">
                    UPLOAD BEZEL PNG: <br>
                    <input type="file" class="" name="file-input" id="myfile"><br><br>
                    <input name="idbillboard" type="hidden" id="idbillboard" value="<?php echo $idbillboard ;?>">
                    <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">
                    <input class="" type="submit" id="btn-submit" name="upload" value="UPLOAD PNG"><br><br>
                </div>
            </form>
          </div>



<a name="coordinates"></a>
            <div class="center lightrow">

                <form action="updatebillboard.php" method="get">
                Billboard has bezel: <input name="bezel" type="checkbox" id="bezel" value="1" <?php if ($bezel == "1") { ?>checked="checked"<?php } ?>><br><br>
                <!--
                <?php if ($bezel <> 0) { ?>
                <img id="canvasbackgroundimage" src="../images/billboards/templates/<?php echo $bezelfilename; ?>" style="display: none;">
                <?php } ?>
                <canvas id="canvas" width="<?php echo $billboardcanvaswidth; ?>" height="<?php echo $billboardcanvasheight; ?>" color="#fff"></canvas>
                  -->



                TEXT POSITIONING:

                <br><br>
                <div style="display: inline; float: left; width: 30%">
                  To Text X pos (px): <input name="totext_x" type="text" id="totext_x" value="<?php echo $totextX ;?>"><br>
                  To Text Y pos (px): <input name="totext_y" type="text" id="totext_y" value="<?php echo $totextY ;?>"><br>
                  To Text Size (px): <input name="totext_size" type="text" id="totext_size" value="<?php echo $totextsize ;?>"><br>
                  To Text Width (px): <input name="totextwidth" type="text" id="totextwidth" value="<?php echo $totextwidth ;?>"><br>
                </div>
                <div style="display: inline; float: left; width: 30%">
                Massage X pos (px): <input name="message_x" type="text" id="message_x" value="<?php echo $messageX ;?>"><br>
                Massage Y pos (px): <input name="message_y" type="text" id="message_y" value="<?php echo $messageY ;?>"><br>
                Massage Size (px): <input name="message_size" type="text" id="message_size" value="<?php echo $messagesize ;?>"><br>
                Message Width (px): <input name="messagewidth" type="text" id="messagewidth" value="<?php echo $messagewidth ;?>"><br>
              </div>
                <div style="display: inline; float: left; width: 30%">
                From Text X pos (px): <input name="fromtext_x" type="text" id="fromtext_x" value="<?php echo $fromtextX ;?>"><br>
                From Text Y pos (px): <input name="fromtext_y" type="text" id="fromtext_y" value="<?php echo $fromtextY ;?>"><br>
                From Text Size (px): <input name="fromtext_size" type="text" id="fromtext_size" value="<?php echo $fromtextsize ;?>"><br>
                From Text Width (px): <input name="fromtextwidth" type="text" id="fromtextwidth" value="<?php echo $fromtextwidth ;?>"><br>
              </div>
              <div style="clear: both;">

                <br><br>
                <center>
                <div id="canvaswrap">
                  <div id="container"></div>
                </div>
              </center>

                <br>

                <input name="idbillboard" type="hidden" id="idbillboard" value="<?php echo $idbillboard ;?>">
                <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">

                Billboard creative width: <input name="billboardcanvas_w" type="text" id="canvas_w" value="<?php echo $billboardcanvaswidth ;?>"><br>
                Billboard creative height:  <input name="billboardcanvas_h" type="text" id="canvas_h" value="<?php echo $billboardcanvasheight ;?>"><br>

                <br><br>

                BILLBOARD BACKGROUND COLOUR:

                <link href="css/sticky.css" rel="stylesheet" type="text/css">
                <script src="js/html5kellycolorpicker.min.js"></script>




                 <div class="css-script-center">
                  <div class="css-script-clear"></div>
                  </div>


                <div style="padding:20px;">
            		<canvas id="picker"></canvas><br>
                    <input id="color" value="<?php echo $billboard_color; ?>" name='billboard_color'>
                    <script>
                        new KellyColorPicker({place : 'picker', input : 'color', size : 150});
                    </script>
                </div>

 
                <br><br>
                FINE-TUNE COMPOSITE POSITIONING:

                <br><br>
                X pos (px): <input name="text_x" type="text" id="text_x" value="<?php echo $innercanvas_X ;?>"><br>
                Y pos (px): <input name="text_y" type="text" id="text_y" value="<?php echo $innercanvas_Y ;?>"><br>
                W pos (px): <input name="text_w" type="text" id="text_w" value="<?php echo $innercanvas_W ;?>"><br>
                H pos (px): <input name="text_h" type="text" id="text_h" value="<?php echo $innercanvas_H ;?>"><br>



                <br><br>
                BILLBOARD CITY:

                <select id="locationid" name="locationid" class="dropdown" required>
        					<option value="" selected >SELECT BILLBOARD MAIN LOCATION:</option>

        					<?php
        					// Query and display Locations
        					$sql = "SELECT * FROM locations";
        					if($result = mysqli_query($link, $sql)){
        					    if(mysqli_num_rows($result) > 0){
        							while($row = mysqli_fetch_array($result)){ ?>

        							<option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $locationid) { ?> selected="selected"<?php } ?>><?php echo $row['location']; ?></option>

        							<?php }

        					        // Free result set
        					        mysqli_free_result($result);
        					    }
        					}

        					?>

        				</select>

                <br><br>

                PHYSICAL LOCATION:

                <input name="physicallocation" type="text" id="physicallocation" value="<?php echo $physicallocation ;?>"><br>

                <br><br>

                BILLBOARD CODE:

                <input name="billboardcode1" type="text" id="billboardcode1" value="<?php echo $billboardcode1 ;?>"><br>

                <br><br>

                ARCHIVE BILLBOARD: <input name="archive" type="checkbox" id="archive" value="1" <?php if ($archive == "1") { ?>checked="checked"<?php } ?>>

                <br><br>

                <input type="submit" value="UPDATE BILLBOARD">

                </form>

              </div>

      </div>
</div>

        <?php  }

  		}
       //$_SESSION['startrownumber'] = $startrownumber / $mycountend + 1;
          // Free result set
          mysqli_free_result($resultbillboards);
      }

  // Close connection
  mysqli_close($link);

$fontname = 'CocogoosePro Reg';
$fontnameLight = 'CocogoosePro Light';
$fontnameUltraLight = 'CocogoosePro UltraLight';
$fontnameSemiLight = 'CocogoosePro SemiLight';


//$fontname = 'Montserrat';
  ?>

<script>



var thecanvaswidth = <?php echo $innercanvas_W; ?>;

var stage = new Konva.Stage({
    container: 'container',
    width: <?php echo $innercanvas_W; ?>,
    height: <?php echo $innercanvas_H; ?>
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
    width: <?php echo $innercanvas_W; ?>,
    height: <?php echo $innercanvas_H; ?>,
  });

  // add the shape to the layer
  layer.add(yoda);
  layer.draw();
};
imageObj.src = '../images/billboards/templates/<?php echo $bezelfilename; ?>';




var totext = 'DUMISWA';
var fromtext = 'Deneash Ruiters'
var message = "YOU'RE A HOME OWNER NOW. CONGRATS SIS!";

function scaledFontsize( text,fontface,desiredWidth ){
    desiredWidth = desiredWidth;
    var c=document.createElement('canvas');
    var cctx=c.getContext('2d');
    var testFontsize=18;
    cctx.font=testFontsize+'px '+fontface;
    var textWidth=cctx.measureText(text).width;
    return((testFontsize*desiredWidth/textWidth) - 2);
}
var scaledSizeTo = scaledFontsize( totext ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $totextwidth; ?>' );
var scaledSizeFrom = scaledFontsize( fromtext ,'<?php echo $fontnameUltraLight; ?>', '<?php echo $fromtextwidth; ?>' );
var messageheight = 70;

//sliding max font size for different bb sizes
//for very large bb;
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
    text: message,
    fontSize: <?php echo $messagesize;?>,
    fontFamily: '<?php echo $fontnameUltraLight?>',
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
},100)



  // alt From Text
  var textHolderFrom = new Konva.Label({
        x: <?php echo $fromtextX;?>,
        y: <?php echo $fromtextY;?>,
    opacity: 0.75,
  });

  textHolderFrom.add(
    new Konva.Tag({
      fill: 'black'
    })
  );
  textHolderFrom.add(
    new Konva.Text({
        x: <?php echo $fromtextX;?>,
        y: <?php echo $fromtextY;?>,
        text: fromtext.toUpperCase(),
        //fontSize: <?php echo $totextsize;?>,
        fontSize: scaledSizeFrom,
        fontFamily: '<?php echo $fontnameUltraLight?>',
        fontWeight: 'Normal',
        fill: '#c16566',
        keepRatio:false,
        width: <?php echo $fromtextwidth; ?>,
        align: 'center',
        name: 'nameTx',
        id: 'nameTx',
        verticalAlign: 'top',
        height: 30
    })
  );
  // alt To Text
  var textHolderTo = new Konva.Label({
        x: <?php echo $totextX;?>,
        y: <?php echo $totextY;?>,
    opacity: 0.75,
  });

  textHolderTo.add(
    new Konva.Tag({
      fill: 'black'
    })
  );
  textHolderTo.add(
    new Konva.Text({
        x: <?php echo $totextX;?>,
        y: <?php echo $totextY;?>,
        text: totext.toUpperCase(),
        //fontSize: <?php echo $totextsize;?>,
        fontSize: scaledSizeTo,
        fontFamily: '<?php echo $fontnameUltraLight?>',
        fontWeight: 'Normal',
        fill: 'white',
        keepRatio:false,
        width: <?php echo $totextwidth; ?>,
        align: 'center',
        name: 'nameTx',
        id: 'nameTx',
        verticalAlign: 'bottom',
        height: 50
    })
  );




      // add the labels to layer
      layertext.add(textHolderTo);
      layertext.draw(textHolderTo);
      layertext.moveToTop();


</script>


</body>
</html>
