<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$MyData = trim($_POST['MyData']);
decode_URL($MyData);
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$sql = "SELECT "._TABLE_RESTAURANT_."_ID AS ID,"._TABLE_RESTAURANT_."_ApproveStatus AS ListStatus FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		if($StatusTo=='Approve'){
			$InExpireDtae = date('Y-m-d H:i:s', strtotime('+'.$YearExpire.' year'));
			$update[_TABLE_RESTAURANT_."_Approved_date"] = "NOW()";
			$update[_TABLE_RESTAURANT_."_Reject_date"] = "'0000-00-00 00:00:00'";
			$update[_TABLE_RESTAURANT_."_Expire_date"] = "'".$InExpireDtae."'";
		}else if($StatusTo=='Reject'){
			$update[_TABLE_RESTAURANT_."_Approved_date"] = "'0000-00-00 00:00:00'";
			$update[_TABLE_RESTAURANT_."_Reject_date"] = "NOW()";
			$update[_TABLE_RESTAURANT_."_Expire_date"] = "'0000-00-00 00:00:00'";
		}else{
			$update[_TABLE_RESTAURANT_."_Approved_date"] = "'0000-00-00 00:00:00'";
			$update[_TABLE_RESTAURANT_."_Reject_date"] = "'0000-00-00 00:00:00'";
			$update[_TABLE_RESTAURANT_."_Expire_date"] = "'0000-00-00 00:00:00'";
		}
		$update[_TABLE_RESTAURANT_."_ApproveStatus"] = "'".$StatusTo."'";
		$update[_TABLE_RESTAURANT_."_InStatus"] = "'".$enumStatus[$StatusTo]."'";
		$z = new __webctrl;
		$z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => $itemid));
		unset($update);

		// logs
		$IP = get_real_ip();
		$ua = @getBrowser();
		$browser = $ua['name']." ".$ua['version'];
		$platform = $ua['platform'];
		$userAgent = $ua['userAgent'];
		$insert = array();
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_Status"] = "'".sql_safe($StatusTo)."'";
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_ContentID"] = sql_safe($itemid,false,true);
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_CreateDate"] = "NOW()";
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_IP"] = "'".sql_safe($IP)."'";
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_Browser"] = "'".sql_safe($browser)."'";
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_Platform"] = "'".sql_safe($platform)."'";
		$insert[_TABLE_RESTAURANT_STATUSLOGS_."_userAgent"] = "'".sql_safe($userAgent)."'";
		$z->insert(_TABLE_RESTAURANT_STATUSLOGS_,$insert);
	  unset($insert);
		// end logs
		$output = array(
			"status" => "OK",
		  "statusto" => strtolower($StatusTo),
			"ClassStatusFrom" => $ClassStatusFrom,
			"ClassStatusTo" => $ClassStatusTo,
			"StatusText" => $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo]
		);
		CloseDB();
		header('Content-Type: application/json');
		echo json_encode($output);
		exit();
		// echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo];
	break;case 'changethisdialogstatus':
    $itemid = $itemid;
    $StatusTo = $status;
    $Myremark = (!empty($_POST["myremark"])?encodetxterea($_POST["myremark"]):'');
    if(!empty($Login_MenuID)){
      $indexLogin_MenuID = substr($Login_MenuID,5);
      $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    }else{
      $mymenuinclude = "";
    }
    include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $sql = "SELECT "._TABLE_RESTAURANT_."_ID AS ID,"._TABLE_RESTAURANT_."_ApproveStatus AS ListStatus FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
    $ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];
    if($StatusTo=='Approve'){
      $InExpireDtae = date('Y-m-d H:i:s', strtotime('+'.$YearExpire.' year'));
      $update[_TABLE_RESTAURANT_."_Approved_date"] = "NOW()";
      $update[_TABLE_RESTAURANT_."_Reject_date"] = "'0000-00-00 00:00:00'";
      $update[_TABLE_RESTAURANT_."_Expire_date"] = "'".$InExpireDtae."'";
    }else if($StatusTo=='Reject'){
      $update[_TABLE_RESTAURANT_."_Approved_date"] = "'0000-00-00 00:00:00'";
      $update[_TABLE_RESTAURANT_."_Reject_date"] = "NOW()";
      $update[_TABLE_RESTAURANT_."_Expire_date"] = "'0000-00-00 00:00:00'";
    }else{
      $update[_TABLE_RESTAURANT_."_Approved_date"] = "'0000-00-00 00:00:00'";
      $update[_TABLE_RESTAURANT_."_Reject_date"] = "'0000-00-00 00:00:00'";
      $update[_TABLE_RESTAURANT_."_Expire_date"] = "'0000-00-00 00:00:00'";
    }
    $update[_TABLE_RESTAURANT_."_ApproveStatus"] = "'".$StatusTo."'";
    $update[_TABLE_RESTAURANT_."_InStatus"] = "'".$enumStatus[$StatusTo]."'";
    $z = new __webctrl;
    $z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => $itemid));
    unset($update);

    // logs
    $IP = get_real_ip();
    $ua = @getBrowser();
    $browser = $ua['name']." ".$ua['version'];
    $platform = $ua['platform'];
    $userAgent = $ua['userAgent'];
    $insert = array();
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Status"] = "'".sql_safe($StatusTo)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_ContentID"] = sql_safe($itemid,false,true);
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_CreateDate"] = "NOW()";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Remark"] = "'".sql_safe($Myremark)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_IP"] = "'".sql_safe($IP)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Browser"] = "'".sql_safe($browser)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Platform"] = "'".sql_safe($platform)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_userAgent"] = "'".sql_safe($userAgent)."'";
    $z->insert(_TABLE_RESTAURANT_STATUSLOGS_,$insert);
    unset($insert);
    // end logs
    $output = array(
      "status" => "OK",
      "statusto" => strtolower($StatusTo),
      "ClassStatusFrom" => $ClassStatusFrom,
      "ClassStatusTo" => $ClassStatusTo,
      "StatusText" => $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo]
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
    exit();
	break;case 'delete':
		$itemid = $itemid;
		if(!empty($Login_MenuID)){
		  $indexLogin_MenuID = substr($Login_MenuID,5);
		  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
		}else{
		  $mymenuinclude = "";
		}
		include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
		$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
		$sql = "SELECT "._TABLE_RESTAURANT_."_PictureFile AS thumb FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
	  $z = new __webctrl;
	  $z->sql($sql);
	  $v = $z->row();
	  $row = $v[0];
	  $ThumbnailPictureName = $row["thumb"];
		$unlinkfile = $PathUploadPicture.$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
    $unlinkfile = $PathUploadPicture."crop-".$ThumbnailPictureName;
    if(is_file($unlinkfile)){unlink($unlinkfile);}
		$z = new __webctrl;
		$z->del(_TABLE_RESTAURANT_,array(_TABLE_RESTAURANT_."_ID=" => (int)$itemid));
		echo "OK";
	break; default:
}
CloseDB();
?>
