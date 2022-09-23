<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataLevel = trim($_POST["dataLevel"]);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

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
	$arrf = array();
	$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
  $arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
  $arrf[] = "a."._TABLE_MEMBER_."_Name AS FullName";
  $arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
  $arrf[] = "a."._TABLE_MEMBER_."_ContactNo as Tel";
  $arrf[] = "a."._TABLE_MEMBER_."_Status AS ListStatus";
  $arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
  $arrf[] = "a."._TABLE_MEMBER_."_MemberType AS MemberType";
  $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE 1";
  if(!empty($dataLevel)){
    $sql .= " AND a."._TABLE_MEMBER_."_MemberType = '".trim($dataLevel)."'";
  }
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
				$sql .= "TBmain.FullName LIKE '%".$TVal."%'";
        $sql .= " OR TBmain.Email LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.ListOrder DESC,TBmain.ID DESC";
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
    $Name = $Row["FullName"];//$Row["FullName"];
    $Tel = $Row["Tel"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
    $MemberLevelShow = "-";

    $Orgpass = "*******";
    $Username = $Row["Username"];
    $MemberType = $Row["MemberType"];
    $MemberTypeText = $arrMemberType[$MemberType];

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
      $listmnubtn .='<li>';
        $dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
        $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
      $listmnubtn .='</li>';
      if($pmaalllist){
        $listmnubtn .='<li>';
  				$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
  			  $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
  			$listmnubtn .='</li>';
      }
			$listmnubtn .='<li class="divider"></li>';
			foreach($MemarrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueEmail"] = $Email;
    $arr["valueTel"] = $Tel;
		$arr["valueName"] = $Name;
    $arr["valueCreateDate"] = $CreateDate;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $MemarrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["valueLevel"] = $MemberLevelShow;
    $arr["Username"] = $Username;
    $arr["Orgpass"] = $Orgpass;
    $arr["MemberType"] = $MemberTypeText;
    $arr["MemberLevel"] = $MemberTypeText;
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
