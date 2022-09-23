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
    $sql = "SELECT COUNT(*) AS CountRecord FROM "._TABLE_PRODUCTS_." WHERE 1";
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
      $update[_TABLE_PRODUCTS_."_Order"] = sql_safe($k,false,true);
      //$z = new __webctrl;
      $z->update(_TABLE_PRODUCTS_,$update,array(_TABLE_PRODUCTS_."_ID=" => intval($v)));
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
        $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
    		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
        $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);

        $PathFileGallery = $PathUploadGallery."gallery".$mymenuinclude.$itemid."/";
    		recursiveDelete($PathFileGallery);

        $PathFileAtt = $PathUploadFile.$itemid."/";
    		recursiveDelete($PathFileAtt);

        $PathFilePicture = $PathUploadPicture.$itemid."/";
        recursiveDelete($PathFilePicture);

        $z->del(_TABLE_PRODUCTS_,array(_TABLE_PRODUCTS_."_ID=" => (int)$itemid));
    		$z->del(_TABLE_PRODUCTS_DETAIL_,array(_TABLE_PRODUCTS_DETAIL_."_ContentID=" => (int)$itemid));
        $z->del(_TABLE_PRODUCTS_FILE_,array(_TABLE_PRODUCTS_FILE_."_ContentID=" => (int)$itemid));
        //end search function
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
