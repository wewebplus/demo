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
        $sql="SELECT "._TABLE_ADMIN_STAFF_."_PictureFileSrc AS PictureFileSrc,"._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
    	  $z->sql($sql);
    	  $v = $z->row();
    	  $oldSrcFile = _RELATIVE_EMPLOYEE_UPLOAD_.$v[0]["PictureFileSrc"];
    	  $oldPictureFile = _RELATIVE_EMPLOYEE_UPLOAD_.$v[0]["PictureFile"];

    		if(is_file($oldSrcFile)) {
          unlink($oldSrcFile);
        }
        if(is_file($oldPictureFile)) {
          unlink($oldPictureFile);
        }
    		$z->del(_TABLE_ADMIN_STAFF_,array(_TABLE_ADMIN_STAFF_."_ID=" => (int)$itemid));
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
