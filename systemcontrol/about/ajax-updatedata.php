<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
  $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
  $mymenukey = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$dataOption = $defaultdata[$Login_MenuID]["option"];

$Lang = "Lang";
$myrand = md5(rand(11111,99999));

$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ABOUT_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ABOUT_HTML_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }

if($itemid>0){
  foreach($systemLang as $lkey=>$lval){
    $detailid = $_POST["detailid".$lkey];
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputDetail01 = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');

    // 01
    $filename01 = md5($Login_MenuID.'-'.$lkey.'-'.$itemid.'-'.$myrand.'-01');
    $content = stripslashes($inputDetail01);
    $html01 = $filename01.'.html';
    savetxt($PathUploadHtml.$html01,$content);

  	if($detailid>0){
  		$sqlx = "SELECT "._TABLE_ABOUT_DETAIL_."_HTMLFileName AS HTMLFileName FROM "._TABLE_ABOUT_DETAIL_." WHERE "._TABLE_ABOUT_DETAIL_."_ID = ".(int)$detailid;
  		$zx = new __webctrl;
  		$zx->sql($sqlx);
  		$vx = $zx->row();
  		$rowx = $vx[0];
  		$oldhtml01 = $PathUploadHtml.$rowx['HTMLFileName'];
      if(is_file($oldhtml01)){unlink($oldhtml01);}
  		$update[_TABLE_ABOUT_DETAIL_.'_HTMLFileName'] = "'".sql_safe($html01)."'";
  		$update[_TABLE_ABOUT_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$update[_TABLE_ABOUT_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$update[_TABLE_ABOUT_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->update(_TABLE_ABOUT_DETAIL_,$update,array(_TABLE_ABOUT_DETAIL_."_ID=" => (int)$detailid));
  		unset($update);
  	}else{
  		$insert[_TABLE_ABOUT_DETAIL_.'_ContentID'] = "'".sql_safe($itemid)."'";
  		$insert[_TABLE_ABOUT_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
  		$insert[_TABLE_ABOUT_DETAIL_.'_HTMLFileName'] = "'".sql_safe($html01)."'";
  		$insert[_TABLE_ABOUT_DETAIL_.'_UpdateDate'] = "NOW()";
  		if(!empty($Ignore)){
  			$insert[_TABLE_ABOUT_DETAIL_.'_Status'] = "'Off'";
  			$Lang .= "|".$lkey.":Off";
  		}else{
  			$insert[_TABLE_ABOUT_DETAIL_.'_Status'] = "'On'";
  			$Lang .= "|".$lkey.":On";
  		}
  		$z = new __webctrl;
  		$z->insert(_TABLE_ABOUT_DETAIL_,$insert);
  		unset($insert);
  	}
  }

	$update[_TABLE_ABOUT_."_LastUpdate"] = "NOW()";
	$update[_TABLE_ABOUT_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
	$update[_TABLE_ABOUT_.'_Ignore'] = "'".sql_safe($Lang)."'";
	$update[_TABLE_ABOUT_.'_IP'] = "'".get_real_ip()."'";

	$z = new __webctrl;
	$z->update(_TABLE_ABOUT_,$update,array(_TABLE_ABOUT_."_ID=" => (int)$itemid));
	unset($update);
}else{
  $sql = "SELECT MAX("._TABLE_ABOUT_."_Order) AS MaxO FROM "._TABLE_ABOUT_." WHERE 1 ";
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $Row = $v[0];
  $MaxOrder = $Row["MaxO"]+1;

  $insert = array();
  $insert[_TABLE_ABOUT_.'_Key'] = "'".$mymenukey."'";
  $insert[_TABLE_ABOUT_.'_CreateDate'] = "NOW()";
  $insert[_TABLE_ABOUT_.'_LastUpdate'] = "NOW()";
  $insert[_TABLE_ABOUT_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_ABOUT_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
  $insert[_TABLE_ABOUT_.'_Status'] = "'On'";
  $insert[_TABLE_ABOUT_.'_Ignore'] = "'".sql_safe($Lang)."'";
  $insert[_TABLE_ABOUT_.'_IP'] = "'".get_real_ip()."'";
  $insert[_TABLE_ABOUT_.'_Order'] = sql_safe($MaxOrder,false,true);
  if(isset($dataOption["MenuID"])){
    if(intval($dataOption["MenuID"])>0){
      $SiteID = 1;
      $insert[_TABLE_ABOUT_.'_SiteID'] = sql_safe($SiteID,false,true);
      $insert[_TABLE_ABOUT_.'_MenuID'] = sql_safe($dataOption["MenuID"],false,true);
    }
  }
  $z = new __webctrl;
  $z->insert(_TABLE_ABOUT_,$insert);
  $insertid = $z->insertid();
  unset($insert);

  foreach($systemLang as $lkey=>$lval){
    $Ignore = (!empty($_POST["inputIgnore".$lkey])?$_POST["inputIgnore".$lkey]:'');
    $inputDetail01 = (!empty($_POST["inputDetail".$lkey])?$_POST["inputDetail".$lkey]:'');

    // 01
    $filename01 = md5($Login_MenuID.'-'.$lkey.'-'.$itemid.'-'.$myrand.'-01');
    $content = stripslashes($inputDetail01);
    $html01 = $filename01.'.html';
    savetxt($PathUploadHtml.$html01,$content);

		$insert[_TABLE_ABOUT_DETAIL_.'_ContentID'] = "'".sql_safe($insertid)."'";
		$insert[_TABLE_ABOUT_DETAIL_.'_Lang'] = "'".sql_safe($lkey)."'";
		$insert[_TABLE_ABOUT_DETAIL_.'_HTMLFileName'] = "'".sql_safe($html01)."'";
		$insert[_TABLE_ABOUT_DETAIL_.'_UpdateDate'] = "NOW()";
		if(!empty($Ignore)){
			$insert[_TABLE_ABOUT_DETAIL_.'_Status'] = "'Off'";
			$Lang .= "|".$lkey.":Off";
		}else{
			$insert[_TABLE_ABOUT_DETAIL_.'_Status'] = "'On'";
			$Lang .= "|".$lkey.":On";
		}
		$z = new __webctrl;
		$z->insert(_TABLE_ABOUT_DETAIL_,$insert);
		unset($insert);
  }
}

echo 2;
CloseDB();
?>
