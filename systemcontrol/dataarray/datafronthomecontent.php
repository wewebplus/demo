<?php
$Array_Mod_Lang["txt:Detail Head"]["Thai"] = "Manage Contact system";
$Array_Mod_Lang["txt:Detail Head"]["English"] = "Detail Head";

$Array_Mod_Lang["txt:Head 01"]["Thai"] = "Contact Date";
$Array_Mod_Lang["txt:Head 01"]["English"] = "Contact Date";
$Array_Mod_Lang["txt:Head 02"]["Thai"] = "Contact Information";
$Array_Mod_Lang["txt:Head 02"]["English"] = "Contact Information";

$Array_Mod_Lang["txt:Tab 01"]["Thai"] = "ข้อความภาษาไทย";
$Array_Mod_Lang["txt:Tab 01"]["English"] = "ข้อความภาษาอังกฤษ";

$Array_Mod_Lang["txtinput:inputGroupSubject"]["Thai"] = "ชื่อกลุ่ม";
$Array_Mod_Lang["txtinput:inputGroupSubject"]["English"] = "Subject Contact Group";
$Array_Mod_Lang["txtinput:inputGroupShotSubject"]["Thai"] = "ชื่อกลุ่มสั้น";
$Array_Mod_Lang["txtinput:inputGroupShotSubject"]["English"] = "Title Contact Group";

$Array_Mod_Lang["txtinput:UnderMenu"]["Thai"] = "อยู่ภายใต้เมนู";
$Array_Mod_Lang["txtinput:UnderMenu"]["English"] = "อยู่ภายใต้เมนู";
$Array_Mod_Lang["txtinput:MenuName"]["Thai"] = "ขื่อเมนู";
$Array_Mod_Lang["txtinput:MenuName"]["English"] = "ขื่อเมนู";
$Array_Mod_Lang["txtinput:MenuType"]["Thai"] = "MenuType";
$Array_Mod_Lang["txtinput:MenuType"]["English"] = "MenuType";
$Array_Mod_Lang["txtinput:SelectMenuName"]["Thai"] = "เลือกขื่อเมนู";
$Array_Mod_Lang["txtinput:SelectMenuName"]["English"] = "เลือกขื่อเมนู";
$Array_Mod_Lang["txtinput:URL"]["Thai"] = "URL";
$Array_Mod_Lang["txtinput:URL"]["English"] = "URL";
$Array_Mod_Lang["txtinput:Target"]["Thai"] = "Target";
$Array_Mod_Lang["txtinput:Target"]["English"] = "Target";

$ArrMenuType["Link"] = "Link";
$ArrMenuType["CMS"] = "CMS";
$ArrMenuType["About"] = "About";

