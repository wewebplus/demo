<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);

$inmodulekey = array_keys($menuFolder, "content");
$arrMnuName = array();
foreach($inmodulekey as $kModuleKey=>$vModuleKey){
	$LMId = "Admin".$vModuleKey;
	$LMModuleKey = $menuModuleKey[$vModuleKey];
	$LMModuleName = $menuName[$vModuleKey];
	$arr = array();
	$arr["ID"] = $vModuleKey;
	$arr["AdminID"] = $LMId;
	$arr["ModuleKey"] = $LMModuleKey;
	$arr["ModuleName"] = $LMModuleName;
	$arrMnuName[] = $arr;
}
// echo '<pre>';
// print_r($arrMnuName);
// echo '</pre>';

// $key = array_search('green', $menuModuleKey);

$PageSize = 50;
$PageShow = 1;
$FolderKey = "products";
$found = array();
$langkey = $_SESSION['Session_Admin_Language'];
$sql = "";
$ArrField = array();
$ArrField[] = "TBmain.ID";
$ArrField[] = "TBmain.ListKey";
$ArrField[] = "TBmain.GroupID";
$ArrField[] = "TBmain.Subject".$_SESSION['Session_Admin_Language'];
$ArrField[] = "TBJoinGroup.TBJoinGroupName AS GroupName";
$ArrField[] = "TBmain.LastUpdate";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
	$arrf[] = "a."._TABLE_CONTENT_."_Key AS ListKey";
	$arrf[] = "a."._TABLE_CONTENT_."_GID AS GroupID";
	$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
	$arrf[] = "a."._TABLE_CONTENT_."_PictureAlt AS PictureAlt";
	$arrf[] = "a."._TABLE_CONTENT_."_Order AS ListOrder";
  $arrf[] = "a."._TABLE_CONTENT_."_View AS ListView";
	$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
	$arrf[] = "a."._TABLE_CONTENT_."_End AS EndDate";
	$arrf[] = "a."._TABLE_CONTENT_."_LastUpdate AS LastUpdate";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusHome AS StatusHome";
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$langkey;
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
	$sql .= " INNER JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_CONTENT_DETAIL_;
    $sql .= " WHERE "._TABLE_CONTENT_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_CONTENT_."_ID = ".$langkey."."._TABLE_CONTENT_DETAIL_."_ContentID)";
	$sql .= " WHERE 1";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
	$sql .= "SELECT "._TABLE_CONTENT_GROUP_."_ID AS TBJoinGroupID,"._TABLE_CONTENT_GROUP_."_Name AS TBJoinGroupName FROM "._TABLE_CONTENT_GROUP_;
	$sql .= " WHERE "._TABLE_CONTENT_GROUP_."_Status = 'On'";
	$sql .= " AND "._TABLE_CONTENT_GROUP_."_Language = '".$langkey."'";
$sql .= ") TBJoinGroup ON (TBmain.GroupID = TBJoinGroup.TBJoinGroupID)";
$sql .= " WHERE 1";
$sql.=" ORDER BY TBmain.LastUpdate DESC";
unset($ArrField);
$z = new __webctrl;
$z->sql($sql,$PageSize,$PageShow);
$RecordCount = $z->num();
$RecordCountInpage = $z->numinpage();
$v = $z->row();
$NoOfPage = $z->totalpage();
$index = 0;
if($RecordCount>0) {
	foreach($v as $Row){
		$index++;
		$ID = $Row["ID"];
		$ListKey = $Row["ListKey"];
		$GroupID = $Row["GroupName"];
		$Subject = $Row["Subject".$_SESSION['Session_Admin_Language']];
		$LastUpdate = $Row["LastUpdate"];
		$Dateshow = @dateformat($LastUpdate,'j M Y H:i');

		$query = "ModuleKey='".$ListKey."'";
		$mydata = @ArraySearch($arrMnuName,$query,1);
		$FullModuleName = @$arrMnuName[array_key_first($mydata)]["ModuleName"];

		$arr["valueid"] = $ID;
		$arr["ListKey"] = $FullModuleName;
		$arr["GroupName"] = $GroupID;
		$arr["Subject"] = $Subject;
		$arr["Dateshow"] = $Dateshow;
		$found[] = $arr;
	}
}
$output = array(
	"status" => "ok",
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
