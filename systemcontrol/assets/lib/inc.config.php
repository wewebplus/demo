<?php
$mainpeotocal = (!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'https://':'http://';
define ("_APP_KEY_",	'QwEaSdZxC0Thaiselect');// remark
define ("_DATABASE_KEY_",	'90TQk9mRXFmeWdkYs50RkxXP9EEZvZ0VhpnVHJGbOdEZ81TPRN1Q4JjV1o0VOxEaFRFf9U0RaRHbtJmZk12YopFWZxXP9EEZvZ0VhpnVHJGbOdEZ81TP31keBpmT8NXOykFa4dUY25ESkxXPFFDZGZkMVtGcGVGRCRkVvZ0VhpnVHJGbOdEZ');
define ("_HTTP_PATH_", $mainpeotocal.$_SERVER["SERVER_NAME"]."/demo/bsexpress");
define ("_SYSTEM_ROOTPATH_", "/demo/bsexpress");
define ("_SYSTEM_DIRROOTPATH_", $_SERVER['DOCUMENT_ROOT']."/demo/bsexpress");
define ("_HTTP_PATH_UPLOAD_", $mainpeotocal.$_SERVER["SERVER_NAME"]."/demo/bsexpress/upload");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.session.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.functiondecode.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configpath.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configdb.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configtable.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/"._DB_TYPE_.".php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configtitle.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configmail.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/inc.configother.php");
include(_SYSTEM_DIRROOTPATH_."/systemcontrol/assets/lib/function.php");
?>
