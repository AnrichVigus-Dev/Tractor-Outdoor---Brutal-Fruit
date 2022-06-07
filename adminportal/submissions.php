<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
?>

<?php
//$_SESSION['uri_query'] = $_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"];
$_SESSION['uri_query'] = $_SERVER["REQUEST_URI"];
if (isset($_GET['idcampaign'])) {
$_SESSION['idcampaign'] = $_GET['idcampaign'];}
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
echo $rowcampaign['campaign'];
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
body, table, th, td .sansserif {
  font-family: Arial, Helvetica, sans-serif;
}
h1 {font-size: 22px;}

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
  height: 50px;
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
  <div class="container left">
    <h1><?php echo strtoupper($campaign); ?> SUBMISSIONS</h1>
  </div>

  <div class="breadcrumbs">
    <a href="campaigns.php">< BACK TO CAMPAIGN SELECT</a>
  </div>

</section>

<section>
<div style="overflow-x:auto;" class="container center">

<?php
//Query User mysql_list_tables

  // 1 Get total records

  if (isset($_GET['page_no']) && $_GET['page_no']!="") {
  	$page_no = $_GET['page_no'];
  	} else {
  		$page_no = 1;
          }

  $total_records_per_page = 10;
  $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";



  // Query User table for row count
  if (!isset($_GET['orderby'])) {$_GET['orderby'] = 0;}

  if ($_GET['orderby'] == 0) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '') AND idcampaign = '$idcampaign' ORDER BY id DESC");
  }
  else if ($_GET['orderby'] == 1) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' ORDER BY id DESC");
  }
  else if ($_GET['orderby'] == 2) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' ORDER BY id ASC");
  }
  else if ($_GET['orderby'] == 3) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '0' ORDER BY id DESC ");
  }
  else if ($_GET['orderby'] == 4) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '0' ORDER BY id ASC");
  }
  else if ($_GET['orderby'] == 5) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '1' ORDER BY id ASC");
  }
  else if ($_GET['orderby'] == 6) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '1' ORDER BY id DESC");
  }
  else if ($_GET['orderby'] == 7) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '2' ORDER BY id ASC");
  }
  else if ($_GET['orderby'] == 8) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '2' ORDER BY id DESC");
  }

  $orderby = $_GET['orderby'];
	//$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorusers` WHERE idcampaign = '$idcampaign'");



	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

?>

<table>
        <tr>
            <th width="15%">VISITOR NAME</th>
            <th width="15%">EMAIL</th>
            <th width="10%">COMPANY</th>
            <th width="20%">PHOTO</th>
            <th width="15%">DATE SUBMITTED</th>
            <th style="text-align:center; background-color:#777;" width="10%">

            <div class="custom-select" style="width:200px;">
            <form id="form" action="" method="get">
            <select id="orderby" name="orderby" onchange="javascript:$('#submit').click();">
              <option value="0" <?php if ($_GET['orderby'] == 0) { ?> selected="selected" <?php } ?> >FILTER STATUS</option>
              <option value="1" <?php if ($_GET['orderby'] == 1) { ?> selected="selected" <?php } ?> >ALL ENTRIES ASC</option>
              <option value="2" <?php if ($_GET['orderby'] == 2) { ?> selected="selected" <?php } ?> >ALL ENTRIES DESC</option>
              <option value="3" <?php if ($_GET['orderby'] == 3) { ?> selected="selected" <?php } ?> >PENDING ASC</option>
              <option value="4" <?php if ($_GET['orderby'] == 4) { ?> selected="selected" <?php } ?> >PENDING DESC</option>
              <option value="5" <?php if ($_GET['orderby'] == 5) { ?> selected="selected" <?php } ?> >APPROVED ASC</option>
              <option value="6" <?php if ($_GET['orderby'] == 6) { ?> selected="selected" <?php } ?> >APPROVED DESC</option>
              <option value="7" <?php if ($_GET['orderby'] == 7) { ?> selected="selected" <?php } ?> >DECLINED ASC</option>
              <option value="8" <?php if ($_GET['orderby'] == 8) { ?> selected="selected" <?php } ?> >DECLINED DESC</option>

            </select>
            <button id="submit" class="hidden" type="submit" name="submit" value="Submit" />
            </form>
            </div>

            </th>
            <th style="text-align:center;" width="15%">MODERATION</th>
        </tr>

<?php

// 2 Query User table

