<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

    $id = $_GET['idbillboard'];
    $locationid = $_GET['locationid'];
    $physicallocation = $_GET['physicallocation'];
    $campaignid = $_GET['idcampaign'];
    $innercanvas_X = $_GET['text_x'];
    $innercanvas_Y = $_GET['text_y'];
    $innercanvas_W = $_GET['text_w'];
    $innercanvas_H = $_GET['text_h'];
    $billboardcanvas_W = $_GET['billboardcanvas_w'];
    $billboardcanvas_H = $_GET['billboardcanvas_h'];
    //$elementsswitch = $_GET['elementsswitch'];
    $bezel = $_GET['bezel'];
    $billboard_color = $_GET['billboard_color'];
    $billboardcode1 = $_GET['billboardcode1'];
    $totextX = $_GET['totext_x'];
    $totextY = $_GET['totext_y'];
    $totextsize = $_GET['totext_size'];
    $messageX = $_GET['message_x'];
    $messageY = $_GET['message_y'];
    $messagesize = $_GET['message_size'];
    $fromtextX = $_GET['fromtext_x'];
    $fromtextY = $_GET['fromtext_y'];
    $fromtextsize = $_GET['fromtext_size']; 
    $totextwidth = $_GET['totextwidth'];
    $messagewidth = $_GET['messagewidth'];
    $fromtextwidth = $_GET['fromtextwidth'];
    $archive = $_GET['archive'];

    if (empty($archive)) {$archive = 0;}
    if (empty($bezel)) {$bezel = 0;}

    $sqlupdate = "UPDATE billboards SET
    canvas_pos_x = '$innercanvas_X',
    canvas_pos_y = '$innercanvas_Y',
    canvas_width = '$innercanvas_W',
    canvas_height = '$innercanvas_H',
    billboard_width = '$billboardcanvas_W',
    billboard_height = '$billboardcanvas_H',
    billboard_color = '$billboard_color',
    locationid = '$locationid',
    physicallocation = '$physicallocation',
    billboardcode1 = '$billboardcode1',
    bezel = '$bezel',
    totextX = '$totextX',
    totextY = '$totextY',
    totextsize = '$totextsize',
    messageX = '$messageX',
    messageY = '$messageY',
    messagesize = '$messagesize',
    fromtextX = '$fromtextX',
    fromtextY = '$fromtextY',
    fromtextsize = '$fromtextsize',
    totextwidth = '$totextwidth', 
    messagewidth = '$messagewidth', 
    fromtextwidth = '$fromtextwidth', 
    archive = '$archive'

    WHERE idbillboard = '$id' ";

    if ($link->query($sqlupdate) === TRUE) {
	  header("Location: editbillboard.php?idcampaign=$campaignid&idbillboard=$id#coordinates");
    } else {
      echo "Error updating record: " . $link->error;
    }


// Close connection
mysqli_close($link);
?>
