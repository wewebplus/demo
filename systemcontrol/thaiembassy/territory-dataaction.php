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
        if(!empty($Login_MenuID)){
          $indexLogin_MenuID = substr($Login_MenuID,5);
          $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
        }else{
          $mymenuinclude = "";
        }
        include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    	  $z = new __webctrl;
    		$z->del(_TABLE_ADMIN_TERRITORY_,array(_TABLE_ADMIN_TERRITORY_."_ID=" => (int)$itemid));
        $z->del(_TABLE_ADMIN_TERRITORY_.'_internal',array(_TABLE_ADMIN_TERRITORY_."_internal_TerritoryID=" => (int)$itemid));
    		$z->del(_TABLE_ADMIN_TERRITORY_.'_external',array(_TABLE_ADMIN_TERRITORY_."_external_TerritoryID=" => (int)$itemid));
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
  break; default:
}
?>
