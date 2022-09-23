<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_CONTENT_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
if($actiontype=='addnew'){
  $inputAName = $_POST["inputAName"];
  $inputFName = $_POST["inputFName"];
  $inputLName = $_POST["inputLName"];
  $inputRefNo = $_POST["inputRefNo"];
  $inputEmail = $_POST["inputEmail"];
  $inputUsername = $_POST["inputUsername"];
  $inputOrgPassword = $_POST["inputPassword"];
  $inputPassword = md5($_POST["inputPassword"]);
  $inputEmail = $_POST["inputEmail"];
  $inputTelephone = $_POST["inputTelephone"];
  $inputFax = $_POST["inputFax"];
  $inputPosition = $_POST["inputPosition"];
  $selectTypeMember = $_POST["selectTypeMember"];
  $inputTypeMember = $_POST["inputTypeMember"];
  $inputProvince = $_POST["inputProvince"];
  $selectProvince = $_POST["selectProvince"];
  $inputZipCode = $_POST["inputZipCode"];
  $inputGender = (!empty($_POST["inputGender"])?$_POST["inputGender"]:'M');
  $BirthdaySelectDay = $_POST["BirthdaySelectDay"];
  $BirthdaySelectMonth = $_POST["BirthdaySelectMonth"];
  $BirthdaySelectYear = $_POST["BirthdaySelectYear"];
  $Birthday = $BirthdaySelectYear."-".$BirthdaySelectMonth."-".$BirthdaySelectDay;

  $inputLevel = $_POST["inputLevel"];
  $selectLevel = $_POST["selectLevel"];

  $lkeyindex = "Home";
  $filewallshow = (!empty($_POST["filewallshow".$lkeyindex])?$_POST["filewallshow".$lkeyindex]:'');
  $filewallurl = (!empty($_POST["filewallurl".$lkeyindex])?$_POST["filewallurl".$lkeyindex]:'');
  $filewallname = (!empty($_POST["filewallname".$lkeyindex])?$_POST["filewallname".$lkeyindex]:'');

  $insert = array();
  $tempfile = $filewallurl.$filewallshow;
  if(is_file($tempfile)){
    if(copy($tempfile,$PathUploadPicture.$filewallshow)) {
      chmod($PathUploadPicture.$filewallshow,0777);
      unlink($tempfile);
      $FileSaveCrop = $PathUploadPicture."crop-".$filewallshow;
      $thumb = new Thumbnail($PathUploadPicture.$filewallshow);
      $thumb->resize(0,$defaultdata[$Login_MenuID]["imghome"]["H"]);
      $thumb->crop(0, 0, $defaultdata[$Login_MenuID]["imghome"]["W"],$defaultdata[$Login_MenuID]["imghome"]["H"]);
      $thumb->save($FileSaveCrop,100);
    }
    $rootpathbanner = str_replace($PathUploadPicture,"",$PathUploadPicture.$filewallshow);
    $insert[_TABLE_MEMBER_."_PictureFile"] = "'".sql_safe($rootpathbanner)."'";
  }
  $insert[_TABLE_MEMBER_."_Folder"] = "'member'";
  $insert[_TABLE_MEMBER_."_AName"] = "'".sql_safe($inputAName)."'";
  $insert[_TABLE_MEMBER_."_Name"] = "'".sql_safe($inputFName)."'";
  $insert[_TABLE_MEMBER_."_LName"] = "'".sql_safe($inputLName)."'";
  $insert[_TABLE_MEMBER_."_Username"] = "'".sql_safe($inputUsername)."'";
  $insert[_TABLE_MEMBER_."_Password"] = "'".sql_safe($inputPassword)."'";
  // $insert[_TABLE_MEMBER_."_Orgpass"] = "'".sql_safe($inputOrgPassword)."'";
  $insert[_TABLE_MEMBER_."_IDCard"] = "'".sql_safe($inputRefNo)."'";
  $insert[_TABLE_MEMBER_."_Email"] = "'".sql_safe($inputEmail)."'";
  $insert[_TABLE_MEMBER_."_Telephone"] = "'".sql_safe($inputTelephone)."'";
  $insert[_TABLE_MEMBER_."_Fax"] = "'".sql_safe($inputFax)."'";
  $insert[_TABLE_MEMBER_."_Province"] = "'".sql_safe($inputProvince)."'";
  $insert[_TABLE_MEMBER_."_ProvinceCode"] = "'".sql_safe($selectProvince)."'";
  $insert[_TABLE_MEMBER_."_ZipCode"] = "'".sql_safe($inputZipCode)."'";
  $insert[_TABLE_MEMBER_."_Member"] = "'".sql_safe($selectTypeMember)."'";
  $insert[_TABLE_MEMBER_."_Membertxt"] = "'".sql_safe($inputTypeMember)."'";
  $insert[_TABLE_MEMBER_."_Position"] = "'".sql_safe($inputPosition)."'";
  $insert[_TABLE_MEMBER_."_Sex"] = "'".sql_safe($inputGender)."'";
  $insert[_TABLE_MEMBER_."_Birthday"] = "'".sql_safe($Birthday)."'";
  $insert[_TABLE_MEMBER_."_Status"] = "'Wait'";
  $insert[_TABLE_MEMBER_."_CreateDate"] = "NOW()";
  $insert[_TABLE_MEMBER_."_LastUpdate"] = "NOW()";
  $insert[_TABLE_MEMBER_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_MEMBER_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_MEMBER_."_Level"] = "'".sql_safe($selectLevel)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_MEMBER_,$insert);
  $insertid = $z->insertid();
  unset($insert);
}
echo 2;
CloseDB();
?>
