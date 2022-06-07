<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
if (isset($_GET['idcampaign'])) {$idcampaign = $_GET['idcampaign'];}
if (isset($_POST['idcampaign'])) {$idcampaign = $_POST['idcampaign'];}
?>


<?php

//save array of messages
if (isset($_POST["savemessages"])) {
  $_GET['idcampaign'] = $idcampaign;
  $billboardmessages = $_POST['billboardmessages'];
  $sqlupdate = "UPDATE tractorcampaigns SET billboardmessages = '".addslashes($billboardmessages)."'
  WHERE id = '$idcampaign' ";


  if(mysqli_query($link, $sqlupdate)){
    //header("Location: editcampaign.php?idcampaign=$idcampaign");
    $response = array(
        "type" => "success",
        "message" => "Your photo uploaded successfully."
    );
  }else{
    $response = array(
        "type" => "error",
        "message" => "Unable to save your messages." //.$sqlupdate. " - " . mysqli_error($link)
    );
  }
}

?>




<?php

// Query Campaigns table

$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE id = '$idcampaign'";

if($resultcampaign = mysqli_query($link, $sqlcampaign)) {

    if(mysqli_num_rows($resultcampaign) > 0) {

    while ($rowcampaign = mysqli_fetch_array($resultcampaign)){
      $campaign = $rowcampaign['campaign'];
      $message = $rowcampaign['message'];
      $message_brief = $rowcampaign['message_brief'];
      $message_more_toggle= $rowcampaign['message_more_toggle'];
      $message_more = $rowcampaign['message_more'];
      $terms_conditions = $rowcampaign['terms_conditions'];
      $billboard_backgroundcolor = $rowcampaign['campaign_backgroundcolor'];
      $billboardmessages = $rowcampaign['billboardmessages'];
      $exiturl = $rowcampaign['exiturl'];
      $exiturl_toggle = $rowcampaign['exiturl_toggle'];
      $share_url = $rowcampaign['share_url'];
      $share_description = $rowcampaign['share_description'];
      $instructions = $rowcampaign['instructions'];
      $copyline_toggle= $rowcampaign['copyline_toggle'];
    }

}
    // Free result set
    mysqli_free_result($resultcampaign);
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
          <h1>EDIT CAMPAIGN - <?php echo $campaign; ?></h1>
    </div>

    <div class="breadcrumbs">

      <a href="campaigns.php">< BACK TO CAMPAINGS</a>
    </div>

  </section>






<div class="mycolgroup">

          <div class="container left">

            <div class="center darkrow" style="min-height: 80px;">
            UPDATE CAMPAIGN DETAIL
            </div>

            <div class="center lightrow">


                <form action="updatecampaign.php" method="post">


                <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">

                Campaign Name: <br><textarea name="campaign" type="text" id="campaign" cols="80" rows="1"><?php echo $campaign ;?></textarea>

                <br>

                Campaign Message: <br><textarea name="message" type="text" id="campaignmessage" cols="80" rows="5"><?php echo $message ;?></textarea>

                <br>

                Campaign Brief: <br><textarea name="message_brief" type="text" id="campaignbrief" cols="80" rows="5"><?php echo $message_brief;?></textarea>

                <br><br><br>

                Toggle Campaign More: <input name="message_more_toggle" type="checkbox" id="message_more_toggle" value="1" <?php if ($message_more_toggle == "1") { ?>checked="checked"<?php } ?>>

                <br>

                Campaign More: <br><textarea name="message_more" type="text" id="idcampaign" cols="80" rows="5"><?php echo $message_more ;?></textarea>

                <br><br><br>

                Toggle Exit URL: <input name="exiturl_toggle" type="checkbox" id="exiturl_toggle" value="1" <?php if ($exiturl_toggle == "1") { ?>checked="checked"<?php } ?>>

                <br>

                Exit URL: <br><input name="exiturl" type="text" id="exiturl" cols="80" value="<?php echo $exiturl ;?>">

                <br><br><br>

                Share URL: <br><input name="share_url" type="text" id="exiturl" cols="80" value="<?php echo $share_url ;?>">

                <br>

                Share Description: <br><textarea name="share_description" type="text" id="share_description" cols="80" rows="5"><?php echo $share_description ;?></textarea>

                <br><br><br>

                Campaign Terms & Conditions: <br><textarea name="campaignterms" type="text" id="idcampaign" cols="80" rows="5"><?php echo $terms_conditions ;?></textarea>

                <br><br><br>

                Campaign Instructions: <br><textarea name="instructions" type="text" id="instructions" cols="80" rows="5"><?php echo $instructions ;?></textarea>

                <br><br>

                Campaign Billboard Background Color:

                <link href="css/sticky.css" rel="stylesheet" type="text/css">
                <script src="js/html5kellycolorpicker.min.js"></script>


                 <div class="css-script-center">
                  <div class="css-script-clear"></div>
                  </div>


                <div style="padding:20px;">
            		<canvas id="picker"></canvas><br>
                    <input id="color" value="<?php echo $billboard_backgroundcolor; ?>" name='billboard_color'>
                    <script>
                        new KellyColorPicker({place : 'picker', input : 'color', size : 150});
                    </script>
                </div>

                <br><br><br>

                Billboard has a copyline: <input name="copyline_toggle" type="checkbox" id="copyline_toggle" value="1" <?php if ($copyline_toggle == "1") { ?>checked="checked"<?php } ?>>

                <br><br>

                <input type="submit" value="UPDATE CAMPAIGN">



              </form>


              </div>






              <div class="center lightrow">
              <form id="frm-billboardmessage-save" action="editcampaign.php" name='img' method="post" enctype="multipart/form-data">
                  <div style="text-align: center; width:300px; margin:auto;">
                      BILLBOARD MESSAGES: <br>
                      One message per line:
                      <br><br>


                      <textarea id='billboardmessages' name= 'billboardmessages' style='width: 100%; height: 200px;' ><?php echo $billboardmessages ;?></textarea><br><br>
                      <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">
                      <input name="bmessage" type="hidden" id="bmessage" value="1">
                      <input class="" type="submit" id="btn-submit" name="savemessages" value="SAVE MESSAGES"><br><br>
                  </div>
              </form>
            </div>








              <div class="center lightrow">

                  <div style="margin:auto; text-align:left; width:400px; background-color: #777; padding:10px;">
                  Manage text message on billboards:
                  </div>

                  <div style="margin:auto; text-align:left; width:400px; background-color:#999; border-bottom:1px; border-color:#777; padding:10px;">

                  <a href="insertcopyline.php?idcampaign=<?php echo $idcampaign; ?>">Insert copyline</a><br><br>

                  <table width="100%" padding="5px;">
                  <thead>
                  <tr>
                  <th>Copyline</th>
                  <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>



                  <?php
        					// Query and display copylines
        					$sqlcopylines = "SELECT * FROM campaign_copylines WHERE idcampaign = '$idcampaign' ";
        					if($resultcopylines = mysqli_query($link, $sqlcopylines)){
        					    if(mysqli_num_rows($resultcopylines) > 0){
        							while($rowcopylines = mysqli_fetch_array($resultcopylines)){ ?>

                        <tr>

                        <form action="updatecopyline.php" method="post">
                        <td>
                        <input type="hidden" name="idcopyline" id="idcopyline" value="<?php echo $rowcopylines["idcopyline"]; ?>">
                        <input type="hidden" name="idcampaign" id="idcampaign" value="<?php echo $idcampaign; ?>">
                        <input type="text" name="copyline" id="copyline" value="<?php echo $rowcopylines["copyline"]; ?>" style="width:200px; margin:5px;"></td>
                        <td><button type="submit" id="update">UPDATE</button></td>
                        <td align="center"><a href="deletecopyline.php?idcampaign=<?php echo $idcampaign;?>&idcopyline=<?php echo $rowcopylines['idcopyline']?>">Delete</a></td>
                        </form>

                        </tr>

        							<?php }
        					        // Free result set
        					        mysqli_free_result($resultcopylines);
        					    }
        					}
        					?>

                  </tbody>
                  </table>

                  </div>




                  <div class="center lightrow">

                      <div style="margin:auto; text-align:left; width:400px; background-color: #777; padding:10px;">
                      Message email rejection copylines:
                      </div>

                      <div style="margin:auto; text-align:left; width:400px; background-color:#999; border-bottom:1px; border-color:#777; padding:10px;">

                      <a href="insertrejectioncopyline.php?idcampaign=<?php echo $idcampaign; ?>">Insert copyline</a><br><br>

                      <table width="100%" padding="5px;">
                      <thead>
                      <tr>
                      <th>Copyline</th>
                      <th>Update</th>
                      </tr>
                      </thead>
                      <tbody>



                      <?php
                      // Query and display copylines
                      $sqlcopylines = "SELECT * FROM campaign_rejectlines WHERE idcampaign = '$idcampaign' ";
                      if($resultcopylines = mysqli_query($link, $sqlcopylines)){
                          if(mysqli_num_rows($resultcopylines) > 0){
                          while($rowcopylines = mysqli_fetch_array($resultcopylines)){ ?>

                            <tr>

                            <form action="updaterejectioncopyline.php" method="post">
                            <td>
                            <input type="hidden" name="id" id="id" value="<?php echo $rowcopylines["id"]; ?>">
                            <input type="hidden" name="idcampaign" id="idcampaign" value="<?php echo $idcampaign; ?>">
                            <textarea name="rejectline" rows="3" id="rejectcopyline" style="width:200px"><?php echo $rowcopylines["rejectline"]; ?></textarea></td>
                            <td><button type="submit" id="update">UPDATE</button></td>
                            <td align="center"><a href="deleterejectioncopyline.php?idcampaign=<?php echo $idcampaign;?>&id=<?php echo $rowcopylines['id']?>">Delete</a></td>
                            </form>

                            </tr>

                          <?php }
                              // Free result set
                              mysqli_free_result($resultcopylines);
                          }
                      }
                      ?>

                      </tbody>
                      </table>

                      </div>




              </div>



      </div>
</div>

<?php
  // Close connection
  mysqli_close($link);
?>




</body>
</html>
