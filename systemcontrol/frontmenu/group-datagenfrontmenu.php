<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
if(!empty($Login_MenuID)){
	$indexLogin_MenuID = substr($Login_MenuID,5);
	$mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
	$mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
$InLang = $_SESSION['Session_Admin_Language'];
genFrontendFileJson($FolderKey,$InLang);
?>