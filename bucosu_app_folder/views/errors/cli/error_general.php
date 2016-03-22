<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($heading) {
	echo "\nERROR: ",
		$heading,
		"\n\n",
		$message,
		"\n\n";
} else {
	echo $message;	
}