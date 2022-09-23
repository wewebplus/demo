<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$myaction = trim($_POST['myaction']);
switch($myaction){
  case 'sortlist':
    $MyData = trim($_POST['MyData']);
    decode_URL($MyData);
    //$Login_MenuID;
    if(!empty($Login_MenuID)){
      $indexLogin_MenuID = substr($Login_MenuID,5);
      $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    }else{
      $mymenuinclude = "";
    }
    include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
    $InLang = $_SESSION['Session_Admin_Language'];

    $selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
    $selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];

    $PageShow = $_POST["mypage"];
    $PageSize = $_POST["mypagesize"];
    $myval = $_POST["myval"];
    $FirstSort = $myval[0];
    $LastSort = $myval[count($myval)-1];
    $RecordStart = ($PageSize*($PageShow-1));
    $RecordEnd = ($RecordStart+$PageSize)-1;
    //echo $RecordStart.":".$RecordEnd;
    //print_r($myval);
    $index = 0;
    $indexinline = 0;
    $sql = "SELECT COUNT(*) AS CountRecord FROM "._TABLE_FRONTMENU_." WHERE "._TABLE_FRONTMENU_."_ParentID = 0";
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $RecordCount = $v[0]["CountRecord"];
    foreach($myval as $kx=>$vx){
      $index++;
      $ListIndex = $RecordCount-($RecordStart+($index-1));
      $MyData = $myval[$indexinline];
      //   decode_URL($MyData);
      $ar[$ListIndex] = $MyData;
      $indexinline++;
    }
    // print_r($ar);
    foreach($ar as $k=>$v){
      $update[_TABLE_FRONTMENU_."_Order"] = sql_safe($k,false,true);
      $z->update(_TABLE_FRONTMENU_,$update,array(_TABLE_FRONTMENU_."_ID=" => intval($v)));
      unset($update);
    }
    echo 'OK';
    genFileJson($FolderKey,$InLang);
  break; case 'selectdelete':
  break;case 'delete':
    $itemid = trim($_POST['MyData']);
		$z = new __webctrl;
		$z->del(_TABLE_FRONTMENU_,array(_TABLE_FRONTMENU_."_ID=" => (int)$itemid));
		echo "OK";
  break; case 'allorder':
    $ArrOrder = $_POST['MyData'];
    // print_r($MyData);
    $counArr = count($ArrOrder);
    $z = new __webctrl;
    if($counArr>0){
      for($i=0;$i<$counArr;$i++){
        // $j = $counArr-$i;
        $j = ($i+1);
        $value = $ArrOrder[$i];
        $update[_TABLE_FRONTMENU_."_Order"] = sql_safe($j,false,true);
        $z->update(_TABLE_FRONTMENU_,$update,array(_TABLE_FRONTMENU_."_ID=" => (int)$value));
        unset($update);
        // echo $ArrOrder[$i].":".$j.",";
      }
    }
  break; case 'allposition':
    $hitMode = trim($_POST['hitMode']);
    $ToData = $_POST['ToData'];
    $Thisid = $_POST['thisid'];
    echo $Thisid.":".$hitMode.":".$ToData;
		$sql = "SELECT "._TABLE_FRONTMENU_."_ID AS ID,"._TABLE_FRONTMENU_."_ParentID AS ParentID FROM "._TABLE_FRONTMENU_." WHERE "._TABLE_FRONTMENU_."_ID = ".(int)$ToData;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
    $Row = $v[0];
    $ParentID = $Row["ParentID"];
    if($hitMode=='over'){
      $update = array();
      $update[_TABLE_FRONTMENU_."_ParentID"] = sql_safe($ToData,false,true);
      $z->update(_TABLE_FRONTMENU_,$update,array(_TABLE_FRONTMENU_."_ID=" => (int)$Thisid));
      unset($update);
    }else if($hitMode=='after'){
      $update = array();
      $update[_TABLE_FRONTMENU_."_ParentID"] = sql_safe($ParentID,false,true);
      $z->update(_TABLE_FRONTMENU_,$update,array(_TABLE_FRONTMENU_."_ID=" => (int)$Thisid));
      unset($update);
    }else if($hitMode=='before'){
      $update = array();
      $update[_TABLE_FRONTMENU_."_ParentID"] = sql_safe($ParentID,false,true);
      $z->update(_TABLE_FRONTMENU_,$update,array(_TABLE_FRONTMENU_."_ID=" => (int)$Thisid));
      unset($update);
    }
  break; default:
}
?>
