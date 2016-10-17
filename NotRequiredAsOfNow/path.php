<?php
include_once 'dbconnect.php';
$result = mysql_query("SELECT * FROM edges") or die('Unable to run query:');
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
while($line = fgets(($fh))){
	echo($line);
	echo nl2br("\r\n");
}
fclose($fh);
?>