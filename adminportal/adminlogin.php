<?php
session_start();
unset($_SESSION['verified']);
include_once('../connections/tractordbcon.php');
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>BRUTAL FRUIT OUTDOOR CAMPAIGNS</title>

<!-- Bootstrap CDN -->

<style>
body, table, th, td .sansserif {
  font-family: Arial, Helvetica, sans-serif;
}

.center {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  border: 5px solid #777;
  padding: 10px;
  text-align: center;
}

h1 {font-size: 22px;}

.breadcrumbs {
  padding: 0 25px;
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
  height: 30px;
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



</style>

</head>

<body>

<div class="center">

<table style="width:400px;text-align:center;">

        <tr style="text-align:center;">
        <th>LOGIN <?php if (isset($_GET['verified'])) {echo " - You do not have permission!";} ?></th>
        </tr>

        <tr style="text-align:center; background-color:#cb5b00;">
            <th>

              <form id="verify" action="loginverify.php" name='verify' method="post">

                  <div style="text-align: center; margin:auto;">
                      Username: <input name="tractorusrnm" type="text" id="username" placeholder="Username" required="required" autofocus>

                      <br><br>

                      Password: <input name="tractorpswrd" type="password" id="password" placeholder="Password" required="required" autofocus>

                      <br><br>

                      <input type="submit">

                  </div>
              </form>

            </th>
        </tr>
</table>

</div>

</body>
</html>
