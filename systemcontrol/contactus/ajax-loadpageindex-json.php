<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontactus.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
//$Login_MenuID;
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$selectGroup = (!empty($_POST["selectGroup"])?$_POST["selectGroup"]:0);
$selectGroup = intval($selectGroup);

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

$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];

$found = array();

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?20:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTACT_.'_ID AS ID';
	$arrf[] = "a."._TABLE_CONTACT_.'_GroupID AS GroupID';
	$arrf[] = "a."._TABLE_CONTACT_.'_Name AS ContactName';
	$arrf[] = "a."._TABLE_CONTACT_.'_Subject AS ContactSubject';
	$arrf[] = "a."._TABLE_CONTACT_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_CONTACT_.'_ID AS ListOrder';
	$arrf[] = "a."._TABLE_CONTACT_.'_CreateDate AS CreateDate';
	$arrf[] = "a."._TABLE_CONTACT_.'_PhyFile AS PhyFile';
	$arrf[] = "a."._TABLE_CONTACT_.'_FileName AS FileName';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTACT_." a";
	$sql .= " WHERE a."._TABLE_CONTACT_."_Key IN ('".implode("','",$dataModuleKey)."')";

	if($selectGroup>0){
		$sql .= " AND a."._TABLE_CONTACT_."_GroupID = ".intval($selectGroup);
	}
	unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
	$sqlsub = "";
	foreach($systemLang as $lkey=>$lval){
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS GSubject".$lkey;
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS GStatus".$lkey;
	}
	$sql .= "SELECT b."._TABLE_CONTACT_GROUP_."_ID as groupid".$sqlsub." FROM "._TABLE_CONTACT_GROUP_." b";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (b."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE b."._TABLE_CONTACT_GROUP_."_Key IN ('".implode("','",$dataModuleKey)."')";
$sql .= ") TBJoin ON (TBmain.GroupID = TBJoin.groupid)";
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
				$sql .= "TBmain.ContactName LIKE '%".$TVal."%'";
				$sql .= " OR TBmain.ContactSubject LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.".$selectOrder." ".$selectASCDESC;
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
		$ListStatus = $Row["ListStatus"];
		$ContactName = $Row["ContactName"];
		$ContactSubject = $Row["ContactSubject"];
		$FileAtt = _RELATIVE_CONTACT_."document/".$Row["PhyFile"];
		if(is_file($FileAtt)){
			$FileAtt = '<a href="'.$FileAtt.'" download="'.$Row["FileName"].'"><i class="fas fa-file-download"></i></a>';
		}else{
			$FileAtt = "-";
		}

		$FullGroupname = $Row["GSubject".$_SESSION['Session_Admin_Language']];
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

		$statuscss = $arrinStatusContactBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=viewlist');
		$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');

		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			if($pmaalllist){
				foreach($arrinContactStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
					$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
					  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
					  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeListStatus(this);">'.$sval.'</a>';
					$listmnubtn .='</li>';
				}
			}
		$listmnubtn .='</ul>';

		$datamail = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=replymail');
		$arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueGroupname"] = $FullGroupname;
		$arr["valueName"] = $ContactName;
		$arr["valueSubject"] = $ContactSubject;
		$arr["valueDateshow"] = $CreateDate;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinContactStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
		$arr["valueDelete"] = $datadelete;
		$arr["valueView"] = $dataview;
		$arr["valueMail"] = $datamail;
		$arr["FileAtt"] = $FileAtt;
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
