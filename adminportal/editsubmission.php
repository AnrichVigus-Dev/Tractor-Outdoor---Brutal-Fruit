<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
?>

<?php
$idcampaign = $_SESSION['idcampaign'];

// Query campaign selected
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE id = '$idcampaign'";
if($resultcampaign = mysqli_query($link, $sqlcampaign)){
    if(mysqli_num_rows($resultcampaign) > 0){
		while($rowcampaign = mysqli_fetch_array($resultcampaign)){
			$campaign = $rowcampaign['campaign'];
      $campaignbasename = $rowcampaign['modrewritename'];
		}

        // Free result set
        mysqli_free_result($resultcampaign);
    }
}
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Untitled Document</title>

<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
  height: 170px;
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

label.label1 {
  background-color: #4879b2; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

label.label2 {
  background-color: red; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

.visually-hidden-accept {
    position: absolute;
    left: -100vw;
}

.visually-hidden-reject {
    position: absolute;
    left: -100vw;
}

</style>

</head>

<body>

<section>
  <div class="container left">
        <h1><?php echo $campaign; ?> - Moderate Submission</h1>
  </div>

  <div class="breadcrumbs">
    <a href="<?php echo $_SESSION['uri_query'];?>">< BACK TO SUBMISSIONS</a>
  </div>

</section>


<?php
// Query User table

$userid = $_GET['id'];

$sqluser = "SELECT tractorusers.id, tractorusers.name, tractorusers.email, tractorusers.company, tractorusers.location, tractorusers.datetime, tractorusers.idbillboard, tractorusers.compositfilename, tractorusers.insitufilename, tractorusers.status, locations.location AS locations, fromname, toname, billboardmessage FROM tractorusers INNER JOIN locations ON tractorusers.idlocation = locations.id WHERE tractorusers.id = '$userid'";

if($resultuser = mysqli_query($link, $sqluser)) {

    if(mysqli_num_rows($resultuser) > 0) {

		while($rowuser = mysqli_fetch_array($resultuser)){
      $status = $rowuser['status'];

$idbillboard = $rowuser['idbillboard'];
$sqlbillboards = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
if($resultbillboards = mysqli_query($link, $sqlbillboards)){
    if(mysqli_num_rows($resultbillboards) > 0){
   while($rowbillboards = mysqli_fetch_array($resultbillboards)){
   $billboardcode = $rowbillboards['billboardcode1'];
 }
         // Free result set
         mysqli_free_result($resultbillboards);
     }
 }
 ?>

<section>

<div class="mycolgroup">

  <div class="container left">

    <div class="darkrow" style="min-height: 80px;">
      <div class="splitleft">
        <strong>Visitor Name:</strong> <?php echo $rowuser['name']; ?>
      </div>
      <div class="splitright"><strong>Submission date:</strong> <?php echo $rowuser['datetime']; ?></div>
    </div>

    <div class="left lightrow"><strong>Visitor's Creative:</strong></div>

    <?php if ($status <> 1) { ?>
    <div class="left lightrow"><?php echo "<img src=\"../usercomposits/" . $rowuser['compositfilename']. '?'. date('His')  . "\" width=\"700px\">"; ?></div>
    <?php } else { ?>
    <div class="left lightrow">
      <?php
      //echo "<img src=\"../approvedcomposits/". $campaignbasename ."/". $billboardcode ."/". $rowuser['displayfilename'] . "\" width=\"700px\">";
      echo "<img src=\"../usercomposits/" . $rowuser['insitufilename']. '?'. date('His') . "\" width=\"700px;\">";
      ?></div>
    <?php }  ?>

    <div class="left altrow"><strong>Email:</strong> <?php echo $rowuser['email']; ?></div>

    <div class="left lightrow"><strong>To Name:</strong> <?php echo $rowuser['toname']; ?></div>
    <div class="left lightrow"><strong>Message:</strong> <?php echo $rowuser['billboardmessage']; ?></div>
    <div class="left lightrow"><strong>From Name:</strong> <?php echo $rowuser['fromname']; ?></div>

    <div class="left altrow"><strong>Sending to:</strong> <?php echo $rowuser['locations']; ?></div>

    <div class="left lightrow"><strong>Billboard: <?php echo $billboardcode; ?></strong>

      </div>

    <div class="left altrow"><strong>In situ preview:</strong></div>

    <div class="left lightrow"><?php echo "<img src=\"../usercomposits/" . $rowuser['insitufilename']. '?'. date('His')  . "\" width=\"700px;\">"; ?>
      <br/>&nbsp;

     <form name="frmRebuildInsitu" action="">
       <center><label for="toggle3" class="label1">RECREATE IN SITU</label></center>
       <input type="checkbox" id="toggle3" class="visually-hidden-accept" >
       <div class="row" id="rebuildinsitu" style="display: none; text-align: center;">
       Are you sure? <a href="action_rebuildinsitu.php?id=<?php echo $userid;?>" onclick="document.getElementById('frmRebuildInsitu').submit();">PROCEED</a>
     </div>
     </form>

                   <script type="text/javascript">
                       $(function () {
                        var x = document.getElementById("rebuildinsitu");
                           $("#toggle3").click(function () {
                               if ($(this).is(":checked")) {
                          if (x.style.display === "none") {x.style.display = "block";}
                               } else {
                                   x.style.display = "none";
                               }
                           });
                       });
                   </script>

    </div>


    </div>
</div>

</section>


<section style="margin-top: -25px;">

  <div class="mycolgroup">

    <div class="container left">

<?php if ((empty($status)) || ($status == "0"))  { ?>

      <div class="footer">

               <div class="splitleft" style="text-align: center;">

                   <script type="text/javascript">
                       $(function () {
                   		  var x = document.getElementById("acceptcreative");
                           $("#toggle").click(function () {
                               if ($(this).is(":checked")) {
                   				if (x.style.display === "none") {x.style.display = "block";}
                               } else {
                                   x.style.display = "none";
                               }
                           });
                       });
                   </script>


                   <form name="myFormaccept" action="approve_submission.php">
                     <label for="toggle" class="label1">ACCEPT CREATIVE</label>
                     <input type="checkbox" id="toggle" class="visually-hidden-accept" >
                     <div class="row" id="acceptcreative" style="display: none; text-align: center;">
                     Are you sure? <a href="actionsubmission.php?status=1&id=<?php echo $userid;?>&idrejectline=0" onclick="document.getElementById('myFormaccept').submit();">PROCEED</a>
                   </div>
                   </form>
                </div>


                <div class="splitright" style="text-align: center;">

                   <script type="text/javascript">
                       $(function () {
                   		  var x = document.getElementById("rejectcreative");
                           $("#toggle2").click(function () {
                               if ($(this).is(":checked")) {
                   				if (x.style.display === "none") {x.style.display = "block";}
                               } else {
                                   x.style.display = "none";
                               }
                           });
                       });
                   </script>



                     <label for="toggle2" class="label2">REJECT CREATIVE</label>
                     <input type="checkbox" id="toggle2" class="visually-hidden-reject" >

                    <form name="myFormreject" action="actionsubmission.php">
                     <div class="row" id="rejectcreative" style="display: none; text-align: center;">

                      <br>


                      <style>
                      select {
                        width: 300px;
                        overflow: hidden;
                        white-space: pre;
                        text-overflow: ellipsis;
                        -webkit-appearance: none;
                      }

                      option {
                        border: solid 1px #DDDDDD;
                      }
                      </style>


                       <select id="idrejectline" name="idrejectline" class="dropdown">
               					<option value="unselected" selected>SELECT MESSAGE TO APPEAR:</option>

               					<?php
               					// Query and display Locations
               					$sqlrejectlines = "SELECT * FROM campaign_rejectlines WHERE idcampaign = '$idcampaign' ";
               					if($resultrejectlines = mysqli_query($link, $sqlrejectlines)){
               					    if(mysqli_num_rows($resultrejectlines) > 0){
               							while($rowrejectlines = mysqli_fetch_array($resultrejectlines)){ ?>

               							<option value="<?php echo $rowrejectlines['id']?>"><?php echo $rowrejectlines['rejectline'] ?></option>

               							<?php }

               					        // Free result set
               					        mysqli_free_result($resultrejectlines);
               					    }
               					}
               					?>
               				</select>

                      <br>

                      <input type="hidden" name="id" id="id" value="<?php echo $userid;?>">
                      <input type="hidden" name="status" id="status" value="2">

                      <style>
                      .submitLink {
                        background-color: transparent;
                        text-decoration: underline;
                        border: none;
                        color: blue;
                        cursor: pointer;
                      }
                      submitLink:focus {
                        outline: none;
                      }
                      </style>

                        Are you sure? <input name="Submit" type="submit" id="submitLink" class="submitLink" value="PROCEED">

                   </div>
                   </form>
                 </div>
        </div>

      </div>

<?php } else if ($status == "1") { ?>

  <div class="footer">

           <div style="text-align: center;">
               <script type="text/javascript">
                   $(function () {
                    var x = document.getElementById("acceptcreative");
                       $("#toggle").click(function () {
                           if ($(this).is(":checked")) {
                      if (x.style.display === "none") {x.style.display = "block";}
                           } else {
                               x.style.display = "none";
                           }
                       });
                   });
               </script>

<!--
REMOVED UNDO
-->
            </div>


    </div>
  </div>

  <?php } ?>

</div>

<section>

<?php

        }

		}
        // Free result set
        mysqli_free_result($resultuser);
}

// Close connection
mysqli_close($link);
?>


</body>
</html>
