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
        $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
        $sql = "SELECT "._TABLE_THAIEMBASSY_."_PictureFile AS thumb FROM "._TABLE_THAIEMBASSY_." WHERE "._TABLE_THAIEMBASSY_."_ID = ".(int)$itemid;
    	  $z = new __webctrl;
    	  $z->sql($sql);
    	  $v = $z->row();
    	  $row = $v[0];
    	  $ThumbnailPictureName = $row["thumb"];
    		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
        if(is_file($unlinkfile)){unlink($unlinkfile);}
        $unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
        if(is_file($unlinkfile)){unlink($unlinkfile);}
    		$z->del(_TABLE_THAIEMBASSY_,array(_TABLE_THAIEMBASSY_."_ID=" => (int)$itemid));
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
