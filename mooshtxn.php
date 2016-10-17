<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="hulk.css" type="text/css" />

	<title>Reporting Page</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>


<?php
	$flag = true;
	session_start();
	include_once 'dbconnect.php';
	if(!isset($_SESSION['user']))
	{
	 header("Location: index.php");

	}
	$res=mysql_query("SELECT * FROM Users WHERE UserID=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);

	if(isset($_POST['cash'])){
		 // print_r($_POST);
		// echo nl2br("\r\n");
	}
	else{
		echo(' <a class="navbar-brand" href="txn.php">Add Bill Then Access This Url</a>');
		exit("");
		
	}

	// $pay = $_POST['payer'];
	$date = mysql_escape_string($_POST['date']);
	$desc = mysql_escape_string($_POST['description']);
	$qry = mysql_query("INSERT INTO Txn(Descr , date) VALUES ('$desc' , '$date')");
	if(!$qry){
		$flag = false;
		echo "failed into inserting to Txn";
	}
	else{
		 $sqlr = mysql_query("SELECT * FROM Txn ORDER BY TxnID DESC LIMIT 1");
		 if(!$sqlr){
		 	echo "failed into getting last id";

		 }
		 else{
		 	// echo nl2br("\r\n");
		 	$last = mysql_fetch_array($sqlr);
		 	$lastid = $last['TxnID'];
		 	// echo "last id =>" . $lastid;
		 	// echo nl2br("\r\n");
		 }

	}
	// echo 'date=> ' . $date;
	// echo nl2br("\r\n");
	// echo 'desc=> ' . $desc;
	// echo nl2br("\r\n");

	
	// echo nl2br("\r\n");
	$keys = array_keys($_POST);
	$total_paid = $_POST[$keys[2]];
	$payer = substr($keys[2], 0, -11);
	// echo "payer id is => " . $payer;
	// echo nl2br("\r\n");
	$i=0;
	$myfile = fopen("tmp.txt","w") or die("Unable to open file");
	$txt = $payer . " " . $total_paid ."\n";
	fwrite($myfile, $txt);
	foreach ($_POST as $key => $value) {
 		if($i>=3 and $key != "cash"){
 			$str =  $key . ' ' . $value . "\n";
 			fwrite($myfile, $str) ; 

 			// echo nl2br("\r\n");

 		}

 		$i++;
	}
	exec('/var/www/html/ProjectYelp/edge');
	$fh = fopen('/var/www/html/ProjectYelp/edge.txt','r');
	
	while($line = fgets(($fh))){
		// echo($line);
		$pieces = explode(" ", $line);
		$sql = mysql_query(" INSERT INTO EDGE VALUES($pieces[0] , $pieces[1] , $pieces[2] , $lastid) ");
		if(!$sql){
			echo "failed here at EDGE";
			$flag = false;
		}
		// echo nl2br("\r\n");
	}

	fclose($fh);



?>



<body>
	<div class = "container">
		<div class="row">
			<nav class="navbar navbar-default ">
			  <div class="container-fluid navi">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			    <a class="navbar-brand" href="#">
			        <img alt="Brand" src="icon.svg">
			      </a>

			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="#">SplitSense</a>
			      <p class="navbar-text">Signed in as <a href="profile.php"><?php echo $userRow['username']; ?></a></p>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			      	<li ><a href="view_txn.php">Home </a></li>
			      	<li class="active"><a href="txn.php">Add A Bill<span class="sr-only">(current)</span></a></li>
			      	<li><a href="new_view.php">Summary</a></li>
			        <li class="dropdown">
			          <a href="logout.php?logout" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Signout <span class="caret"></span></a>
			          <ul class="dropdown-menu">
			            <li><a href="logout.php?logout">Signout</a></li>
			            <li><a href="#">Settings</a></li>
			            <li><a href="profile.php">Profile</a></li>
			            <li role="separator" class="divider"></li>
			            <li><a href="#">Separated link</a></li>
			          </ul>
			        </li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>

		<div class="row" style="margin-top:-19px;">
			<div class="col-md-3 left">
				&nbsp;
			</div>
			<div class="col-md-6 mid ">
			 <?php
			 	if($flag == true){
			 		echo ' <h2> We have successfully received following  data' ; 
			 	}
			 	else{
			 		echo ' <h2> We have failed to process your data' ; 
			 	}
			 ?>
			 <?php
					$i=$lastid;
					// echo "came to bakrid";
					// echo nl2br("\r\n");
					while($i<=$lastid){
						// echo "inside while";
						// echo nl2br("\r\n");
						$new = mysql_query("SELECT * from EDGE where EDGE.TxnID = $i") or die('failed to fetch table');
						$cnt = mysql_num_rows($new);
						if(!$new){
							echo "failed $new query";
							echo nl2br("\r\n");
							// echo $cnt . " count is";
							// echo nl2br("\r\n");
						}
						if($cnt > 0){
							while ($row = mysql_fetch_array($new)) {
								$from = $row['from'] ; 
								$to = $row['to'];
								$val = $row['weight'];
								$f1 = mysql_query("SELECT * from Users where UserID = '$from' ");
								$f2 = mysql_fetch_array($f1);
								$fname  = $f2['username'];
								$t1 = mysql_query("SELECT * from Users where UserID = '$to' ");
								$t2 = mysql_fetch_array($t1);
								$tname = $t2['username'];
								if($f1 and $t1){
									$x =  $fname . " gave " . $tname . " ₹ " . $val ;
									echo '<h4 style = " padding-left : 40 px;">'. $x . '</h4>'; 
								}
								else{
									echo "failed tp get edge";
									echo nl2br("\r\n");
								}
								
							}
						}
						echo nl2br("\r\n");
						$i++;
					}
				?>
			</div>
			<div class="col-md-3 right">
				&nbsp;
			</div>

		</div>
		<div class="row">

			<div class="col-md-3">
				
			</div>	
			<div class="col-md-6">
				
			</div>
			<div class="col-md-3">
				
			</div>

		</div>

	</div>
</body>
</html>