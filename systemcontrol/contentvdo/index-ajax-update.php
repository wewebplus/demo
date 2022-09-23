<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

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
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_VDO_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_VDO_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_VDO_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_VDO_IMG_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }

$selectGroup = (!empty($_POST["selectGroup"])?$_POST["selectGroup"]:0);
$selectSubGroup = (!empty($_POST["selectSubGroup"])?$_POST["selectSubGroup"]:0);

$inputStartDate = (!empty($_POST['datepickerFrom'])?$_POST['datepickerFrom']:'');
$inputStartDate = convertdatetodb($inputStartDate,'English');
$inputExpireDate = (!empty($_POST['datepickerTo'])?$_POST['datepickerTo']:'');
$inputExpireDate = convertdatetodb($inputExpireDate,'English');

$putDataFile = $_POST["putDataFile"];
$putDataFile = str_replace(_HTTP_PATH_UPLOAD_,_RELATIVE_PATH_UPLOAD_,$putDataFile);
$putData = $_POST["putData"];

$lkeyindex = "Home";
$filewallshow = (!empty($_POST["filewallshow".$lkeyindex])?$_POST["filewallshow".$lkeyindex]:'');
$filewallurl = (!empty($_POST["filewallurl".$lkeyindex])?$_POST["filewallurl".$lkeyindex]:'');
$filewallname = (!empty($_POST["filewallname".$lkeyindex])?$_POST["filewallname".$lkeyindex]:'');

