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
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
$found = array();
// _TABLE_PRODUCTS_FILE_
$ArrField = array();
$ArrField[] = _TABLE_PRODUCTS_FILE_."_ID AS ID";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_ContentID AS ContentID";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_Session AS Session";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_Subject AS Subject";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_FileName AS FileName";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_FileType AS FileType";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_Flag AS Flag";
$ArrField[] = _TABLE_PRODUCTS_FILE_."_AddIndex AS AddIndex";
$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_PRODUCTS_FILE_." WHERE 1 ";
$sql .=" AND "._TABLE_PRODUCTS_FILE_."_ContentID = ".(int)$ContentID;
$sql .=" AND "._TABLE_PRODUCTS_FILE_."_Flag = '".$myflag."'";
if($SessionID<>""){
  $sql .= " AND "._TABLE_PRODUCTS_FILE_."_Session='".$SessionID."'";
}
$sql .="  ORDER BY "._TABLE_PRODUCTS_FILE_."_Order ASC";
unset($ArrField);
// echo $sql;
// exit();
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
	foreach($v as $Row){
		$ID = $Row["ID"];
    $ContentID = $Row["ContentID"];
    $SessionID = $Row["Session"];
		$FileName = $Row["FileName"];
    $Subject = urldecode(!empty($Row["Subject"])?$Row["Subject"]:'');
    $FileType = $Row["FileType"];
    $FullpathFilePath = "../assets/img/file_ext/".$FileType.".png";
    $AddIndex = $Row["AddIndex"];
    if($myflag=='product'){
      $PathUpload = $PathUploadPicture;
    }else{
      $PathUpload = $PathUploadFile;
    }
    if($AddIndex=="Old"){
      $FilePathLogoFromDB = $PathUpload.$FileName;
    }else{
      $FilePathLogoFromDB = $PathUpload.$ContentID."/".$FileName;
    }
    $datadwn = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID);
    if (!is_file($FilePathLogoFromDB)) {
			$URLFile = "javascript:void(0)";
		}else{
			$URLFile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$FilePathLogoFromDB);
      // $URLFile = '<a href="'.$URLFile.'" target="_blank" download="'.$Subject.'">'.$Subject.'</a>';
		}
    $arr = array();
		$arr['ID'] = $ID;
		$arr['Detail'] = $Subject;
		$arr['URLFile'] = $URLFile;
    $arr['FileType'] = $FileType;
    $arr['FileTypeShow'] = $FullpathFilePath;
    $arr['DataDWN'] = $datadwn;
		$found[] = $arr;
    unset($arr);
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
