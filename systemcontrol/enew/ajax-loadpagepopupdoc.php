<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):0);
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$found = array();

if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$DataKey = $defaultdata[$Login_MenuID]["group"]["menudoc"];
if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}
if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?15:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
  $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_CreateDate AS CreateDate";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Order AS ListOrder";
	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
  $sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_Folder IN ('".$FolderKey ."','".$DataKey."')";
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
		$Fullname = $Row["Subject"];
		$arr = array();
		$arr["ListIndex"] = $ListIndex;
		$arr["valueidencode"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
    $arr["valueid"] = $ID;
		$arr["valueName"] = $Fullname;
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
	"reccount" => number_format($RecordCount),
	"reccountinpage" => $RecordCountInpage,
	"noofpage" => $NoOfPage,
	"spstart" => $rpagestart,
	"spend" => $rpageend,
	"nextpage" => ($nextpage<=$NoOfPage?$nextpage:$selectPage),
	"backpage" => ($backpage>0?$backpage:$selectPage),
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
