<?php
	//connect to db
//Sample Database Connection Syntax for PHP and MySQL.

$hostname="localhost";
$username="bws1-lboone";
$password="X*T9vq6Fs]38@(1";
$dbname="bucosu-web-service-1";
$usertable="customers";
$yourfield = "post_title";

mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
mysql_select_db($dbname);

# Check If Record Exists

$query = "SELECT * FROM $usertable";
	
	
	//call the passed function
	if(isset($_GET['method']) && !empty($_GET['method'])) {
		if(function_exists($_GET['method'])) {
			$_GET['method']();
		}
	}
	// methods
	
	function getAllCustomers(){
		$cus_sql = mysql_query("SELECT * FROM customers");
		$cuss = array();
		while($cus = mysql_fetch_array($cus_sql)){
			$cuss[] = $cus;
		}
		$cuss = json_encode($cuss);
		echo $_GET['jsoncallback']. '(' .$cuss. ')';
	}
?>