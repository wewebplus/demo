<?php include("./assets/lib/inc.session.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.....</title>
<?php
if($_SESSION['Session_Admin_ID']==0){
    echo '<meta http-equiv="refresh" content="0;URL=loginfrm.php">';
}else{
    echo '<meta http-equiv="refresh" content="0;URL=home/home.php">';
}
?>
</head>

<body>
<div align="center"><img src="assets/img/loader/loading-bars.gif" /></div>
</body>
</html>