if ($_GET['orderby'] == 0) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '') AND idcampaign = '$idcampaign' ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 1) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 2) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' ORDER BY id ASC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 3) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '0' ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 4) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '0' ORDER BY id ASC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 5) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '1' ORDER BY id ASC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 6) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '1' ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 7) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '2' ORDER BY id ASC LIMIT $offset, $total_records_per_page";
}
else if ($_GET['orderby'] == 8) {
$sqluser = "SELECT * FROM tractorusers WHERE (insitufilename != '' OR compositfilename != '' ) AND idcampaign = '$idcampaign' AND status = '2' ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}

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
                echo "<td width=\"15%\">" . $rowuser['name'] . "</td>";
                echo "<td width=\"15%\">" . $rowuser['email'] . "</td>";
                echo "<td width=\"10%\">" . $rowuser['company'] . "</td>";
                ?>

                <td width="20%">
                <div>
                  <?php
                  if ($rowuser['status'] == 1) {
                  echo "<img src=\"../usercomposits/" . $rowuser['insitufilename'] . "\" width=\"150px;\">";
                  } else {
                  echo "<img src=\"../usercomposits/" . $rowuser['compositfilename'] . "\" width=\"150px\">";
                  }
                  ?>
                </div>
                </td>

                <?php
                echo "<td width=\"15%\">" . $rowuser['datetime'] . "</td>";
                if ($rowuser['status'] == 0) { echo "<td style=\"text-align:center; background-color:#cb5b00; color:#fff;\" width=\"10%\">Awaiting Approval</td>";}
                if ($rowuser['status'] == 1) { echo "<td style=\"text-align:center; background-color:#4879b2; color:#fff;\" width=\"10%\">Approved</td>";}
                if ($rowuser['status'] == 2) {  echo "<td style=\"text-align:center; background-color:#ddd; color:#fff;\" width=\"10%\">Declined</td>"; };

		            echo "<td style=\"text-align:center; background-color:#FFF;\" width=\"15%\"><a href=\"editsubmission.php?id=" . $rowuser['id'] . "\">VIEW SUBMISSION</a></td>";
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


<div class="center">

  <div style='padding: 10px 20px 0px;'>

      <?php echo $total_records; ?> Records | Page <strong><?php echo $page_no."</strong> of <strong>".$total_no_of_pages; ?></strong>
  </div>

  <ul class="pagination">
  	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>

  	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
  	<a <?php if($page_no > 1){ echo "href='?idcampaign=$idcampaign&page_no=$previous_page&orderby=$orderby'"; } ?>>Previous</a>
  	</li>

      <?php
  	if ($total_no_of_pages <= 10){
  		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter&orderby=$orderby'>$counter</a></li>";
  				}
          }
  	}
  	elseif($total_no_of_pages > 10){

  	if($page_no <= 4) {
  	 for ($counter = 1; $counter < 8; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter&orderby=$orderby'>$counter</a></li>";
  				}
          }
  		echo "<li><a>...</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$second_last&orderby=$orderby'>$second_last</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages&orderby=$orderby'>$total_no_of_pages</a></li>";
  		}

  	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=1&orderby=$orderby'>1</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=2&orderby=$orderby'>2</a></li>";
          echo "<li><a>...</a></li>";
          for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
             if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter&orderby=$orderby'>$counter</a></li>";
  				}
         }
         echo "<li><a>...</a></li>";
  	   echo "<li><a href='?idcampaign=$idcampaign&page_no=$second_last&orderby=$orderby'>$second_last</a></li>";
  	   echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages&orderby=$orderby'>$total_no_of_pages</a></li>";
              }

  		else {
          echo "<li><a href='?idcampaign=$idcampaign&page_no=1&orderby=$orderby'>1</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=2&orderby=$orderby'>2</a></li>";
          echo "<li><a>...</a></li>";

          for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter&orderby=$orderby'>$counter</a></li>";
  				}
                  }
              }
  	}
  ?>

  	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
  	<a <?php if($page_no < $total_no_of_pages) { echo "href='?idcampaign=$idcampaign&page_no=$next_page&orderby=$orderby'"; } ?>>Next</a>
  	</li>
      <?php if($page_no < $total_no_of_pages){
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages&orderby=$orderby'>Last &rsaquo;&rsaquo;</a></li>";
  		} ?>
  </ul>

</div>

</section>


<script>
var x, i, j, l, ll, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
        $('#submit').click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
</script>

</body>
</html>
