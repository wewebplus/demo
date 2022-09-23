<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
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
$dataGroup = $defaultdata[$Login_MenuID]["group"];
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_BANNER_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_BANNER_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_BANNER_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_BANNER_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$inputStartDate = (!empty($_POST['datepickerFrom'])?$_POST['datepickerFrom']:'');
$inputStartDate = convertdatetodb($inputStartDate,'English');

$inputExpireDate = (!empty($_POST['datepickerTo'])?$_POST['datepickerTo']:'');
$inputExpireDate = convertdatetodb($inputExpireDate,'English');

$selectGroup = (!empty($_POST['selectGroup'])?$_POST['selectGroup']:'');
if(!empty($selectGroup)){
  $query = "Key='".$selectGroup."'";
  $mydata = @ArraySearch($dataGroup,$query,1);
  $GroupID = $dataGroup[array_key_first($mydata)]["ID"];
  $W = $dataGroup[array_key_first($mydata)]["W"];
  $H = $dataGroup[array_key_first($mydata)]["H"];
}else{
  $GroupID = 0;
  $W = 0;
  $H = 0;
}
if($itemid>0){
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputTitle = (!empty($_POST["inputTitle".$lkey])?encodetxterea($_POST["inputTitle".$lkey]):'');
    $inputURL = (!empty($_POST["inputURL".$lkey])?$_POST["inputURL".$lkey]:'');
    $selectTarget = (!empty($_POST["selectTarget".$lkey])?$_POST["selectTarget".$lkey]:'');

    $filewallshow = (!empty($_POST["filewallshow".$lkey])?$_POST["filewallshow".$lkey]:'');
    $filewallurl = (!empty($_POST["filewallurl".$lkey])?$_POST["filewallurl".$lkey]:'');
    $filewallname = (!empty($_POST["filewallname".$lkey])?$_POST["filewallname".$lkey]:'');

    $tempfile = $filewallurl.$filewallshow;
    if(is_file($tempfile)){
			if(copy($tempfile,$PathUploadPicture.$filewallshow)) {
				chmod($PathUploadPicture.$filewallshow,0777);
				unlink($tempfile);
        if(!empty($selectGroup)){
          $thumb = new Thumbnail($PathUploadPicture.$filewallshow);
          $thumb->resize($W);
          $thumb->crop(0, 0, $W,$H);
          $thumb->save($PathUploadPicture."crop-".$filewallshow,100);
        }
			}

      $rootpathbanner = str_replace($PathUploadPicture,"",$PathUploadPicture.$filewallshow);
      $update[_TABLE_WEBLINK_DETAIL_.'_PictureFile'] = "'".sql_safe($rootpathbanner)."'";

      $insert[_TABLE_WEBLINK_DETAIL_.'_PictureFile'] = "'".sql_safe($rootpathbanner)."'";
      if($detailid>0){
        $sqlx = "SELECT "._TABLE_WEBLINK_DETAIL_."_PictureFile AS PictureFile FROM "._TABLE_WEBLINK_DETAIL_." WHERE "._TABLE_WEBLINK_DETAIL_."_ID = ".(int)$detailid;
    		$zx = new __webctrl;
    		$zx->sql($sqlx);
    		$vx = $zx->row();
    		$rowx = $vx[0];
    		$oldhtml01 = $PathUploadPicture.$rowx['PictureFile'];
        $oldhtml02 = $PathUploadPicture."crop-".$rowx['PictureFile'];
        $oldhtml03 = $PathUploadPicture."crop-".$rowx['PictureFile'].".webp";
        if(is_file($oldhtml01)){unlink($oldhtml01);}
        if(is_file($oldhtml02)){unlink($oldhtml02);}
        if(is_file($oldhtml03)){unlink($oldhtml03);}
      }
    }

  	if($detailid>0){
  		$update[_TABLE_WEBLINK_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  		$update[_TABLE_WEBLINK_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
      $update[_TABLE_WEBLINK_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
      $update[_TABLE_WEBLINK_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
  		$update[_TABLE_WEBLINK_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_WEBLINK_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_WEBLINK_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->update(_TABLE_WEBLINK_DETAIL_,$update,array(_TABLE_WEBLINK_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_WEBLINK_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
  		$insert[_TABLE_WEBLINK_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  		$insert[_TABLE_WEBLINK_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  		$insert[_TABLE_WEBLINK_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
      $insert[_TABLE_WEBLINK_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
      $insert[_TABLE_WEBLINK_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
  		$insert[_TABLE_WEBLINK_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$insert[_TABLE_WEBLINK_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$insert[_TABLE_WEBLINK_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->insert(_TABLE_WEBLINK_DETAIL_,$insert);
  		unset($insert);
  	}
  }
  $update[_TABLE_WEBLINK_.'_GroupID'] = sql_safe($GroupID,false,true);
  $update[_TABLE_WEBLINK_.'_GroupBanner'] = "'".sql_safe($selectGroup)."'";
  $update[_TABLE_WEBLINK_.'_GroupW'] = "'".sql_safe($W)."'";
  $update[_TABLE_WEBLINK_.'_GroupH'] = "'".sql_safe($H)."'";
	$update[_TABLE_WEBLINK_."_LastUpdate"] = "NOW()";
	$update[_TABLE_WEBLINK_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_WEBLINK_.'_Ignore'] = "'".sql_safe($Lang)."'";
	$update[_TABLE_WEBLINK_.'_Start'] = "'".sql_safe($inputStartDate)."'";
	$update[_TABLE_WEBLINK_.'_End'] = "'".sql_safe($inputExpireDate)."'";

	$z = new __webctrl;
	$z->update(_TABLE_WEBLINK_,$update,array(_TABLE_WEBLINK_."_ID=" => (int)$itemid));
	unset($update);
}

echo 2;
CloseDB();
?>
