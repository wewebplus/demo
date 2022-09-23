<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$MyData = trim($_POST["MyData"]);
$MyID = intval($_POST["MyID"]);

if($MyID>0){

  $sql = "UPDATE "._TABLE_MEMBER_PICCARD_." SET "._TABLE_MEMBER_PICCARD_."_Position = '".$MyData."' WHERE "._TABLE_MEMBER_PICCARD_."_ID=".(int)$MyID;
  $z = new __webctrl;
  $z->query($sql);

  echo "OK:".strtoupper($MyData);
}else{
  echo "NONE";
}

CloseDB();
?>
