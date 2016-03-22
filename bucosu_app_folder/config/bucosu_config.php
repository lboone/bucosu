<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['site_name'] = 'Bucosu.com';

/*
|--------------------------------------------------------------------------
| Used for attaching documents
|--------------------------------------------------------------------------
|
| Define all my folders for attaching documents
|
*/
$config['server_root']						= $_SERVER['DOCUMENT_ROOT'];
$config['BCS_ADMIN_ATTACHMENTS_FOLDER']		= $_SERVER['DOCUMENT_ROOT'] . '/attachments/admin';
$config['BCS_APP_ATTACHMENTS_FOLDER']		= $_SERVER['DOCUMENT_ROOT'] . '/attachments/app';
$config['BCS_USER_ATTACHMENTS_FOLDER']		= $_SERVER['DOCUMENT_ROOT'] . '/attachments/user';
$config['BCS_COMPANY_ATTACHMENTS_FOLDER']	= $_SERVER['DOCUMENT_ROOT'] . '/attachments/user/company';
