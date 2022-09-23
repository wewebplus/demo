<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
//$Login_MenuID;

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
$userid = intval($_SESSION['Session_Admin_ID']);
$found = array();

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?20:$selectPerPage);// _DEFAULT_PAGESIZE_
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$arrfmain = array();
$arrfmain[] = "TBmain.*";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = _TABLE_ADMIN_USER_."_ID AS ID";
	$arrf[] = _TABLE_ADMIN_USER_."_EmpID AS EmpID";
	$arrf[] = _TABLE_ADMIN_USER_."_Type AS uType";
	$arrf[] = _TABLE_ADMIN_USER_."_Level AS uLevel";
	$arrf[] = _TABLE_ADMIN_USER_."_UserName AS UserName";
	$arrf[] = _TABLE_ADMIN_USER_."_Status AS ListStatus";
	$arrf[] = _TABLE_ADMIN_USER_."_LastLoginDate AS LastLoginDate";
	$arrf[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
	$arrf[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
	$arrf[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
	$arrf[] = "TBType.TypeName";
	$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_USER_;
	$sql .= " LEFT JOIN "._TABLE_ADMIN_STAFF_." ON ("._TABLE_ADMIN_USER_."_EmpID = "._TABLE_ADMIN_STAFF_."_ID)";
	$sql .= " LEFT JOIN (";
		$sql .= "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS ID, "._TABLE_ADMIN_USERGROUP_."_Name AS TypeName FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
	$sql .= ") TBType ON ("._TABLE_ADMIN_USER_."_Type = TBType.ID)";
	$sql .= " WHERE 1";
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
				$sql .= "TBmain.FName LIKE '%".$TVal."%'";
				$sql .= " OR TBmain.LName LIKE '%".$TVal."%'";
				$sql .= " OR TBmain.UserName LIKE '%".$TVal."%'";
				$sql .= " OR TBmain.TypeName LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql.=" ORDER BY TBmain.ID ASC";
unset($arrf);
// echo $sql;
// exit();
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
		$UserType = (!empty($Row["TypeName"])?$Row["TypeName"]:'-');
		$UserName = $Row["UserName"];
		$Fullname = $Row["FName"]." ".$Row["LName"];
		$LastLoginDate = $Row["LastLoginDate"];
		$FixListItem = ($userid==$ID?true:false);
		$thumb = _RELATIVE_EMPLOYEE_UPLOAD_.$Row["PictureFile"];
		if(is_file($thumb)){
			$ext = pathinfo($thumb, PATHINFO_EXTENSION);
			//svg+xml
			if($ext!='svg+xml'){
				$picturefile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$thumb);
			}else{
				$picturefile = _HTTP_PATH_."/"._MAIN_FOLDER_SYSTEM_."/assets/img/avatars/1.jpg";
			}
		}else{
			$picturefile = _HTTP_PATH_."/"._MAIN_FOLDER_SYSTEM_."/assets/img/avatars/1.jpg";
		}

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';
		$LinkView = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
		$LinkEdit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
		$LinkDelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueImages"] = $picturefile;
		$arr["valueSubject"] = $Fullname;
		$arr["valueUserType"] = $UserType;
		$arr["valueUserName"] = $UserName;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
		$arr["LinkView"] = $LinkView;
		$arr["LinkEdit"] = $LinkEdit;
		$arr["LinkDelete"] = $LinkDelete;
		$arr["FixListItem"] = $FixListItem;
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
