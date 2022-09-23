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
	case 'changestatus':
		$itemid = $itemid;
		$StatusTo = $statusto;
		$sql = "SELECT "._TABLE_FRONTMENUCONTENT_."_ID AS ID,"._TABLE_FRONTMENUCONTENT_."_Status AS ListStatus,"._TABLE_FRONTMENUCONTENT_."_Language AS InLanguage,"._TABLE_FRONTMENUCONTENT_."_Folder AS InFolder FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$FolderKey = $Row["InFolder"];
		$InLang = $Row["InLanguage"];

		$update[_TABLE_FRONTMENUCONTENT_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_FRONTMENUCONTENT_,$update,array(_TABLE_FRONTMENUCONTENT_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='On'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Off&actiontype=changestatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=On&actiontype=changestatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง</a>';
		}
		echo $btnstatus;
		// genFileJson($FolderKey,$InLang);
	break;case 'delete':
		$itemid = $itemid;
		$sql = "SELECT "._TABLE_FRONTMENUCONTENT_."_ID AS ID,"._TABLE_FRONTMENUCONTENT_."_Status AS ListStatus,"._TABLE_FRONTMENUCONTENT_."_Language AS InLanguage,"._TABLE_FRONTMENUCONTENT_."_Folder AS InFolder FROM "._TABLE_FRONTMENUCONTENT_." WHERE "._TABLE_FRONTMENUCONTENT_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$FolderKey = $Row["InFolder"];
		$InLang = $Row["InLanguage"];
		$z = new __webctrl;
		$z->del(_TABLE_FRONTMENUCONTENT_,array(_TABLE_FRONTMENUCONTENT_."_ID=" => (int)$itemid));
		echo "OK";
		// genFileJson($FolderKey,$InLang);
	break;case 'deletesublist':
		if(!empty($Login_MenuID)){
			$indexLogin_MenuID = substr($Login_MenuID,5);
			$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
			$mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$sql = "SELECT "._TABLE_PHONE_GROUP_."_ID AS ID,"._TABLE_PHONE_GROUP_."_PictureFile AS PictureFile FROM "._TABLE_PHONE_GROUP_." WHERE "._TABLE_PHONE_GROUP_."_ID = ".(int)$SubGroupID;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$userpathpath = _RELATIVE_PHONEBOOK_IMG_UPLOAD_;
		$ThumbnailPicture = $Row["PictureFile"];
		$unlinkfile = $userpathpath.$ThumbnailPicture;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		foreach($defaultdata[$Login_MenuID]["thumbgroup"]["P"] as $kvl=>$vvl){
			$W = $defaultdata[$Login_MenuID]["thumbgroup"]["W"][$kvl];
			$H = $defaultdata[$Login_MenuID]["thumbgroup"]["H"][$kvl];
			$prefix = "thum".$W;
			$unlinkfile = $userpathpath.$prefix."-".$ThumbnailPicture;
			if(is_file($unlinkfile)){unlink($unlinkfile);}
		}
		$z->del(_TABLE_PHONE_GROUP_,array(_TABLE_PHONE_GROUP_."_ID=" => (int)$SubGroupID));
		echo "OK";
	break;case 'changesubstatus':
		$itemid = $itemid;
		$StatusTo = $statusto;
		$sql = "SELECT "._TABLE_PHONE_GROUP_."_ID AS ID,"._TABLE_PHONE_GROUP_."_Status AS ListStatus FROM "._TABLE_PHONE_GROUP_." WHERE "._TABLE_PHONE_GROUP_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$update[_TABLE_PHONE_GROUP_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_PHONE_GROUP_,$update,array(_TABLE_PHONE_GROUP_."_ID=" => $itemid));
		unset($update);
		if($StatusTo=='On'){
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=Off&actiontype=changesubstatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeSubStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง</a>';
		}else{
			$datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$itemid.'&statusto=On&actiontype=changesubstatus');
			$btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeSubStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง</a>';
		}
		echo $btnstatus;
	break;case 'sort':
		$myorder = $_POST['tsort'];
		$ArrOrder = explode('|x|',$myorder);
		$counArr = count($ArrOrder);
		if($counArr>0){
			for($i=1;$i<$counArr;$i++){
				$value = str_replace("s","",$ArrOrder[$i]);
				if($value <> 'null'){
					// $j = $counArr-$i;
					$j = $i;
					$update[_TABLE_PHONE_GROUP_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_PHONE_GROUP_,$update,array(_TABLE_PHONE_GROUP_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
	 break;case 'sortsub':
 		$myorder = $_POST['tsort'];
 		$ArrOrder = explode('|x|',$myorder);
 		$counArr = count($ArrOrder);
 		if($counArr>0){
 			for($i=1;$i<$counArr;$i++){
 			$value = str_replace("s","",$ArrOrder[$i]);
 				if($value <> 'null'){
 				//$j = $counArr-$i;
 				$j = $i;
 				$update[_TABLE_PHONE_GROUP_."_Order"] = sql_safe($j,false,true);
 					$z = new __webctrl;
 					$z->update(_TABLE_PHONE_GROUP_,$update,array(_TABLE_PHONE_GROUP_."_ID=" => (int)$value));
 					unset($update);
 				}
 			}
 		}
	break; default:
}
CloseDB();
?>
