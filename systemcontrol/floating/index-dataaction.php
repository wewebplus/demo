<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$myaction = trim($_POST['myaction']);
switch($myaction){
  case 'sortlist':
    $MyData = trim($_POST['MyData']);
    decode_URL($MyData);
    //$Login_MenuID;
    if(!empty($Login_MenuID)){
      $indexLogin_MenuID = substr($Login_MenuID,5);
      $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    }else{
      $mymenuinclude = "";
    }
    include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
    $selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];

    $PageShow = $_POST["mypage"];
    $PageSize = $_POST["mypagesize"];
    $myval = $_POST["myval"];
    $FirstSort = $myval[0];
    $LastSort = $myval[count($myval)-1];
    $RecordStart = ($PageSize*($PageShow-1));
    $RecordEnd = ($RecordStart+$PageSize)-1;
    //echo $RecordStart.":".$RecordEnd;
    //print_r($myval);
    $index = 0;
    $indexinline = 0;
    $sql = "SELECT COUNT(*) AS CountRecord FROM "._TABLE_ADS_." WHERE 1";
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $RecordCount = $v[0]["CountRecord"];
    foreach($myval as $kx=>$vx){
      $index++;
      $ListIndex = $RecordCount-($RecordStart+($index-1));
      $MyData = $myval[$indexinline];
      decode_URL($MyData);
      $ar[$ListIndex] = $itemid;
      $indexinline++;
    }
    //print_r($ar);
    foreach($ar as $k=>$v){
      $update[_TABLE_ADS_."_Order"] = sql_safe($k,false,true);
      $z->update(_TABLE_ADS_,$update,array(_TABLE_ADS_."_ID=" => intval($v)));
      unset($update);
    }
    echo 'OK';
  break; case 'selectdelete':
    $z = new __webctrl;
    $found = array();
    if(isset($_POST["paramName"])){
      foreach($_POST["paramName"] as $val){
        decode_URL($val);
        $indexLogin_MenuID = substr($Login_MenuID,5);
        $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
        $mymenukey = @$menuFolderModule[$indexLogin_MenuID];
        include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
        $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ADS_UPLOAD_);
        $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_ADS_UPLOAD_);
        $sql = "SELECT "._TABLE_ADS_DETAIL_."_File AS PictureFile FROM "._TABLE_ADS_DETAIL_." WHERE "._TABLE_ADS_DETAIL_."_ContentID = ".(int)$itemid;
    		$z->sql($sql);
    		$num = $z->num();
    		$r = $z->row();
    		if($num>0){
    			foreach($r as $row){
    				$oldhtml01 = $PathUploadPicture.$row['PictureFile'];
    				if(is_file($oldhtml01)){unlink($oldhtml01);}
    			}
    		}
    		$z->del(_TABLE_ADS_,array(_TABLE_ADS_."_ID=" => (int)$itemid));
    		$z->del(_TABLE_ADS_DETAIL_,array(_TABLE_ADS_DETAIL_."_ContentID=" => (int)$itemid));
      }
      $status = "ok";
    }else{
      $status = "no";
    }
    $output = array(
    	"status" => $status,
    	"result" => $found
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
  break;case 'delete':
  break; default:
}
?>
