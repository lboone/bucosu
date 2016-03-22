<?php
/**
  *
  * This is the database constants file.
  *
  */
?>
<?php
// Define the main constants.
define ('BASE_CLASS', 'BaseClass');
define ('BASE_CLASS_FILE', BASE_CLASS . '.php');
define ('ARCHITECT_FIRM_CLASS', 'ArchitectFirmClass');
define ('ARCHITECT_FIRM_CLASS_FILE', ARCHITECT_FIRM_CLASS . '.php');
define ('SCHOOL_DISTRICT_CLASS', 'SchoolDistrictClass');
define ('SCHOOL_DISTRICT_CLASS_FILE', SCHOOL_DISTRICT_CLASS . '.php');

define ('USER',     'bws1-lboone');
define ('PASSWORD', 'X*T9vq6Fs]38@(1');
define ('DATABASE', 'bucosu-web-service-1');
define ('SERVER',   'localhost');

// Now load the db-con file that connects the database.
require_once 'Connection.php';

// Now load the db-static file that holds the static class.
require_once 'ConnectionManager.php';
?>