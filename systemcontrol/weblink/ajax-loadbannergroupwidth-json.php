<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);

$indexLogin_MenuID = substr($Login_MenuID,5);
$mymenuinclude = $menuFolder[$indexLogin_MenuID];
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$DataGroup = $defaultdata[$Login_MenuID]["group"];

$thisval = $_POST["thisval"];
if(!empty($thisval)){
  $query = "Key='".$thisval."'";
  $mydata = @ArraySearch($DataGroup,$query,1);
  $W = $DataGroup[array_key_first($mydata)]["W"];
  $H = $DataGroup[array_key_first($mydata)]["H"];
}else{
  $W = "xx";
  $H = "xx";
}
$output = array(
	"status" => "ok",
	"W" => $W,
  "H" => $H
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
