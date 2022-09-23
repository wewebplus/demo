<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$sql = "SELECT "._TABLE_THAIEMBASSY_."_ID AS ID,"._TABLE_THAIEMBASSY_."_Status AS ListStatus FROM "._TABLE_THAIEMBASSY_." WHERE "._TABLE_THAIEMBASSY_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_THAIEMBASSY_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_THAIEMBASSY_,$update,array(_TABLE_THAIEMBASSY_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$MemarrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
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
		$z = new __webctrl;
		$z->del(_TABLE_THAIEMBASSY_,array(_TABLE_THAIEMBASSY_."_ID=" => (int)$itemid));
		echo "OK";
	break; default:
}
CloseDB();
?>
