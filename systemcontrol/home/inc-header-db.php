<?php
decode_URL($_SERVER["QUERY_STRING"]);
if($_SESSION['Session_Admin_ID']==0){
	Header("Location:../index.php");
}
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$Login_MenuID = (empty($_POST["Login_MenuID"])?@$Login_MenuID:$_POST["Login_MenuID"]);
$actiontype = (empty($_POST["actiontype"])?@$actiontype:$_POST["actiontype"]);
$actionpage = (empty($_POST["actionpage"])?@$actionpage:$_POST["actionpage"]);
$actionpage = (empty($actionpage)?1:$actionpage);
$actionpage = (!empty($_GET["page"])?$_GET["page"]:$actionpage);

if($_SESSION['Session_Admin_ID']>0){
	if(_UserRoot_ == $_SESSION['Session_Admin_UserName']){
		$enableroot = true;
		$StaffImg = "../assets/img/avatars/1.jpg";
		$StaffFullname = _UserRoot_;
		$StaffUser = _UserRoot_;
		$StaffUserRemark = "";
	}else{
		$StaffInfo = getStaffInfo((int)$_SESSION['Session_Admin_ID']);
		$StaffImg = $StaffInfo->picture;
		$StaffFullname = $StaffInfo->fullname;
		$StaffUser = $StaffInfo->empuser;
		$StaffUserRemark = $StaffInfo->userRemark;
		$enableroot = false;
	}
}else{
	$enableroot = false;
}
$UserPermission = userPma();
$osmain = $UserPermission->osmain;
$os = $UserPermission->os;
$osmnu = $UserPermission->osmnu;
$osmnupma = $UserPermission->osmnupma;
$pmaeditfield = $UserPermission->editfield;
$pmadelfield = $UserPermission->delfield;
$pmausertype = $UserPermission->usertype;
$pmauserlevel = $UserPermission->userlevel;
$pmaadminbtn = $UserPermission->adminbtn;
$pmaapprove = $UserPermission->approve;

if(!empty($Login_MenuID)){
	$indexLogin_MenuID = substr($Login_MenuID,5);
	$mymenuname = @$menuName[$indexLogin_MenuID];
	$mymenuInGroup = @$menuInGroup[$indexLogin_MenuID];
	if(@$osmnupma[$Login_MenuID]=='RW'){
		$btnaspma = true;
	}else{
		$btnaspma = false;
	}
	$pmamenuapprove = @$pmaapprove[$mymenuInGroup];
	$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
	$adminprofile = "";
}else{
	if(!empty($adminprofile)){
		if($adminprofile=="profile001"){
			$mymenuname = "User Profile";
			$mymenuInGroup = 0;
			$mymenuinclude = "";
		}else{
			$mymenuname = "Profile";
			$mymenuInGroup = 0;
			$mymenuinclude = "";
		}
	}else{
		$mymenuname = "Dashboard";
		$mymenuInGroup = 0;
		$mymenuinclude = "";
	}
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
/*
echo "<pre>";
print_r($StaffInfo);
echo "</pre>";
echo $UserPermission->approve[2];
echo "<pre>";
print_r($UserPermission);
echo "</pre>";
*/
/*
if(!empty($Login_MenuID)){
	$defaultpagesize = _DEFAULT_PAGESIZE_;
	$defaultlist = $menuDefaultList[substr($Login_MenuID,5)];
	$defaultorder = $menuDefaultOrder[substr($Login_MenuID,5)];
	$defaultfillter = $menuDefaultFilter[substr($Login_MenuID,5)];
	$defaultstatus = $menuDefaultStatus[substr($Login_MenuID,5)];
	$defaultdetail = $menuDefaultDetails[substr($Login_MenuID,5)];
}
$myFormselectOrder = (empty($_POST["myFormselectOrder"])?@$defaultlist:$_POST["myFormselectOrder"]);
$myFormselectASCDESC = (empty($_POST["myFormselectASCDESC"])?@$defaultorder:$_POST["myFormselectASCDESC"]);
$myFormselectFilter = (empty($_POST["myFormselectFilter"])?@$defaultfillter:$_POST["myFormselectFilter"]);
$myFormselectSTATUS = (empty($_POST["myFormselectSTATUS"])?@$defaultstatus:$_POST["myFormselectSTATUS"]);
$myFormselectDetail = (empty($_POST["myFormselectDetail"])?@$defaultdetail:$_POST["myFormselectDetail"]);
$myFormSearch = (empty($_POST["myFormSearch"])?@$myFormSearch:$_POST["myFormSearch"]);
$myFormPage = (empty($_POST["myFormPage"])?@$myFormPage:$_POST["myFormPage"]);
$myFormPerPage = (empty($_POST["myFormPerPage"])?@$defaultpagesize:$_POST["myFormPerPage"]);
*/
$myrand = rand();
$LoginData = encode_URL('Login_MenuID='.(empty($Login_MenuID)?0:$Login_MenuID).'&actionpage='.$actionpage);
//$LoginData = ('Login_MenuID='.(empty($Login_MenuID)?0:$Login_MenuID).'&actionpage='.$actionpage);
?>
