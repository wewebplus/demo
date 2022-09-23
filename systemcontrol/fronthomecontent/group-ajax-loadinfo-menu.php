<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datafronthomecontent.php");
$MyData = trim($_POST['MyData']);
$infomenu = array();
if($MyData>0){
  $infomenu = array();
  $infomenu["ID"] = $MyData;
  $infomenu["Name"] = $menuName[$MyData];
  $infomenu["Key"] = $menuModuleKey[$MyData];
}
$output = array(
    "status" => "ok",
    "result" => $infomenu
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
?>
