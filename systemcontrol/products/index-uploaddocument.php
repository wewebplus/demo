<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
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
$id = $_REQUEST['id'];
$sessionid = $_REQUEST['sessionid'];
$PathFile = $_REQUEST['mypath'];
$myflag = $_REQUEST['myflag'];
$found = array();
if(!is_dir($PathFile)) { mkdir($PathFile,0777);}
if($itemid==0){
  $PathFile = $PathFile.$sessionid;
  if(!is_dir($PathFile)) { mkdir($PathFile,0777);}
}else{
  $PathFile = $PathFile.$itemid;
  if(!is_dir($PathFile)) { mkdir($PathFile,0777);}
}

foreach($_FILES as $index => $file){
  // for easy access
  $myrand = md5(rand(11111,99999));

  $fileName     = $file['name'];
  $myExtensionArray = explode(".",$fileName);
  $myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);

  $NewFile = strtolower($myrand.".".$myExtension);
  $NewFilenotype = strtolower($myrand);
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
    $FileSize = filesize($target_path);
		$status = "Complete";

    $myExtensionArray = explode(".",$fileName);
  	$myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);

    $sql = "SELECT MAX("._TABLE_PRODUCTS_FILE_."_Order) AS MaxO FROM "._TABLE_PRODUCTS_FILE_." WHERE 1 ";
		$sql .= " AND "._TABLE_PRODUCTS_FILE_."_ContentID = ".(int)$itemid;
		if($sessionid<>""){
			$sql .= " AND "._TABLE_PRODUCTS_FILE_."_Session='".$sessionid."'";
		}
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$MaxOrder = $Row["MaxO"]+1;
		$insert[_TABLE_PRODUCTS_FILE_."_ContentID"] = "'".sql_safe($itemid)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_Session"] = "'".sql_safe($sessionid)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_Subject"] = "'".sql_safe($fileName)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_FileName"] = "'".sql_safe($NewFile)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_FileType"] = "'".sql_safe($myExtension)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_FileSize"] = "'".sql_safe($FileSize)."'";
		$insert[_TABLE_PRODUCTS_FILE_."_Views"] = "'0'";
		$insert[_TABLE_PRODUCTS_FILE_."_CreateByID"] = "'".(int)$_SESSION['Session_Admin_ID']."'";
		$insert[_TABLE_PRODUCTS_FILE_."_CreateDate"] = "NOW()";
		$insert[_TABLE_PRODUCTS_FILE_."_Order"] = "'".sql_safe($MaxOrder)."'";
    $insert[_TABLE_PRODUCTS_FILE_."_Flag"] = "'".sql_safe($myflag)."'";
		$z = new __webctrl;
		$z->insert(_TABLE_PRODUCTS_FILE_,$insert);
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
