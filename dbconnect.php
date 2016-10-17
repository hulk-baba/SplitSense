<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

if(!mysql_connect($server,$username,$password))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db($db))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>