<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$LoginData = trim($_POST['MyData']);
decode_URL($LoginData);
if(!empty($Login_MenuID)){
	$indexLogin_MenuID = substr($Login_MenuID,5);
	$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
	$mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $sql = "";
    $ArrFieldMain[] = "TB.*";
    $sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
    $sql .= " (";
        $arrf = array();
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ID AS ID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Status AS ListStatus';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Order AS ListOrder';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Name AS Name';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Path AS _Path';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Target AS _Target';
        $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENUCONTENT_." a";
        $sql .= " WHERE a."._TABLE_FRONTMENUCONTENT_."_ID=".intval($itemid);
        unset($arrf);
    $sql .= ") TB";
    $sql .= " WHERE 1";
    $z = new __webctrl;
    $z->sql($sql);
    $RecordCount = $z->num();
    $found = array();
    if($RecordCount>0){
        $v = $z->row();
        $Row = $v[0];
        $InID = $Row["ID"];
        $Name = $Row["Name"];
        $_Path = $Row["_Path"];
        $_Target = $Row["_Target"];
        $found["ID"] = $InID;
		$found["Name"] = $Name;
        $found["URL"] = $_Path;
        $found["TARGET"] = $_Target;
    }

$output = array(
    "status" => "ok",
    "result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
?>
