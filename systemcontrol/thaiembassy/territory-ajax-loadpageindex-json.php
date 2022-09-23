<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):'');
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

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
$sql .= "SELECT * FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_ID AS ID";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionID AS _RegionID";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionName AS _RegionName";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Name AS _Name";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CountryName AS CountryName";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CreateDate AS CreateDate";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Order AS ListOrder";
  $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Status AS ListStatus";
  $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_;
  $sql .= " WHERE 1";
  if(!empty($dataGroup)){
    $sql .= " AND "._TABLE_ADMIN_TERRITORY_."_RegionID = ".intval($dataGroup);
  }
	unset($ArrField);
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
				$sql .= "TBmain._RegionName LIKE '%".$TVal."%'";
        $sql .= " OR TBmain._Name LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.ListOrder ASC";
unset($ArrField);
// echo $sql;
// exit();
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
    $_RegionName = $Row["_RegionName"];
    $_Name = $Row["_Name"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
    $CountryName = $Row["CountryName"];

    $ArrField = array();
    $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_internal_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_internal_StateName , "._TABLE_ADMIN_TERRITORY_."_internal_CountryName) AS StateName";
    $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_internal WHERE "._TABLE_ADMIN_TERRITORY_."_internal_TerritoryID = ".intval($ID);
    unset($ArrField);
    $z->sql($sql);
    $vInternal = $z->row();
    $vArrProvince_I = array_column($vInternal, 'StateName');

    $ArrField = array();
    $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_external_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_external_StateName , "._TABLE_ADMIN_TERRITORY_."_external_CountryName) AS StateName";
    $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_external WHERE "._TABLE_ADMIN_TERRITORY_."_external_TerritoryID = ".intval($ID);
    unset($ArrField);
    $z->sql($sql);
    $vExternal = $z->row();
    $vArrCountru_E = array_column($vExternal, 'StateName');

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      $listmnubtn .='<li>';
        $dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
        $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
      $listmnubtn .='</li>';
      $listmnubtn .='<li>';
        $datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
        $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
      $listmnubtn .='</li>';
      $listmnubtn .='<li class="divider"></li>';
      foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
        $listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
          $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
          $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
        $listmnubtn .='</li>';
      }
		$listmnubtn .='</ul>';
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["RegionName"] = $_RegionName;
		$arr["Name"] = $_Name;
    $arr["valueCreateDate"] = $CreateDate;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $MemarrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["CountryName"] = $CountryName;
    $arr["vInternal"] = $vArrProvince_I;
    $arr["vExternal"] = $vArrCountru_E;
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
