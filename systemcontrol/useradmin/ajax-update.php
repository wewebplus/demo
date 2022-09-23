<?php
include("../assets/lib/inc.config.php");

decode_URL($_POST["saveData"]);
$myrand = rand(11111,99999);

if($itemid>0){

  $inputUsername = $_POST["inputUsername"];
  $inputPassword = $_POST["inputPassword"];
  $SelectEmployee = $_POST["SelectEmployee"];
  $uLevel = $_POST["uLevel"];
  $SelectUserType = $_POST["SelectUserType"];
  $inputRemark = encodetxterea($_POST["Remark"]);

  $update[_TABLE_ADMIN_USER_."_EmpID"] = "'".sql_safe($SelectEmployee)."'";
  $update[_TABLE_ADMIN_USER_."_Type"] = "'".sql_safe($SelectUserType)."'";
  $update[_TABLE_ADMIN_USER_."_UserName"] = "'".sql_safe($inputUsername)."'";
  if(!empty($inputPassword)){
	//rand:md5(pass):id:APP_SECRET_KEY:time
	$pwd = $myrand.":".md5($inputPassword).":".$itemid.":".APP_SECRET_KEY.":".time();
	$pwd = base64_encode($pwd);
	/*
	echo ($pwd);
	echo "<br />";
	echo base64_decode($pwd);
	echo "<br />";
	*/

    $update[_TABLE_ADMIN_USER_."_Password"] = "'".$pwd."'";

    //_TABLE_ADMIN_HISTORYPASS_
    $insert[_TABLE_ADMIN_USERHISTORYPASS_."_UserID"] = "'".sql_safe($itemid)."'";
    $insert[_TABLE_ADMIN_USERHISTORYPASS_."_Password"] = "'".$pwd."'";
    $insert[_TABLE_ADMIN_USERHISTORYPASS_."_OrgPass"] = "'".sql_safe($inputPassword)."'";
    $insert[_TABLE_ADMIN_USERHISTORYPASS_."_CreateDate"] = "NOW()";
    $z = new __webctrl;
    $z->insert(_TABLE_ADMIN_USERHISTORYPASS_,$insert);
    unset($insert);
  }
  $update[_TABLE_ADMIN_USER_."_LastUpdate"] = "NOW()";
  $update[_TABLE_ADMIN_USER_."_Level"] = "'".sql_safe($uLevel)."'";
  $update[_TABLE_ADMIN_USER_."_Remark"] = "'".sql_safe($inputRemark)."'";

  $z = new __webctrl;
  $z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_ID=" => (int)$itemid));
  unset($update);

  $sql = "UPDATE "._TABLE_ADMIN_USERTOKEN_." SET "._TABLE_ADMIN_USERTOKEN_."_Status = 'InActive' WHERE "._TABLE_ADMIN_USERTOKEN_."_UserID = ".(int)$itemid;
  $z = new __webctrl;
  $z->query($sql);
  $token = generate_token();
  $insert[_TABLE_ADMIN_USERTOKEN_."_TokenID"] = "'".sql_safe($token)."'";
  $insert[_TABLE_ADMIN_USERTOKEN_."_UserID"] = "'".sql_safe($itemid)."'";
  $insert[_TABLE_ADMIN_USERTOKEN_."_CreateDate"] = "NOW()";
  $insert[_TABLE_ADMIN_USERTOKEN_."_LastUpdate"] = "NOW()";
  $z = new __webctrl;
  $z->insert(_TABLE_ADMIN_USERTOKEN_,$insert);
  unset($insert);
}

echo 2;
CloseDB();
?>
