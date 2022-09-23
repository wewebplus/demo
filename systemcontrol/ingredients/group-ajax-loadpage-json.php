<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
//$Login_MenuID;
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];

$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
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
if($loadtype=='footable'){
	$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
	$PageSize = (empty($selectPerPage)?_DEFAULT_PAGESIZE_:$selectPerPage);
	$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
}else{
	$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
	$PageSize = (empty($selectPerPage)?20:$selectPerPage);
	$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
}

$sql = "";
$sqlsub = "";
$arrfmain = array();
$arrfmain[] = "TB.*";
$arrfmain[] = "IF(TBJoin.CountRefAll IS NULL or TBJoin.CountRefAll = '', 0, TBJoin.CountRefAll) AS CountLogs";
$arrfmain[] = "IF(TBJoin.CountRefNoUsage IS NULL or TBJoin.CountRefNoUsage = '', 0, TBJoin.CountRefNoUsage) AS CountRefNoUsage";
$arrfmain[] = "IF(TBJoin.CountRefUsage IS NULL or TBJoin.CountRefUsage = '', 0, TBJoin.CountRefUsage) AS CountRefUsage";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_INGREDIENTS_GROUP_.'_ID AS ID';
	$arrf[] = "a."._TABLE_INGREDIENTS_GROUP_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_INGREDIENTS_GROUP_.'_Order AS ListOrder';
	$sqlsub .= "a.*";
	foreach($systemLang as $lkey=>$lval){
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_GROUP_DETAIL_."_Subject AS Subject".$lkey;
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_GROUP_DETAIL_."_Status AS Status".$lkey;
	}
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_INGREDIENTS_GROUP_." a";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_INGREDIENTS_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_INGREDIENTS_GROUP_."_ID = ".$lkey."."._TABLE_INGREDIENTS_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_INGREDIENTS_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE a."._TABLE_INGREDIENTS_GROUP_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TB";
$sql .= " LEFT JOIN (";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrinnercount = array();
		$arrinnercount[] = "COUNT(*) AS CountRefAll";
		$arrinnercount[] = _TABLE_INGREDIENTS_."_GID AS JoinGroupID";
		$arrinnercount[] = "SUM(IF("._TABLE_INGREDIENTS_."_Status='Off', 1, 0)) AS CountRefNoUsage";
		$arrinnercount[] = "SUM(IF("._TABLE_INGREDIENTS_."_Status='On', 1, 0)) AS CountRefUsage";
		$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_INGREDIENTS_." WHERE 1 GROUP BY "._TABLE_INGREDIENTS_."_GID";
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
		$Fullname = $Row["Subject".$_SESSION['Session_Admin_Language']];
		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$CountLogs = $Row["CountLogs"];
		$listmnubtn = '';
		if($pmaalllist){
			$listmnubtn .='<ul class="dropdown-menu" role="menu">';
				// $listmnubtn .='<li>';
				// 	$dataexportexcel = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=listexportpdf');
				// 	$listmnubtn .='<a rev="'.$dataexportexcel.'" rel="'.$index.'" href="javascript:void(0);" onclick="exportGroupExcel(this);">Export Excel</a>';
				// $listmnubtn .='</li>';
				$listmnubtn .='<li>';
					$dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
				  $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
				$listmnubtn .='</li>';
				$listmnubtn .='<li>';
					if($CountLogs>0){
						$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
					  $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);">No Delete</a>';
					}else{
						$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
					  $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
					}
				$listmnubtn .='</li>';
				$listmnubtn .='<li class="divider"></li>';
				foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
					$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';

					  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
					  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';

					$listmnubtn .='</li>';
				}
			$listmnubtn .='</ul>';
		}
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueSubject"] = $Fullname;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
		$arr["CountLogs"] = number_format($CountLogs);
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
CloseDB();
?>
