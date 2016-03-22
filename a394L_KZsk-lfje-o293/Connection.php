<?php 
/**
 *
 * connection class
 *
 */
?>
<?php
class connection
{
	function __construct()
	{
		$this->connect();
	}

	function __destruct()
	{
		$this->close();
	}

	function connect(){
		//Connect to MYSQL
		$connection = mysql_connect(SERVER, USER, PASSWORD) or die(mysql_error());

		//Connect to DB
		$dbconnect = mysql_select_db(DATABASE) or die(mysql_error()) or die(mysql_error());
		return $connection;
	}
	function close()
	{
		mysql_close();
	}
}
?>