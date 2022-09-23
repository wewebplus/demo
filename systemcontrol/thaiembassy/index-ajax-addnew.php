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

  $inputProvince = $_POST["inputProvince"];
  $selectProvince = $_POST["selectProvince"];
  $inputZipCode = $_POST["inputZipCode"];
  $inputGender = (!empty($_POST["inputGender"])?$_POST["inputGender"]:'M');
  $BirthdaySelectDay = $_POST["BirthdaySelectDay"];
  $BirthdaySelectMonth = $_POST["BirthdaySelectMonth"];
  $BirthdaySelectYear = $_POST["BirthdaySelectYear"];
  $Birthday = $BirthdaySelectYear."-".$BirthdaySelectMonth."-".$BirthdaySelectDay;

  $selectCountry = $_POST["selectCountry"];
  $inputCountry = $_POST["inputCountry"];

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
    $insert[_TABLE_THAIEMBASSY_."_PictureFile"] = "'".sql_safe($rootpathbanner)."'";
  }
  $insert[_TABLE_THAIEMBASSY_."_Folder"] = "'member'";
  $insert[_TABLE_THAIEMBASSY_."_AName"] = "'".sql_safe($inputAName)."'";
  $insert[_TABLE_THAIEMBASSY_."_Name"] = "'".sql_safe($inputFName)."'";
  $insert[_TABLE_THAIEMBASSY_."_LName"] = "'".sql_safe($inputLName)."'";
  $insert[_TABLE_THAIEMBASSY_."_Username"] = "'".sql_safe($inputUsername)."'";
  $insert[_TABLE_THAIEMBASSY_."_Password"] = "'".sql_safe($inputPassword)."'";
  // $insert[_TABLE_THAIEMBASSY_."_Orgpass"] = "'".sql_safe($inputOrgPassword)."'";
  $insert[_TABLE_THAIEMBASSY_."_IDCard"] = "'".sql_safe($inputRefNo)."'";
  $insert[_TABLE_THAIEMBASSY_."_Email"] = "'".sql_safe($inputEmail)."'";
  $insert[_TABLE_THAIEMBASSY_."_Telephone"] = "'".sql_safe($inputTelephone)."'";
  $insert[_TABLE_THAIEMBASSY_."_Fax"] = "'".sql_safe($inputFax)."'";
  $insert[_TABLE_THAIEMBASSY_."_Province"] = "'".sql_safe($inputProvince)."'";
  $insert[_TABLE_THAIEMBASSY_."_ProvinceCode"] = "'".sql_safe($selectProvince)."'";
  $insert[_TABLE_THAIEMBASSY_."_ZipCode"] = "'".sql_safe($inputZipCode)."'";
  $insert[_TABLE_THAIEMBASSY_."_Position"] = "'".sql_safe($inputPosition)."'";
  $insert[_TABLE_THAIEMBASSY_."_Sex"] = "'".sql_safe($inputGender)."'";
  $insert[_TABLE_THAIEMBASSY_."_Birthday"] = "'".sql_safe($Birthday)."'";
  $insert[_TABLE_THAIEMBASSY_."_Status"] = "'Wait'";
  $insert[_TABLE_THAIEMBASSY_."_CreateDate"] = "NOW()";
  $insert[_TABLE_THAIEMBASSY_."_LastUpdate"] = "NOW()";
  $insert[_TABLE_THAIEMBASSY_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_THAIEMBASSY_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_THAIEMBASSY_."_Level"] = "'".sql_safe($selectLevel)."'";
  $insert[_TABLE_THAIEMBASSY_.'_CountryCode'] = "'".sql_safe($selectCountry)."'";
  $insert[_TABLE_THAIEMBASSY_.'_CountryName'] = "'".sql_safe($inputCountry)."'";
  $z = new __webctrl;
  $z->insert(_TABLE_THAIEMBASSY_,$insert);
  $insertid = $z->insertid();
  unset($insert);
}
echo 2;
CloseDB();
?>
