<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
//include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):0);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
//$Login_MenuID;
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
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
$ArrFieldMain[] = "TBmain.*";
$sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
$sql .= " (";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ID";
  $ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ListOrder";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Name AS Subject";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfMember AS NoOfMember";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfSend AS NoOfSend";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_CreateDate AS CreateDate";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Status AS ListStatus";
  $ArrField[] = "TB."._TABLE_MAIL_TASK_."_SendDate AS SendDate";
  $ArrField[] = "IF(TBDocument.DocSubject IS NULL or TBDocument.DocSubject = '', '-', TBDocument.DocSubject) as DocSubject";
	$sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_MAIL_TASK_." TB";
  $sql .= " LEFT JOIN (";
    $arrf = array();
  	$arrf[] = _TABLE_MAIL_DOCUMENT_."_ID AS DocID";
  	$arrf[] = _TABLE_MAIL_DOCUMENT_."_Subject AS DocSubject";
  	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_;
  	$sql .= " WHERE 1";
  	unset($arrf);
  $sql .= ") TBDocument ON (TB."._TABLE_MAIL_TASK_."_DocumentID = TBDocument.DocID)";
	$sql .= " WHERE 1";
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
				$sql .= "TBmain.Subject LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
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
		$CreateDate = $Row['CreateDate'];
		$Dateshow = dateformat($CreateDate,'j M Y');
    $Subject = $Row["Subject"];
    $DocSubject = $Row["DocSubject"];
    $NoOfMember = $Row["NoOfMember"];
    $NoOfSend = $Row["NoOfSend"];

    $SendDate = $Row['SendDate'];
    $SendDateShow = dateformat($SendDate,'j M Y');

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
      /*
      $listmnubtn .='<li>';
        $dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
        $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="'.$linkpriview.'" target="_blank">Preview</a>';
      $listmnubtn .='</li>';
      */
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      if($pmaalllist){
  			$listmnubtn .='<li>';
  				$dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=send');
  			  $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Send</a>';
  			$listmnubtn .='</li>';
  			$listmnubtn .='<li>';
  				$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
  			  $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
  			$listmnubtn .='</li>';
        $listmnubtn .='<li class="divider"></li>';
        $listmnubtn .='<li>';
  				$datareset = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=resettask');
  			  $listmnubtn .='<a rev="'.$datareset.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoreset(this);">Reset</a>';
  			$listmnubtn .='</li>';
  			$listmnubtn .='<li class="divider"></li>';
  			foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
  				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
  				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
  				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
  				$listmnubtn .='</li>';
  			}
      }
		$listmnubtn .='</ul>';
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["Subject"] = $Subject;
    $arr["DocSubject"] = $DocSubject;
    $arr["NoOfMember"] = $NoOfMember;
    $arr["NoOfSend"] = $NoOfSend;
		$arr["Dateshow"] = $Dateshow;
    $arr["SendDateShow"] = $SendDateShow;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
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
