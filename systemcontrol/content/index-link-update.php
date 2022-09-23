<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/thumbnail_php5.inc.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$Lang = "Lang";
$myrand = md5(rand(11111,99999));

if($actiontype=='update'){
  //$itemid
  $z = new __webctrl;
  $dataINID = array();
  if(isset($_POST["inputLinkDataID"])){
    if(count($_POST["inputLinkDataID"])>0){
      $indexorder = 0;
      foreach($_POST["inputLinkDataID"] as $skey=>$sval){
        $indexorder++;
        $LinkDataID = intval($sval);
        $inputLinkName = (!empty($_POST["inputLinkName"][$skey])?$_POST["inputLinkName"][$skey]:'');
        $inputURL = (!empty($_POST["inputURL"][$skey])?$_POST["inputURL"][$skey]:'');
        if($LinkDataID>0){
          $update = array();
          $update[_TABLE_CONTENT_LINK_."_Subject"] = "'".sql_safe($inputLinkName)."'";
          $update[_TABLE_CONTENT_LINK_."_URL"] = "'".sql_safe($inputURL)."'";
          $update[_TABLE_CONTENT_LINK_."_CreateDate"] = "NOW()";
          $z->update(_TABLE_CONTENT_LINK_,$update,array(_TABLE_CONTENT_LINK_."_ID=" => (int)$LinkDataID));
          unset($update);
          array_push($dataINID,$LinkDataID);
        }else{
          $insert = array();
          $insert[_TABLE_CONTENT_LINK_."_ContentID"] = sql_safe($itemid,false,true);
          $insert[_TABLE_CONTENT_LINK_."_Subject"] = "'".sql_safe($inputLinkName)."'";
          $insert[_TABLE_CONTENT_LINK_."_URL"] = "'".sql_safe($inputURL)."'";
          $insert[_TABLE_CONTENT_LINK_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
          $insert[_TABLE_CONTENT_LINK_.'_CreateDate'] = "NOW()";
          $insert[_TABLE_CONTENT_LINK_."_Order"] = sql_safe($indexorder,false,true);
      		$z->insert(_TABLE_CONTENT_LINK_,$insert);
          $LinkDataID = $z->insertid();
      		unset($insert);
          array_push($dataINID,$LinkDataID);
        }
      }
    }
  }
  if(isset($dataINID)){
    $sql = "SELECT "._TABLE_CONTENT_LINK_."_ID AS ID FROM "._TABLE_CONTENT_LINK_." WHERE "._TABLE_CONTENT_LINK_."_ContentID = ".intval($itemid);
    $sql .= " AND "._TABLE_CONTENT_LINK_."_ID NOT IN (".implode(',',$dataINID).")";
    $z = new __webctrl;
    $z->sql($sql);
    $RecordCount = $z->num();
    if($RecordCount>0){
      $v = $z->row();
      foreach($v as $Row){
        $ID = $Row["ID"];
        $z->del(_TABLE_CONTENT_LINK_,array(_TABLE_CONTENT_LINK_."_ID=" => (int)$ID));
      }
    }
  }
}
echo "OK";
?>