function genFileJson($inkey,$inlang){
    $PathFile = _RELATIVE_FRONTMENU_UPLOAD_;
    if(!is_dir($PathFile)) { mkdir($PathFile,0777); }
    // $catData = getSubCategories(0,0,'On');
    // $output = array(
    //     "status" => "ok",
    //     "result" => $catData
    // );
    // $fp = fopen($PathFile.'resultsmenu-'.$inlang.'.json', 'w');
    // fwrite($fp, json_encode($output));
    // fclose($fp);

    $catDataBackend = getSubCategories(0,0);
    $fp = fopen($PathFile.'resultsmenu-backend.json', 'w');
    fwrite($fp, json_encode($catDataBackend));
    fclose($fp);
}
function genFrontendFileJson($inkey,$inlang){
    $PathFile = _RELATIVE_FRONTMENU_UPLOAD_;
    if(!is_dir($PathFile)) { mkdir($PathFile,0777); }
    $catData = getSubCategories(0,0,'On');
    $output = array(
        "status" => "ok",
        "result" => $catData
    );
    $fp = fopen($PathFile.'resultscontent-'.$inlang.'.json', 'w');
    fwrite($fp, json_encode($output));
    fclose($fp);
}
function getSubCategoriesEcho($parent_id, $level) {
    $FolderKey = "fronthomecontent";
    $z = new __webctrl;
    $sql = "";
    $ArrFieldMain[] = "TB.*";
    $sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
    $sql .= " (";
        $arrf = array();
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ID AS ID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ParentID AS ParentID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Status AS ListStatus';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Order AS ListOrder';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Name AS Name';
        $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENUCONTENT_." a";
        $sql .= " WHERE a."._TABLE_FRONTMENUCONTENT_."_Folder='".$FolderKey."'";
        $sql .= " AND ";
        $sql .= "(a."._TABLE_FRONTMENUCONTENT_."_ParentID  = ".$parent_id.")";
        unset($arrf);
    $sql .= ") TB";
    $sql .= " WHERE 1";
    $z->sql($sql);
    $RecordCount = $z->num();
    $v = $z->row();
    $level++;
    if($RecordCount>0) {
        foreach($v as $Row){
            $InID = $Row["ID"];
            $Name = $Row["Name"];
            $InStatus = $Row["ListStatus"];
            $ParentID = $Row["ParentID"];
            $arr["ID"] = $InID;
            $arr["ParentID"] = $ParentID;
            $arr["Name"] = $Name;
            $arr["Status"] = $InStatus;
            echo str_repeat("-", ($level * 4)) . $Name  . '<br>';
            getSubCategories($InID, $level);
        }
    }
    // return true;
}
function getSubCategories($parent_id, $level,$instatus = null) {
    $catData=[];
    $FolderKey = "fronthomecontent";
    $z = new __webctrl;
    $sql = "";
    $ArrFieldMain[] = "TB.*";
    $sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
    $sql .= " (";
        $arrf = array();
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ID AS ID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_ParentID AS ParentID';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Status AS ListStatus';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Order AS ListOrder';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Key AS MenuKey';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Name AS Name';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Path AS URL';
        $arrf[] = "a."._TABLE_FRONTMENUCONTENT_.'_Target AS URLTarget';
        $arrf[] = "(SELECT COUNT(*) FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ParentID = a."._TABLE_FRONTMENUCONTENT_."_ID) AS CountParent";
        $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_FRONTMENUCONTENT_." a";
        $sql .= " WHERE a."._TABLE_FRONTMENUCONTENT_."_Folder='".$FolderKey."'";
        if(!empty($instatus)){
            $sql .= " AND a."._TABLE_FRONTMENUCONTENT_."_Status='".$instatus."'";
        }
        $sql .= " AND ";
        $sql .= "(a."._TABLE_FRONTMENUCONTENT_."_ParentID  = ".$parent_id.")";
        unset($arrf);
    $sql .= ") TB";
    $sql .= " WHERE 1";
    $sql .= " ORDER BY TB.ListOrder ASC";
    $z->sql($sql);
    $RecordCount = $z->num();
    $v = $z->row();
    $level++;
    if($RecordCount>0) {
        foreach($v as $Row){
            $InLevel = $level;
            $InID = $Row["ID"];
            $Name = $Row["Name"];
            $URL = $Row["URL"];
            $URLTarget = $Row["URLTarget"];
            $InStatus = $Row["ListStatus"];
            $ParentID = $Row["ParentID"];
            $CountParent = $Row["CountParent"];
            $arr["InLevel"] = $InLevel;
            $arr["ID"] = intval($InID);
            $arr["ParentID"] = intval($ParentID);
            $arr["Name"] = $Name;
            $arr["URL"] = $URL;
            $arr["URLTarget"] = $URLTarget;
            $arr["Status"] = $InStatus;
            $arr["CountParent"] = $CountParent;
            $arr["key"] = $InID;
            $arr["title"] = $Name;
            if($CountParent>0){
                $arr["expanded"] = true;
                $arr["folder"] = true;
                $arr["lazy"] = true;
            }else{
                $arr["expanded"] = false;
                $arr["folder"] = false;
                $arr["lazy"] = false;
            }
            $arr["nested_categories"] = getSubCategories($InID,$level,$instatus);
            $arr["children"] = getSubCategories($InID,$level,$instatus);
            $catData[] = $arr;
        }
        return $catData;
    }else{
        return $catData=[];
    }
}
?>
