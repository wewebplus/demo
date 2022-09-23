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
    $myval = (isset($_POST["myval"])?$_POST["myval"]:array());
    $inCount = count($myval);
    $z = new __webctrl;
    if($inCount>0){
      foreach($myval as $k=>$v){
        $inorder = $inCount-$k;
        // echo ",".$inorder.":".$v;
        $update[_TABLE_WEBLINK_GROUP_."_Order"] = sql_safe($inorder,false,true);
        $z->update(_TABLE_WEBLINK_GROUP_,$update,array(_TABLE_WEBLINK_GROUP_."_ID=" => intval($v)));
        unset($update);
      }
    }
    echo 'OK';
  break; case 'addnew':
    $dataGroup = $_POST["inMenu"];
    if($dataGroup>0){
      $ModuleKey = $menuModuleKey[$dataGroup];
      $sql = "SELECT MAX("._TABLE_WEBLINK_GROUP_."_Order) AS MaxO FROM "._TABLE_WEBLINK_GROUP_." WHERE 1 ";
      $sql .= " AND "._TABLE_WEBLINK_GROUP_."_Folder='".$ModuleKey."'";
      $z = new __webctrl;
      $z->sql($sql);
      $v = $z->row();
      $Row = $v[0];
      $MaxOrder = $Row["MaxO"]+1;

      $insert = array();
      $insert[_TABLE_WEBLINK_GROUP_.'_Folder'] = "'".$ModuleKey."'";
      $insert[_TABLE_WEBLINK_GROUP_.'_Language'] = "'".sql_safe($_SESSION['Session_Admin_Language'])."'";
      $insert[_TABLE_WEBLINK_GROUP_.'_Name'] = "'".sql_safe($_POST["inputGroup_".$_SESSION['Session_Admin_Language']])."'";
      foreach($Array_Lang["txt:Language"] as $k=>$v){
        $dataGroupText = $_POST["inputGroup_".$k];
        $insert[_TABLE_WEBLINK_GROUP_.'_'.$k] = "'".sql_safe($dataGroupText)."'";
      }
      $insert[_TABLE_WEBLINK_GROUP_.'_Order'] = sql_safe($MaxOrder,false,true);
      $z->insert(_TABLE_WEBLINK_GROUP_,$insert);
      $insertid = $z->insertid();
      unset($insert);
    }
    echo $insertid;
  break;case 'edit':
    $mydata = $_POST["mydata"];
    $sql = "";
    $ArrField = array();
    $ArrField[] = "TBmain.ID";
    foreach($Array_Lang["txt:Language"] as $k=>$v){
      $ArrField[] = "TBmain.Name".$k;
    }
    $sql .= "SELECT ".implode(',',$ArrField)." FROM ";
    $sql .= "("	;
      $ArrInnerField = array();
      $ArrInnerField[] = _TABLE_WEBLINK_GROUP_."_ID AS ID";
      $ArrInnerField[] = _TABLE_WEBLINK_GROUP_."_Order AS ListOrder";
      $ArrInnerField[] = _TABLE_WEBLINK_GROUP_."_Status AS ListStatus";
      foreach($Array_Lang["txt:Language"] as $k=>$v){
        $ArrInnerField[] = _TABLE_WEBLINK_GROUP_."_".$k." AS Name".$k;
      }
      $sql .= "SELECT ".implode(',',$ArrInnerField)." FROM "._TABLE_WEBLINK_GROUP_;
      $sql .= " WHERE "._TABLE_WEBLINK_GROUP_."_ID = ".intval($mydata);
      unset($ArrInnerField);
    $sql .= ") TBmain";
    $z = new __webctrl;
    $z->sql($sql);
    $RecordCount = $z->num();
    $arrfield = array();
    if($RecordCount>0){
      $v = $z->row();
      $Row = $v[0];
      $arrfield["ID"] = $Row["ID"];
      $arr = array();
      foreach($Array_Lang["txt:Language"] as $k=>$v){
        $arr["Name"] = "inputEditGroup_".$k;
        $arr["Val"] = $Row["Name".$k];
        $arrfield["inputGroup"][] = $arr;
      }
    }
    $output = array(
    	"status" => "ok",
    	"result" => $arrfield
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
    exit();
  break;case 'update':
    $itemid = intval($_POST["inID"]);
    if($itemid>0){
      $status = "ok";
      $z = new __webctrl;
      foreach($Array_Lang["txt:Language"] as $k=>$v){
        $dataGroupText = $_POST["inputEditGroup_".$k];
        $update[_TABLE_WEBLINK_GROUP_.'_'.$k] = "'".sql_safe($dataGroupText)."'";
      }
      $z->update(_TABLE_WEBLINK_GROUP_,$update,array(_TABLE_WEBLINK_GROUP_."_ID=" => $itemid));
      unset($update);
    }else{
      $status = "no";
    }
    echo 10;
  break;case 'deleteitem':
    $itemid = intval($_POST["mydata"]);
    $found = array();
    if($itemid>0){
      $status = "ok";
      $z = new __webctrl;
      $z->del(_TABLE_WEBLINK_GROUP_,array(_TABLE_WEBLINK_GROUP_."_ID=" => (int)$itemid));
    }else{
      $status = "no";
    }
    $output = array(
    	"status" => $status,
    	"result" => $found
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
  break;case 'savetxtgroup':
    $dataitemid = explode("_",$_POST["dataitemid"]);
    $datadetail = $_POST["datadetail"];
    $itemid = intval($dataitemid[1]);
    $found = array();
    if($itemid>0){
      $status = "ok";
      $z = new __webctrl;
      $update[_TABLE_WEBLINK_GROUP_."_Name"] = "'".sql_safe($datadetail)."'";
      $z->update(_TABLE_WEBLINK_GROUP_,$update,array(_TABLE_WEBLINK_GROUP_."_ID=" => $itemid));
      unset($update);
      $found["detail"] = $datadetail;
    }else{
      $status = "no";
    }
    $output = array(
    	"status" => $status,
    	"result" => $found
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
  break;case 'changestatus':
    $itemid = intval($_POST["mydata"]);
    $sql = "SELECT "._TABLE_WEBLINK_GROUP_."_ID AS ID,"._TABLE_WEBLINK_GROUP_."_Status AS ListStatus FROM "._TABLE_WEBLINK_GROUP_." WHERE "._TABLE_WEBLINK_GROUP_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $ListStatus = $Row["ListStatus"];
    if($ListStatus=='On'){
      $StatusIcon = '<i class="fas fa-bell"></i>';
      $StatusTo = "Off";
    }else{
      $StatusIcon = '<i class="fas fa-bell-slash"></i>';
      $StatusTo = "On";
    }
    $update = array();
    $update[_TABLE_WEBLINK_GROUP_."_Status"] = "'".$StatusTo."'";
    $z = new __webctrl;
    $z->update(_TABLE_WEBLINK_GROUP_,$update,array(_TABLE_WEBLINK_GROUP_."_ID=" => $itemid));
    unset($update);
    $status = "ok";
    $output = array(
      "status" => $status,
    	"liststatus" => $StatusTo
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
  break; default:
}
?>
