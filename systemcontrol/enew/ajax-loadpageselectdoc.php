<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['saveData']);
decode_URL($LoginData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);

$myselectdoc = (!empty($_POST["myselectdoc"])?trim($_POST["myselectdoc"]):'');

$arrmyselect = explode(",",$myselectdoc);
rsort($arrmyselect);
$foundselect = array();
$z = new __webctrl;
if(count($arrmyselect)>0){
  foreach($arrmyselect as $k=>$v){
    $docid = intval($v);
    if($docid>0){
      $sql = "";
      $sql .= "SELECT * FROM ";
      $sql .= "("	;
      	$arrf = array();
      	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
        $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_CreateDate AS CreateDate";
      	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus";
      	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Order AS ListOrder";
      	$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
        $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
      	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
      	$sql .= " WHERE "._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$docid;
      	unset($arrf);
      $sql .= ") TBmain";
      $sql .= " WHERE 1";
      $z->sql($sql);
      $RecordCount = $z->num();
      if($RecordCount>0){
        $v = $z->row();
        $ID = $v[0]["ID"];
        $Name = $v[0]["Subject"];
        $html = $PathUploadHtml.$v[0]['HTMLFileName'];
        if(is_file($html)){
          $html = file_get_contents($html);
        }else{
          $html = "";
        }
      }else{
        $Name = "";
        $html = "";
      }
      $arr = array();
      $arr["id"] = $docid;
      $arr["name"] = $Name;
      $arr["datahtml"] = $html;
      $foundselect[] = $arr;
    }
  }
}

$output = array(
	"status" => "ok",
  "resultselectcount" => count($foundselect),
	"resultselect" => $foundselect,
);
CloseDB();
echo json_encode($output);
exit();
?>
