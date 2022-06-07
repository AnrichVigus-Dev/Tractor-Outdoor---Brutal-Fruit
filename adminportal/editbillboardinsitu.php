<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
?>

<?php
if (!isset($_POST["upload"])) {
 $idcampaign = $_GET['idcampaign'];
 $idbillboard = $_GET['idbillboard'];
}
 ?>

<?php
//Upload INSITU PNG
if (isset($_POST["upload"])) {
    $idbillboard = $_POST['idbillboard'];
    $idcampaign = $_POST['idcampaign'];
    //echo $idbillboard ;

    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

    $allowed_image_extension = array(
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
            "message" => "Upload valid images. Only PNG and JPEG are allowed."
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
    echo $newfilename;
    //$target = "useruploads/" . basename($_FILES["file-input"]["name"]);
    $target = "../images/billboards/insitu/" . $newfilename.".".$file_extension;
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {

// Attempt insert query execution

$insitufilename = $newfilename.".".$file_extension;

$sqlupdate = "UPDATE billboards SET
billboard_insitu_png_width = '$width',
billboard_insitu_png_height = '$height',
billboard_insitu_png = '$insitufilename'

WHERE idbillboard = '$idbillboard' ";
echo $sqlupdate;

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
          <h1>EDIT BILLBOARD - IN SITU DISPLAY POSITION</h1>
    </div>

    <div class="breadcrumbs">

      <a href="billboards.php?idcampaign=<?php echo $idcampaign; ?>">< BACK TO BILLBOARDS</a> | <a href="editbillboard.php?idcampaign=<?php echo $idcampaign; ?>&idbillboard=<?php echo $idbillboard; ?>">BACK TO CURRENT SELECTED BILLBOARD</a>
    </div>

  </section>

  <?php

  // 2 Query Campaigns table


  //$idbillboard = $_GET['idbillboard'];
  $sqlbillboards = "SELECT * FROM billboards WHERE idbillboard = $idbillboard";

  if($resultbillboards = mysqli_query($link, $sqlbillboards)) {

      if(mysqli_num_rows($resultbillboards) > 0) { ?>

  		<?php while ($rowbillboards = mysqli_fetch_array($resultbillboards)){ ?>

        <?php
        $idbillboard = $rowbillboards['idbillboard'];
        $idcampaign = $rowbillboards['campaignid'];
        $idlocation = $rowbillboards['locationid'];
        $physicallocation = $rowbillboards['physicallocation'];
        $billboard_insitu_png_width = $rowbillboards['billboard_insitu_png_width'];
        $billboard_insitu_png_height = $rowbillboards['billboard_insitu_png_height'];
        $insitu_width = $rowbillboards['insitu_width'];
        $insitu_height = $rowbillboards['insitu_height'];
        $insitu_pos_x = $rowbillboards['insitu_pos_x'];
        $insitu_pos_y = $rowbillboards['insitu_pos_y'];
        $billboard_insitu_png = $rowbillboards['billboard_insitu_png'];
        ?>

<div class="mycolgroup">

          <div class="container left">

            <div class="center darkrow" style="min-height: 80px; min-width:<?php echo $billboard_insitu_png_width; ?>px;">

            SET <?php echo strtoupper($physicallocation); ?> BILLBOARD'S IN SITU ARTWORK POSITION

            </div>

            <div class="center lightrow" style="min-width:<?php echo $billboard_insitu_png_width; ?>px;">
            <form id="frm-image-upload" action="editbillboardinsitu.php" name='img' method="post" enctype="multipart/form-data">
                <div style="text-align: center; width:300px; margin:auto;">
                    UPLOAD IN SITU PNG: <br>
                    <input type="file" class="" name="file-input" id="myfile"><br><br>
                    <input name="idbillboard" type="hidden" id="idbillboard" value="<?php echo $idbillboard ;?>">
                    <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">
                    <input class="" type="submit" id="btn-submit" name="upload" value="UPLOAD PNG"><br><br>
                </div>
            </form>
          </div>


            <div class="center lightrow" style="min-width:<?php echo $billboard_insitu_png_width; ?>px; min-height:<?php echo $billboard_insitu_png_height; ?>px;">

                  <div style="background-image: url(../images/billboards/insitu/<?php echo $billboard_insitu_png; ?>); background-repeat: no-repeat; background-position: center top 1px; min-width:<?php echo $billboard_insitu_png_width; ?>px; min-height:<?php echo $billboard_insitu_png_height; ?>px;" >
                  <canvas id="canvas" width="<?php echo $billboard_insitu_png_width; ?>" height="<?php echo $billboard_insitu_png_height; ?>" ></canvas>
                  </div

                  <br>

                <?php if(!empty($response)) { ?>
                		<div class="response <?php echo $response["type"]; ?>">
                    <p class="scampaign-heading-small"><?php echo $response["message"]; ?></p>
                		</div>
                <?php } ?>




                <form action="updatebillboardinsitu.php" method="get">
                <input name="idbillboard" type="hidden" id="idbillboard" value="<?php echo $idbillboard ;?>">
                <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">

                Billboard in-situ creative width: <input name="billboardcanvas_w" type="text" id="canvas_w" value="<?php echo $billboard_insitu_png_width;?>"><br>
                Billboard in-situ creative height:  <input name="billboardcanvas_h" type="text" id="canvas_h" value="<?php echo $billboard_insitu_png_height;?>"><br>

                X <input name="text_x" type="text" id="text_x" value="<?php echo $insitu_pos_x ;?>"><br>
                Y <input name="text_y" type="text" id="text_y" value="<?php echo $insitu_pos_y ;?>"><br>
                W <input name="text_w" type="text" id="text_w" value="<?php echo $insitu_width ;?>"><br>
                H <input name="text_h" type="text" id="text_h" value="<?php echo $insitu_height ;?>"><br>

                <br>

                <input type="submit" value="UPDATE IN SITU BILLBOARD">

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

  ?>


<script>
var canvas = document.getElementById('canvas'),
    ctx = canvas.getContext('2d'),

    rect = {
      x: <?php echo $insitu_pos_x; ?>,
      y: <?php echo $insitu_pos_y; ?>,
      w: <?php echo $insitu_width; ?>,
      h: <?php echo $insitu_height; ?>
    },
    handlesSize = 8,
    currentHandle = false,
    drag = false;

function init() {
    canvas.addEventListener('mousedown', mouseDown, false);
    canvas.addEventListener('mouseup', mouseUp, false);
    canvas.addEventListener('mousemove', mouseMove, false);
}

function point(x, y) {
    return {
        x: x,
        y: y
    };
}

function dist(p1, p2) {
    return Math.sqrt((p2.x - p1.x) * (p2.x - p1.x) + (p2.y - p1.y) * (p2.y - p1.y));
}

function getHandle(mouse) {
    if (dist(mouse, point(rect.x, rect.y)) <= handlesSize) return 'topleft';
    if (dist(mouse, point(rect.x + rect.w, rect.y)) <= handlesSize) return 'topright';
    if (dist(mouse, point(rect.x, rect.y + rect.h)) <= handlesSize) return 'bottomleft';
    if (dist(mouse, point(rect.x + rect.w, rect.y + rect.h)) <= handlesSize) return 'bottomright';
    if (dist(mouse, point(rect.x + rect.w / 2, rect.y)) <= handlesSize) return 'top';
    if (dist(mouse, point(rect.x, rect.y + rect.h / 2)) <= handlesSize) return 'left';
    if (dist(mouse, point(rect.x + rect.w / 2, rect.y + rect.h)) <= handlesSize) return 'bottom';
    if (dist(mouse, point(rect.x + rect.w, rect.y + rect.h / 2)) <= handlesSize) return 'right';
    document.getElementById("text_x").value = rect.x;
    document.getElementById("text_y").value = rect.y;
    document.getElementById("text_w").value = rect.w;
    document.getElementById("text_h").value = rect.h;
    return false;
}

function mouseDown(e) {
    if (currentHandle) drag = true;
    draw();
}

function mouseUp() {
    drag = false;
    currentHandle = false;
    draw();
}

function mouseMove(e) {
    var previousHandle = currentHandle;
    if (!drag) currentHandle = getHandle(point(e.pageX - this.offsetLeft, e.pageY - this.offsetTop));
    if (currentHandle && drag) {
        var mousePos = point(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
        switch (currentHandle) {
            case 'topleft':
                rect.w += rect.x - mousePos.x;
                rect.h += rect.y - mousePos.y;
                rect.x = mousePos.x;
                rect.y = mousePos.y;
                break;
            case 'topright':
                rect.w = mousePos.x - rect.x;
                rect.h += rect.y - mousePos.y;
                rect.y = mousePos.y;
                break;
            case 'bottomleft':
                rect.w += rect.x - mousePos.x;
                rect.x = mousePos.x;
                rect.h = mousePos.y - rect.y;
                break;
            case 'bottomright':
                rect.w = mousePos.x - rect.x;
                rect.h = mousePos.y - rect.y;
                break;

            case 'top':
                rect.h += rect.y - mousePos.y;
                rect.y = mousePos.y;
                break;

            case 'left':
                rect.w += rect.x - mousePos.x;
                rect.x = mousePos.x;
                break;

            case 'bottom':
                rect.h = mousePos.y - rect.y;
                break;

            case 'right':
                rect.w = mousePos.x - rect.x;
                break;
        }
    }
    if (drag || currentHandle != previousHandle) draw();
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = 'black';
    ctx.fillRect(rect.x, rect.y, rect.w, rect.h);
    if (currentHandle) {
        var posHandle = point(0, 0);
        switch (currentHandle) {
            case 'topleft':
                posHandle.x = rect.x;
                posHandle.y = rect.y;
                break;
            case 'topright':
                posHandle.x = rect.x + rect.w;
                posHandle.y = rect.y;
                break;
            case 'bottomleft':
                posHandle.x = rect.x;
                posHandle.y = rect.y + rect.h;
                break;
            case 'bottomright':
                posHandle.x = rect.x + rect.w;
                posHandle.y = rect.y + rect.h;
                break;
            case 'top':
                posHandle.x = rect.x + rect.w / 2;
                posHandle.y = rect.y;
                break;
            case 'left':
                posHandle.x = rect.x;
                posHandle.y = rect.y + rect.h / 2;
                break;
            case 'bottom':
                posHandle.x = rect.x + rect.w / 2;
                posHandle.y = rect.y + rect.h;
                break;
            case 'right':
                posHandle.x = rect.x + rect.w;
                posHandle.y = rect.y + rect.h / 2;
                break;
        }
        ctx.globalCompositeOperation = 'xor';
        ctx.beginPath();
        ctx.arc(posHandle.x, posHandle.y, handlesSize, 0, 2 * Math.PI);
        ctx.fill();
        ctx.globalCompositeOperation = 'source-over';
    }
}

init();
draw();


</script>


</body>
</html>
