<?php
session_start();
include_once('../connections/tractordbcon.php');
include_once('include/veriparms.php');
$idcampaign = $_GET['idcampaign'];
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

// Selected town

if (isset($_GET['orderby'])) {
  $orderby = $_GET['orderby'];
  $sqlselectedtowns = "SELECT * FROM locations WHERE id = $orderby";
  if($resultselectedtowns = mysqli_query($link, $sqlselectedtowns)){
      if(mysqli_num_rows($resultselectedtowns) > 0){
      while($rowselectedtowns = mysqli_fetch_array($resultselectedtowns)) { $selectedtown = $rowselectedtowns['location']; }
        // Free result set
        mysqli_free_result($resultselectedtowns);
    }
  }
} else {$selectedtown = "ALL";}
?>

    <h1>TRACTOR OUTDOOR ⏤ <?php echo strtoupper($selectedtown); ?> BILLBOARDS</h1>
  </div>

  <div class="breadcrumbs">
    <a href="campaigns.php">< BACK TO CAMPAIGN SELECT</a> | <a href="insertbillboard.php?idcampaign=<?php echo $idcampaign; ?>">INSERT NEW BILLBOARD</a>
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

  if (!isset($_GET['orderby'])) {$_GET['orderby'] = 0;}

  if ($_GET['orderby'] == 0) {
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `billboards` WHERE campaignid = $idcampaign");
  } else {
  $selectedtown = $_GET['orderby'];
	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `billboards` WHERE campaignid = $idcampaign AND locationid = $selectedtown ORDER BY idbillboard ASC");
  }

	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

?>

<table>
        <tr>

            <th width="200px">BILLBOARD PHOTO</th>

            <th width="20%">

              <div class="custom-select" style="width:250px;">
              <form id="form" action="" method="get">
              <input name="idcampaign" type="hidden" id="idcampaign" value="<?php echo $idcampaign ;?>">
              <select id="orderby" name="orderby" onchange="javascript:$('#submit').click();">

                <option value="0" <?php if ($_GET['orderby'] == 0) { ?> selected="selected" <?php } ?> >FILTER BILLBOARD BY TOWN</option>

                <?php
                $sqltowns = "SELECT * FROM locations";
                if($resulttowns = mysqli_query($link, $sqltowns)){
                    if(mysqli_num_rows($resulttowns) > 0){
                		while($rowtowns = mysqli_fetch_array($resulttowns)){ ?>
                  <option value="<?php echo $rowtowns['id']?>" <?php if ($rowtowns['id'] == $selectedtown) { ?>selected="selected" <?php } ?>><?php echo strtoupper($rowtowns['location']); ?>

                  <?php }
                      // Free result set
                      mysqli_free_result($resulttowns);
                  }
                }

               ?>

              </select>

              <button id="submit" class="hidden" type="submit" name="submit" value="Submit" />
              </form>

              </div>
            </th>

            <th width="">PHYSICAL LOCATION</th>
            <th width="10%">CODE A</th>
            <th width="10%" style="text-align:center;">STATUS</th>
            <th width="20%" style="text-align:center;">EDIT BILLBOARD</th>

        </tr>

<?php

// 2 Query Campaigns table

if ($_GET['orderby'] == 0) {
$sqlbillboards = "SELECT billboards.idbillboard, billboards.archive, billboards.physicallocation, billboards.billboard_insitu_example, billboards.billboardcode1, billboards.billboardcode2, billboards.locationid, billboards.campaignid, locations.location AS billboardtown FROM billboards INNER JOIN locations ON billboards.locationid = locations.id WHERE billboards.campaignid = $idcampaign ORDER BY billboards.idbillboard DESC LIMIT $offset, $total_records_per_page";
} else {
$sqlbillboards = "SELECT billboards.idbillboard, billboards.archive, billboards.physicallocation, billboards.billboard_insitu_example, billboards.billboardcode1, billboards.billboardcode2, billboards.locationid, billboards.campaignid, locations.location AS billboardtown FROM billboards INNER JOIN locations ON billboards.locationid = locations.id WHERE billboards.locationid = $selectedtown AND billboards.campaignid = $idcampaign ORDER BY billboards.idbillboard ASC LIMIT $offset, $total_records_per_page";
}


if($resultbillboards = mysqli_query($link, $sqlbillboards)) {

    if(mysqli_num_rows($resultbillboards) > 0) { ?>

		<?php while ($rowbillboards = mysqli_fetch_array($resultbillboards)){
            echo "<tr>";
                echo "<td width=\"200px\"><img src=\"../images/billboards/" . $rowbillboards['billboard_insitu_example'] . "\" width=\"200px\"></td>";
                echo "<td width=\"20%\" style=\"padding-left:30px;\">" . $rowbillboards['billboardtown'] . "</td>";
                echo "<td width=\"\">" . $rowbillboards['physicallocation'] . "</td>";
                echo "<td width=\"20%\">" . $rowbillboards['billboardcode1'] . "</td>";?>

                <?php
                if ($rowbillboards['archive'] == 0) { echo "<td style=\"text-align:center; background-color:#4879b2; color:#fff;\" width=\"10%\">Active</td>";}
                if ($rowbillboards['archive'] == 1) {  echo "<td style=\"text-align:center; background-color:#ddd; color:#fff;\" width=\"10%\">Archived</td>"; };
                ?>

                <?php
		            echo "<td style=\"text-align:center;\" width=\"20%\"><a href=\"editbillboard.php?idbillboard=" . $rowbillboards['idbillboard'] . "&idcampaign=" . $rowbillboards['campaignid'] . "\">EDIT</a></td>";

            echo "</tr>";
        }

		}
     //$_SESSION['startrownumber'] = $startrownumber / $mycountend + 1;
        // Free result set
        mysqli_free_result($resultbillboards);
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
  	<a <?php if($page_no > 1){ echo "href='?idcampaign=$idcampaign&page_no=$previous_page'"; } ?>>Previous</a>
  	</li>

      <?php
  	if ($total_no_of_pages <= 10){
  		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter'>$counter</a></li>";
  				}
          }
  	}
  	elseif($total_no_of_pages > 10){

  	if($page_no <= 4) {
  	 for ($counter = 1; $counter < 8; $counter++){
  			if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter'>$counter</a></li>";
  				}
          }
  		echo "<li><a>...</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$second_last'>$second_last</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
  		}

  	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=1'>1</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=2'>2</a></li>";
          echo "<li><a>...</a></li>";
          for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
             if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter'>$counter</a></li>";
  				}
         }
         echo "<li><a>...</a></li>";
  	   echo "<li><a href='?idcampaign=$idcampaign&page_no=$second_last'>$second_last</a></li>";
  	   echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
              }

  		else {
          echo "<li><a href='?idcampaign=$idcampaign&page_no=1'>1</a></li>";
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=2'>2</a></li>";
          echo "<li><a>...</a></li>";

          for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
  		   echo "<li class='active'><a>$counter</a></li>";
  				}else{
             echo "<li><a href='?idcampaign=$idcampaign&page_no=$counter'>$counter</a></li>";
  				}
                  }
              }
  	}
  ?>

  	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
  	<a <?php if($page_no < $total_no_of_pages) { echo "href='?idcampaign=$idcampaign&page_no=$next_page'"; } ?>>Next</a>
  	</li>
      <?php if($page_no < $total_no_of_pages){
  		echo "<li><a href='?idcampaign=$idcampaign&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
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
