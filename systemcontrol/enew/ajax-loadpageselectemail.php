<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['saveData']);
decode_URL($LoginData);
$myselect = (!empty($_POST["myselect"])?trim($_POST["myselect"]):'');
$mygroupselect = (!empty($_POST["mygroupselect"])?$_POST["mygroupselect"]:'');
$myothselect = (!empty($_POST["myothselect"])?$_POST["myothselect"]:'');

$arrmyselect = explode(",",$myselect);
rsort($arrmyselect);
$foundselect = array();

$arrmygroupselect = explode(",",$mygroupselect);
//sort($arrmygroupselect);
$foundgroupselect = array();

$arrmyothselect = explode(",",$myothselect);
rsort($arrmyothselect);
$foundothselect = array();

$z = new __webctrl;
if(count($arrmyselect)>0){
  foreach($arrmyselect as $k=>$v){
    $emailid = intval($v);
    if($emailid>0){
      $sql = "";
      $sql .= "SELECT * FROM ";
      $sql .= "("	;
      	$arrf = array();
      	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ID";
        $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_CreateDate AS CreateDate";
      	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Status AS ListStatus";
      	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ListOrder";
      	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Name AS Name";
        $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Email AS Email";
        $arrf[] = "TBGroup.GroupID AS GroupID";
      	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_MAILLIST_." a";
        $sql .= " LEFT JOIN (";
          $sql .= "SELECT "._TABLE_MAIL_MAILLISTINGROUP_."_MailListID AS MailListID,GROUP_CONCAT("._TABLE_MAIL_MAILLISTINGROUP_."_GroupID) AS GroupID FROM "._TABLE_MAIL_MAILLISTINGROUP_." WHERE 1 GROUP BY "._TABLE_MAIL_MAILLISTINGROUP_."_MailListID";
        $sql .= ") TBGroup ON ("._TABLE_MAIL_MAILLIST_."_ID = TBGroup.MailListID)";
      	$sql .= " WHERE a."._TABLE_MAIL_MAILLIST_."_ID = ".$emailid;
      	unset($arrf);
      $sql .= ") TBmain";
      $sql .= " WHERE 1";
      $z->sql($sql);
      $RecordCount = $z->num();
      if($RecordCount>0){
        $v = $z->row();
        $Name = $v[0]["Name"];
        $Email = $v[0]["Email"];
      }else{
        $Name = "";
        $Email = "";
      }
      $arr = array();
      $arr["id"] = $emailid;
      $arr["name"] = $Name;
      $arr["email"] = $Email;
      $foundselect[] = $arr;
    }
  }
}
if(count($arrmygroupselect)>0){
  foreach($arrmygroupselect as $k=>$v){
    $groupid = intval($v);
    if($groupid>0){
      $arrf = array();
      $arrf[] = "a."._TABLE_MAIL_GROUP_.'_ID AS ID';
    	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_Status AS ListStatus';
    	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupName AS GroupName';
    	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupShotname AS GroupShotname';
    	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_Order AS ListOrder';
      $sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_MAIL_GROUP_." a";
      $sql .= " WHERE "._TABLE_MAIL_GROUP_."_ID = ".(int)$groupid;
      unset($arrf);
      $z->sql($sql);
      $RecordCount = $z->num();
      if($RecordCount>0){
        $v = $z->row();
        $Name = $v[0]["GroupName"];

        $sql = "SELECT TBMail.* FROM "._TABLE_MAIL_MAILLISTINGROUP_;
        $sql .= " LEFT JOIN (";
          $arrf = array();
        	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS MailListID";
        	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Name AS Name";
          $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Email AS Email";
        	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_MAILLIST_." a";
        	$sql .= " WHERE 1";
        	unset($arrf);
        $sql .= ") TBMail ON ("._TABLE_MAIL_MAILLISTINGROUP_."_MailListID = TBMail.MailListID)";
        $sql .= " WHERE "._TABLE_MAIL_MAILLISTINGROUP_."_GroupID = ".intval($groupid);
        $z->sql($sql);
        $RecordCountEmail = $z->num();
        $Email = $z->row();
      }else{
        $Name = '';
        $Email = array();
      }
      $arr = array();
      $arr["id"] = $groupid;
      $arr["name"] = $Name;
      $arr["email"] = $Email;
      $foundgroupselect[] = $arr;
    }
  }
}

if(count($arrmyothselect)>0){
  foreach($arrmyothselect as $k=>$v){
    $emailid = intval($v);
    if($emailid>0){
      $sql = "";
      $arrf = array();
    	$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
      $arrf[] = "a."._TABLE_MEMBER_."_Name AS Name";
      $arrf[] = "a."._TABLE_MEMBER_."_RefNo AS RefNo";
      $arrf[] = "a."._TABLE_MEMBER_."_Email AS Email";
      $arrf[] = "a."._TABLE_MEMBER_."_Telephone AS Tel";
      $arrf[] = "a."._TABLE_MEMBER_."_Status AS ListStatus";
      $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
      $arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
      $arrf[] = "a."._TABLE_MEMBER_."_Level AS MLevel";
    	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
    	$sql .= " WHERE a."._TABLE_MEMBER_."_ID = ".$emailid;
      $z->sql($sql);
      $RecordCount = $z->num();
      if($RecordCount>0){
        $v = $z->row();
        $Name = $v[0]["Name"];
        $Email = $v[0]["Email"];
      }else{
        $Name = "";
        $Email = "";
      }
      $arr = array();
      $arr["id"] = $emailid;
      $arr["name"] = $Name;
      $arr["email"] = $Email;
      $foundothselect[] = $arr;
    }
  }
}

$output = array(
	"status" => "ok",
  "resultselectcount" => count($foundselect),
	"resultselect" => $foundselect,
  "resultgroupselectcount" => count($foundgroupselect),
	"resultgroupselect" => $foundgroupselect,
  "resultothselectcount" => count($foundothselect),
	"resultothselect" => $foundothselect
);
CloseDB();
echo json_encode($output);
exit();
?>
