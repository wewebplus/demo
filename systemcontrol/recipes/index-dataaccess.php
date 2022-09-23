<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
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
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_RECIPES_."_Key AS myKey,"._TABLE_RECIPES_."_ID AS ID,"._TABLE_RECIPES_."_Status AS ListStatus FROM "._TABLE_RECIPES_." WHERE "._TABLE_RECIPES_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
    $myKey = $Row["myKey"];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update = array();
		$update[_TABLE_RECIPES_."_Status"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'changeusestatushome':
		$itemid = $itemid;
		$StatusTo = $statusto;
		// $sql = "SELECT "._TABLE_RECIPES_."_ID AS ID,"._TABLE_RECIPES_."_StatusHome AS ListStatus FROM "._TABLE_RECIPES_." WHERE "._TABLE_RECIPES_."_ID = ".(int)$itemid;
		// $z = new __webctrl;
		// $z->sql($sql);
		// $v = $z->row();
		// $Row = $v[0];
		$update = array();
		$update[_TABLE_RECIPES_."_StatusHome"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='Yes'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=No&StatusType=StatusHome&actiontype=changeusestatushome');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:HomeStatus"][$_SESSION['Session_Admin_Language']].')</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Yes&StatusType=StatusHome&actiontype=changeusestatushome');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:HomeStatus"][$_SESSION['Session_Admin_Language']].')</a>';
		}
		echo $btnstatus;
  break;case 'changeuseRating':
    $itemid = $itemid;
    $StatusTo = $statusto;
    // echo $StatusType;
    $update = array();
		$update[_TABLE_RECIPES_."_StatusRating"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='Yes'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=No&StatusType=StatusRating&actiontype=changeuseRating');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:Rating"][$_SESSION['Session_Admin_Language']].')</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Yes&StatusType=StatusRating&actiontype=changeuseRating');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:Rating"][$_SESSION['Session_Admin_Language']].')</a>';
		}
		echo $btnstatus;
  break;case 'changeusebtnComment':
    $itemid = $itemid;
    $StatusTo = $statusto;
    // echo $StatusType;
    $update = array();
		$update[_TABLE_RECIPES_."_StatusComment"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='Yes'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=No&StatusType=StatusComment&actiontype=changeusebtnComment');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:Comment"][$_SESSION['Session_Admin_Language']].')</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Yes&StatusType=StatusComment&actiontype=changeusebtnComment');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:Comment"][$_SESSION['Session_Admin_Language']].')</a>';
		}
		echo $btnstatus;
  break;case 'changeusebtnPin':
    $itemid = $itemid;
    $StatusTo = $statusto;
    // echo $StatusType;
    $update = array();
		$update[_TABLE_RECIPES_."_Pin"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='Yes'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=No&StatusType=Pin&actiontype=changeusebtnPin');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse pinYes" onclick="changeInPin(this)"><i class="fas fa-map-pin"></i> ปักหมุด</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Yes&StatusType=Pin&actiontype=changeusebtnPin');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse pinNo" onclick="changeInPin(this)"><i class="fas fa-map-pin"></i> ไม่ปักหมุด</a>';
		}
		echo $btnstatus;
  break;case 'changeusebtnPublic':
    $itemid = $itemid;
    $StatusTo = $statusto;
    // echo $StatusType;
    $update = array();
		$update[_TABLE_RECIPES_."_Public"] = "'".$StatusTo."'";
		$update[_TABLE_RECIPES_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RECIPES_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='Yes'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=No&StatusType=StatusPublic&actiontype=changeusebtnPublic');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse PublicOn" onclick="changeInStatus(this)"><i class="fas fa-user-friends"></i> '.$Array_Mod_Lang["txt:Public"][$_SESSION['Session_Admin_Language']].'</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Yes&StatusType=StatusPublic&actiontype=changeusebtnPublic');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse PublicOff" onclick="changeInStatus(this)"><i class="fas fa-user-friends"></i> '.$Array_Mod_Lang["txt:Public"][$_SESSION['Session_Admin_Language']].'</a>';
		}
		echo $btnstatus;
	break;case 'delete':
		$itemid = $itemid;
		$sql = "SELECT "._TABLE_RECIPES_."_Key AS myKey,"._TABLE_RECIPES_."_Picture AS thumb,"._TABLE_RECIPES_."_PictureHome AS thumbhome FROM "._TABLE_RECIPES_." WHERE "._TABLE_RECIPES_."_ID = ".(int)$itemid;
	  $z = new __webctrl;
	  $z->sql($sql);
	  $v = $z->row();
	  $row = $v[0];
		$indexLogin_MenuID = substr($Login_MenuID,5);
	  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

	  $ThumbnailPictureName = $row["thumb"];
		$ThumbnailPictureHome = $row['thumbhome'];

		$PathFileGallery = $PathUploadGallery."gallery".$mymenuinclude.$itemid."/";
		recursiveDelete($PathFileGallery);

    $PathFileAtt = $PathUploadFile.$itemid."/";
		recursiveDelete($PathFileAtt);

		$sql = "SELECT "._TABLE_RECIPES_DETAIL_."_HTMLFileName AS HTMLFileName FROM "._TABLE_RECIPES_DETAIL_." WHERE "._TABLE_RECIPES_DETAIL_."_ContentID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$num = $z->num();
		$r = $z->row();
		if($num>0){
			foreach($r as $row){
				$html = $PathUploadHtml.$row['HTMLFileName'];
				if(is_file($html)){unlink($html);}
			}
		}
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureHome;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName.'.webp';
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
      $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName;
      if(is_file($unlinkfile)){unlink($unlinkfile);}
      $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName.'.webp';
      if(is_file($unlinkfile)){unlink($unlinkfile);}
    }
		$z = new __webctrl;
		$z->del(_TABLE_RECIPES_,array(_TABLE_RECIPES_."_ID=" => (int)$itemid));
		$z->del(_TABLE_RECIPES_DETAIL_,array(_TABLE_RECIPES_DETAIL_."_ContentID=" => (int)$itemid));
    $z->del(_TABLE_RECIPES_DETAILRELATE_,array(_TABLE_RECIPES_DETAILRELATE_."_ContentID=" => (int)$itemid));
		$z->del(_TABLE_RECIPES_PHOTO_,array(_TABLE_RECIPES_PHOTO_."_ContentID=" => (int)$itemid));
    $z->del(_TABLE_RECIPES_FILE_,array(_TABLE_RECIPES_FILE_."_ContentID=" => (int)$itemid));
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
					$update[_TABLE_RECIPES_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_RECIPES_,$update,array(_TABLE_RECIPES_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
	break; default:
}
CloseDB();
?>
