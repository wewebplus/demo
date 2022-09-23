<?php
include("../assets/lib/inc.config.php");

$saveData = $_POST["saveData"];
$myrand = rand(11111,99999);
$inputUsername = $_POST["inputUsername"];
$inputPassword = $_POST["inputPassword"];
$SelectEmployee = $_POST["SelectEmployee"];
$uLevel = $_POST["uLevel"];
$SelectUserType = $_POST["SelectUserType"];
if($saveData>0){
  $insert[_TABLE_ADMIN_USER_."_EmpID"] = "'".sql_safe($SelectEmployee)."'";
  $insert[_TABLE_ADMIN_USER_."_Type"] = "'".sql_safe($SelectUserType)."'";
  $insert[_TABLE_ADMIN_USER_."_UserName"] = "'".sql_safe($inputUsername)."'";
  //$insert[_TABLE_ADMIN_USER_."_Password"] = "'".md5(sql_safe($inputPassword))."'";
  $insert[_TABLE_ADMIN_USER_."_CreateByID"] = "'".$_SESSION['Session_Admin_ID']."'";
  $insert[_TABLE_ADMIN_USER_."_Status"] = "'On'";
  $insert[_TABLE_ADMIN_USER_."_CreateDate"] = "NOW()";
  $insert[_TABLE_ADMIN_USER_."_LastUpdate"] = "NOW()";
  $insert[_TABLE_ADMIN_USER_."_Level"] = "'".sql_safe($uLevel)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_ADMIN_USER_,$insert);
  $MaxID = $z->insertid();
  unset($insert);
  if(!empty($inputPassword)){
	//rand:md5(pass):id:APP_SECRET_KEY:time
  $pwd = $myrand.":".md5($inputPassword).":".$MaxID.":".APP_SECRET_KEY.":".time();
	$pwd = base64_encode($pwd);

	$update[_TABLE_ADMIN_USER_."_Password"] = "'".$pwd."'";
	$z = new __webctrl;
	$z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_ID=" => (int)$MaxID));
	unset($update);

	//_TABLE_ADMIN_HISTORYPASS_
	$insert[_TABLE_ADMIN_USERHISTORYPASS_."_UserID"] = "'".sql_safe($MaxID)."'";
	$insert[_TABLE_ADMIN_USERHISTORYPASS_."_Password"] = "'".$pwd."'";
	$insert[_TABLE_ADMIN_USERHISTORYPASS_."_OrgPass"] = "'".sql_safe($inputPassword)."'";
	$insert[_TABLE_ADMIN_USERHISTORYPASS_."_CreateDate"] = "NOW()";
	$z = new __webctrl;
	$z->insert(_TABLE_ADMIN_USERHISTORYPASS_,$insert);
	unset($insert);
  }

  $token = generate_token();
  $insert[_TABLE_ADMIN_USERTOKEN_."_TokenID"] = "'".sql_safe($token)."'";
  $insert[_TABLE_ADMIN_USERTOKEN_."_UserID"] = "'".sql_safe($MaxID)."'";
  $insert[_TABLE_ADMIN_USERTOKEN_."_CreateDate"] = "NOW()";
  $insert[_TABLE_ADMIN_USERTOKEN_."_LastUpdate"] = "NOW()";
  $z = new __webctrl;
  $z->insert(_TABLE_ADMIN_USERTOKEN_,$insert);
  unset($insert);
}
echo 2;
CloseDB();
?>
