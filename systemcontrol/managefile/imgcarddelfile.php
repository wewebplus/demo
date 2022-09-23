<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");

$fileList = $_POST['fileList'];
//$folder = _RELATIVE_TEMP_UPLOAD_.session_id();
//$unlinkfile = $folder."/".$fileList;
if(is_file($fileList)){unlink($fileList);}

?>