if($itemid>0){
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputTitle = (!empty($_POST["inputTitle".$lkey])?encodetxterea($_POST["inputTitle".$lkey]):'');
    $VDOType = (!empty($_POST["VDOType".$lkey])?$_POST["VDOType".$lkey]:'E');
    $inputEmbed = (!empty($_POST["inputEmbed".$lkey])?$_POST["inputEmbed".$lkey]:'');
    $inputLink = (!empty($_POST["inputLink".$lkey])?$_POST["inputLink".$lkey]:'');
    $ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
    $ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
    $ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');

    $tmpfile = $ushowpathfile.$ushowfile;
    if(is_file($tmpfile)){
      $sqlx = "SELECT "._TABLE_VDO_DETAIL_."_VdoF AS VdoFile FROM "._TABLE_VDO_DETAIL_." WHERE "._TABLE_VDO_DETAIL_."_ID = ".(int)$detailid;
  		$zx = new __webctrl;
  		$zx->sql($sqlx);
  		$vx = $zx->row();
  		$rowx = $vx[0];
  		$oldvdo = $PathUploadFile.$rowx['VdoFile'];
      if(is_file($oldvdo)){unlink($oldvdo);}

      $myExtensionArray = explode(".",$tmpfile);
    	$myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);
    	if(copy($tmpfile,$PathUploadFile.$ushowfile)) {
    		chmod($PathUploadFile.$ushowfile,0777);
    	}
    	if(is_file($tmpfile)) {
    		unlink($tmpfile);
    	}
      $update[_TABLE_VDO_DETAIL_.'_VdoF'] = "'".sql_safe($ushowfile)."'";
      $update[_TABLE_VDO_DETAIL_.'_VdoFType'] = "'".sql_safe($myExtension)."'";
      $update[_TABLE_VDO_DETAIL_.'_VdoFName'] = "'".sql_safe($ushowfilename)."'";

      $insert[_TABLE_VDO_DETAIL_.'_VdoF'] = "'".sql_safe($ushowfile)."'";
      $insert[_TABLE_VDO_DETAIL_.'_VdoFType'] = "'".sql_safe($myExtension)."'";
      $insert[_TABLE_VDO_DETAIL_.'_VdoFName'] = "'".sql_safe($ushowfilename)."'";
    }

  	if($detailid>0){

  		$update[_TABLE_VDO_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  		$update[_TABLE_VDO_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
      $update[_TABLE_VDO_DETAIL_.'_VdoType'] = "'".sql_safe($VDOType)."'";
      $update[_TABLE_VDO_DETAIL_.'_VdoE'] = "'".sql_safe($inputEmbed)."'";
      $update[_TABLE_VDO_DETAIL_.'_VdoL'] = "'".sql_safe($inputLink)."'";
  		$update[_TABLE_VDO_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_VDO_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_VDO_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->update(_TABLE_VDO_DETAIL_,$update,array(_TABLE_VDO_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_VDO_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
  		$insert[_TABLE_VDO_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  		$insert[_TABLE_VDO_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  		$insert[_TABLE_VDO_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
      $insert[_TABLE_VDO_DETAIL_.'_VdoType'] = "'".sql_safe($VDOType)."'";
      $insert[_TABLE_VDO_DETAIL_.'_VdoE'] = "'".sql_safe($inputEmbed)."'";
      $insert[_TABLE_VDO_DETAIL_.'_VdoL'] = "'".sql_safe($inputLink)."'";
  		$insert[_TABLE_VDO_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$insert[_TABLE_VDO_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$insert[_TABLE_VDO_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->insert(_TABLE_VDO_DETAIL_,$insert);
  		unset($insert);
  	}
  }

  $sql = "SELECT "._TABLE_VDO_."_Picture AS thumb,"._TABLE_VDO_."_PictureHome AS thumbhome FROM "._TABLE_VDO_." WHERE "._TABLE_VDO_."_ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $row = $v[0];
  $ThumbnailPictureName = $row["thumb"];
  $ThumbnailPictureHome = $row['thumbhome'];

  $tempfile = $filewallurl.$filewallshow;
  if(is_file($tempfile)){
    if(copy($tempfile,$PathUploadPicture.$filewallshow)) {
      chmod($PathUploadPicture.$filewallshow,0777);
      unlink($tempfile);
    }
    $rootpathbanner = str_replace($PathUploadPicture,"",$PathUploadPicture.$filewallshow);
    $update[_TABLE_VDO_.'_PictureHome'] = "'".sql_safe($rootpathbanner)."'";
    $unlinkfile = $PathUploadPicture.$ThumbnailPictureHome;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
  }

  if(!empty($putDataFile)){
    // del img
    $unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
    $unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
    $unlinkfile = $PathUploadPicture.$ThumbnailPictureName.'.webp';
    if(is_file($unlinkfile)){unlink($unlinkfile);}
    foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
      $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName;
      if(is_file($unlinkfile)){unlink($unlinkfile);}
      $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName.'.webp';
      if(is_file($unlinkfile)){unlink($unlinkfile);}
    }
    // end del img

    $arrDataFileTemp = explode("/",$putDataFile);
    $filename = $arrDataFileTemp[count($arrDataFileTemp)-1];
    if(copy($putDataFile,$PathUploadPicture.$filename)) {
      chmod($PathUploadPicture.$filename,0777);

      $FileSave = $PathUploadPicture.$filename;
      $FileSaveCrop = $PathUploadPicture."crop-".$filename;

      $thumb = new Thumbnail($FileSave);
      // $thumb->resize($defaultdata[$Login_MenuID]["img"]["W"],0);
      $thumb->resize(0,$defaultdata[$Login_MenuID]["img"]["H"]);
      $thumb->crop(0, 0, $defaultdata[$Login_MenuID]["img"]["W"],$defaultdata[$Login_MenuID]["img"]["H"]);
      $thumb->save($FileSaveCrop,100);

      // $jw = new ImageToWebp();
      // $jw->convert( $FileSaveCrop, $FileSave.'.webp' );

      foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
        $FileSaveThumb = $PathUploadPicture.$vvl."-".$filename;
        $thumb = new Thumbnail($FileSave);
        $thumb->resize(0,$defaultdata[$Login_MenuID]["thumb"]["H"][$kvl]);
        $thumb->crop(0, 0, $defaultdata[$Login_MenuID]["thumb"]["W"][$kvl],$defaultdata[$Login_MenuID]["thumb"]["H"][$kvl]);
        $thumb->save($FileSaveThumb,100);
        // $jw = new ImageToWebp();
        // $jw->convert( $FileSaveThumb, $FileSaveThumb.'.webp' );
      }

      $update[_TABLE_VDO_.'_Picture'] = "'".sql_safe($filename)."'";
      $update[_TABLE_VDO_.'_PictureAlt'] = "'".sql_safe($putData)."'";
      unlink($putDataFile);
    }
  }

	$update[_TABLE_VDO_.'_GID'] = "'".sql_safe($selectGroup)."'";
  $update[_TABLE_VDO_.'_SGID'] = "'".sql_safe($selectSubGroup)."'";
	$update[_TABLE_VDO_."_LastUpdate"] = "NOW()";
	$update[_TABLE_VDO_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_VDO_.'_Ignore'] = "'".sql_safe($Lang)."'";
	$update[_TABLE_VDO_.'_Start'] = "'".sql_safe($inputStartDate)."'";
	$update[_TABLE_VDO_.'_End'] = "'".sql_safe($inputExpireDate)."'";
	$update[_TABLE_VDO_.'_IP'] = "'".get_real_ip()."'";

	$z = new __webctrl;
	$z->update(_TABLE_VDO_,$update,array(_TABLE_VDO_."_ID=" => (int)$itemid));
	unset($update);

  //search function
  $option = array();
  $option["dataid"] = $itemid;
  $option["datatype"] = "vdo";
  $option["datakey"] = $mymenukey;
  $option["datacreateid"] = $_SESSION['Session_Admin_ID'];
  $option["datacreatename"] = $_SESSION['Session_Admin_Name'];
  $option["datalang"] = $systemLang;
  addSearch($option);
  //end search function
}

echo 2;
CloseDB();
?>
