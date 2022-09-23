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
//$Login_MenuID;
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');

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
$PageSize = (empty($selectPerPage)?20:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= " (";
  $arrf = array();
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ID';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_Keyword AS ListKeyword';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_IP AS ListIP';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ListOrder';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_SearchDate AS CreateDate';
  $arrf[] = 'TBJoin.cnt AS ListCount';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_SEARCH_LOGS_;
  $sql .= " INNER JOIN (";
    $sql .= "SELECT "._TABLE_SEARCH_LOGS_."_Keyword AS InJoinKey,max("._TABLE_SEARCH_LOGS_."_SearchDate) max_created_at,COUNT(*) cnt FROM "._TABLE_SEARCH_LOGS_." GROUP BY "._TABLE_SEARCH_LOGS_."_Keyword";
  $sql .= ") TBJoin ON ("._TABLE_SEARCH_LOGS_."_Keyword = TBJoin.InJoinKey AND "._TABLE_SEARCH_LOGS_."_SearchDate = TBJoin.max_created_at)";
	unset($arrf);
$sql .= ") TBmain";
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
				$sql .= "TBmain.ListKeyword LIKE '%".$TVal."%'";
				$sql .= " OR TBmain.ListIP LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.".$selectOrder." ".$selectASCDESC;
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
		$ListKeyword = $Row["ListKeyword"];
		$ListIP = $Row["ListIP"];
    $ListCount = $Row["ListCount"];
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

		$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=viewlist');
    $datareport = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=viewlist');

		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["ListKeyword"] = $ListKeyword;
		$arr["valueDateshow"] = $CreateDate;
		$arr["valueView"] = $dataview;
    $arr["valueReport"] = $datareport;
    $arr["ListCount"] = $ListCount;
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
	"pmaalllist" => $pmaalllist,
	"totalreccount" => number_format($RecordCount),
	"reccount" => (int)$RecordCount,
	"reccountinpage" => $RecordCountInpage,
	"pagesize" => $PageSize,
	"noofpage" => $NoOfPage,
	"spstart" => $rpagestart,
	"spend" => $rpageend,
	"nextpage" => intval($nextpage<=$NoOfPage?$nextpage:$selectPage),
	"backpage" => intval($backpage>0?$backpage:$selectPage),
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
