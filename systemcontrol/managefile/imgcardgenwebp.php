<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");

$id = $_POST["id"];
$saveData = $_POST["saveData"];
decode_URL($saveData);
if($id>0){
  $sql = "";
  $arrf = array();
  $arrf[] = "a."._TABLE_STOCKFILE_.'_ID AS ID';
  $arrf[] = "a."._TABLE_STOCKFILE_.'_Name AS Name';
  $arrf[] = "a."._TABLE_STOCKFILE_.'_File AS File';
  $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_STOCKFILE_." a";
  $sql .= " WHERE "._TABLE_STOCKFILE_."_ID = ".(int)$id;
  unset($arrf);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $File = $v[0]["File"];

  $myfolderfile = _RELATIVE_STOCKFILE_UPLOAD_.$File;
  $Picturexxwebp = _RELATIVE_STOCKFILE_UPLOAD_.$File.'.webp';

  if(!is_file($Picturexxwebp)){
    $jw = new ImageToWebp();
    $jw->convert( $myfolderfile, $Picturexxwebp );
    $fullpathPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picturexxwebp);
  }else{
    $fullpathPicture = '';
  }
  $arr['path'] = $fullpathPicture;
  $found = $arr;
}else{
  $found = array();
}
$output = array(
	"status" => "ok",
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();

?>
