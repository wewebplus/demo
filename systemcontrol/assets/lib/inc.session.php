<?php
session_start();
//session_set_cookie_params(0, '/', '.xx.co.th');

//ini_set('display_errors', '1');
//ini_set('error_reporting', 30711);
//#error_reporting = E_ALL & ~E_STRICT & ~E_NOTICE //-- .user.ini
//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
//date_default_timezone_set('Asia/Bangkok');

ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000);

if(!isset($_SESSION['Session_Admin_ID'])) {
   	$_SESSION['Session_Admin_ID']=0;
}
if(!isset($_SESSION['Session_Admin_ID_Change'])) {
   	$_SESSION['Session_Admin_ID_Change']=0;
}
if(!isset($_SESSION['Session_Admin_UserName'])) {
   	$_SESSION['Session_Admin_UserName']="";
}
if(!isset($_SESSION['Session_Admin_Name'])) {
   	$_SESSION['Session_Admin_Name']="";
}
if(!isset($_SESSION['Session_User_ID'])) {
   	$_SESSION['Session_User_ID']="";
}
if(!isset($_SESSION['Session_User_UserName'])) {
   	$_SESSION['Session_User_UserName']="";
}
if(!isset($_SESSION['Session_User_TypeMember'])) {
   	$_SESSION['Session_User_TypeMember']="";
}
if(!isset($_SESSION['Session_Admin_Language'])) {
   	$_SESSION['Session_Admin_Language']="EN";//English
}
if(!isset($_SESSION['Session_Admin_Permission'])) {
   $_SESSION['Session_Admin_Permission']="";
}
if(!isset($_SESSION['Session_Admin_CountLogin'])) {
	$_SESSION['Session_Admin_CountLogin']=0;
}
if(!isset($_SESSION['Member_Admin_ID'])) {
   	$_SESSION['Member_Admin_ID']=0;
}

?>
