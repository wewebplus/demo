<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['saveData']);
decode_URL($LoginData);

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?100:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$arrf = array();
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_ID AS ID';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_Status AS ListStatus';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_StaffID AS StaffID';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_StaffName AS StaffName';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_StaffType AS StaffType';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_Detail AS Detail';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_CreateDate AS CreateDate';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_SendStatus AS SendStatus';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_MSGStatus AS MSGStatus';
$arrf[] = "a."._TABLE_CONTACT_REPLY_.'_Err AS Err';
$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTACT_REPLY_." a";
$sql .= " WHERE a."._TABLE_CONTACT_REPLY_."_ContactID = ".intval($itemid);
$sql .= " ORDER BY a."._TABLE_CONTACT_REPLY_."_CreateDate DESC";
unset($arrf);
$z = new __webctrl;
$z->sql($sql,$PageSize,$PageShow);
$RecordCount = $z->num();
$RecordCountInpage = $z->numinpage();
$v = $z->row();
$NoOfPage = $z->totalpage();
$RecordStart = ($PageSize*($PageShow-1));
$index = 0;
$found = array();
if($RecordCount>0) {
  foreach($v as $Row){
    $index++;
		$ListIndex = $RecordCount-($RecordStart+($index-1));
		$ID = $Row["ID"];
    $StaffName = $Row["StaffName"];
    $Detail = $Row["Detail"];
    // $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');
    $MSGStatus = $Row["MSGStatus"];
    $arr["ListIndex"] = $ListIndex;
    $arr["StaffName"] = $StaffName;
    $arr["Detail"] = echoDetailToediter($Detail);
    $arr["CreateDate"] = $CreateDate;
    $arr["MSGStatus"] = $MSGStatus;
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
