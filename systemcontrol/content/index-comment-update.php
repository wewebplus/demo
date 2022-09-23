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
  $TextComment = (!empty($_POST["TextComment"])?encodetxterea($_POST["TextComment"]):'');

  $sql = "SELECT MAX("._TABLE_CONTENT_COMMENT_."_Order) AS MaxO FROM "._TABLE_CONTENT_COMMENT_." WHERE "._TABLE_CONTENT_COMMENT_."_ContentID = ".intval($itemid);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $MaxOrder = $Row["MaxO"]+1;

  $ua = getBrowser();
  $yourbrowser = $ua['name']." ".$ua['version'];

  $insert = array();
  $insert[_TABLE_CONTENT_COMMENT_."_ContentID"] = sql_safe($itemid,false,true);
  $insert[_TABLE_CONTENT_COMMENT_."_MemberID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_CONTENT_COMMENT_."_MemberName"] = "'".sql_safe($_SESSION['Session_Admin_Name'])."'";
  $insert[_TABLE_CONTENT_COMMENT_."_MemberType"] = "'Admin'";
  $insert[_TABLE_CONTENT_COMMENT_."_Detail"] = "'".sql_safe($TextComment)."'";
  $insert[_TABLE_CONTENT_COMMENT_.'_CreateDate'] = "NOW()";
  $insert[_TABLE_CONTENT_COMMENT_."_Order"] = sql_safe($MaxOrder,false,true);
  $insert[_TABLE_CONTENT_COMMENT_."_IP"] = "'".get_real_ip()."'";
  $insert[_TABLE_CONTENT_COMMENT_."_Browser"] = "'".sql_safe($yourbrowser)."'";
  $insert[_TABLE_CONTENT_COMMENT_."_Platform"] = "'".sql_safe($ua['platform'])."'";
  $insert[_TABLE_CONTENT_COMMENT_."_userAgent"] = "'".sql_safe($ua['userAgent'])."'";
  $z->insert(_TABLE_CONTENT_COMMENT_,$insert);
  $CommentDataID = $z->insertid();
  unset($insert);

  // update count
  $sql = "SELECT COUNT(*) AS CountComment FROM "._TABLE_CONTENT_COMMENT_." WHERE "._TABLE_CONTENT_COMMENT_."_ContentID = ".intval($itemid);
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $CountComment = $Row["CountComment"];

  $update[_TABLE_CONTENT_."_Comment"] = sql_safe($CountComment,false,true);
  $z->update(_TABLE_CONTENT_,$update,array(_TABLE_CONTENT_."_ID=" => (int)$itemid));
  unset($update);
  // update count
  // echo "xxxxx".$itemid." : ".$CommentDataID;
}
echo "OK";
?>
