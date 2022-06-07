<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
?>

<?php

//Upload PNG
if (isset($_POST["upload"])) {
    $idcampaign = $_POST['idcampaign'];

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
    //$target = "useruploads/" . basename($_FILES["file-input"]["name"]);
    $target = "../images/campaignimages/1/" . $newfilename.".".$file_extension;
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {

// Attempt insert query execution

$insitufilename = $newfilename.".".$file_extension;

$sqlupdate = "UPDATE tractorcampaigns SET
billboard_logo = '$insitufilename'

WHERE id = '$idcampaign' ";

      if(mysqli_query($link, $sqlupdate)){

      header("Location: editcampaign.php?idcampaign=$idcampaign");
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


  // Close connection
  mysqli_close($link);

?>
