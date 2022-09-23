<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
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

$sql = "SELECT MAX("._TABLE_BANNER_."_Order) AS MaxO FROM "._TABLE_BANNER_;
$sql .= " WHERE "._TABLE_BANNER_."_Key IN ('".implode("','",$dataModuleKey)."')";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$MaxOrder = $Row["MaxO"]+1;

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
$StatusPublic = (!empty($_POST["StatusPublic"])?$_POST["StatusPublic"]:'Yes');
$selectLevel = (isset($_POST['selectLevel'])?$_POST['selectLevel']:'');
$inputLevel = (!empty($_POST['inputLevel'])?$_POST['inputLevel']:'');

$insert = array();
$insert[_TABLE_BANNER_.'_Key'] = "'".$mymenukey."'";
$insert[_TABLE_BANNER_.'_GroupID'] = sql_safe($GroupID,false,true);
$insert[_TABLE_BANNER_.'_GroupBanner'] = "'".sql_safe($selectGroup)."'";
$insert[_TABLE_BANNER_.'_GroupW'] = "'".sql_safe($W)."'";
$insert[_TABLE_BANNER_.'_GroupH'] = "'".sql_safe($H)."'";
$insert[_TABLE_BANNER_.'_CreateDate'] = "NOW()";
$insert[_TABLE_BANNER_.'_LastUpdate'] = "NOW()";
$insert[_TABLE_BANNER_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_BANNER_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_BANNER_.'_Start'] = "'".sql_safe($inputStartDate)."'";
$insert[_TABLE_BANNER_.'_End'] = "'".sql_safe($inputExpireDate)."'";
$insert[_TABLE_BANNER_.'_Status'] = "'On'";
$insert[_TABLE_BANNER_.'_Ignore'] = "'".sql_safe($Lang)."'";
$insert[_TABLE_BANNER_.'_Order'] = sql_safe($MaxOrder,false,true);
$insert[_TABLE_BANNER_.'_Public'] = "'".sql_safe($StatusPublic)."'";
$insert[_TABLE_BANNER_.'_SeeOnlyType'] = "''";
$insert[_TABLE_BANNER_.'_SeeOnly'] = "''";
$z = new __webctrl;
$z->insert(_TABLE_BANNER_,$insert);
$insertid = $z->insertid();
unset($insert);
if($insertid>0){
  foreach($systemLang as $lkey=>$lval){
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputSubject = (!empty($_POST["inputSubject".$lkey])?$_POST["inputSubject".$lkey]:'');
    $inputTitle = (!empty($_POST["inputTitle".$lkey])?encodetxterea($_POST["inputTitle".$lkey]):'');
    $inputURL = (!empty($_POST["inputURL".$lkey])?$_POST["inputURL".$lkey]:'');
    $selectTarget = (!empty($_POST["selectTarget".$lkey])?$_POST["selectTarget".$lkey]:'');
    $inputBannerCode = (!empty($_POST["inputBannerCode".$lkey])?encodetxterea($_POST["inputBannerCode".$lkey]):'');

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
          $thumb->save($PathUploadPicture."thum-1-".$filewallshow,100);
        }
      }
      $rootpathbanner = str_replace($PathUploadPicture,"",$PathUploadPicture.$filewallshow);
      $insert[_TABLE_BANNER_DETAIL_.'_PictureFile'] = "'".sql_safe($rootpathbanner)."'";
    }
    $insert[_TABLE_BANNER_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_Subject'] = "'".sql_safe($inputSubject)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_Title'] = "'".sql_safe($inputTitle)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_BannerCode'] = "'".sql_safe($inputBannerCode)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_URL'] = "'".sql_safe($inputURL)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_Target'] = "'".sql_safe($selectTarget)."'";
    $insert[_TABLE_BANNER_DETAIL_.'_UpdateDate'] = "NOW()";
    if(!empty($Ignore)){
      $insert[_TABLE_BANNER_DETAIL_.'_Status'] = "'Off'";
      $Lang .= "|".$lkey.":Off";
    }else{
      $insert[_TABLE_BANNER_DETAIL_.'_Status'] = "'On'";
      $Lang .= "|".$lkey.":On";
    }
    $z = new __webctrl;
    $z->insert(_TABLE_BANNER_DETAIL_,$insert);
    unset($insert);
  }
}
$sql = "UPDATE "._TABLE_BANNER_." SET "._TABLE_BANNER_."_Ignore='".sql_safe($Lang)."' WHERE "._TABLE_BANNER_."_ID = ".(int)$insertid;
$z = new __webctrl;
$z->query($sql);

echo 2;
CloseDB();
?>
