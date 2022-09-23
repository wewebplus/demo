<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$found = array();

if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $ModuleKey = $menuFolderModule[substr($Login_MenuID,5)];
}else{
  $mymenuinclude = "";
  $ModuleKey = "";
}
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}
if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$DataKey = $defaultdata[$Login_MenuID]["group"]["menuid"];

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?15:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$sqlsub = "";
$arrfmain = array();
$arrfmain[] = "TB.*";
$arrfmain[] = "IF(TBJoin.CountAllContent IS NULL or TBJoin.CountAllContent = '', 0, TBJoin.CountAllContent) AS CountLogs";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
  $arrf[] = "a."._TABLE_MAIL_GROUP_.'_ID AS ID';
	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupName AS GroupName';
	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_GroupShotname AS GroupShotname';
	$arrf[] = "a."._TABLE_MAIL_GROUP_.'_Order AS ListOrder';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_GROUP_." a";
	$sql .= " WHERE a."._TABLE_MAIL_GROUP_."_Folder='".$ModuleKey."'";
	unset($arrf);
$sql .= ") TB";
$sql .= " LEFT JOIN (";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrinnercount = array();
		$arrinnercount[] = "COUNT(*) AS CountAllContent";
		$arrinnercount[] = _TABLE_MAIL_MAILLISTINGROUP_."_GroupID AS JoinGroupID";
		$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_MAIL_MAILLISTINGROUP_." WHERE 1 GROUP BY "._TABLE_MAIL_MAILLISTINGROUP_."_GroupID";
		unset($arrinnercount);
	$sql .= ") TBCount";
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
				$sql .= "TB.GroupName LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TB.".$selectOrder." ".$ASCDESC." ,TB.ID DESC";
unset($ArrField);
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
		$Fullname = $Row["GroupName"];
    $CountLogs = $Row["CountLogs"];
		$arr = array();
		$arr["ListIndex"] = $ListIndex;
		$arr["valueidencode"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
    $arr["valueid"] = $ID;
		$arr["valueName"] = $Fullname;
    $arr["valueCount"] = $CountLogs;
		$found[] = $arr;
	}
}

$nextpage = $selectPage+1;
$backpage = $selectPage-1;
$rpagestart = $selectPage-2;
$rpagestart = ($rpagestart>=1?$rpagestart:1);
$rpageend = $rpagestart+4;
$rpageend = ($rpageend<=$NoOfPage?$rpageend:$NoOfPage);

$output = array(
	"status" => "ok",
	"reccount" => number_format($RecordCount),
	"reccountinpage" => $RecordCountInpage,
	"noofpage" => $NoOfPage,
	"spstart" => $rpagestart,
	"spend" => $rpageend,
	"nextpage" => ($nextpage<=$NoOfPage?$nextpage:$selectPage),
	"backpage" => ($backpage>0?$backpage:$selectPage),
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
