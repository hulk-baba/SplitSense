<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="hulk.css" type="text/css" />

	<title>Summary Page</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<?php
session_start();
include_once 'dbconnect.php';
$result = mysql_query("SELECT * FROM EDGE") or die('Unable to run query:');
//print_r($result);
$counter = mysql_num_rows($result);
$myfile = fopen("file.txt","w") or die("Unable to open file");

if($counter > 0){
	while($row = mysql_fetch_array($result)){
		$txt = $row['from']." ".$row['to']." ".$row['weight']."\n" ; 
		fwrite($myfile, $txt);

	}
}
//$cmd = "g++ /home/atul/CODES/forphp";
//$output = exec('/home/atul/CODES/forphp_2');
//print_r($output);
//echo $output;
exec('/var/www/html/ProjectYelp/forphp');
$fh = fopen('/var/www/html/ProjectYelp/out.txt','r');

?>
<?php

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE UserID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

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
			      	<li ><a href="view_txn.php">Home</a></li>
			      	<li><a href="txn.php">Add A Bill</a></li>
			      	<li class="active"><a href="new_view.php">Summary <span class="sr-only">(current)</span></a></li>
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
			<div class="col-md-2 left">
				&nbsp;
			</div>
			<div class="col-md-8 mid">
				<h1 style="padding-left:15px;">Summary</h1>
				<h4 style="padding-left:15px;"><?php
						while($line = fgets(($fh))){
							echo($line);
							echo nl2br("\r\n");
						}
		 				fclose($fh);
					?>
				</h4>
			</div>
			<div class="col-md-2 right">
				&nbsp;
			</div>

		</div>

	</div>
</body>
</html>