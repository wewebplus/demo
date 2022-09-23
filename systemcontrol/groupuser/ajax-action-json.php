<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$contents = file_get_contents('php://input');
$data = json_decode($contents);
$InAction = $data->InAction;
decode_URL($data->saveData);
switch($InAction){
  case 'savemanage':
    $GroupID = intval($itemid);
    $Data = $data->data;
    if(count($Data)>0){
      $update[_TABLE_ADMIN_USER_."_Type"] = 0;
      $z = new __webctrl;
      $z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_Type=" => (int)$GroupID));
      unset($update);
      foreach($Data as $UID){
        $DataID = $UID->id;
        $DataSubject = $UID->value;
        $update[_TABLE_ADMIN_USER_."_Type"] = "'".sql_safe($GroupID)."'";
        $z = new __webctrl;
        $z->update(_TABLE_ADMIN_USER_,$update,array(_TABLE_ADMIN_USER_."_ID=" => (int)$DataID));
        unset($update);
      }
    }
    echo 'OK';
  break; default:
}
?>
