<?php
include('../assets/lib/inc.config.php');

$insert[_TABLE_ADMIN_USERLOGIN_."_UserID"] = "'".sql_safe($_SESSION['Session_Admin_ID'])."'";
$insert[_TABLE_ADMIN_USERLOGIN_."_IP"] = "'".get_real_ip()."'";
$insert[_TABLE_ADMIN_USERLOGIN_."_Type"] = "'Logout'";
$insert[_TABLE_ADMIN_USERLOGIN_."_CreateDate"] = "NOW()";
$z = new __webctrl;
$z->insert(_TABLE_ADMIN_USERLOGIN_,$insert);
unset($insert);
session_destroy();
CloseDB();
echo "ok";
?>
