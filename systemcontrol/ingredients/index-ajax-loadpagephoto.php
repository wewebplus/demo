<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$saveData = trim($_POST['saveData']);
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$found = array();

$ArrField[] = _TABLE_INGREDIENTS_PHOTO_."_ID AS ID";
$ArrField[] = _TABLE_INGREDIENTS_PHOTO_."_ContentID AS CID";
$ArrField[] = _TABLE_INGREDIENTS_PHOTO_."_FileName AS FileName";
$ArrField[] = _TABLE_INGREDIENTS_PHOTO_."_Detail AS Detail";
$ArrField[] = _TABLE_INGREDIENTS_PHOTO_."_AddIndex AS AddIndex";

$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_INGREDIENTS_PHOTO_." WHERE 1 ";
$sql .=" AND "._TABLE_INGREDIENTS_PHOTO_."_ContentID = ".(int)$itemid;
$sql .="  ORDER BY "._TABLE_INGREDIENTS_PHOTO_."_Order ASC";
unset($ArrField);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
	foreach($v as $Row){
		$ID = $Row["ID"];
		$FileName = $Row["FileName"];
		$Detail = (!empty($Row["Detail"])?$Row["Detail"]:'');
    $AddIndex = $Row["AddIndex"];
    if($AddIndex=="Old"){
      $ThumbPic = $PathUploadGallery.$FileName;
    }else{
      $ThumbPic = $PathUploadGallery."gallery".$mymenuinclude.$itemid."/thm-".$defaultdata[$Login_MenuID]["gallery"]["W"]."-".$FileName;
    }
		if (!is_file($ThumbPic)) {
			$ThumbPic = "./images/defaultdhow.jpg";
		}else{
			$ThumbPic = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$ThumbPic);
		}

		$arr['ID'] = $ID;
		$arr['Detail'] = $Detail;
		$arr['ThumbPic'] = $ThumbPic;
		$found[] = $arr;
	}
}

$output = array(
	"status" => "ok",
	"reccount" => number_format($RecordCount),
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
