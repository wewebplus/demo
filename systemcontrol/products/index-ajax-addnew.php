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
$sql = "SELECT MAX("._TABLE_PRODUCTS_."_Order) AS MaxO FROM "._TABLE_PRODUCTS_;
$sql .= " WHERE "._TABLE_PRODUCTS_."_Key IN ('".implode("','",$dataModuleKey)."')";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;
$selectMember = (!empty($_POST['selectMember'])?$_POST['selectMember']:0);
$SessionID = (!empty($_POST['SessionID'])?$_POST['SessionID']:'');
$selectGroup = (!empty($_POST['selectGroup'])?$_POST['selectGroup']:'');
// $ListStatus = (!empty($_POST["ListStatus"])?$_POST["ListStatus"]:'Off');
$insert = array();
$insert[_TABLE_PRODUCTS_."_MemberID"] = sql_safe($selectMember,false,true);
$insert[_TABLE_PRODUCTS_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_PRODUCTS_.'_CreateDate'] = "NOW()";
$insert[_TABLE_PRODUCTS_."_LastUpdate"] = "NOW()";
$insert[_TABLE_PRODUCTS_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_PRODUCTS_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_PRODUCTS_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_PRODUCTS_.'_Order'] = sql_safe($MaxOrder,false,true);
$insert[_TABLE_PRODUCTS_.'_TypeID'] = "'".sql_safe($selectGroup)."'";
$z->insert(_TABLE_PRODUCTS_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  $Attroldname = $PathUploadFile.$SessionID."/";
  $Attrnewname = $PathUploadFile.$insertid."/";
  if(is_dir($Attroldname)) {
    rename($Attroldname, $Attrnewname);
  }
  $Imgroldname = $PathUploadPicture.$SessionID."/";
  $Imgrnewname = $PathUploadPicture.$insertid."/";
  if(is_dir($Imgroldname)) {
    rename($Imgroldname, $Imgrnewname);
  }
  $update = array();
  $update[_TABLE_PRODUCTS_FILE_."_ContentID"] = sql_safe($insertid,false,true);
  $z = new __webctrl;
  $z->update(_TABLE_PRODUCTS_FILE_,$update,array(_TABLE_PRODUCTS_FILE_."_Session=" => "'".$SessionID."'",_TABLE_PRODUCTS_FILE_."_ContentID=" => 0));
  unset($update);
  foreach($systemLang as $lkey=>$lval){
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject01 = (!empty($_POST["inputSubject01".$lkey])?$_POST["inputSubject01".$lkey]:'');
    $inputSubject02 = (!empty($_POST["inputSubject02".$lkey])?$_POST["inputSubject02".$lkey]:'');
    $inputDetail = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');
    $insert[_TABLE_PRODUCTS_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
    $insert[_TABLE_PRODUCTS_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
    $insert[_TABLE_PRODUCTS_DETAIL_.'_Subject01'] = "'".sql_safe($inputSubject01)."'";
    $insert[_TABLE_PRODUCTS_DETAIL_.'_Subject02'] = "'".sql_safe($inputSubject02)."'";
    $insert[_TABLE_PRODUCTS_DETAIL_.'_Detail'] = "'".sql_safe($inputDetail)."'";
    $insert[_TABLE_PRODUCTS_DETAIL_.'_UpdateDate'] = "NOW()";
    if(!empty($Ignore)){
      $insert[_TABLE_PRODUCTS_DETAIL_.'_Status'] = "'Off'";
      $Lang .= "|".$lkey.":Off";
    }else{
      $insert[_TABLE_PRODUCTS_DETAIL_.'_Status'] = "'On'";
      $Lang .= "|".$lkey.":On";
    }
    $z->insert(_TABLE_PRODUCTS_DETAIL_,$insert);
    unset($insert);
  }
  $update = array();
  $update[_TABLE_PRODUCTS_.'_Ignore'] = "'".sql_safe($Lang)."'";
  $update[_TABLE_PRODUCTS_.'_MigrateID'] = sql_safe($insertid,false,true);
  $z = new __webctrl;
  $z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => (int)$insertid));
  unset($update);
}
echo 2;
CloseDB();
?>
