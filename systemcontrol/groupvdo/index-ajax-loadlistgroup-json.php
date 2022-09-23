<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = trim($_POST['saveData']);
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):0);
if($dataGroup>0){
  $ModuleKey = $menuModuleKey[$dataGroup];
}
$sql = "";
$ArrField = array();
$ArrField[] = "TBmain.ID";
foreach($Array_Lang["txt:Language"] as $k=>$v){
  $ArrField[] = "TBmain.Name".$k;
}
$ArrField[] = "TBmain.ListStatus";
$ArrField[] = "TBmain.ListOrder";
$ArrField[] = "IF(TBJoinCount.CountRefAll IS NULL or TBJoinCount.CountRefAll = '', 0, TBJoinCount.CountRefAll) as CountLogs";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
  $ArrInnerField = array();
  $ArrInnerField[] = _TABLE_VDO_GROUP_."_ID AS ID";
  $ArrInnerField[] = _TABLE_VDO_GROUP_."_Order AS ListOrder";
  $ArrInnerField[] = _TABLE_VDO_GROUP_."_Status AS ListStatus";
  foreach($Array_Lang["txt:Language"] as $k=>$v){
    $ArrInnerField[] = _TABLE_VDO_GROUP_."_".$k." AS Name".$k;
  }
  $sql .= "SELECT ".implode(',',$ArrInnerField)." FROM "._TABLE_VDO_GROUP_;
  $sql .= " WHERE "._TABLE_VDO_GROUP_."_Folder = '".$ModuleKey."'";
  unset($ArrInnerField);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
  $sql .= "SELECT * FROM ";
  $sql .= "(";
    $arrinnercount = array();
    $arrinnercount[] = "COUNT(*) AS CountRefAll";
    $arrinnercount[] = _TABLE_VDO_."_GID AS JoinContentID";
    $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_VDO_." WHERE 1 GROUP BY "._TABLE_VDO_."_GID";
    unset($arrinnercount);
  $sql .= ") TBCount";
$sql .= ") TBJoinCount ON (TBmain.ID = TBJoinCount.JoinContentID)";
$sql .= " WHERE 1";
$sql .= " ORDER BY TBmain.ListOrder DESC";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$arrGroup = array();
if($RecordCount>0){
  $v = $z->row();
  foreach($v as $Row){
    $ListStatus = $Row["ListStatus"];
    if($ListStatus=='On'){
      $StatusIcon = '<i class="fas fa-bell"></i>';
    }else{
      $StatusIcon = '<i class="fas fa-bell-slash"></i>';
    }
    $strName = array();
    foreach($Array_Lang["txt:Language"] as $k=>$v){
      $strName[] = $Row["Name".$k];
    }
    $arr = array();
    $arr["ID"] = $Row["ID"];
    $arr["Name"] = implode(' / ',$strName);
    $arr["ListStatus"] = $ListStatus;
    $arr["StatusIcon"] = $StatusIcon;
    $arr["CountLogs"] = intval($Row["CountLogs"]);
    $arrGroup[] = $arr;
  }
}
$output = array(
	"status" => "ok",
  "dataModuleKey" => $ModuleKey,
	"totalreccount" => number_format($RecordCount),
	"reccount" => (int)$RecordCount,
	"result" => $arrGroup
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
