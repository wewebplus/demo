<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

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

$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_DOWNLOAD_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_DOWNLOAD_HTML_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_DOWNLOAD_FILE_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_DOWNLOAD_IMG_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }

$sql = "SELECT MAX("._TABLE_DOWNLOAD_."_Order) AS MaxO FROM "._TABLE_DOWNLOAD_;
$sql .= " WHERE "._TABLE_DOWNLOAD_."_Key IN ('".implode("','",$dataModuleKey)."')";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

$selectGroup = (!empty($_POST["selectGroup"])?$_POST["selectGroup"]:0);
$selectSubGroup = (!empty($_POST["selectSubGroup"])?$_POST["selectSubGroup"]:0);

$inputStartDate = (!empty($_POST['datepickerFrom'])?$_POST['datepickerFrom']:'');
$inputStartDate = convertdatetodb($inputStartDate,'English');

$inputExpireDate = (!empty($_POST['datepickerTo'])?$_POST['datepickerTo']:'');
$inputExpireDate = convertdatetodb($inputExpireDate,'English');

$ListStatusContentPassword = (!empty($_POST["ListStatusContentPassword"])?$_POST["ListStatusContentPassword"]:'No');
$ContentPassword = (!empty($_POST["ContentPassword"])?$_POST["ContentPassword"]:'');
$StatusPublic = (!empty($_POST["StatusPublic"])?$_POST["StatusPublic"]:'No');

$putDataFile = $_POST["putDataFile"];
$putDataFile = str_replace(_HTTP_PATH_UPLOAD_,_RELATIVE_PATH_UPLOAD_,$putDataFile);
$putData = $_POST["putData"];

$insert = array();
$insert[_TABLE_DOWNLOAD_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_DOWNLOAD_.'_GID'] = "'".sql_safe($selectGroup)."'";
$insert[_TABLE_DOWNLOAD_.'_SGID'] = "'".sql_safe($selectSubGroup)."'";

$insert[_TABLE_DOWNLOAD_.'_CreateDate'] = "NOW()";
$insert[_TABLE_DOWNLOAD_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_DOWNLOAD_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_DOWNLOAD_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_DOWNLOAD_.'_Start'] = "'".sql_safe($inputStartDate)."'";
$insert[_TABLE_DOWNLOAD_.'_End'] = "'".sql_safe($inputExpireDate)."'";
$insert[_TABLE_DOWNLOAD_.'_Status'] = "'On'";
$insert[_TABLE_DOWNLOAD_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_DOWNLOAD_.'_IP'] = "'".get_real_ip()."'";
$insert[_TABLE_DOWNLOAD_.'_Order'] = sql_safe($MaxOrder,false,true);
$insert[_TABLE_DOWNLOAD_.'_StatusContentPassword'] = "'".sql_safe($ListStatusContentPassword)."'";
$insert[_TABLE_DOWNLOAD_.'_ContentPassword'] = "'".sql_safe($ContentPassword)."'";
$insert[_TABLE_DOWNLOAD_.'_Public'] = "'".sql_safe($StatusPublic)."'";

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

    $insert[_TABLE_DOWNLOAD_.'_Picture'] = "'".sql_safe($filename)."'";
    $insert[_TABLE_DOWNLOAD_.'_PictureAlt'] = "'".sql_safe($putData)."'";
    unlink($putDataFile);
  }
}

$z = new __webctrl;
$z->insert(_TABLE_DOWNLOAD_,$insert);
$insertid = $z->insertid();
unset($insert);

foreach($systemLang as $lkey=>$lval){
  $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
  $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
  $inputTitle = (!empty($_POST["inputTitle".$lkey])?encodetxterea($_POST["inputTitle".$lkey]):'');;
  $VDOType = (!empty($_POST["DocumentDownloadType".$lkey])?$_POST["DocumentDownloadType".$lkey]:'F');
  $inputLink = (!empty($_POST["inputLink".$lkey])?$_POST["inputLink".$lkey]:'');
  $ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
  $ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
  $ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');

  $tmpfile = $ushowpathfile.$ushowfile;
  if(is_file($tmpfile)){
    $myExtensionArray = explode(".",$tmpfile);
    $myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);
    if(copy($tmpfile,$PathUploadFile.$ushowfile)) {
      chmod($PathUploadFile.$ushowfile,0777);
    }
    if(is_file($tmpfile)) {
      unlink($tmpfile);
    }
    $insert[_TABLE_DOWNLOAD_DETAIL_.'_F'] = "'".sql_safe($ushowfile)."'";
    $insert[_TABLE_DOWNLOAD_DETAIL_.'_FType'] = "'".sql_safe($myExtension)."'";
    $insert[_TABLE_DOWNLOAD_DETAIL_.'_FName'] = "'".sql_safe($ushowfilename)."'";
  }

  $insert[_TABLE_DOWNLOAD_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_Type'] = "'".sql_safe($VDOType)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_L'] = "'".sql_safe($inputLink)."'";
  $insert[_TABLE_DOWNLOAD_DETAIL_.'_UpdateDate'] = "NOW()";
  if(!empty($Ignore)){
    $insert[_TABLE_DOWNLOAD_DETAIL_.'_Status'] = "'Off'";
    $Lang .= "|".$lkey.":Off";
  }else{
    $insert[_TABLE_DOWNLOAD_DETAIL_.'_Status'] = "'On'";
    $Lang .= "|".$lkey.":On";
  }
  $z = new __webctrl;
  $z->insert(_TABLE_DOWNLOAD_DETAIL_,$insert);
  unset($insert);
}
$sql = "UPDATE "._TABLE_DOWNLOAD_." SET "._TABLE_DOWNLOAD_."_Ignore='".sql_safe($Lang)."' WHERE "._TABLE_DOWNLOAD_."_ID = ".(int)$insertid;
$z = new __webctrl;
$z->query($sql);

//search function
$option = array();
$option["dataid"] = $insertid;
$option["datatype"] = "download";
$option["datakey"] = $mymenukey;
$option["datacreateid"] = $_SESSION['Session_Admin_ID'];
$option["datacreatename"] = $_SESSION['Session_Admin_Name'];
$option["datalang"] = $systemLang;
addSearch($option);
//end search function

echo 2;
CloseDB();
?>
