<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
if (!isset($_SESSION['idcampaign'])) {$_SESSION['idcampaign'] = 1;}
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>BRUTAL FRUIT OUTDOOR CAMPAIGNS</title>

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

.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
}


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

<?php
if (!isset($_GET['orderby'])) {$_GET['orderby'] = 0;}
if ($_GET['orderby'] == 0) {$status = "ALL CAMPAIGNS";}
if ($_GET['orderby'] == 1) {$status = "ALL CAMPAIGNS ASCENDING";}
if ($_GET['orderby'] == 2) {$status = "ALL CAMPAIGNS DESCENDING";}
if ($_GET['orderby'] == 3) {$status = "ACTIVE CAMPAIGNS ASCENDING";}
if ($_GET['orderby'] == 4) {$status = "ACTIVE CAMPAIGNS DESCENDING";}
if ($_GET['orderby'] == 5) {$status = "INACTIVE CAMPAIGNS ASCENDING";}
if ($_GET['orderby'] == 6) {$status = "INACTIVE CAMPAIGNS DESCENDING";}
if ($_GET['orderby'] == 7) {$status = "FUTURE CAMPAIGNS ASCENDING";}
if ($_GET['orderby'] == 8) {$status = "FUTURE CAMPAIGNS DESCENDING";}
?>

    <h1>TRACTOR OUTDOOR ⏤ <?php echo $status; ?></h1>
  </div>

  <div class="breadcrumbs">
    <a href="" class="isDisabled">INSERT NEW CAMPAIGN</a> | <a href="adminlogin.php">LOGOUT</a>
  </div>

</section>

