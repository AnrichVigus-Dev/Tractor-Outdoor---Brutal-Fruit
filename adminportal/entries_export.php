<?php
session_start();
include_once('../connections/tractordbcon.php');
$_GET['idcampaign'] = 1;
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Untitled Document</title>

<!-- Bootstrap CDN -->

<style>
body, table, th, td .sansserif {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 8px;
}
h1 {font-size: 8px;}

.breadcrumbs {
  padding: 0 25px;
  text-align: left;
}

.container {
  margin: auto;
}

.center {
  margin: auto;
  width: 100%;
  border: 0px solid #fff;
  padding: 25px;
  text-align: center;
}

.left {
  margin: auto;
  width: 100%;
  border: 0px solid #fff;
  padding: 25px;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

table, th, td {
  border: 0px solid #4CAF50;
}

th {
  height: 25px;
}

th {
  background-color: #777;
  color: white;
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

tr:hover {
	background-color: #f5f5f5;
	}
/*tr:nth-child(even) {
	background-color: #f2f2f2;
	}
*/


/* CUSTOM SELECT The container must be positioned relative: */
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element: */
}

.select-selected {
  background-color: #777;
}

/* Style the arrow inside the select element: */
.select-selected:after {
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

/* Point the arrow upwards when the select box is open (active): */
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/* style the items (options), including the selected item: */
.select-items div,.select-selected {
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
}

/* Style items (options): */
.select-items {
  position: absolute;
  background-color: #777;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 99;
}

/* Hide the items when the select box is closed: */
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}

</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


</head>

<body>

<section>
<div style="overflow-x:auto;" class="container center">



<table>
        <tr>
            <th width="7%">id</th>
            <th width="7%">name</th>
            <th width="7%">email</th>
            <th width="7%">location</th>
            <th width="7%">billboardcode</th>
            <th width="7%">billboardlocation</th>
            <th width="7%">billboardmessage</th>
            <th width="7%">fromname</th>
            <th width="7%">toname</th>
            <th width="7%">displayfilename</th>
            <th width="7%">uniquesession</th>
            <th width="7%">dateofbirth</th>
            <th width="7%">datetime</th>
            <th width="7%">status</th>
        </tr>

<?php

$sqluser = "SELECT * FROM tractorusers ORDER BY id ASC";

if($resultuser = mysqli_query($link, $sqluser)) {

    if(mysqli_num_rows($resultuser) > 0) { ?>

		<?php while ($rowuser = mysqli_fetch_array($resultuser)){

      //Obtain billboard for this user
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

            echo "<tr>";
                echo "<td width=\"7%\">" . $rowuser['id'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['name'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['email'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['idlocation'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['idbillboard'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['idbillboard'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['billboardmessage'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['fromname'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['toname'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['displayfilename'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['uniquesession'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['datetime'] . "</td>";
                echo "<td width=\"7%\">" . $rowuser['dateofbirth'] . "</td>";
                if ($rowuser['status'] == 0) { echo "<td style=\"text-align:center; background-color:#cb5b00; color:#fff;\" width=\"10%\">Awaiting Approval</td>";}
                if ($rowuser['status'] == 1) { echo "<td style=\"text-align:center; background-color:#4879b2; color:#fff;\" width=\"10%\">Approved</td>";}
                if ($rowuser['status'] == 2) {  echo "<td style=\"text-align:center; background-color:#ddd; color:#fff;\" width=\"10%\">Declined</td>"; };
            echo "</tr>";
        }

		}
     //$_SESSION['startrownumber'] = $startrownumber / $mycountend + 1;
        // Free result set
        mysqli_free_result($resultuser);
    }

// Close connection
mysqli_close($link);

echo "</table>";
?>




</body>
</html>
