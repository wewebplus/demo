<?php
## DATABASE #################################################
$arrda = array();
$arrda["APIKEY"] = _APP_KEY_;
$arrda["TEXT"] = _DATABASE_KEY_;
$datadecode = decodeAPPData($arrda);
unset($arrda);
define ("_DB_CHARSET_",	'UTF-8');
define ("_DB_TYPE_",		'mysqli'); //mysql or mysqli or mysqlpdo
define ("_DB_PORT_",		"3306");
define ("_DB_HOSTNAME_", "localhost"); //host
define ("_DB_USERNAME_", "admin_grava");
define ("_DB_PASSWORD_", "IBlWyb5KHL");
define ("_DB_NAME_", "thaiselect");

define ("_UserRoot_", $datadecode->option["ROOTUSER"]);
define ("_PasswordRoot_", $datadecode->option["ROOTPASS"]);
?>
