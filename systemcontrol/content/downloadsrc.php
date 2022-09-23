<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_SERVER["QUERY_STRING"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
$sql = "";
$ArrField[] = _TABLE_CONTENT_FILE_."_ID AS ID";
$ArrField[] = _TABLE_CONTENT_FILE_."_ContentID AS CID";
$ArrField[] = _TABLE_CONTENT_FILE_."_Session AS Session";
$ArrField[] = _TABLE_CONTENT_FILE_."_Subject AS Detail";
$ArrField[] = _TABLE_CONTENT_FILE_."_FileName AS FileName";
$ArrField[] = _TABLE_CONTENT_FILE_."_FileType AS FileType";
$ArrField[] = _TABLE_CONTENT_FILE_."_Flag AS Flag";
$ArrField[] = _TABLE_CONTENT_FILE_."_AddIndex AS AddIndex";
$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_CONTENT_FILE_." WHERE "._TABLE_CONTENT_FILE_."_ID = ".intval($itemid);
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$FileName = $Row["FileName"];
$filename = $Row["Detail"];
$ContentID = $Row["CID"];
$SessionID = $Row["Session"];
$AddIndex = $Row["AddIndex"];
if(intval($ContentID)>0){
	if($AddIndex=="Old"){
		$myfile = $PathUploadFile.$FileName;
	}else{
		$myfile = $PathUploadFile.$ContentID."/".$FileName;
	}
}else{
	$myfile = $PathUploadFile.$SessionID."/".$FileName;
}
$myExtensionArray = explode(".",$filename);
$filetype = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);
$fileName = str_replace(" ","",$Row["Detail"]);
$fileName = str_replace(".".$filetype,'',$fileName).".".$filetype;

$File_extensions["jpg"]=array("image/jpg" , "image/jpeg", "application/jpg" , "image/pjpeg" , "image/vnd.swiftview-jpeg");
$File_extensions["gif"]=array("image/gif", "image/x-xbitmap");
$File_extensions["png"]=array("image/png", "application/png", "application/x-png","image/x-png");
$File_extensions["pdf"]=array("application/pdf" , "application/x-pdf" , "application/acrobat" , "applications/vnd.pdf" , "text/pdf" , "text/x-pdf");
$File_extensions["doc"]=array("application/msword", "application/doc" , "appl/text" , "application/vnd.msword" , "application/vnd.ms-word", "application/winword" , "application/word" , "application/x-msw6", "application/x-msword" , "zz-application/zz-winassoc-doc");
$File_extensions["xls"]=array("application/msexcel" , "application/x-msexcel" , "application/x-ms-excel" , "application/vnd.ms-excel" , "application/x-excel" , "application/x-dos_ms_excel" , "application/xls"  , "application/x-xls", "zz-application/zz-winassoc-xls");
$File_extensions["ppt"]=array("application/mspowerpoint" , "application/ms-powerpoint" , "application/mspowerpnt" , "application/vnd-mspowerpoint" , "application/vnd.ms-powerpoint"  , "application/powerpoint" , "application/x-powerpoint" , "application/x-mspowerpoint");
$File_extensions["wma"]=array("audio/x-ms-wma" , "video/x-ms-asf");
$File_extensions["wmv"]=array("video/x-ms-wmv");
$File_extensions["zip"]=array("application/zip" , "application/x-zip" , "application/x-zip-compressed" , "application/x-compress" , "application/x-compressed" , "multipart/x-zip");
$File_extensions["swf"]=array("application/x-shockwave-flash", "application/x-shockwave-flash2-preview", "application/futuresplash", "image/vnd.rn-realflash");
$File_extensions["flv"]=array("application/octet-stream");
$File_extensions["mp3"]=array("audio/mpeg");
$File_extensions["docx"]=array("application/vnd.openxmlformats-officedocument.wordprocessingml.document");
$File_extensions["xlsx"]=array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
$File_extensions["pptx"]=array("application/vnd.openxmlformats-officedocument.presentationml.presentation");

	if (file_exists($myfile)) {
		header('Content-Description: File Transfer');
		header('Content-Type: '.$File_extensions[$filetype][0]);
		if($filetype=='pdf'){
			header('Content-Disposition: inline; filename='.basename($fileName));
		}else{
			header('Content-Disposition: attachment; filename='.basename($fileName));
		}
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($myfile));
		ob_clean();
		flush();
		readfile($myfile);
		exit;
	}else{
		echo $myfile;
	}
CloseDB();
?>
