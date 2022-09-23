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

		$sql = "SELECT "._TABLE_MAIL_DOCUMENT_."_ID AS ID,"._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus FROM "._TABLE_MAIL_DOCUMENT_." WHERE "._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update[_TABLE_MAIL_DOCUMENT_."_Status"] = "'".$StatusTo."'";
		$z = new __webctrl;
		$z->update(_TABLE_MAIL_DOCUMENT_,$update,array(_TABLE_MAIL_DOCUMENT_."_ID=" => $itemid));
		unset($update);
		echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
		if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
		$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
		$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
		if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
		if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }

		$arrf = array();
		$sql = "";
		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
		$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
		$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
		$sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$itemid;
		unset($arrf);
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$oldhtml01 = $PathUploadHtml.$Row['HTMLFileName'];
		if(is_file($oldhtml01)){unlink($oldhtml01);}

		$sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_FileName AS FileName FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE "._TABLE_MAIL_DOCUMENT_FILE_."_CID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$num = $z->num();
		$r = $z->row();
		if($num>0){
			foreach($r as $row){
				$oldFile = $PathUploadFile.$row['FileName'];
				if(is_file($oldFile)){unlink($oldFile);}
			}
		}
		$z = new __webctrl;
		$z->del(_TABLE_MAIL_DOCUMENT_,array(_TABLE_MAIL_DOCUMENT_."_ID=" => (int)$itemid));
		$z->del(_TABLE_MAIL_DOCUMENT_FILE_,array(_TABLE_MAIL_DOCUMENT_FILE_."_CID=" => (int)$itemid));
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
					$update[_TABLE_MAIL_DOCUMENT_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_MAIL_DOCUMENT_,$update,array(_TABLE_MAIL_DOCUMENT_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
	break; default:
}
CloseDB();
?>
