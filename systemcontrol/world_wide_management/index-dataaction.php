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
    		$z->del(_TABLE_ADDRCOUNTRIES_,array(_TABLE_ADDRCOUNTRIES_."_ID=" => (int)$itemid));
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
  break; default:
}
?>
