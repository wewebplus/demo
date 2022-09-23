<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$dataLevel = (isset($_POST['mydata'])?trim($_POST['mydata']):'');
$txtcheck = (isset($_POST['txtcheck'])?trim($_POST['txtcheck']):'');

$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$z = new __webctrl;
$founduser = array();
$stringarr = "0";
if($txtcheck=='checkdatabanner'){
	$sql = "SELECT "._TABLE_BANNER_SEEONLY_."_MemberID AS MemberID FROM "._TABLE_BANNER_SEEONLY_." WHERE "._TABLE_BANNER_SEEONLY_."_BannerID = ".intval($itemid);
	$z->sql($sql);
	$RecordCount = $z->num();
	$v = $z->row();
	$index = 0;
	if($RecordCount>0) {
	  foreach($v as $Row){
	    $index++;
	    $MemberID = $Row["MemberID"];
			$arrMemberInfo = MemberInfo($MemberID);
			$Name = $arrMemberInfo->data["Name"];
			$stringarr .= ",".$MemberID;
	    $arr["valueid"] = encode_URL('memberid='.$MemberID.'&actiontype=lineid');
	    $arr["value"] = $Name;
	    $founduser[] = $arr;
	  }
	}
}
// echo implode(', ', array_map(function ($entry) {return $entry['valueid'];}, $founduser));

$found = array();
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
  $arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
  $arrf[] = "a."._TABLE_MEMBER_."_Orgpass AS Orgpass";
	$arrf[] = "a."._TABLE_MEMBER_."_AName AS AName";
  $arrf[] = "a."._TABLE_MEMBER_."_Name AS FName";
  $arrf[] = "a."._TABLE_MEMBER_."_LName AS LName";
  $arrf[] = "CONCAT(IF(a."._TABLE_MEMBER_."_AName IS NULL or a."._TABLE_MEMBER_."_AName = '', '', TRIM(a."._TABLE_MEMBER_."_AName)),TRIM(a."._TABLE_MEMBER_."_Name), ' ', TRIM(a."._TABLE_MEMBER_."_LName)) AS FullName";
  $arrf[] = "a."._TABLE_MEMBER_."_IDCard AS IDCard";
  $arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '', a."._TABLE_MEMBER_."_Email) as Email";
  $arrf[] = "IF(a."._TABLE_MEMBER_."_Telephone IS NULL or a."._TABLE_MEMBER_."_Telephone = '', '', a."._TABLE_MEMBER_."_Telephone) as Tel";
  $arrf[] = "a."._TABLE_MEMBER_."_Status AS ListStatus";
  $arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
  $arrf[] = "IF(a."._TABLE_MEMBER_."_Member IS NULL or a."._TABLE_MEMBER_."_Member = '', '0', a."._TABLE_MEMBER_."_Member) as MLevel";
  $arrf[] = "a."._TABLE_MEMBER_."_Membertxt AS MLevelTxt";
  $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE 1";
  if($dataLevel != ''){
    $sql .= " AND a."._TABLE_MEMBER_."_Member = '".trim($dataLevel)."'";
  }
	if($txtcheck=='checkdatabanner'){
		$sql .= " AND a."._TABLE_MEMBER_."_ID NOT IN (".$stringarr.")";
	}
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .= " ORDER BY TBmain.ListOrder DESC,TBmain.ID DESC";
unset($ArrField);
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$index = 0;
if($RecordCount>0) {
  foreach($v as $Row){
    $index++;
    $ID = $Row["ID"];
		$ID = encode_URL('memberid='.$ID.'&actiontype=lineid');
    $Name = $Row["FullName"];
    // $Email = $Row["Email"];
    // $Tel = $Row["Tel"];
		// $GroupName = $founduser[array_key_first($mydata)]["Name"];
		$arr["valueid"] = $ID;
    $arr["value"] = $Name;
    // $arr["valueEmail"] = $Email;
    // $arr["valueName"] = $Name;
    // $arr["valueTel"] = $Tel;
    $found[] = $arr;
  }
}
$output = array(
	"status" => "ok",
	"RecordCount" => $RecordCount,
  "mydata" => $dataLevel,
	"resultuser" => $founduser,
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();

?>
