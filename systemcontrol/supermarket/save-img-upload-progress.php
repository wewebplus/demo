<?php
session_start();
$sessionid = session_id();
$PathFile = "../../upload/temp/";
if(!is_dir($PathFile)) { mkdir($PathFile,0777); }
$PathFile = "../../upload/temp/".$sessionid."/";
if(!is_dir($PathFile)) { mkdir($PathFile,0777); }

$myrand = md5(rand(11111,99999));
//user_error( print_r( $_FILES, true ) );
//$target_path = $PathFile.basename( $_FILES[ 'file' ][ 'name' ] );

$filename = $_FILES[ 'file' ][ 'name' ];
$myExtensionArray = explode(".",$filename);
$myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);

$NewFile = strtolower("img-".$myrand.".".$myExtension);
$NewFilenotype = strtolower("img-".$myrand);
$target_path = $PathFile.$NewFile;
$found = array();
if ( move_uploaded_file( $_FILES[ 'file' ][ 'tmp_name' ], $target_path ) ){
    //echo 'File uploaded: ' . $target_path;
  $status = "OK";
}else{
  $status = "Error in uploading file";
    //echo 'Error in uploading file ' . $target_path;
}
$output = array(
  "status" => $status,
  "sessionid" => $sessionid,
  "filename" => $filename,
  "phyfilename" => $NewFilenotype,
  "filetype" => $myExtension,
  "pathfile" => $PathFile,
  "result" => $found
);
echo json_encode($output);
?>
