<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
//$Login_MenuID;
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$dataGroup = (!empty($_POST["dataGroup"])?$_POST["dataGroup"]:0);

if(!empty($Login_MenuID)){
	$indexLogin_MenuID = substr($Login_MenuID,5);
	$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
	$mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}

if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
$W = $defaultdata[$Login_MenuID]["thumbgroup"]["W"][count($defaultdata[$Login_MenuID]["thumbgroup"]["W"])-1];
$prefiximg = "thum".$W;

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
$ArrFieldMain[] = "TB.*";
$sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_FRONTMENU_.'_ID AS ID';
	$arrf[] = "a."._TABLE_FRONTMENU_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_FRONTMENU_.'_Order AS ListOrder';
	$arrf[] = "a."._TABLE_FRONTMENU_.'_Name AS Name';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENU_." a";
	$sql .= " WHERE a."._TABLE_FRONTMENU_."_Folder='".$FolderKey."'";
	$sql .= " AND ";
	$sql .= "(a."._TABLE_FRONTMENU_."_ParentID  = 0)";
	unset($arrf);
$sql .= ") TB";
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
				$sql .= "TB.Name LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql.=" ORDER BY TB.".$selectOrder." ".$selectASCDESC;
unset($ArrFieldMain);
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
		$ListIndex = ($RecordStart+$index);
		$InID = $Row["ID"];
    	$Name = $Row["Name"];
		$InStatus = $Row["ListStatus"];
		if($InStatus=='On'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$InID.'&statusto=Off&actiontype=changestatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$InID.'&statusto=On&actiontype=changestatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง</a>';
		}
		$dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$InID.'&actiontype=edit');
		$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$InID.'&actiontype=delete');
		$dataaddsub = encode_URL('Login_MenuID='.$Login_MenuID.'&GroupID='.$InID.'&actiontype=add');
		$datasortsub = encode_URL('Login_MenuID='.$Login_MenuID.'&GroupID='.$InID.'&actiontype=sortsubgroup');
		$arrSubgroup = array();
		$RecordCountSubGroup = 0;
		$arr["ListIndex"] = $ListIndex;
		$arr["dataedit"] = $dataedit;
		$arr["datadelete"] = $datadelete;
		$arr["dataaddsub"] = $dataaddsub;
		$arr["datasortsub"] = $datasortsub;
		$arr["ID"] = $InID;
		$arr["Name"] = $Name;
		$arr["Status"] = $InStatus;
		$arr["Btnstatus"] = $btnstatus;
		$arr["CountSubGroup"] = $RecordCountSubGroup;
		$arr["DataSubGroup"] = $arrSubgroup;
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
