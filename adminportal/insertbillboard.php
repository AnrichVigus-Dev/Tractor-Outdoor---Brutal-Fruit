<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

    $locationid = "1";
    $physicallocation = "Update";
    $idcampaign = $_GET['idcampaign'];
    $innercanvas_X = "119";
    $innercanvas_Y = "0";
    $innercanvas_W = "361";
    $innercanvas_H = "240";
    $billboardcanvas_W = "480";
    $billboardcanvas_H = "240";
    $insituexample_filename = "insituexample.png";
    //$elementsswitch = $_GET['elementsswitch'];
    $bezel = "0";
    $billboard_color = "#f7335d";
    $billboardcode1 = "Update";
    $billboardcode2 = "Update";
    $archive = "1";
    //Brutal Layout Fields
    $fromtextX = "0";
    $fromtextY = "0";
    $fromtextsize = "0";
    $messageX = "0";
    $messageY = "0";
    $messagesize = "0";
    $totextX = "0";
    $totextY = "0";
    $totextsize = "0";

    $sql = "INSERT INTO billboards (campaignid, billboard_insitu_example, canvas_pos_x, canvas_pos_y, canvas_width, canvas_height, billboard_width, billboard_height, billboard_color, locationid, physicallocation, billboardcode1, billboardcode2, bezel, archive, fromtextX, fromtextY, fromtextsize, messageX, messageY, messagesize, totextX, totextY, totextsize) VALUES
('$idcampaign', '$insituexample_filename', '$innercanvas_X', '$innercanvas_Y', '$innercanvas_W', '$innercanvas_H', '$billboardcanvas_W', '$billboardcanvas_H', '$billboard_color', '$locationid', '$physicallocation', '$billboardcode1', '$billboardcode2', '$bezel', '$archive', '$fromtextX', '$fromtextY', '$fromtextsize', '$messageX', '$messageY', '$messagesize', '$totextX', '$totextY', '$totextsize')";
			if(mysqli_query($link, $sql)){

			header("Location: billboards.php?idcampaign=$idcampaign");
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
?>
