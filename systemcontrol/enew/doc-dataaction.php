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
    		$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
    		$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
    		$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
        $arrf = array();
    		$sql = "";
    		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
    		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
    		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
    		$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
    		$sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$itemid;
    		unset($arrf);
    		$z->sql($sql);
    		$v = $z->row();
    		$Row = $v[0];
    		$oldhtml01 = $PathUploadHtml.$Row['HTMLFileName'];
    		if(is_file($oldhtml01)){unlink($oldhtml01);}

    		$sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_FileName AS FileName FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE "._TABLE_MAIL_DOCUMENT_FILE_."_CID = ".(int)$itemid;
    		$z->sql($sql);
    		$num = $z->num();
    		$r = $z->row();
    		if($num>0){
    			foreach($r as $row){
    				$oldFile = $PathUploadFile.$row['FileName'];
    				if(is_file($oldFile)){unlink($oldFile);}
    			}
    		}
        $z->del(_TABLE_MAIL_DOCUMENT_,array(_TABLE_MAIL_DOCUMENT_."_ID=" => (int)$itemid));
    		$z->del(_TABLE_MAIL_DOCUMENT_FILE_,array(_TABLE_MAIL_DOCUMENT_FILE_."_CID=" => (int)$itemid));
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
