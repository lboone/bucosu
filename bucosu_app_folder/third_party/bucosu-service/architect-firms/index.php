<?php
/**
 *
 * The main file for handling the architect firm service requests.
 *
 */
?>
<?php
require_once '../inc.php';
require_once ARCHITECT_FIRM_CLASS_FILE;


if(isset($_GET['method']) && !empty($_GET['method'])) {
	$method = $_GET['method'];

	$objClass = new ArchitectFirms();

	if ($method == 'getAll') {
		$objClass->getAll();
	} else {
		$response['success'] = false;
		$response['message'] = 'Wrong method passed.';

		$rslts = json_encode($response);
		echo $_GET['jsoncallback'] . '(' . $rslts . ')';
	}

}

?>