<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");

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
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_INTRO_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_INTRO_UPLOAD_);
if(!is_dir($PathUploadPicture)) { mkdir($PathUploadPicture,0777); }

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$sql = "SELECT MAX("._TABLE_INTRO_."_Order) AS MaxO FROM "._TABLE_INTRO_." WHERE 1 ";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

$inputStartDate = (!empty($_POST['datepickerFrom'])?$_POST['datepickerFrom']:'');
$inputStartDate = convertdatetodb($inputStartDate,'English');

$inputExpireDate = (!empty($_POST['datepickerTo'])?$_POST['datepickerTo']:'');
$inputExpireDate = convertdatetodb($inputExpireDate,'English');

$insert = array();
$insert[_TABLE_INTRO_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_INTRO_.'_CreateDate'] = "NOW()";
$insert[_TABLE_INTRO_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_INTRO_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_INTRO_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_INTRO_.'_Start'] = "'".sql_safe($inputStartDate)."'";
$insert[_TABLE_INTRO_.'_End'] = "'".sql_safe($inputExpireDate)."'";
$insert[_TABLE_INTRO_.'_Status'] = "'On'";
$insert[_TABLE_INTRO_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_INTRO_.'_Order'] = sql_safe($MaxOrder,false,true);
$z = new __webctrl;
$z->insert(_TABLE_INTRO_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  foreach($systemLang as $lkey=>$lval){
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputURL = (!empty($_POST["inputURL".$lkey])?$_POST["inputURL".$lkey]:'');
    $selectTarget = (!empty($_POST["selectTarget".$lkey])?$_POST["selectTarget".$lkey]:'');

    $ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
    $ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
    $ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');

    $IntroType = (!empty($_POST["IntroType".$lkey])?$_POST["IntroType".$lkey]:'P');
    $inputEmbed = (!empty($_POST["inputEmbed".$lkey])?$_POST["inputEmbed".$lkey]:'');
    $inputLink = (!empty($_POST["inputLink".$lkey])?$_POST["inputLink".$lkey]:'');
    $inputHTML = (!empty($_POST["inputHTML".$lkey])?$_POST["inputHTML".$lkey]:'');

    $tempfile = $ushowpathfile.$ushowfile;
    if(is_file($tempfile)){
      if(copy($tempfile,$PathUploadPicture.$ushowfile)) {
        chmod($PathUploadPicture.$ushowfile,0777);
        unlink($tempfile);
      }
      $rootpathbanner = str_replace($PathUploadPicture,"",$PathUploadPicture.$ushowfile);
      $insert[_TABLE_INTRO_DETAIL_.'_PictureFile'] = "'".sql_safe($rootpathbanner)."'";
    }
    $insert[_TABLE_INTRO_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_IntroType'] = "'".sql_safe($IntroType)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_IntroEmbed'] = "'".sql_safe($inputEmbed)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_IntroLink'] = "'".sql_safe($inputLink)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_IntroHTML'] = "'".sql_safe($inputHTML)."'";
    $insert[_TABLE_INTRO_DETAIL_.'_UpdateDate'] = "NOW()";
    if(!empty($Ignore)){
      $insert[_TABLE_INTRO_DETAIL_.'_Status'] = "'Off'";
      $Lang .= "|".$lkey.":Off";
    }else{
      $insert[_TABLE_INTRO_DETAIL_.'_Status'] = "'On'";
      $Lang .= "|".$lkey.":On";
    }
    $z->insert(_TABLE_INTRO_DETAIL_,$insert);
    unset($insert);
  }
  $sql = "UPDATE "._TABLE_INTRO_." SET "._TABLE_INTRO_."_Ignore='".sql_safe($Lang)."' WHERE "._TABLE_INTRO_."_ID = ".(int)$insertid;
  $z->query($sql);
}
echo 2;
CloseDB();
?>
