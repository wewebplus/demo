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

		$sql = "SELECT "._TABLE_PRODUCTS_."_Key AS myKey,"._TABLE_PRODUCTS_."_ID AS ID,"._TABLE_PRODUCTS_."_Status AS ListStatus FROM "._TABLE_PRODUCTS_." WHERE "._TABLE_PRODUCTS_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
    $myKey = $Row["myKey"];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update = array();
		$update[_TABLE_PRODUCTS_."_Status"] = "'".$StatusTo."'";
		$update[_TABLE_PRODUCTS_."_LastUpdate"] = "NOW()";
		$update[_TABLE_PRODUCTS_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => $itemid));
		unset($update);
    $output = array(
			"status" => "OK",
		  "statusto" => strtolower($StatusTo),
			"ClassStatusFrom" => $ClassStatusFrom,
			"ClassStatusTo" => $ClassStatusTo,
			"StatusText" => $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo]
		);
		CloseDB();
		header('Content-Type: application/json');
		echo json_encode($output);
		exit();
    //
		// echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'delete':
		$itemid = $itemid;
		$indexLogin_MenuID = substr($Login_MenuID,5);
	  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
    $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

		$PathFileGallery = $PathUploadGallery."gallery".$mymenuinclude.$itemid."/";
		recursiveDelete($PathFileGallery);

    $PathFileAtt = $PathUploadFile.$itemid."/";
		recursiveDelete($PathFileAtt);

    $PathFilePicture = $PathUploadPicture.$itemid."/";
		recursiveDelete($PathFilePicture);

		$z = new __webctrl;
		$z->del(_TABLE_PRODUCTS_,array(_TABLE_PRODUCTS_."_ID=" => (int)$itemid));
		$z->del(_TABLE_PRODUCTS_DETAIL_,array(_TABLE_PRODUCTS_DETAIL_."_ContentID=" => (int)$itemid));
    $z->del(_TABLE_PRODUCTS_FILE_,array(_TABLE_PRODUCTS_FILE_."_ContentID=" => (int)$itemid));
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
					$update[_TABLE_PRODUCTS_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
	break; default:
}
CloseDB();
?>
