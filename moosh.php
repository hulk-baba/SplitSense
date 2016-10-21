<?php
	include_once 'dbconnect.php';
	if(isset($_POST['cash'])){
		// print_r($_POST);
		// echo nl2br("\r\n");
	}
	// $pay = $_POST['payer'];
	$total_paid = reset($_POST);
	$first_key = key($_POST);
	// echo nl2br("\r\n");
	$payer = substr($first_key, 0, -11);
	// echo "payer id is => " . $payer;
	// echo nl2br("\r\n");
	$i=0;
	$myfile = fopen("tmp.txt","w") or die("Unable to open file");
	$txt = $payer . " " . $total_paid ."\n";
	fwrite($myfile, $txt);
	foreach ($_POST as $key => $value) {
 		if($i!=0 and $key != "cash"){
 			$str =  $key . ' ' . $value . "\n";
 			fwrite($myfile, $str) ; 
 			// echo nl2br("\r\n");

 		}

 		$i++;
	}
	exec('/var/www/html/ProjectYelp/edge');
	$fh = fopen('/var/www/html/ProjectYelp/edge.txt','r');
	$flag = true;
	while($line = fgets(($fh))){
		// echo($line);
		$pieces = explode(" ", $line);
		$sql = mysql_query(" INSERT INTO edges VALUES($pieces[0] , $pieces[1] , $pieces[2]) ");
		if(!$sql){
			echo "failed query";
			$flag = false;
		}
		// echo nl2br("\r\n");
	}

	fclose($fh);



?>

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


<body>
	<div class = "container-fluid">
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
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			      	<li ><a href="view.php">Summary </a></li>
			      	<li class="active"><a href="bill.php">Add A Bill<span class="sr-only">(current)</span></a></li>
			      	<li><a href="index.php">Signin</a></li>
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
			<div class="col-md-6 mid">
			 <?php
			 	if($flag == true){
			 		echo ' <h1> We have successfully received your data' ; 
			 	}
			 	else{
			 		echo ' <h1> We have failed to process your data' ; 
			 	}
			 ?>
			</div>
			<div class="col-md-3 right">
				&nbsp;
			</div>

		</div>

	</div>
</body>
</html>