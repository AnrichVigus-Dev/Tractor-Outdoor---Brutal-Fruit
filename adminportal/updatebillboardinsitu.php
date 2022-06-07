<?php
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

    $id = $_GET['idbillboard'];
    $campaignid = $_GET['idcampaign'];
    $billboardcanvas_h = $_GET['billboardcanvas_h'];
    $billboardcanvas_w = $_GET['billboardcanvas_w'];
    $innercanvas_X = $_GET['text_x'];
    $innercanvas_Y = $_GET['text_y'];
    $innercanvas_W = $_GET['text_w'];
    $innercanvas_H = $_GET['text_h'];

    $sqlupdate = "UPDATE billboards SET
    billboard_insitu_png_height = '$billboardcanvas_h',
    billboard_insitu_png_width = '$billboardcanvas_w',
    insitu_pos_x = '$innercanvas_X',
    insitu_pos_y = '$innercanvas_Y',
    insitu_width = '$innercanvas_W',
    insitu_height = '$innercanvas_H'

    WHERE idbillboard = '$id' ";

    if ($link->query($sqlupdate) === TRUE) {
	     header("Location: billboards.php?idcampaign=$campaignid");
    } else {
      echo "Error updating record: " . $link->error;
    }


// Close connection
mysqli_close($link);
?>
