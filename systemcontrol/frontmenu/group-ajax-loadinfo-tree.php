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
        $arrf[] = "a."._TABLE_FRONTMENU_.'_ID AS ID';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_Status AS ListStatus';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_Order AS ListOrder';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_Name AS Name';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_MenuType AS _MenuType';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_Path AS _Path';
        $arrf[] = "a."._TABLE_FRONTMENU_.'_Target AS _Target';
        $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENU_." a";
        $sql .= " WHERE a."._TABLE_FRONTMENU_."_ID=".intval($MyData);
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
        $found["ID"] = $InID;
		    $found["Name"] = $Name;
        $found["MenuType"] = $_MenuType;
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
