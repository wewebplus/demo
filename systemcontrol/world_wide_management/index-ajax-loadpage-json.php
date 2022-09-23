<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
//$Login_MenuID;

if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}

if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}

$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;
$pmausertype = $UserPermission->usertype;
if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}

$found = array();

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?20:$selectPerPage);//_DEFAULT_PAGESIZE_
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "(";
	$arrf = array();
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_ID AS ID";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryID AS CountryID";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryCode AS CountryCode";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryLongCode AS CountryLongCode";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryISD AS CountryISD";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryNameEN AS CountryName";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_Status AS ListStatus";
	$arrf[] = "IF(TBJoinCheck.CountRefCheck IS NULL or TBJoinCheck.CountRefCheck = '', 0, TBJoinCheck.CountRefCheck) as CountRefCheck";
	$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRCOUNTRIES_;
	$sql .= " LEFT JOIN (";
		$sql .= "SELECT * FROM ";
		$sql .= "(";
			$arrinnercount = array();
			$arrinnercount[] = "COUNT(*) AS CountRefCheck";
			$arrinnercount[] = _TABLE_ADDRSTATE_."_CountryID AS JoinContentID";
			$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADDRSTATE_." WHERE 1 GROUP BY "._TABLE_ADDRSTATE_."_CountryID";
			unset($arrinnercount);
		$sql .= ") TBCount";
	$sql .= ") TBJoinCheck ON ("._TABLE_ADDRCOUNTRIES_."_CountryID = TBJoinCheck.JoinContentID)";
	$sql .= " WHERE 1";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if(!empty($dataKeyword)){
  $arrkeyword = explode(" ",$dataKeyword);
  if(count($arrkeyword)>0){
    $sql .= " AND ";
    $sql .= "(";
    $ikeyword = 0;
    foreach($arrkeyword as $TKey=>$TVal){
      if(trim($TVal)!=''){
        $ikeyword++;
        if($ikeyword>1){
          $sql .= " AND ";
        }
        $sql .= "(";
          $sql .= "TBmain.CountryName LIKE '%".$TVal."%'";
          $sql .= " OR TBmain.CountryLongCode LIKE '%".$TVal."%'";
          $sql .= " OR TBmain.CountryCode LIKE '%".$TVal."%'";
        $sql .= ")";
      }
    }
    $sql .= ")";
  }
}
$sql.=" ORDER BY TBmain.CountryName ASC";
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
		$CountryName = $Row["CountryName"];
		$CountryCode = $Row["CountryCode"];
		$CountryLongCode = $Row["CountryLongCode"];
		$CountryISD = $Row["CountryISD"];
		$CountRefCheck = $Row["CountRefCheck"];

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			$showdropdown = true;
			foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
					$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
					$listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';
		$LinkUser = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=user');
		$LinkView = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
		$LinkEdit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
		$LinkDelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["CountryNameEN"] = $CountryName;
		$arr["CountryCode"] = $CountryCode;
		$arr["CountryLongCode"] = $CountryLongCode;
		$arr["CountryISD"] = $CountryISD;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
		$arr["LinkView"] = $LinkView;
		$arr["LinkEdit"] = $LinkEdit;
		$arr["LinkDelete"] = $LinkDelete;
		$arr["LinkUser"] = $LinkUser;
		$arr["LinkDhowDropdown"] = $showdropdown;
		$arr["CountRefCheck"] = $CountRefCheck;
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
