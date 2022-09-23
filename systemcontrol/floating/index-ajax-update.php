<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");

decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuFolderModule[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ADS_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ADS_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ADS_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_ADS_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$inputStartDate = (!empty($_POST['datepickerFrom'])?$_POST['datepickerFrom']:'');
$inputStartDate = convertdatetodb($inputStartDate,'English');

$inputExpireDate = (!empty($_POST['datepickerTo'])?$_POST['datepickerTo']:'');
$inputExpireDate = convertdatetodb($inputExpireDate,'English');

$selectPosition = (!empty($_POST['selectPosition'])?$_POST['selectPosition']:'L');

$z = new __webctrl;
if($itemid>0){
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputURL = (!empty($_POST["inputURL".$lkey])?$_POST["inputURL".$lkey]:'');
    $selectTarget = (!empty($_POST["selectTarget".$lkey])?$_POST["selectTarget".$lkey]:'');
    $DocumentType = (!empty($_POST["DocumentType".$lkey])?$_POST["DocumentType".$lkey]:'F');
    $inputEmbed = (!empty($_POST["inputEmbed".$lkey])?$_POST["inputEmbed".$lkey]:'');

    $ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
    $ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
    $ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');

    $tempfile = $ushowpathfile.$ushowfile;
    if(is_file($tempfile)){
			if(copy($tempfile,$PathUploadPicture.$ushowfile)) {
				chmod($PathUploadPicture.$ushowfile,0777);
				unlink($tempfile);
			}
      $update[_TABLE_ADS_DETAIL_.'_File'] = "'".sql_safe($ushowfile)."'";

      $insert[_TABLE_ADS_DETAIL_.'_File'] = "'".sql_safe($ushowfile)."'";
      if($detailid>0){
        $sqlx = "SELECT "._TABLE_ADS_DETAIL_."_File AS PictureFile FROM "._TABLE_ADS_DETAIL_." WHERE "._TABLE_ADS_DETAIL_."_ID = ".(int)$detailid;
        $zx = new __webctrl;
    		$zx->sql($sqlx);
    		$vx = $zx->row();
    		$rowx = $vx[0];
    		$oldhtml01 = $PathUploadPicture.$rowx['PictureFile'];
        if(is_file($oldhtml01)){unlink($oldhtml01);}
      }
    }

  	if($detailid>0){
  		$update[_TABLE_ADS_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
      $update[_TABLE_ADS_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
      $update[_TABLE_ADS_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
      $update[_TABLE_ADS_DETAIL_.'_DocumentType'] = "'".sql_safe($DocumentType)."'";
      $update[_TABLE_ADS_DETAIL_.'_HtmlCode'] = "'".sql_safe($inputEmbed)."'";
  		$update[_TABLE_ADS_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_ADS_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_ADS_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z->update(_TABLE_ADS_DETAIL_,$update,array(_TABLE_ADS_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_ADS_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
  		$insert[_TABLE_ADS_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  		$insert[_TABLE_ADS_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
      $insert[_TABLE_ADS_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
      $insert[_TABLE_ADS_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
      $insert[_TABLE_ADS_DETAIL_.'_DocumentType'] = "'".sql_safe($DocumentType)."'";
      $insert[_TABLE_ADS_DETAIL_.'_HtmlCode'] = "'".sql_safe($inputEmbed)."'";
  		$insert[_TABLE_ADS_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$insert[_TABLE_ADS_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$insert[_TABLE_ADS_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z->insert(_TABLE_ADS_DETAIL_,$insert);
  		unset($insert);
  	}
  }
	$update[_TABLE_ADS_."_LastUpdate"] = "NOW()";
	$update[_TABLE_ADS_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_ADS_.'_Ignore'] = "'".sql_safe($Lang)."'";
	$update[_TABLE_ADS_.'_Start'] = "'".sql_safe($inputStartDate)."'";
	$update[_TABLE_ADS_.'_End'] = "'".sql_safe($inputExpireDate)."'";
  $update[_TABLE_ADS_.'_Position'] = "'".sql_safe($selectPosition)."'";
	$z->update(_TABLE_ADS_,$update,array(_TABLE_ADS_."_ID=" => (int)$itemid));
	unset($update);
}
echo 2;
CloseDB();
?>
