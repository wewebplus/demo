<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$myaction = trim($_POST['myaction']);
switch($myaction){
  case 'sortlist':
  break; case 'selectdelete':
    $z = new __webctrl;
    $found = array();
    if(isset($_POST["paramName"])){
      foreach($_POST["paramName"] as $val){
        decode_URL($val);
    		$z->del(_TABLE_ADMIN_USERGROUP_,array(_TABLE_ADMIN_USERGROUP_."_ID=" => (int)$itemid));
    		$z->del(_TABLE_ADMIN_USERGROUPPMA_,array(_TABLE_ADMIN_USERGROUPPMA_."_GroupUserID=" => (int)$itemid));
    		$z->del(_TABLE_ADMIN_USERGROUPAPPROVE_,array(_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID=" => (int)$itemid));
      }
      $status = "ok";
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
  break;case 'delete':
  break;case 'checkshotname':
    $z = new __webctrl;
    $indata = $_POST["indata"];
    $LoginData = $_POST["LoginData"];
    decode_URL($LoginData);
    $sql = "SELECT "._TABLE_ADMIN_USERGROUP_."_ID,"._TABLE_ADMIN_USERGROUP_."_ShotName FROM "._TABLE_ADMIN_USERGROUP_." WHERE "._TABLE_ADMIN_USERGROUP_."_ShotName = '".trim($indata)."'";
    if(intval($itemid)>0){
      $sql .= " AND "._TABLE_ADMIN_USERGROUP_."_ID <> ".intval($itemid);
    }
    $z->sql($sql);
    $v = $z->row();
    if(count($v)>0){
      $inuse = false;
      $Intext = "ไม่สมารถใช้งานชื่อย่อนี้ได้ เนื่องจากมีข้อมูลนี้ในระบบแล้ว";
      $status = "NoUse";
    }else{
      $inuse = true;
      $Intext = "สมารถใช้งานชื่อย่อนี้ได้";
      $status = "InUse";
    }
    $output = array(
    	"status" => $status,
      "Intext" => $Intext,
    	"result" => $inuse
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
  break; default:
}
?>
