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

		$sql = "SELECT "._TABLE_ADS_."_ID AS ID,"._TABLE_ADS_."_Status AS ListStatus FROM "._TABLE_ADS_." WHERE "._TABLE_ADS_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_ADS_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_ADS_,$update,array(_TABLE_ADS_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		$indexLogin_MenuID = substr($Login_MenuID,5);
	  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    $mymenukey = @$menuFolderModule[$indexLogin_MenuID];
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ADS_UPLOAD_);
    $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_ADS_UPLOAD_);
		$sql = "SELECT "._TABLE_ADS_DETAIL_."_File AS PictureFile FROM "._TABLE_ADS_DETAIL_." WHERE "._TABLE_ADS_DETAIL_."_ContentID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$num = $z->num();
		$r = $z->row();
		if($num>0){
			foreach($r as $row){
				$oldhtml01 = $PathUploadPicture.$row['PictureFile'];
				if(is_file($oldhtml01)){unlink($oldhtml01);}
			}
		}

		$z = new __webctrl;
		$z->del(_TABLE_ADS_,array(_TABLE_ADS_."_ID=" => (int)$itemid));
		$z->del(_TABLE_ADS_DETAIL_,array(_TABLE_ADS_DETAIL_."_ContentID=" => (int)$itemid));
		echo "OK";
		break;case 'sort':
			$myorder = $_POST['tsort'];
			$ArrOrder = explode('|x|',$myorder);
			$counArr = count($ArrOrder);
			if($counArr>0){
				for($i=1;$i<$counArr;$i++){
					$value = str_replace("s","",$ArrOrder[$i]);
					if($value <> 'null'){
						$j = $counArr-$i;
						$update[_TABLE_ADS_."_Order"] = sql_safe($j,false,true);
						$z = new __webctrl;
						$z->update(_TABLE_ADS_,$update,array(_TABLE_ADS_."_ID=" => (int)$value));
						unset($update);
					}
				}
			}
		 echo "OK";
	break; default:
}
CloseDB();
?>
