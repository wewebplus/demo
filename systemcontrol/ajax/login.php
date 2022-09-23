<?php
include('../assets/lib/inc.config.php');

$inputUserName = trim($_POST['inputuser']);
$inputPassword = trim($_POST['inputpass']);

if(($inputUserName == _UserRoot_) && ($inputPassword == _PasswordRoot_)){
	// logs login to DB
	$insert[_TABLE_ADMIN_USERLOGIN_."_UserID"] = "'1000'";
	$insert[_TABLE_ADMIN_USERLOGIN_."_IP"] = "'".get_real_ip()."'";
	$insert[_TABLE_ADMIN_USERLOGIN_."_Type"] = "'Login'";
	$insert[_TABLE_ADMIN_USERLOGIN_."_CreateDate"] = "NOW()";
	$z = new __webctrl;
	$z->insert(_TABLE_ADMIN_USERLOGIN_,$insert);
	unset($insert);

	$_SESSION['Session_Admin_ID'] = 1000;
	$_SESSION['Session_Admin_UserName'] = _UserRoot_;
	$_SESSION['Session_Admin_Name'] = _UserRoot_;
	$_SESSION['Session_Admin_Level'] = "Admin";
	echo "ok";
}else{
	// Normal User Login ----------------------------------------
	$sql = "SELECT "._TABLE_ADMIN_USER_."_ID,"._TABLE_ADMIN_USER_."_Password,"._TABLE_ADMIN_USER_."_UserName,"._TABLE_ADMIN_USER_."_Level,"._TABLE_ADMIN_USER_."_EmpID ,"._TABLE_ADMIN_USER_."_Type FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_UserName='".$inputUserName."' AND  "._TABLE_ADMIN_USER_."_Status = 'On'";
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	if($RecordCount>0) {
		$Row=$v[0];
		$fromdbpass=$Row[_TABLE_ADMIN_USER_."_Password"];
		$pwd = base64_decode($fromdbpass);
		$arrpwd = explode(":",$pwd);
		$myPassword = $arrpwd[1];

		if($myPassword==md5($inputPassword)) {

			$UserID = $Row[_TABLE_ADMIN_USER_."_ID"];
			$update[_TABLE_ADMIN_USER_."_LastLoginDate"] = "NOW()";
			$z = new __webctrl;
			$z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_ID=" => $UserID));
			unset($update);

			// logs login to DB
			$insert[_TABLE_ADMIN_USERLOGIN_."_UserID"] = "'".sql_safe($UserID)."'";
			$insert[_TABLE_ADMIN_USERLOGIN_."_IP"] = "'".get_real_ip()."'";
			$insert[_TABLE_ADMIN_USERLOGIN_."_Type"] = "'Login'";
			$insert[_TABLE_ADMIN_USERLOGIN_."_CreateDate"] = "NOW()";
			$z = new __webctrl;
			$z->insert(_TABLE_ADMIN_USERLOGIN_,$insert);
			unset($insert);

			$StaffInfo = getStaffInfo((int)$UserID);
			$StaffFullname = $StaffInfo->fullname;

			$_SESSION['Session_Admin_ID'] = $UserID;
			$_SESSION['Session_Admin_UserName'] = $Row[_TABLE_ADMIN_USER_."_UserName"];
			$_SESSION['Session_Admin_Name'] = $StaffFullname;
			$_SESSION['Session_Admin_Level'] = $Row[_TABLE_ADMIN_USER_."_Level"];

			echo "ok";
		} else {
			echo "nopass";
		}
	} else {
		echo "nouser";
	}
}
CloseDB();
?>
