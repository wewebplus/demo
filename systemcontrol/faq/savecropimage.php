<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");

$folder = _RELATIVE_TEMP_UPLOAD_.session_id();
if(!is_dir($folder)) { mkdir($folder,0777); }
$myrand = md5(rand(11111,99999));
$nametotemp = "content-".md5(session_id().rand(11111,99999)).".png";

$filename = $folder."/".$nametotemp;
$img = $_POST['pngimageData'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
file_put_contents($filename, $data);

$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$filename);
echo $showPicture;
?>
