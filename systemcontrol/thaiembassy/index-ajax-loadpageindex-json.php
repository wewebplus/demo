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
  $ArrField[] = "CONCAT(REPLACE(LEFT("._TABLE_ADMIN_STAFF_."_EmpCode, 1), '_', ''),SUBSTRING("._TABLE_ADMIN_STAFF_."_EmpCode, 2)) AS NewNo";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ID";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
  $ArrField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_AName,"._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_Status AS ListStatus";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ListOrder";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_InType AS InType";
  $ArrField[] = _TABLE_ADMIN_STAFF_."_CreateDate AS CreateDate";
  $ArrField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryName IS NULL or "._TABLE_ADMIN_STAFF_."_CountryName = '', '-', "._TABLE_ADMIN_STAFF_."_CountryName) AS CountryName";
  $ArrField[] = "IF(TBCheck.CountRefAll IS NULL or TBCheck.CountRefAll = '', 0, TBCheck.CountRefAll) AS CountRefAll";
  $ArrField[] = "IF(TBTerritory.TName IS NULL or TBTerritory.TName = '', '-', TBTerritory.TName) AS TerritoryName";
  $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_STAFF_;
  $sql .= " LEFT JOIN (";
  	$arrinnercount = array();
  	$arrinnercount[] = "COUNT(*) AS CountRefAll";
  	$arrinnercount[] = _TABLE_ADMIN_USER_."_EmpID AS JoinContentID";
  	$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADMIN_USER_." WHERE 1 GROUP BY "._TABLE_ADMIN_USER_."_EmpID";
  	unset($arrinnercount);
  $sql .= ") TBCheck ON ("._TABLE_ADMIN_STAFF_."_ID = TBCheck.JoinContentID)";
  $sql .= " LEFT JOIN (";
    $sql .= " SELECT "._TABLE_ADMIN_TERRITORY_."_ID AS TID,"._TABLE_ADMIN_TERRITORY_."_Name AS TName FROM "._TABLE_ADMIN_TERRITORY_;
  $sql .= ") TBTerritory ON ("._TABLE_ADMIN_STAFF_."_Territory = TBTerritory.TID)";
  $sql .= " WHERE 1";
  $sql .= " AND "._TABLE_ADMIN_STAFF_."_InType = 'Embassy'";
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
				$sql .= "TBmain.FullName LIKE '%".$TVal."%'";
        $sql .= " OR TBmain.Email LIKE '%".$TVal."%'";
        $sql .= " OR TBmain.Tel LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.ListOrder DESC";
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
    $Email = $Row["Email"];
    $Name = $Row["FullName"];
    $Email = $Row["Email"];
    $Tel = $Row["Tel"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
    $TerritoryName = $Row["TerritoryName"];
    $Picture = $PathUploadPicture.$Row["PictureFile"];
    if(is_file($Picture)){
      $showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
      $showPicture = '<img src="'.$showPicture.'" class="imglist" alt="" />';
    }else{
      $showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
    }
    $CountryName = $Row["CountryName"];

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
      $listmnubtn .='<li>';
        $dataexportpdf = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=listexportpdf');
        $listmnubtn .='<a rev="'.$dataexportpdf.'" rel="'.$index.'" href="javascript:void(0);" onclick="exportpdf(this);">PDF</a>';
      $listmnubtn .='</li>';
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      if($pmaalllist){
        $listmnubtn .='<li>';
          $dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
          $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
        $listmnubtn .='</li>';
      }
		$listmnubtn .='</ul>';
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueEmail"] = $Email;
		$arr["valueName"] = $Name;
    $arr["valueTel"] = $Tel;
    $arr["valueCreateDate"] = $CreateDate;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $MemarrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["valuePicture"] = $showPicture;
    $arr["CountryName"] = $CountryName;
    $arr["TerritoryName"] = $TerritoryName;
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
