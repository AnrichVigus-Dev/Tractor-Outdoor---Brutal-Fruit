<?php
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');

    $userid = $_GET['id'];
    $status = $_GET['status'];

// Query User

    $sqluser = "SELECT tractorusers.id, tractorusers.idcampaign, tractorusers.name, tractorusers.email, tractorusers.location, tractorusers.datetime, tractorusers.uploadfilename,tractorusers.idbillboard, tractorusers.displayfilename, locations.location AS billboardlocation FROM tractorusers INNER JOIN locations ON tractorusers.idlocation = locations.id WHERE tractorusers.id = '$userid'";
    if($resultuser = mysqli_query($link, $sqluser)) {

        if(mysqli_num_rows($resultuser) > 0) {
    		while($rowuser = mysqli_fetch_array($resultuser)){

          $name = $rowuser['name'];
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

  $source_file = '../approvedcomposits/'.$campaignbasename.'/'.$billboardcode.'/'.$displayfilename;
  $destination_path = '../usercomposits/'.$displayfilename;
  //rename($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME));
  rename($source_file, $destination_path);

header("Location: submissions.php?idcampaign=$idcampaign");
} else {
echo "Error updating record: " . $link->error;
}

// Close connection
mysqli_close($link);
?>
