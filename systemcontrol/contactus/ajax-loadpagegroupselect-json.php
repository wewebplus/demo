<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];

$PageSearch = "";
if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}
if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;

if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}
$found = array();
$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?_DEFAULT_PAGESIZE_:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$arrfmain = array();
$arrfmain[] = "TB.ID";
$arrfmain[] = "TB.ListStatus";
$arrfmain[] = "TB.ListOrder";
$arrfmain[] = "IF(TB.Subject".$_SESSION['Session_Admin_Language']." IS NULL or TB.Subject".$_SESSION['Session_Admin_Language']." = '', TB.SubjectEN, TB.Subject".$_SESSION['Session_Admin_Language'].") as Subject";
$arrfmain[] = "IF(TB.Email".$_SESSION['Session_Admin_Language']." IS NULL or TB.Email".$_SESSION['Session_Admin_Language']." = '', TB.EmailEN, TB.Email".$_SESSION['Session_Admin_Language'].") as Email";
$arrfmain[] = "COUNT(TBJoin.JoinGroupID) AS CountLogs";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_ID AS ID';
	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Order AS ListOrder';
	foreach($systemLang as $lkey=>$lval){
		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS Subject".$lkey;
		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Email AS Email".$lkey;
		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS Status".$lkey;
	}
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTACT_GROUP_." a";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE a."._TABLE_CONTACT_GROUP_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TB";
$sql .= " LEFT JOIN (";
	$sql .= "SELECT "._TABLE_CONTACT_."_GroupID AS JoinGroupID,"._TABLE_CONTACT_."_CreateDate AS JoinCreateDate FROM "._TABLE_CONTACT_." WHERE 1";
$sql .= ") TBJoin ON (TB.ID = TBJoin.JoinGroupID)";
$sql .= " WHERE 1";
if(!empty($dataKeyword)){
  $arrkeyword = explode(" ",$dataKeyword);
  if(count($arrkeyword)>0){
    $sql .= " AND ";
    $sql .= "(";
    foreach($arrkeyword as $TKey=>$TVal){
      if($TKey>0){
        $sql .= " OR ";
      }
      $sql .= "(";
				$sql .= "TB.Subject".$_SESSION['Session_Admin_Language']." LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " GROUP BY TB.ID";
$sql .= " ORDER BY TB.".$selectOrder." ".$ASCDESC;
unset($arrfmain);
$z = new __webctrl;
$z->sql($sql,$PageSize,$PageShow);
$RecordCount = $z->num();
$RecordCountInpage = $z->numinpage();
$v = $z->row();
$NoOfPage = $z->totalpage();
$RecordStart = ($PageSize*($PageShow-1));
$index = 0;
if($RecordCount>0) {
	foreach($v as $Row){
		$index++;
		$ListIndex = $RecordCount-($RecordStart+($index-1));
		$ID = $Row["ID"];
		$Fullname = $Row["Subject"];
		$Email = $Row["Email"];
		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$CountLogs = $Row["CountLogs"];
		$arr["ListIndex"] = $ListIndex;
		// $arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueid"] = $ID;
		$arr["valueSubject"] = $Fullname;
		$arr["valueEmail"] = $Email;
		$arr["CountLogs"] = number_format($CountLogs);
		$found[] = $arr;
	}
}
$output = array(
	"status" => "ok",
  "pmaalllist" => $pmaalllist,
	"totalreccount" => number_format($RecordCount),
	"reccount" => (int)$RecordCount,
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
CloseDB();
?>
