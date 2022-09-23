<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$saveData = trim($_POST['saveData']);
decode_URL($saveData);
//$Login_MenuID;

$PageSearch = "";

if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}

if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}

$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;

if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}

$found = array();

$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
$PageSize = (empty($selectPerPage)?_DEFAULT_PAGESIZE_:$selectPerPage);
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);

$sql = "";
$arrf = array();
$arrf[] = "a."._TABLE_STOCKFILE_.'_ID AS ID';
$arrf[] = "a."._TABLE_STOCKFILE_.'_Name AS Name';
$arrf[] = "a."._TABLE_STOCKFILE_.'_File AS File';
$arrf[] = "a."._TABLE_STOCKFILE_.'_FileType AS FileType';

$arrf[] = "a."._TABLE_STOCKFILE_.'_Status AS myStatus';
$arrf[] = "a."._TABLE_STOCKFILE_.'_Position AS myPosition';
$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_STOCKFILE_." a";
$sql .= " WHERE 1";
$sql .= " ORDER BY "._TABLE_STOCKFILE_."_Order ASC";
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
	foreach($v as $Row){
		$ID = $Row["ID"];
		$Name = $Row["Name"];
		$File = $Row["File"];
		$FileType = $Row["FileType"];
		if(strtolower($FileType)=='jpg' || strtolower($FileType)=='png'){
			$iswebp = true;
		}else{
			$iswebp = false;
		}
		$myPosition = $Row["myPosition"];
		$myStatus = $Row["myStatus"];

		$myfolder = _RELATIVE_STOCKFILE_UPLOAD_;
		$myFile = $myfolder.$File;
		if(is_file($myFile)){
			$fullpathPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$myFile);
			if(strtolower($FileType)=='jpg' || strtolower($FileType)=='png'){
				$showFile = '<img src="'.$fullpathPicture.'" class="imglistgallery" alt="'.$Name.'" />';
			}else{
				$FullpathExt = '<img src="../assets/img/file_ext/'.$FileType.'.png" class="imglistgallery" alt="'.$FileType.'" />';
				$showFile = '<a href="'.$fullpathPicture.'" target="_blank" download>'.$FullpathExt.'</a>';
			}
		}else{
			$fullpathPicture = "";
			$showFile = '<img src="../img/icon/8.jpg" class="imglistgallery" alt="" />';
		}

		$arr["valueid"] = $ID;
		$arr["valueName"] = $Name;
		$arr["valueFileType"] = $FileType;
		$arr["valueiswebp"] = $iswebp;
		$arr["valueFile"] = $showFile;
		$arr["valueFullpath"] = $fullpathPicture;
		$arr["valueStatus"] = $myStatus;
		$arr["valuePosition"] = $myPosition;
		$arr["valuePositionShow"] = strtoupper($myPosition);
		$found[] = $arr;

	}
}

$output = array(
	"status" => "ok",
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
