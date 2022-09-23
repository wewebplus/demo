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

$arrf = array();
$arrf[] = _TABLE_ADMIN_USERGROUP_."_ID AS ID";
$arrf[] = _TABLE_ADMIN_USERGROUP_."_Name AS Name";
$arrf[] = _TABLE_ADMIN_USERGROUP_."_Title AS Title";
$arrf[] = _TABLE_ADMIN_USERGROUP_."_Status AS ListStatus";
$arrf[] = "IF(TBJoinCheck.CountRefCheck IS NULL or TBJoinCheck.CountRefCheck = '', 0, TBJoinCheck.CountRefCheck) as CountRefCheck";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_USERGROUP_;
$sql .= " LEFT JOIN (";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrinnercount = array();
		$arrinnercount[] = "COUNT(*) AS CountRefCheck";
		$arrinnercount[] = _TABLE_ADMIN_USER_."_Type AS JoinContentID";
		$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADMIN_USER_." WHERE 1 GROUP BY "._TABLE_ADMIN_USER_."_Type";
		unset($arrinnercount);
	$sql .= ") TBCount";
$sql .= ") TBJoinCheck ON ("._TABLE_ADMIN_USERGROUP_."_ID = TBJoinCheck.JoinContentID)";
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
				$sql .= "("._TABLE_ADMIN_USERGROUP_."_Name LIKE '%".$TVal."%' OR "._TABLE_ADMIN_USERGROUP_."_Title LIKE '%".$TVal."%')";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql.=" ORDER BY "._TABLE_ADMIN_USERGROUP_."_Order ASC";
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
		$Fullname = $Row["Name"];
		$Title = echoDetailTooneline($Row["Title"]);
		$CountRefCheck = $Row["CountRefCheck"];

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			/*
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
			*/
			if($pmausertype!=$ID){
				$showdropdown = true;
				foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
					$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
					  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
						$listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
					$listmnubtn .='</li>';
				}
			}else{
				$showdropdown = false;
			}
		$listmnubtn .='</ul>';
		$LinkUser = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=user');
		$LinkView = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
		$LinkEdit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
		$LinkDelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueSubject"] = $Fullname;
		$arr["valueTitle"] = $Title;
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
