<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

//Include mail params
require 'include/phpmailerconf.php';

    $userid = $_GET['id'];
    $status = $_GET['status'];
    $idrejectline = $_GET['idrejectline'];
    $uri_query = $_SESSION['uri_query'];



// Query User

    $sqluser = "SELECT tractorusers.id, tractorusers.idcampaign, tractorusers.name, tractorusers.fromname, tractorusers.email, tractorusers.location, tractorusers.datetime,tractorusers.idbillboard, tractorusers.displayfilename, locations.location AS billboardlocation FROM tractorusers INNER JOIN locations ON tractorusers.idlocation = locations.id WHERE tractorusers.id = '$userid'";

    if($resultuser = mysqli_query($link, $sqluser)) {

        if(mysqli_num_rows($resultuser) > 0) {
    		while($rowuser = mysqli_fetch_array($resultuser)){

          $name = $rowuser['name'];
          $fromname = $rowuser['fromname'];
          $idcampaign = $rowuser['idcampaign'];
          $to = $rowuser['email'];
          $billboardlocation = $rowuser['billboardlocation'];
          $displayfilename = $rowuser['displayfilename'];

                $idbillboard = $rowuser['idbillboard'];
                $sqlbillboards = "SELECT * FROM billboards WHERE idbillboard = '$idbillboard'";
                if($resultbillboards = mysqli_query($link, $sqlbillboards)){
                    if(mysqli_num_rows($resultbillboards) > 0){
                		while($rowbillboards = mysqli_fetch_array($resultbillboards)){
                    $physicallocation = $rowbillboards['physicallocation'];
                    $billboardcode = $rowbillboards['billboardcode1'];
                 }

                         // Free result set
                         mysqli_free_result($resultbillboards);
                     }
                 }

        }

        // Free result set
        mysqli_free_result($resultuser);
    }
}



// Query and display Locations
$sqlrejectlines = "SELECT * FROM campaign_rejectlines WHERE id = '$idrejectline' ";
if($resultrejectlines = mysqli_query($link, $sqlrejectlines)){
    if(mysqli_num_rows($resultrejectlines) > 0){
    while($rowrejectlines = mysqli_fetch_array($resultrejectlines)){
    $rejectline = $rowrejectlines['rejectline'];
    }
        // Free result set
        mysqli_free_result($resultrejectlines);
    }
}


    // Query campaign selected

    $sqlcampaign = "SELECT * FROM tractorcampaigns WHERE id = '$idcampaign'";
    if($resultcampaign = mysqli_query($link, $sqlcampaign)){

        if(mysqli_num_rows($resultcampaign) > 0){
    		while($rowcampaign = mysqli_fetch_array($resultcampaign)){
    			$campaign = $rowcampaign['campaign'];
          $campaignbasename= $rowcampaign['modrewritename'];
    		}
            // Free result set
            mysqli_free_result($resultcampaign);
        }
    }

//Update User

    $sqlupdate = "UPDATE tractorusers SET
    status='$status'
    WHERE id = '$userid' ";

    if ($link->query($sqlupdate) === TRUE) {


if ($status == 1) {
  //check for campaign folder and create if not exist
  $campaigndirectory = '../approvedcomposits/'.$campaignbasename;
  //echo $campaigndirectory;
  if(!is_dir($campaigndirectory))
  {
     mkdir($campaigndirectory);
  }
  //check for billboard folder and create if not exist
  $fulldirectorymovepath = '../approvedcomposits/'.$campaignbasename.'/'.$billboardcode;
  //echo $fulldirectorymovepath;
  if(!is_dir($fulldirectorymovepath))
  {
     mkdir($fulldirectorymovepath);
  }

  $source_file = '../usercomposits/'.$displayfilename;
  $destination_path = '../approvedcomposits/'.$campaignbasename.'/'.$billboardcode.'/'.$displayfilename;
  rename($source_file, $destination_path);


// Define Mailer Body
$subject = "BRUTAL FRUIT YOU BELONG TO CELEBRATE";
$mailerbody="
<body style=\"font-family: 'Raleway',Arial,Helvetica,sans-serif; font-size: 12px; color: #414042; background: #ebb6b0; margin: 0; width:100% !important; \">
	<table width=\"100%\" border=\"0\" cellpadding=\"20\">
  <tbody>
    <tr>
      <td align=\"center\"><table width=\"600\" style=\"border: 1px solid #ffffff;\" cellpadding=\"30\" cellspacing=\"0\">
        <tbody>
          <tr>
            <td bgcolor=\"#ebb6b0\">
							<img src=\"https://app-cm.azurewebsites.net/images/BFLogoOnly.png\" alt=\"BRUTAL FRUIT\" width=\"100\">
							<p style=\"font-size:21px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">BRUTAL FRUIT YOU BELONG TO CELEBRATE</p>
							<br>
              <p style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">Dear ". $name . "</p>
              <p style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">Thank you!<br>Your ". strtoupper($billboardlocation). ", ". strtoupper($physicallocation). " digital billboard submission has been approved.</p>
              <p>&nbsp;</p>
              <p style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\"><br>
              <a href=\"https://app-cm.azurewebsites.net/previewandshare.php?id=".$userid."&name=".$fromname."\" style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">Click here</a> to view your image.</p>
						</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
  </tbody>
</table>
</body>
";

$mailerbodyplaintext = "BRUTAL FRUIT YOU BELONG TO CELEBRATE - %0A Thank you! Your submission has been approved. . %0A Click here to view your image: <https://app-cm.azurewebsites.net/previewandshare.php?id=".$userid."&name=".$fromname.">";

} else if ($status == 2) {

$subject = "BRUTAL FRUIT YOU BELONG TO CELEBRATE";
  $mailerbody="
  <body style=\"font-family: 'Raleway',Arial,Helvetica,sans-serif; font-size: 12px; color: #414042; background: #ebb6b0; margin: 0; width:100% !important; \">
  	<table width=\"100%\" border=\"0\" cellpadding=\"20\">
    <tbody>
      <tr>
        <td align=\"center\"><table width=\"600\" style=\"border: 1px solid #ffffff;\" cellpadding=\"30\" cellspacing=\"0\">
          <tbody>
            <tr>
              <td bgcolor=\"#ebb6b0\">
  							<img src=\"https://app-cm.azurewebsites.net/images/BFLogoOnly.png\" alt=\"BRUTAL FRUIT\" width=\"100\">
  							<p style=\"font-size:21px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">BRUTAL FRUIT YOU BELONG TO CELEBRATE</p>
  							<br>
                <p style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\">Dear ". $name . "</p>
                <p style=\"font-size:18px; font-family: 'Raleway',Arial,Helvetica,sans-serif;  color:#ffffff;\"><i>". $rejectline . "</i></p>
  						</td>
            </tr>
          </tbody>
        </table>
        </td>
      </tr>
    </tbody>
  </table>
  </body>
  ";
$mailerbodyplaintext = "BRUTAL FRUIT YOU BELONG TO CELEBRATE - %0A" . $rejectline;
  }
}


// send HTML mail with PHPMailer

$mail->addAddress($to); // Add a recipient
$mail->Subject = $subject;
$mail->Body = $mailerbody;
$mail->AltBody = $mailerbodyplaintext;

if(!$mail->send()) {

//echo 'Message could not be sent.'
//echo 'Mailer Error: ' . $mail->ErrorInfo;

} else {
//header("Location: submissions.php?idcampaign=$idcampaign");
header("Location: $uri_query");
//echo 'Message has been sent';
}

// Close connection
mysqli_close($link);
?>
