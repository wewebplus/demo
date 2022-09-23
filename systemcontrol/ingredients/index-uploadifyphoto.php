<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = $_POST["saveData"];
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$found = array();

$PathFile = $PathFile."gallery".$mymenuinclude.$itemid;
if(!is_dir($PathFile)) { mkdir($PathFile,0777); }

foreach($_FILES as $index => $file){
  // for easy access
  $myrand = md5(rand(11111,99999));

  $fileName     = $file['name'];
  $myExtensionArray = explode(".",$fileName);
  $myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);

  $NewFile = strtolower($Login_MenuID."-".$myrand.".".$myExtension);
  $NewFilenotype = strtolower($Login_MenuID."-".$myrand);

  $target_path = $PathFile."/".$NewFile;
  // for easy access
  $fileTempName = $file['tmp_name'];
  // check if there is an error for particular entry in array
  if(!empty($file['error'][$index]))  {
    // some error occurred with the file in index $index
    // yield an error here
    return false;
  }

  // check whether file has temporary path and whether it indeed is an uploaded file
  if(!empty($fileTempName) && is_uploaded_file($fileTempName))  {
    // move the file from the temporary directory to somewhere of your choosing
    move_uploaded_file($fileTempName, $target_path);
    chmod($target_path,0777);
    list($width, $height, $type, $attr) = getimagesize($target_path);
    $FileSize = filesize($target_path);

		$NewThumbFile = strtolower("thm-".$defaultdata[$Login_MenuID]["gallery"]["W"]."-".$NewFile);
		$thumb = new Thumbnail($target_path);
		if((int)$width>(int)$height){
			if((int)$height>(int)$defaultdata[$Login_MenuID]["gallery"]["H"]){
				$thumb->resize(0,$defaultdata[$Login_MenuID]["gallery"]["H"]);
			}else{
				$thumb->resize($defaultdata[$Login_MenuID]["gallery"]["W"]);
			}
		}else{
			$thumb->resize(0,$defaultdata[$Login_MenuID]["gallery"]["H"]);
		}
		$thumb->crop(0, 0, $defaultdata[$Login_MenuID]["gallery"]["W"],$defaultdata[$Login_MenuID]["gallery"]["H"]);
		//$thumb->watermark($Arrwatermark_file[0],0,0,'left','bottom');
		$thumb->save($PathFile."/".$NewThumbFile,100);
		$status = "Complete";

    $sql = "SELECT MAX("._TABLE_INGREDIENTS_PHOTO_."_Order) AS MaxO FROM "._TABLE_INGREDIENTS_PHOTO_." WHERE 1 ";
		$sql .= " AND "._TABLE_INGREDIENTS_PHOTO_."_ContentID = ".(int)$itemid;
		if($sessionid<>""){
			$sql .= " AND "._TABLE_INGREDIENTS_PHOTO_."_Session = '".$sessionid."'";
		}
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$MaxOrder = $Row["MaxO"]+1;
		$insert[_TABLE_INGREDIENTS_PHOTO_."_ContentID"] = "'".sql_safe($itemid)."'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_Session"] = "'".sql_safe($sessionid)."'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_Subject"] = "'".sql_safe($fileName)."'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_FileName"] = "'".sql_safe($NewFile)."'";
    $insert[_TABLE_INGREDIENTS_PHOTO_."_FileType"] = "'".sql_safe($myExtension)."'";
    $insert[_TABLE_INGREDIENTS_PHOTO_."_FileSize"] = "'".sql_safe($FileSize)."'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_Views"] = "'0'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_CreateByID"] = "'".(int)$_SESSION['Session_Admin_ID']."'";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_CreateDate"] = "NOW()";
		$insert[_TABLE_INGREDIENTS_PHOTO_."_Order"] = "'".sql_safe($MaxOrder)."'";
		$z = new __webctrl;
		$z->insert(_TABLE_INGREDIENTS_PHOTO_,$insert);
		unset($insert);
    // mark-up to be passed to jQuery's success function.
  }else{
		$status = "NotComplete";
	}
  $arr["status"] = $status;
  $arr["sessionid"] = $sessionid;
  $arr["filename"] = $fileName;
  $arr["phyfilename"] = $NewFilenotype;
  $arr["filetype"] = $myExtension;
  $arr["pathfile"] = $PathFile;
  $found[] = $arr;
}
$output = array(
  "status" => "OK",
  "result" => $found
);
echo json_encode($output);
?>
