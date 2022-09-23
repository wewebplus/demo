<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");

$folder = _RELATIVE_TEMP_UPLOAD_.session_id();
if(!is_dir($folder)) { mkdir($folder,0777); }

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $folder."/";  //4

    $path_parts = pathinfo($_FILES["file"]["name"]);
    $extension = $path_parts["extension"];
    $newFileName = rand(00000,99999)."-".time().'.'.$extension;

    //$newFileName = strtolower($_FILES["file"]["name"]);
    $targetFile =  $targetPath.$newFileName;

    if(move_uploaded_file($tempFile,$targetFile)){
      chmod($targetFile,0777);
    }
    echo $targetFile;
}

?>
