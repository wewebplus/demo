<?php
$myval = $_GET["myval"];
$filetype = $_GET["filetype"];
$arrexp = explode(",",$filetype);
header('Content-type: application/javascript');
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
$File_extensions["mp4"]=array("video/mp4");
$File_extensions["mp3"]=array("audio/mpeg");
$File_extensions["docx"]=array("application/vnd.openxmlformats-officedocument.wordprocessingml.document");
$File_extensions["xlsx"]=array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
$File_extensions["pptx"]=array("application/vnd.openxmlformats-officedocument.presentationml.presentation");

$result = array();
if(count($arrexp)>0){
  foreach($arrexp as $val){
    $result = array_merge($result,$File_extensions[$val]);
  }
}
echo 'var '.$myval.' = ["'.implode("\",\"",$result).'"];';
?>
