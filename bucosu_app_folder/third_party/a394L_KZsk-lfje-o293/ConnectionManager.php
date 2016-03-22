<?php
/**
 *
 */
?>
<?php
class ConnectionManager
{
	static $connection = null;
	static $table = null;

	public static function getInstance()
	{
		if(ConnectionManager::$connection == null)
				ConnectionManager::$connection = new Connection();
			return ConnectionManager::$connection;
	}

	public static function getTable()
	{
		if(ConnectionManager::$table == null)
				ConnectionManager::$table = "wp_posts";
			return ConnectionManager::$table;
	}
	public static function setTable($tbl)
	{
		ConnectionManager::$table = $tbl;
	}

	private function __construct()
	{

	}

	private function __clone()
	{

	}

}
?>