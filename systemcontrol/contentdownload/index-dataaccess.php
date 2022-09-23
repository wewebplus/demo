<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
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

		$sql = "SELECT "._TABLE_DOWNLOAD_."_Key AS myKey,"._TABLE_DOWNLOAD_."_ID AS ID,"._TABLE_DOWNLOAD_."_Status AS ListStatus FROM "._TABLE_DOWNLOAD_." WHERE "._TABLE_DOWNLOAD_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
    $myKey = $Row["myKey"];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_DOWNLOAD_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_DOWNLOAD_,$update,array(_TABLE_DOWNLOAD_."_ID=" => $itemid));
		unset($update);

		//search function
		$option = array();
		$option["dataid"] = $itemid;
		$option["datatype"] = "download";
		$option["datakey"] = $myKey;
		$option["datacreateid"] = $_SESSION['Session_Admin_ID'];
		$option["datacreatename"] = $_SESSION['Session_Admin_Name'];
		$option["datalang"] = $systemLang;
		addSearch($option);
		//end search function

		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'changeusebtnPublic':
    $itemid = $itemid;
    $StatusTo = $statusto;
    // echo $StatusType;
    $update = array();
		$update[_TABLE_DOWNLOAD_."_Public"] = "'".$StatusTo."'";
		$update[_TABLE_DOWNLOAD_."_LastUpdate"] = "NOW()";
		$update[_TABLE_DOWNLOAD_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_DOWNLOAD_,$update,array(_TABLE_DOWNLOAD_."_ID=" => $itemid));
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
    $indexLogin_MenuID = substr($Login_MenuID,5);
		$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_DOWNLOAD_HTML_UPLOAD_);
    $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_DOWNLOAD_FILE_UPLOAD_);
    $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_DOWNLOAD_IMG_UPLOAD_);

		$sql = "SELECT "._TABLE_DOWNLOAD_DETAIL_."_F AS DocumentFile FROM "._TABLE_DOWNLOAD_DETAIL_." WHERE "._TABLE_DOWNLOAD_DETAIL_."_ContentID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$num = $z->num();
		$r = $z->row();
		if($num>0){
			foreach($r as $row){
				$html = $PathUploadFile.$row['DocumentFile'];
				if(is_file($html)){unlink($html);}
			}
		}

		$sql = "SELECT "._TABLE_DOWNLOAD_."_Key AS ListKey,"._TABLE_DOWNLOAD_."_Picture AS thumb FROM "._TABLE_DOWNLOAD_." WHERE "._TABLE_DOWNLOAD_."_ID = ".(int)$itemid;
	  $z = new __webctrl;
	  $z->sql($sql);
	  $v = $z->row();
	  $row = $v[0];
	  $ThumbnailPictureName = $row["thumb"];
		$ListKey = $row["ListKey"];

		foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
			$unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName;
      if(is_file($unlinkfile)){unlink($unlinkfile);}
      $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName.'.webp';
      if(is_file($unlinkfile)){unlink($unlinkfile);}
		}
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName.'.webp';
    if(is_file($unlinkfile)){unlink($unlinkfile);}

		$z = new __webctrl;
		$z->del(_TABLE_DOWNLOAD_,array(_TABLE_DOWNLOAD_."_ID=" => (int)$itemid));
		$z->del(_TABLE_DOWNLOAD_DETAIL_,array(_TABLE_DOWNLOAD_DETAIL_."_ContentID=" => (int)$itemid));

		//search function
		$option = array();
		$option["dataid"] = $itemid;
		$option["datatype"] = "download";
		$option["datakey"] = $ListKey;
		$option["datacreateid"] = $_SESSION['Session_Admin_ID'];
		$option["datacreatename"] = $_SESSION['Session_Admin_Name'];
		$option["datalang"] = $systemLang;
		addSearch($option);
		//end search function

		echo "OK";
	break;case 'sort':
		$myorder = $_POST['tsort'];
		$ArrOrder = explode('|x|',$myorder);
		$counArr = count($ArrOrder);
		if($counArr>0){
			for($i=1;$i<$counArr;$i++){
				$value = str_replace("s","",$ArrOrder[$i]);
				if($value <> 'null'){
					$j = ($counArr-$i);
					$update[_TABLE_DOWNLOAD_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_DOWNLOAD_,$update,array(_TABLE_DOWNLOAD_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
	break; default:
}
CloseDB();
?>
