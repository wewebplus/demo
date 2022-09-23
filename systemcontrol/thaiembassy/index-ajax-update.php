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

if($itemid>0){
  $inputAName = $_POST["inputAName"];
  $inputFName = $_POST["inputFName"];
  $inputLName = $_POST["inputLName"];
  $inputGender = (!empty($_POST["inputGender"])?$_POST["inputGender"]:'M');
  $BirthdaySelectDay = $_POST["BirthdaySelectDay"];
  $BirthdaySelectMonth = $_POST["BirthdaySelectMonth"];
  $BirthdaySelectYear = $_POST["BirthdaySelectYear"];
  $Birthday = $BirthdaySelectYear."-".$BirthdaySelectMonth."-".$BirthdaySelectDay;
  $inputEmail = $_POST["inputEmail"];
  $inputEmailInfo = $_POST["inputEmailInfo"];
  $inputTelephone = $_POST["inputTelephone"];
  $inputFax = $_POST["inputFax"];
  $inputPosition = $_POST["inputPosition"];
  $SelectTerritory = (!empty($_POST["SelectTerritory"])?$_POST["SelectTerritory"]:0);
  $inputCountry = $_POST["inputCountry"];
  $selectCountry = $_POST["selectCountry"];
  if($selectCountry>0){
    $InfoCountry = getInfoCountry($selectCountry);
    $selectCountryName = $InfoCountry->data["CountryName"];
    $selectCountryCode = $InfoCountry->data["CountryCode"];
  }else{
    $selectCountryName = "";
    $selectCountryCode = "";
  }
  $inputProvince = $_POST["inputProvince"];
  $selectProvinceID = "";
  $selectProvinceName = "";
  if(isset($_POST["selectProvince"])){
    foreach($_POST["selectProvince"] as $kProvince=>$vProvince){
      $InfoProvince = getInfoState($vProvince);
      if($kProvince>0){
        $selectProvinceID .= ",";
        $selectProvinceName .= ",";
      }
      $selectProvinceID .= $InfoProvince->data["StateID"];
      $selectProvinceName .= $InfoProvince->data["StateName"];
    }
  }
  $inputDistrict = $_POST["inputDistrict"];
  $selectDistrict = (!empty($_POST["selectDistrict"])?$_POST["selectDistrict"]:array());
  $arrDistrict = array();
  if(isset($_POST["selectDistrict"])){
    foreach($_POST["selectDistrict"] as $kDistrict=>$vDistrict){
      $InfoDistrict = getInfoCity($vDistrict);
      $arr = array();
      $arr["_EmbassyID"] = $itemid;
      $arr["_CountryID"] = $InfoDistrict->data["CountryID"];
      $arr["_StateID"] = $InfoDistrict->data["StateID"];
      $arr["_CityID"] = $vDistrict;
      $arrDistrict[] = $arr;
    }
  }

  $inputAddress = encodetxterea($_POST["inputAddress"]);
  $inputZipCode = $_POST["inputZipCode"];

  $lkeyindex = "Home";
  $filewallshow = (!empty($_POST["filewallshow".$lkeyindex])?$_POST["filewallshow".$lkeyindex]:'');
  $filewallurl = (!empty($_POST["filewallurl".$lkeyindex])?$_POST["filewallurl".$lkeyindex]:'');
  $filewallname = (!empty($_POST["filewallname".$lkeyindex])?$_POST["filewallname".$lkeyindex]:'');

  $sql = "SELECT "._TABLE_ADMIN_STAFF_."_PictureFile AS thumb FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $row = $v[0];
  $ThumbnailPictureName = $row["thumb"];

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
    $update[_TABLE_ADMIN_STAFF_."_PictureFile"] = "'".sql_safe($rootpathbanner)."'";
    $unlinkfile = $userpathpath.$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
    $unlinkfile = $userpathpath."crop-".$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
  }

  $update[_TABLE_ADMIN_STAFF_."_AName"] = "'".sql_safe($inputAName)."'";
  $update[_TABLE_ADMIN_STAFF_."_FName"] = "'".sql_safe($inputFName)."'";
  $update[_TABLE_ADMIN_STAFF_."_LName"] = "'".sql_safe($inputLName)."'";
  $update[_TABLE_ADMIN_STAFF_."_Gender"] = "'".sql_safe($inputGender)."'";
  $update[_TABLE_ADMIN_STAFF_."_Birthday"] = "'".sql_safe($Birthday)."'";
  $update[_TABLE_ADMIN_STAFF_."_Email"] = "'".sql_safe($inputEmail)."'";
  $update[_TABLE_ADMIN_STAFF_."_EmailInfo"] = "'".sql_safe($inputEmailInfo)."'";
  $update[_TABLE_ADMIN_STAFF_."_Tel"] = "'".sql_safe($inputTelephone)."'";
  $update[_TABLE_ADMIN_STAFF_."_Fax"] = "'".sql_safe($inputFax)."'";
  $update[_TABLE_ADMIN_STAFF_."_Position"] = "'".sql_safe($inputPosition)."'";
  $update[_TABLE_ADMIN_STAFF_."_ZipCode"] = "'".sql_safe($inputZipCode)."'";
  $update[_TABLE_ADMIN_STAFF_."_Address"] = "'".sql_safe($inputAddress)."'";
	$update[_TABLE_ADMIN_STAFF_."_LastUpdate"] = "NOW()";
	$update[_TABLE_ADMIN_STAFF_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $update[_TABLE_ADMIN_STAFF_."_Territory"] = sql_safe($SelectTerritory,false,true);
  if($selectCountry>0){
    $update[_TABLE_ADMIN_STAFF_."_Country"] = "'".sql_safe($selectCountry)."'";
    $update[_TABLE_ADMIN_STAFF_."_CountryCode"] = "'".sql_safe($selectCountryCode)."'";
    $update[_TABLE_ADMIN_STAFF_."_CountryName"] = "'".sql_safe($selectCountryName)."'";
  }
  if(!empty($selectProvinceID)){
    $update[_TABLE_ADMIN_STAFF_."_StateID"] = "'".sql_safe($selectProvinceID)."'";
    $update[_TABLE_ADMIN_STAFF_."_StateName"] = "'".sql_safe($selectProvinceName)."'";
  }
	$z = new __webctrl;
	$z->update(_TABLE_ADMIN_STAFF_,$update,array(_TABLE_ADMIN_STAFF_."_ID=" => (int)$itemid));
	unset($update);

  if(count($arrDistrict)>0){
    $z = new __webctrl;
    $z->del(_TABLE_THAIEMBASSY_CITY_,array(_TABLE_THAIEMBASSY_CITY_."_EmbassyID=" => (int)$itemid));
    foreach($arrDistrict as $relateDistrict){
      $insert[_TABLE_THAIEMBASSY_CITY_.'_EmbassyID'] = sql_safe($relateDistrict["_EmbassyID"],false,true);
      $insert[_TABLE_THAIEMBASSY_CITY_.'_CountryID'] = sql_safe($relateDistrict["_CountryID"],false,true);
      $insert[_TABLE_THAIEMBASSY_CITY_.'_StateID'] = sql_safe($relateDistrict["_StateID"],false,true);
      $insert[_TABLE_THAIEMBASSY_CITY_.'_CityID'] = sql_safe($relateDistrict["_CityID"],false,true);
      $z->insert(_TABLE_THAIEMBASSY_CITY_,$insert);
      unset($insert);
      // echo ",".$relateDistrict["_EmbassyID"];
    }
  }
}
echo 2;
CloseDB();
?>
