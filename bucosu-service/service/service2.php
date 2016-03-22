<?php
//Sample Database Connection Syntax for PHP and MySQL.

$hostname="localhost";
$username="i1265172_wp1";
$password="X*T9vq6Fs]38@(1";
$dbname="i1265172_wp1";
$usertable="wp_posts";
$yourfield = "post_title";

mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
mysql_select_db($dbname);

# Check If Record Exists

$query = "SELECT * FROM $usertable";

$result = mysql_query($query);

if($result)
{
  while($row = mysql_fetch_array($result))
  {
    $name = $row["$yourfield"];
    echo "Name: ".$name."<br>";
  }
}
?>