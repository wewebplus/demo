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
    $sql = "SELECT COUNT(*) AS CountRecord FROM "._TABLE_CONTENT_." WHERE 1";
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
      $update[_TABLE_CONTENT_."_Order"] = sql_safe($k,false,true);
      //$z = new __webctrl;
      $z->update(_TABLE_CONTENT_,$update,array(_TABLE_CONTENT_."_ID=" => intval($v)));
      unset($update);
    }
    echo 'OK';
  break; case 'selectdelete':
    $z = new __webctrl;
    $found = array();
    if(isset($_POST["paramName"])){
      foreach($_POST["paramName"] as $val){
        decode_URL($val);
        $sql = "SELECT "._TABLE_CONTENT_."_Key AS myKey,"._TABLE_CONTENT_."_Picture AS thumb,"._TABLE_CONTENT_."_PictureHome AS thumbhome FROM "._TABLE_CONTENT_." WHERE "._TABLE_CONTENT_."_ID = ".(int)$itemid;
    	  $z->sql($sql);
    	  $v = $z->row();
    	  $row = $v[0];
    		$indexLogin_MenuID = substr($Login_MenuID,5);
    	  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
        $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
    		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
        $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_CONTENT_HTML_UPLOAD_);
        $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
        $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
        $PathUploadVDO = (isset($defaultdata[$Login_MenuID]["path"]["VDO"])?$defaultdata[$Login_MenuID]["path"]["VDO"]:_RELATIVE_CONTENT_FILE_UPLOAD_);
        $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

    	  $ThumbnailPictureName = $row["thumb"];
    		$ThumbnailPictureHome = $row['thumbhome'];

        $PathFileGallery = $PathUploadGallery."gallery".$mymenuinclude.$itemid."/";
    		recursiveDelete($PathFileGallery);

        $PathFileAtt = $PathUploadFile.$itemid."/";
    		recursiveDelete($PathFileAtt);

    		$sql = "SELECT "._TABLE_CONTENT_DETAIL_."_HTMLFileName AS HTMLFileName FROM "._TABLE_CONTENT_DETAIL_." WHERE "._TABLE_CONTENT_DETAIL_."_ContentID = ".(int)$itemid;
    		$z->sql($sql);
    		$num = $z->num();
    		$r = $z->row();
    		if($num>0){
    			foreach($r as $row){
    				$html = $PathUploadHtml.$row['HTMLFileName'];
    				if(is_file($html)){unlink($html);}
    			}
    		}
    		$unlinkfile = $PathUploadPicture.$ThumbnailPictureHome;
        if(is_file($unlinkfile)){unlink($unlinkfile);}
    		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
        if(is_file($unlinkfile)){unlink($unlinkfile);}
    		$unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
        if(is_file($unlinkfile)){unlink($unlinkfile);}
    		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName.'.webp';
        if(is_file($unlinkfile)){unlink($unlinkfile);}
    		foreach($defaultdata[$Login_MenuID]["thumb"]["P"] as $kvl=>$vvl){
          $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName;
          if(is_file($unlinkfile)){unlink($unlinkfile);}
          $unlinkfile = $PathUploadPicture.$vvl."-".$ThumbnailPictureName.'.webp';
          if(is_file($unlinkfile)){unlink($unlinkfile);}
        }
    		$z->del(_TABLE_CONTENT_,array(_TABLE_CONTENT_."_ID=" => (int)$itemid));
    		$z->del(_TABLE_CONTENT_DETAIL_,array(_TABLE_CONTENT_DETAIL_."_ContentID=" => (int)$itemid));
    		$z->del(_TABLE_CONTENT_PIC_,array(_TABLE_CONTENT_PIC_."_ContentID=" => (int)$itemid));
        $z->del(_TABLE_CONTENT_FILE_,array(_TABLE_CONTENT_FILE_."_ContentID=" => (int)$itemid));
        $z->del(_TABLE_CONTENT_RATING_,array(_TABLE_CONTENT_RATING_."_ContentID=" => (int)$itemid));
        $z->del(_TABLE_CONTENT_LINK_,array(_TABLE_CONTENT_LINK_."_ContentID=" => (int)$itemid));
        //search function
        $option = array();
        $option["dataid"] = $itemid;
        $option["datatype"] = "cms";
        $option["datakey"] = $mymenukey;
        $option["datacreateid"] = $_SESSION['Session_Admin_ID'];
        $option["datacreatename"] = $_SESSION['Session_Admin_Name'];
        $option["datalang"] = $systemLang;
        addSearch($option);
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