<section style="">
<div style="min-height: 800px;" class="container center">

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


  if ($_GET['orderby'] == 0) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns`");
  }
  if ($_GET['orderby'] == 1) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` ORDER BY id ASC");
  }
  if ($_GET['orderby'] == 2) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` ORDER BY id DESC");
  }
  if ($_GET['orderby'] == 3) {
  $result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '1' ORDER BY ID ASC");
  }
  if ($_GET['orderby'] == 4) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '1' ORDER BY ID DESC");
  }
  if ($_GET['orderby'] == 5) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '2' ORDER BY ID ASC");
  }
  if ($_GET['orderby'] == 6) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '2' ORDER BY ID DESC");
  }
  if ($_GET['orderby'] == 7) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '0' ORDER BY ID ASC");
  }
  if ($_GET['orderby'] == 8) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `tractorcampaigns` WHERE status = '0' ORDER BY ID DESC");
  }


	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

?>

<table>
        <tr>
            <th>CAMPAIGN</th>
            <th width="10%">START DATE</th>
            <th width="10%">END DATE</th>
            <th style="text-align:center; background-color:#777;" width="270px;">

            <div class="custom-select" style="width:250px;">
            <form id="form" action="" method="get">
            <select id="orderby" name="orderby" onchange="javascript:$('#submit').click();">
              <option value="0" <?php if ($_GET['orderby'] == 0) { ?> selected="selected" <?php } ?> >FILTER CAMPAIGN</option>
              <option value="1" <?php if ($_GET['orderby'] == 1) { ?> selected="selected" <?php } ?> >ALL CAMPAIGNS ASC</option>
              <option value="2" <?php if ($_GET['orderby'] == 2) { ?> selected="selected" <?php } ?> >ALL CAMPAIGNS DESC</option>
              <option value="3" <?php if ($_GET['orderby'] == 3) { ?> selected="selected" <?php } ?> >ACTIVE CAMPAIGNS ASC</option>
              <option value="4" <?php if ($_GET['orderby'] == 4) { ?> selected="selected" <?php } ?> >ACTIVE CAMPAIGNS DESC</option>
              <option value="5" <?php if ($_GET['orderby'] == 5) { ?> selected="selected" <?php } ?> >INACTIVE CAMPAIGNS ASC</option>
              <option value="6" <?php if ($_GET['orderby'] == 6) { ?> selected="selected" <?php } ?> >INACTIVE CAMPAIGNS DESC</option>
              <option value="7" <?php if ($_GET['orderby'] == 7) { ?> selected="selected" <?php } ?> >FUTURE CAMPAIGNS ASC</option>
              <option value="8" <?php if ($_GET['orderby'] == 8) { ?> selected="selected" <?php } ?> >FUTURE CAMPAIGNS DESC</option>

            </select>
            <button id="submit" class="hidden" type="submit" name="submit" value="Submit" />
            </form>
            </div>

            </th>

            <th width="10%" style="text-align:center;">SUBMISSIONS</th>
            <th width="10%" style="text-align:center;">EDIT CAMPAIGN</th>
            <th width="10%" style="text-align:center;">BILLBOARDS</th>

        </tr>

<?php

// 2 Query Campaigns table

if ($_GET['orderby'] == 0) {
$sqlcampaign = "SELECT * FROM tractorcampaigns ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 1) {
$sqlcampaign = "SELECT * FROM tractorcampaigns ORDER BY id ASC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 2) {
$sqlcampaign = "SELECT * FROM tractorcampaigns ORDER BY id DESC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 3) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '1' ORDER BY ID ASC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 4) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '1' ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 5) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '2' ORDER BY ID ASC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 6) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '2' ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 7) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '0' ORDER BY ID ASC LIMIT $offset, $total_records_per_page";
}
if ($_GET['orderby'] == 8) {
$sqlcampaign = "SELECT * FROM tractorcampaigns WHERE status = '0' ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
}

if($resultcampaign = mysqli_query($link, $sqlcampaign)) {

    if(mysqli_num_rows($resultcampaign) > 0) { ?>

		<?php while ($rowcampaign = mysqli_fetch_array($resultcampaign)){
            echo "<tr>";
                echo "<td>" . $rowcampaign['campaign'] . "</td>";
                echo "<td width=\"10%\">" . $rowcampaign['startdate'] . "</td>";
                echo "<td width=\"10%\">" . $rowcampaign['enddate'] . "</td>";

                if ($rowcampaign['status'] == 0) { echo "<td style=\"text-align:center; background-color:#cb5b00; color:#fff;\" width=\"270px\">FUTURE CAMPAIGN</td>";}
                if ($rowcampaign['status'] == 1) { echo "<td style=\"text-align:center; background-color:#4879b2; color:#fff;\" width=\"270px\">ACTIVE CAMPAIGN</td>";}
                if ($rowcampaign['status'] == 2) {  echo "<td style=\"text-align:center; background-color:#ddd; color:#fff;\" width=\"270px\">INACTIVE CAMPAIGN</td>"; };

		            echo "<td style=\"text-align:center; background-color:#FFF;\" width=\"10%\"><a href=\"submissions.php?idcampaign=" . $rowcampaign['id'] . "\">VIEW</a></td>";
		            echo "<td style=\"text-align:center; background-color:#FFF;\" width=\"10%\"><a href=\"editcampaign.php?idcampaign=" . $rowcampaign['id'] . "\">EDIT</a></td>";
                echo "<td style=\"text-align:center; background-color:#FFF;\" width=\"10%\"><a href=\"billboards.php?idcampaign=" . $rowcampaign['id'] . "\">MANAGE</a></td>";

            echo "</tr>";
        }

		}
     //$_SESSION['startrownumber'] = $startrownumber / $mycountend + 1;
        // Free result set
        mysqli_free_result($resultcampaign);
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
  	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
  	</li>

      <?php
  	if ($total_no_of_pages <= 10){
  		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?page_no=$counter'>$counter</a></li>";
  				}
          }
  	}
  	elseif($total_no_of_pages > 10){

  	if($page_no <= 4) {
  	 for ($counter = 1; $counter < 8; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?page_no=$counter'>$counter</a></li>";
  				}
          }
  		echo "<li><a>...</a></li>";
  		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
  		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
  		}

  	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
  		echo "<li><a href='?page_no=1'>1</a></li>";
  		echo "<li><a href='?page_no=2'>2</a></li>";
          echo "<li><a>...</a></li>";
          for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
             if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?page_no=$counter'>$counter</a></li>";
  				}
         }
         echo "<li><a>...</a></li>";
  	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
  	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
              }

  		else {
          echo "<li><a href='?page_no=1'>1</a></li>";
  		echo "<li><a href='?page_no=2'>2</a></li>";
          echo "<li><a>...</a></li>";

          for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?page_no=$counter'>$counter</a></li>";
  				}
                  }
              }
  	}
  ?>

  	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
  	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
  	</li>
      <?php if($page_no < $total_no_of_pages){
  		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
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
