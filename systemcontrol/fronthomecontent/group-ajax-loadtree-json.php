<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datafronthomecontent.php");

$catDataBackend = getSubCategories(0,0);
header('Content-Type: application/json');
echo json_encode($catDataBackend);
exit();
?>
