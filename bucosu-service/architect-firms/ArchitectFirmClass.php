<?php
/**
 *
 * This the the main class for dealing with the Architect Firm.
 *
 */
require_once '../inc/BaseClass.php';
class ArchitectFirms
{

	function __construct(){
		ConnectionManager::getInstance();
		ConnectionManager::setTable('architect_firms');
	}

	public function getAll()
	{
		$result = mysql_query('SELECT * FROM '.ConnectionManager::getTable()) or die(mysql_error());

		if (mysql_num_rows($result) > 0)
		{
			$response['data'] = array();

			while($row = mysql_fetch_array($result))
			{
				$dat = array();
				$dat['ID'] = $row['id'];
				$dat['Name'] = $row['name'];

				array_push($response['data'], $dat);
			}
			$response['success'] = true;	
		}
		else
		{
			$response['success'] = false;
			$response['message'] = "No Records " . __CLASS__ . " Found";
		}
		$rslts = json_encode($response);
		echo $_GET['jsoncallback'] . '(' . $rslts . ')';
	}

}
?>
