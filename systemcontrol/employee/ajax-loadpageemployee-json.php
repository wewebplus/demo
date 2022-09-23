<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$dataEmpType = (!empty($_POST["dataEmpType"])?$_POST["dataEmpType"]:'');
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

$found = array();

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?20:$selectPerPage);//_DEFAULT_PAGESIZE_
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
$ArrField = array();
$ArrField[] = "CONCAT(REPLACE(LEFT("._TABLE_ADMIN_STAFF_."_EmpCode, 1), '_', ''),SUBSTRING("._TABLE_ADMIN_STAFF_."_EmpCode, 2)) AS NewNo";
$ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ID";
$ArrField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
$ArrField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
$ArrField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
$ArrField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
$ArrField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
$ArrField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
$ArrField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
$ArrField[] = _TABLE_ADMIN_STAFF_."_Status AS ListStatus";
$ArrField[] = _TABLE_ADMIN_STAFF_."_InType AS InType";
$ArrField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryName IS NULL or "._TABLE_ADMIN_STAFF_."_CountryName = '', '-', "._TABLE_ADMIN_STAFF_."_CountryName) AS CountryName";
$ArrField[] = "IF(TBCheck.CountRefAll IS NULL or TBCheck.CountRefAll = '', 0, TBCheck.CountRefAll) AS CountRefAll";
$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_STAFF_;
$sql .= " LEFT JOIN (";
	$arrinnercount = array();
	$arrinnercount[] = "COUNT(*) AS CountRefAll";
	$arrinnercount[] = _TABLE_ADMIN_USER_."_EmpID AS JoinContentID";
	$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADMIN_USER_." WHERE 1 GROUP BY "._TABLE_ADMIN_USER_."_EmpID";
	unset($arrinnercount);
$sql .= ") TBCheck ON ("._TABLE_ADMIN_STAFF_."_ID = TBCheck.JoinContentID)";
$sql .= " WHERE 1";
if(!empty($dataEmpType)){
	$sql .= " AND "._TABLE_ADMIN_STAFF_."_InType = '".$dataEmpType."'";
}
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
				$sql .= _TABLE_ADMIN_STAFF_."_FName LIKE '%".$TVal."%'";
				$sql .= " OR "._TABLE_ADMIN_STAFF_."_LName LIKE '%".$TVal."%'";
				$sql .= " OR "._TABLE_ADMIN_STAFF_."_EmpCode LIKE '%".$TVal."%'";
				$sql .= " OR "._TABLE_ADMIN_STAFF_."_Email LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql.=" ORDER BY NewNo ".$ASCDESC;
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
		$Fullname = $Row["FullName"];
		$ID = $Row["ID"];
		$CountRef = $Row["CountRefAll"];
		$InType = $Row["InType"];
		$PictureFile = _RELATIVE_EMPLOYEE_UPLOAD_.$Row["PictureFile"];
		if(is_file($PictureFile)){
			if(is_image($PictureFile)){
				$thumbImg = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$PictureFile);
			}else{
				$thumbImg = "../assets/img/avatars/1.jpg";
			}
		}else{
			$thumbImg = "../assets/img/avatars/1.jpg";
		}
		$CountryName = $Row["CountryName"];

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
			*/
			// $listmnubtn .='<li class="divider"></li>';
			foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
				  //$listmnubtn .='<a rev="'.$skey.'" rel="'.$ID.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';
		$LinkView = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
		$LinkEdit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
		$LinkDelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueImages"] = $thumbImg;
		$arr["valueCode"] = $Row["EmpCode"];
		$arr["valueSubject"] = $Fullname;
		$arr["valueTel"] = $Row["Tel"];
		$arr["valueEmail"] = $Row["Email"];
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
		$arr["LinkView"] = $LinkView;
		$arr["LinkEdit"] = $LinkEdit;
		$arr["LinkDelete"] = $LinkDelete;
		$arr["CountRef"] = $CountRef;
		$arr["InType"] = $arrInType[$_SESSION['Session_Admin_Language']][$InType];
		$arr["CountryName"] = $CountryName;
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
