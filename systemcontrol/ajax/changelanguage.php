<?php
ob_start();
include("../assets/lib/inc.config.php");
$MyData = $_POST['MyData'];
$MyAction = $_POST['MyAction'];
if($MyAction=="setlanguage") {
	$_SESSION['Session_Admin_Language'] = $MyData;
}
?>
