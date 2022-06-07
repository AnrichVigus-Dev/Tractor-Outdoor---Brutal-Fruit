<?php
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

    $idcampaign = $_POST['idcampaign'];
    $campaign = mysqli_real_escape_string($link, $_POST['campaign']);
    $message = mysqli_real_escape_string($link, $_POST['message']);
    $message_brief = mysqli_real_escape_string($link, $_POST['message_brief']);
    $message_more = mysqli_real_escape_string($link, $_POST['message_more']);
    $message_more_toggle = $_POST['message_more_toggle'];
    $campaignterms = mysqli_real_escape_string($link, $_POST['campaignterms']);
    $billboard_color = $_POST['billboard_color'];
    $exiturl = mysqli_real_escape_string($link, $_POST['exiturl']);
    $exiturl_toggle = $_POST['exiturl_toggle'];
    $share_url = mysqli_real_escape_string($link, $_POST['share_url']);
    $share_description = mysqli_real_escape_string($link, $_POST['share_description']);
    $instructions = mysqli_real_escape_string($link, $_POST['instructions']);
    $copyline_toggle = $_POST['copyline_toggle'];

    if (empty($message_more_toggle)) {$message_more_toggle = 0;}
    if (empty($exiturl_toggle)) {$exiturl_toggle = 0;}
    if (empty($copyline_toggle)) {$copyline_toggle = 0;}

    $sqlupdate = "UPDATE tractorcampaigns SET
    campaign = '$campaign',
    message = '$message',
    message_brief = '$message_brief',
    message_more = '$message_more',
    message_more_toggle = '$message_more_toggle',
    terms_conditions = '$campaignterms',
    campaign_backgroundcolor = '$billboard_color',
    exiturl = '$exiturl',
    exiturl_toggle = '$exiturl_toggle',
    share_url = '$share_url',
    share_description = '$share_description',
    instructions = '$instructions',
    copyline_toggle = $copyline_toggle

    WHERE id = $idcampaign ";

    if ($link->query($sqlupdate) === TRUE) {
       header("Location: campaigns.php");
    } else {
    echo "Error updating record: " . $link->error;
    }

// Close connection
mysqli_close($link);
?>
