<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
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
$selectMember = (!empty($_POST['selectMember'])?$_POST['selectMember']:0);
$selectGroup = (!empty($_POST['selectGroup'])?$_POST['selectGroup']:'');
if($itemid>0){
  $update[_TABLE_PRODUCTS_."_MemberID"] = sql_safe($selectMember,false,true);
	$update[_TABLE_PRODUCTS_."_LastUpdate"] = "NOW()";
	$update[_TABLE_PRODUCTS_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_PRODUCTS_.'_Ignore'] = "'".sql_safe($Lang)."'";
  $update[_TABLE_PRODUCTS_.'_TypeID'] = "'".sql_safe($selectGroup)."'";
	$z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => (int)$itemid));
	unset($update);
  // echo '<pre>';
  // print_r($update);
  // echo '</pre>';
  // exit();
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject01 = (!empty($_POST["inputSubject01".$lkey])?$_POST["inputSubject01".$lkey]:'');
    $inputSubject02 = (!empty($_POST["inputSubject02".$lkey])?$_POST["inputSubject02".$lkey]:'');
    $inputDetail = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');
  	if($detailid>0){
  		$update[_TABLE_PRODUCTS_DETAIL_.'_Subject01'] = "'".sql_safe($inputSubject01)."'";
      $update[_TABLE_PRODUCTS_DETAIL_.'_Subject02'] = "'".sql_safe($inputSubject02)."'";
  		$update[_TABLE_PRODUCTS_DETAIL_.'_Detail'] = "'".sql_safe($inputDetail)."'";
  		$update[_TABLE_PRODUCTS_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_PRODUCTS_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_PRODUCTS_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z->update(_TABLE_PRODUCTS_DETAIL_,$update,array(_TABLE_PRODUCTS_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_PRODUCTS_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
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
  }
}
echo 2;
CloseDB();
?>
