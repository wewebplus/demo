<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datafrontmenu.php");
$MyData = trim($_POST['MyData']);
    $sql = "";
    $ArrFieldMain[] = "TB.*";
    $sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
    $sql .= " (";
        $arrf = array();
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ID AS ID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Status AS ListStatus';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Order AS ListOrder';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_KeyID AS MenuKeyID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Key AS MenuKey';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Name AS Name';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_MenuType AS _MenuType';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Path AS _Path';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Target AS _Target';
        $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENUCONTENT_." a";
        $sql .= " WHERE a."._TABLE_FRONTMENUCONTENT_."_ID=".intval($MyData);
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
        $_MenuType = $Row["_MenuType"];
        $_Path = $Row["_Path"];
        $_Target = $Row["_Target"];
        $MenuKeyID = $Row["MenuKeyID"];
        $MenuKey = $Row["MenuKey"];
        $found["ID"] = $InID;
		    $found["Name"] = $Name;
        $found["MenuType"] = $_MenuType;
        $found["URL"] = $_Path;
        $found["TARGET"] = $_Target;
        $found["MenuKeyID"] = $MenuKeyID;
        $found["MenuKey"] = $MenuKey;
    }

$output = array(
    "status" => "ok",
    "result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
?>
