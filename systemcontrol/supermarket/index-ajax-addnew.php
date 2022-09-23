<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$dataOption = $defaultdata[$Login_MenuID]["option"];
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_TEMP_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadGallery)) { mkdir($PathUploadGallery,0777); }
if(!is_dir($PathUploadVDO)) { mkdir($PathUploadVDO,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$DataArrDay = $defaultdata[$Login_MenuID]["day"];
// echo '<pre>';
// print_r($defaultdata[$Login_MenuID]["path"]["PATH"]);
// echo '</pre>';
// exit();
//
// if(!is_dir(_RELATIVE_CONTENT_UPLOAD_)) { mkdir(_RELATIVE_CONTENT_UPLOAD_,0777); }
// if(!is_dir(_RELATIVE_CONTENT_IMG_UPLOAD_)) { mkdir(_RELATIVE_CONTENT_IMG_UPLOAD_,0777); }
// if(!is_dir(_RELATIVE_CONTENT_HTML_UPLOAD_)) { mkdir(_RELATIVE_CONTENT_HTML_UPLOAD_,0777); }
//
$sql = "SELECT MAX("._TABLE_SUPERMARKET_."_Order) AS MaxO FROM "._TABLE_SUPERMARKET_;
$sql .= " WHERE "._TABLE_SUPERMARKET_."_Key IN ('".implode("','",$dataModuleKey)."')";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;


$inputCountry = (!empty($_POST['inputCountry'])?$_POST['inputCountry']:'');
$selectCountry = (!empty($_POST['selectCountry'])?$_POST['selectCountry']:0);
if($selectCountry>0){
  $InfoCountry = getInfoCountry($selectCountry);
  $selectCountryID = $selectCountry;
  $selectCountryName = $InfoCountry->data["CountryName"];
  $selectCountryCode = $InfoCountry->data["CountryCode"];
}else{
  $selectCountryID = $selectCountry;
  $selectCountryName = "";
  $selectCountryCode = "";
}
$inputProvince = (!empty($_POST['inputProvince'])?$_POST['inputProvince']:'');
$selectProvince = (!empty($_POST['selectProvince'])?$_POST['selectProvince']:0);
if($selectProvince>0){
  $InfoProvince = getInfoState($selectProvince);
  $selectProvinceID = $InfoProvince->data["StateID"];
  $selectProvinceName = $InfoProvince->data["StateName"];
}else{
  $selectProvinceID = $selectProvince;
  $selectProvinceName = "";
}
$inputDistrict = (!empty($_POST['inputDistrict'])?$_POST['inputDistrict']:'');
$selectDistrict = (!empty($_POST['selectDistrict'])?$_POST['selectDistrict']:0);
if($selectDistrict>0){
  $InfoDistrict = getInfoCity($selectDistrict);
  $selectDistrictID = $InfoDistrict->data["DistrictID"];
  $selectDistrictName = $InfoDistrict->data["Name"];
}else{
  $selectDistrictID = $selectDistrict;
  $selectDistrictName = "";
}
$inputAddress = (!empty($_POST['inputAddress'])?encodetxterea($_POST['inputAddress']):'');
$inputEmail = (!empty($_POST['inputEmail'])?$_POST['inputEmail']:'');
$inputTelephone = (!empty($_POST['inputTelephone'])?$_POST['inputTelephone']:'');
$inputShare_website = (!empty($_POST['inputShare_website'])?$_POST['inputShare_website']:'');
$inputWebsite = (!empty($_POST['inputWebsite'])?$_POST['inputWebsite']:'');
$inputTimeZone = (!empty($_POST['inputTimeZone'])?$_POST['inputTimeZone']:'');
$selectTimeZone = (!empty($_POST['selectTimeZone'])?$_POST['selectTimeZone']:0);
$sup_search = (!empty($_POST['sup_search'])?$_POST['sup_search']:'');
$sup_lat = (!empty($_POST['sup_lat'])?$_POST['sup_lat']:'');
$sup_lng = (!empty($_POST['sup_lng'])?$_POST['sup_lng']:'');

$putDataFile = $_POST["putDataFile"];
$putDataFile = str_replace(_HTTP_PATH_UPLOAD_,_RELATIVE_PATH_UPLOAD_,$putDataFile);
$putData = $_POST["putData"];

$ListStatus = (!empty($_POST["ListStatus"])?$_POST["ListStatus"]:'Off');

$insert = array();
$insert[_TABLE_SUPERMARKET_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_SUPERMARKET_.'_CreateDate'] = "NOW()";
$insert[_TABLE_SUPERMARKET_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_SUPERMARKET_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_SUPERMARKET_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_SUPERMARKET_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_SUPERMARKET_.'_IP'] = "'".get_real_ip()."'";
$insert[_TABLE_SUPERMARKET_.'_Order'] = sql_safe($MaxOrder,false,true);
$insert[_TABLE_SUPERMARKET_.'_Status'] = "'".sql_safe($ListStatus)."'";
$insert[_TABLE_SUPERMARKET_."_Country"] = "'".sql_safe($selectCountryID)."'";
$insert[_TABLE_SUPERMARKET_.'_CountryCode'] = "'".sql_safe($selectCountryCode)."'";
$insert[_TABLE_SUPERMARKET_.'_CountryName'] = "'".sql_safe($selectCountryName)."'";
$insert[_TABLE_SUPERMARKET_."_Province"] = "'".sql_safe($selectProvinceID)."'";
$insert[_TABLE_SUPERMARKET_.'_ProvinceName'] = "'".sql_safe($selectProvinceName)."'";
$insert[_TABLE_SUPERMARKET_."_City"] = "'".sql_safe($selectDistrictID)."'";
$insert[_TABLE_SUPERMARKET_.'_CityName'] = "'".sql_safe($selectDistrictName)."'";
$insert[_TABLE_SUPERMARKET_.'_Timezone'] = "'".sql_safe($selectTimeZone)."'";
$insert[_TABLE_SUPERMARKET_.'_Address'] = "'".sql_safe($inputAddress)."'";
$insert[_TABLE_SUPERMARKET_.'_Email'] = "'".sql_safe($inputEmail)."'";
$insert[_TABLE_SUPERMARKET_.'_Phone'] = "'".sql_safe($inputTelephone)."'";
$insert[_TABLE_SUPERMARKET_.'_Share_website'] = "'".sql_safe($inputShare_website)."'";
$insert[_TABLE_SUPERMARKET_.'_Website'] = "'".sql_safe($inputWebsite)."'";
$insert[_TABLE_SUPERMARKET_.'_Mapsearch'] = "'".sql_safe($sup_search)."'";
$insert[_TABLE_SUPERMARKET_.'_Lat'] = "'".sql_safe($sup_lat)."'";
$insert[_TABLE_SUPERMARKET_.'_Lng'] = "'".sql_safe($sup_lng)."'";
if(!empty($putDataFile)){
  $arrDataFileTemp = explode("/",$putDataFile);
  $filename = $arrDataFileTemp[count($arrDataFileTemp)-1];
  if(copy($putDataFile,$PathUploadPicture.$filename)) {
    chmod($PathUploadPicture.$filename,0777);
    $FileSave = $PathUploadPicture.$filename;
    $FileSaveCrop = $PathUploadPicture."crop-".$filename;
    $thumb = new Thumbnail($FileSave);
    $thumb->resize(0,$defaultdata[$Login_MenuID]["img"]["H"]);
    $thumb->crop(0, 0, $defaultdata[$Login_MenuID]["img"]["W"],$defaultdata[$Login_MenuID]["img"]["H"]);
    $thumb->save($FileSaveCrop,100);
    foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
      $FileSaveThumb = $PathUploadPicture.$vvl."-".$filename;
      $thumb = new Thumbnail($FileSave);
      $thumb->resize(0,$defaultdata[$Login_MenuID]["thumb"]["H"][$kvl]);
      $thumb->crop(0, 0, $defaultdata[$Login_MenuID]["thumb"]["W"][$kvl],$defaultdata[$Login_MenuID]["thumb"]["H"][$kvl]);
      $thumb->save($FileSaveThumb,100);
    }
    $insert[_TABLE_SUPERMARKET_.'_Picture'] = "'".sql_safe($filename)."'";
    $insert[_TABLE_SUPERMARKET_.'_PictureAlt'] = "'".sql_safe($putData)."'";
    unlink($putDataFile);
  }
}
$z->insert(_TABLE_SUPERMARKET_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  $mydataGroup = array();
  if(isset($_POST["checkboxGroup"])){
    foreach($_POST["checkboxGroup"] as $GID){
      $query = "ID='".$GID."'";
      $mydata = @ArraySearch($DataGroup,$query,1);
      $FullGroupname = @$DataGroup[array_key_first($mydata)]["Name"];
      $arr = array();
      $arr["_ContentID"] = $insertid;
      $arr["_GroupID"] = $GID;
      $arr["_GroupName"] = $FullGroupname;
      $arr["_LastUpdate"] = "NOW()";
      $arr["_Status"] = 'On';
      $mydataGroup[] = $arr;
      unset($arr);
    }
  }
  $mydataTime = array();
  if(count($DataArrDay)>0){
    foreach($DataArrDay as $kkd=>$vvd){
      $TimeDataID = $_POST["inputTimeDataID_".$vvd["ID"]];
      $DayID = $vvd["ID"];
      if(count($TimeDataID)>0){
        foreach($TimeDataID as $kkt=>$vvt){
          $TimeOpen = $_POST["TIMEOPEN_".$vvd["ID"]][$kkt];
          $TimeClose = $_POST["TIMECLOSE_".$vvd["ID"]][$kkt];
          $arr = array();
          $arr["_ContentID"] = $insertid;
          $arr["_DayID"] = $DayID;
          $arr["_Open"] = (!empty($TimeOpen)?$TimeOpen:'00:00').':00';
          $arr["_Close"] = (!empty($TimeClose)?$TimeClose:'00:00').':00';
          $arr["_LastUpdate"] = "NOW()";
          $arr["_Status"] = 'On';
          $arr["_Order"] = $kkt;
          $mydataTime[] = $arr;
        }
      }
    }
  }
  foreach($systemLang as $lkey=>$lval){
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputTitle = (!empty($_POST["inputTitle".$lkey])?encodetxterea($_POST["inputTitle".$lkey]):'');
    $inputDetail = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');

    $filename01 = md5($Login_MenuID.'-'.$lkey.'-'.$insertid.'-'.$myrand.'-01');
    $content = stripslashes($inputDetail);
    $html01 = $filename01.'.html';
    savetxt($PathUploadHtml.$html01,$content);

    $insert[_TABLE_SUPERMARKET_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_HTMLFileName'] = "'".sql_safe($html01)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_HTMLDetail'] = "'".sql_safe($content)."'";
    $insert[_TABLE_SUPERMARKET_DETAIL_.'_UpdateDate'] = "NOW()";
    if(!empty($Ignore)){
      $insert[_TABLE_SUPERMARKET_DETAIL_.'_Status'] = "'Off'";
      $Lang .= "|".$lkey.":Off";
    }else{
      $insert[_TABLE_SUPERMARKET_DETAIL_.'_Status'] = "'On'";
      $Lang .= "|".$lkey.":On";
    }
    $z->insert(_TABLE_SUPERMARKET_DETAIL_,$insert);
    unset($insert);
  }
  $sql = "UPDATE "._TABLE_SUPERMARKET_." SET "._TABLE_SUPERMARKET_."_Ignore='".sql_safe($Lang)."' WHERE "._TABLE_SUPERMARKET_."_ID = ".(int)$insertid;
  $z->query($sql);
  if(count($mydataGroup)>0){
    $z->del(_TABLE_SUPERMARKET_GROUP_,array(_TABLE_SUPERMARKET_GROUP_."_ContentID=" => (int)$insertid));
    foreach($mydataGroup as $list){
      $insert = array();
      $insert[_TABLE_SUPERMARKET_GROUP_.'_ContentID'] = sql_safe($list["_ContentID"],false,true);
      $insert[_TABLE_SUPERMARKET_GROUP_.'_GroupID'] = sql_safe($list["_GroupID"],false,true);
      $insert[_TABLE_SUPERMARKET_GROUP_.'_GroupName'] = "'".sql_safe($list["_GroupName"])."'";
      $insert[_TABLE_SUPERMARKET_GROUP_.'_LastUpdate'] = $list["_LastUpdate"];
      $insert[_TABLE_SUPERMARKET_GROUP_.'_Status'] = "'".$list["_Status"]."'";
      $z->insert(_TABLE_SUPERMARKET_GROUP_,$insert);
      unset($insert);
      // print_r($insert);
    }
  }else{
    $z->del(_TABLE_SUPERMARKET_GROUP_,array(_TABLE_SUPERMARKET_GROUP_."_ContentID=" => (int)$insertid));
  }
  // $mydataTime.
  if(count($mydataTime)>0){
    $z->del(_TABLE_SUPERMARKET_WTIME_,array(_TABLE_SUPERMARKET_WTIME_."_ContentID=" => (int)$insertid));
    foreach($mydataTime as $list){
      $insert = array();
      $insert[_TABLE_SUPERMARKET_WTIME_.'_ContentID'] = sql_safe($list["_ContentID"],false,true);
      $insert[_TABLE_SUPERMARKET_WTIME_.'_DayID'] = sql_safe($list["_DayID"],false,true);
      $insert[_TABLE_SUPERMARKET_WTIME_.'_Open'] = "'".$list["_Open"]."'";
      $insert[_TABLE_SUPERMARKET_WTIME_.'_Close'] = "'".$list["_Close"]."'";
      $insert[_TABLE_SUPERMARKET_WTIME_.'_LastUpdate'] = $list["_LastUpdate"];
      $insert[_TABLE_SUPERMARKET_WTIME_.'_Status'] = "'".$list["_Status"]."'";
      $insert[_TABLE_SUPERMARKET_WTIME_.'_Order'] = sql_safe($list["_Order"],false,true);
      $z->insert(_TABLE_SUPERMARKET_WTIME_,$insert);
      unset($insert);
      // print_r($insert);
    }
  }
}

echo 2;
CloseDB();
?>
