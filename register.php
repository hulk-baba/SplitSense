<?php
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include_once 'dbconnect.php';



if(isset($_POST['btn-signup']))
{

 $uname = mysql_real_escape_string($_POST['uname']);
 $email = mysql_real_escape_string($_POST['email']);
 $upass = md5(mysql_real_escape_string($_POST['pass']));
 $upass2 = md5(mysql_real_escape_string($_POST['pass2']));
 $img = mysql_real_escape_string($_POST['img']);
 if($upass2 === $upass){

	 if(mysql_query("INSERT INTO Users(username,email,imgaddr,password) VALUES('$uname','$email','$img','$upass')"))
		 {
		 	$qry = mysql_query("SELECT * from Users") or die('Unable to run query:');
		 	$counter = mysql_num_rows($qry);
			$myfile = fopen("Names.txt","w") or die("Unable to open file");

			if($counter > 0){
				while($row = mysql_fetch_array($qry)){
					$txt = $row['UserID']." ".$row['username']."\n" ; 
					fwrite($myfile, $txt);

				}
			}


		  ?>
		        <script>alert('successfully registered ');</script>
		        <?php
		 }
		 else
		 {
		  ?>
		        <script>alert('error while registering you... You are already on our database');</script>
		        <?php
		 }
}
else{
	?>
		 <script>alert('Both Passwords Do not Match');</script>
	<?php
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><input type="password" name="pass2" placeholder="Retype Your Password" required /></td>
</tr>
<tr>
<tr>
<td><input type="text" name="img" placeholder="Image Address" required /></td>
</tr>
<td><button type="submit" name="btn-signup">Sign Up SplitSense</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In to SplitSense</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>