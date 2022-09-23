<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$inputTaskName = $_POST["inputTaskName"];
$myselectdoc = intval($_POST["myselectdoc"]);
$NoOfMember = (!empty($_POST["selectmailid"])?count($_POST["selectmailid"]):0);
$inputStart = (!empty($_POST["inputStart"])?$_POST["inputStart"]:'');
$inputStart = convertdatetodb($inputStart,"English")." 00:00:00";

$insert[_TABLE_MAIL_TASK_."_Folder"] = "'".$FolderKey."'";
$insert[_TABLE_MAIL_TASK_."_Language"] = "'".$_SESSION["Session_Admin_Language"]."'";
$insert[_TABLE_MAIL_TASK_."_Name"] = "'".sql_safe($inputTaskName)."'";
$insert[_TABLE_MAIL_TASK_."_NoOfMember"] = "'0'";
$insert[_TABLE_MAIL_TASK_."_NoOfSend"] = "'0'";
$insert[_TABLE_MAIL_TASK_."_DocumentID"] = sql_safe($myselectdoc,false,true);
$insert[_TABLE_MAIL_TASK_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
$insert[_TABLE_MAIL_TASK_."_CreateBy"] =  "'".sql_safe(	$_SESSION['Session_Admin_Name'])."'";
$insert[_TABLE_MAIL_TASK_."_CreateDate"] = "NOW()";
$insert[_TABLE_MAIL_TASK_."_LastUpdate"] = "NOW()";
$insert[_TABLE_MAIL_TASK_."_Status"] = "'On'";
$insert[_TABLE_MAIL_TASK_."_NoOfMember"] = sql_safe($NoOfMember,false,true);
$insert[_TABLE_MAIL_TASK_."_SendDate"] =  "'".sql_safe($inputStart)."'";
//$sql="INSERT INTO "._TABLE_MAIL_TASK_."(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
$z = new __webctrl;
$z->insert(_TABLE_MAIL_TASK_,$insert);
$MaxID = $z->insertid();
unset($insert);
$dataemail = array();
if($NoOfMember>0){
  foreach($_POST["selectmailid"] as $k=>$v){
    $datatype = $_POST["selectmailtype"][$k];
    switch($datatype){
      case 'enew':
        $sqllist = "SELECT "._TABLE_MAIL_MAILLIST_."_ID,"._TABLE_MAIL_MAILLIST_."_Name,"._TABLE_MAIL_MAILLIST_."_Email FROM "._TABLE_MAIL_MAILLIST_." WHERE "._TABLE_MAIL_MAILLIST_."_ID IN (".intval($v).")";
      	$z->sql($sqllist);
      	$RecordCountList = $z->num();
      	$vList = $z->row();
        $TaskID = @$MaxID;
        $MailType = "L";
        $MailID = $vList[0][_TABLE_MAIL_MAILLIST_."_ID"];
        $Name = $vList[0][_TABLE_MAIL_MAILLIST_."_Name"];
        $Email = $vList[0][_TABLE_MAIL_MAILLIST_."_Email"];
        $Status = "Waiting";
      break;case 'member':
        $sqllist = "SELECT "._TABLE_MEMBER_."_ID,"._TABLE_MEMBER_."_Name,"._TABLE_MEMBER_."_Email FROM "._TABLE_MEMBER_." WHERE "._TABLE_MEMBER_."_ID IN (".intval($v).")";
      	$z = new __webctrl;
      	$z->sql($sqllist);
      	$RecordCountList = $z->num();
      	$vList = $z->row();
        $TaskID = @$MaxID;
        $MailType = "M";
        $MailID = $vList[0][_TABLE_MEMBER_."_ID"];
        $Name = $vList[0][_TABLE_MEMBER_."_Name"];
        $Email = $vList[0][_TABLE_MEMBER_."_Email"];
        $Status = "Waiting";
      break; default:
    }
    $arr = array();
    $arr["TaskID"] = $TaskID;
    $arr["MailType"] = $MailType;
    $arr["MailID"] = $MailID;
    $arr["Name"] = $Name;
    $arr["Email"] = $Email;
    $arr["Status"] = $Status;
    $dataemail[] = $arr;
  }
}
if(count($dataemail)>0){
  foreach($dataemail as $vv){
    $insertProgress = array();
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_TaskID"] = sql_safe($vv["TaskID"],false,true);
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_MailType"] = "'".sql_safe($vv['MailType'])."'";
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_MailID"] = sql_safe($vv["MailID"],false,true);
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_Name"] = "'".sql_safe($vv['Name'])."'";
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_Email"] = "'".sql_safe($vv['Email'])."'";
    $insertProgress[_TABLE_MAIL_TASKPROGRESS_."_Status"] = "'".sql_safe($vv['Status'])."'";
    //$sql="INSERT INTO "._TABLE_MAIL_TASKPROGRESS_."(".implode(",",array_keys($insertProgress)).") VALUES (".implode(",",array_values($insertProgress)).")";
    $z->insert(_TABLE_MAIL_TASKPROGRESS_,$insertProgress);
    unset($insert);
  }
}
echo 2;
/*
echo '<pre>';
print_r($_POST["inputTaskName"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["saveData"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["myselect"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["mygroupselect"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["myothselect"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["myselectdoc"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["selectmailid"]);
echo '</pre>';
echo '<pre>';
print_r($_POST["selectmailtype"]);
echo '</pre>';
*/
?>
