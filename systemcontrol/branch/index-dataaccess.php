<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
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
switch($actiontype){
	case 'changethisstatus':
		$itemid = $itemid;
		$StatusTo = $status;

		$sql = "SELECT "._TABLE_RESTAURANT_."_Key AS myKey,"._TABLE_RESTAURANT_."_ID AS ID,"._TABLE_RESTAURANT_."_Status AS ListStatus FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
    $myKey = $Row["myKey"];

		$ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
		$ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

		$update = array();
		$update[_TABLE_RESTAURANT_."_Status"] = "'".$StatusTo."'";
		$update[_TABLE_RESTAURANT_."_LastUpdate"] = "NOW()";
		$update[_TABLE_RESTAURANT_."_UpdateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$z = new __webctrl;
		$z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => $itemid));
		unset($update);
    $output = array(
			"status" => "OK",
		  "statusto" => strtolower($StatusTo),
			"ClassStatusFrom" => $ClassStatusFrom,
			"ClassStatusTo" => $ClassStatusTo,
			"StatusText" => $arrinStatus[$_SESSION['Session_Admin_Language']][$StatusTo]
		);
		CloseDB();
		header('Content-Type: application/json');
		echo json_encode($output);
		exit();
    //
		// echo "OK:".strtolower($StatusTo).":".$ClassStatusFrom.":".$ClassStatusTo.":".$arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo];
  break;case 'changethisapprovestatus':
    $itemid = $itemid;
    $StatusTo = $status;
    if(!empty($Login_MenuID)){
      $indexLogin_MenuID = substr($Login_MenuID,5);
      $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    }else{
      $mymenuinclude = "";
    }
    include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $YearExpire = $arrINTERVAL["RestaurantExpire"];
    $sql = "SELECT "._TABLE_RESTAURANT_."_ID AS ID,"._TABLE_RESTAURANT_."_ApproveStatus AS ListStatus FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
    $ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

    if($StatusTo=='Approve'){
      $InExpireDtae = date('Y-m-d H:i:s', strtotime('+'.$YearExpire));
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
    $YearExpire = $arrINTERVAL["RestaurantExpire"];
    $sql = "SELECT "._TABLE_RESTAURANT_."_ID AS ID,"._TABLE_RESTAURANT_."_ApproveStatus AS ListStatus FROM "._TABLE_RESTAURANT_." WHERE "._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
    $ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];
    if($StatusTo=='Approve'){
      $InExpireDtae = date('Y-m-d H:i:s', strtotime('+'.$YearExpire));
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
  break;case 'changethisrenew':
    // echo $itemid;
    if(!empty($Login_MenuID)){
      $indexLogin_MenuID = substr($Login_MenuID,5);
      $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
    }else{
      $mymenuinclude = "";
    }
    include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
    $YearExpire = $arrINTERVAL["RestaurantExpire"];
    $langkey = $_SESSION['Session_Admin_Language'];
    $sql = "";
    $ArrField = array();
    $ArrField[] = "TBmain.ID";
    $ArrField[] = "TBmain.ListStatus";
    $ArrField[] = "TBmain.ListOrder";
    $ArrField[] = "TBmain.ListCountView";
    $ArrField[] = "TBmain.StartDate";
    $ArrField[] = "TBmain.EndDate";
    $ArrField[] = "TBmain.ResType";
    $ArrField[] = "TBmain.Picture";
    $ArrField[] = "TBmain.FilAddIndex";
    $ArrField[] = "TBmain.CreateDate";
    $ArrField[] = "TBmain.LastUpdate";
    $ArrField[] = "TBmain.Name";
    $ArrField[] = "TBmain._Branch";
    $ArrField[] = "TBmain.FullMemberName";
    $ArrField[] = "TBmain.SubjectID";
    $ArrField[] = "TBmain.Subject";
    $ArrField[] = "TBmain.StatusLang";
    $ArrField[] = "TBmain._ApproveStatus";
    $ArrField[] = "TBmain._Approved_date";
    $ArrField[] = "TBmain._Reject_date";
    $ArrField[] = "TBmain._Expire_date";
    $ArrField[] = "TBmain.RealLastDay";
    $ArrField[] = "IF(DATEDIFF(TBmain.RealLastDay, CURDATE())<180, 'Y', 'N') as ChkStatusRetirement";
    $sql .= "SELECT ".implode(',',$ArrField)." FROM ";
    $sql .= "("	;
    	$arrf = array();
    	$arrf[] = "a."._TABLE_RESTAURANT_."_ID AS ID";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_MemberID AS MemberID";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_Name AS Name";
      $arrf[] = "a."._TABLE_RESTAURANT_."_Type AS ResType";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_Status AS ListStatus";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_Order AS ListOrder";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_Start AS StartDate";
    	$arrf[] = "a."._TABLE_RESTAURANT_."_End AS EndDate";
      $arrf[] = "a."._TABLE_RESTAURANT_."_View AS ListCountView";
      $arrf[] = "a."._TABLE_RESTAURANT_."_CreateDate AS CreateDate";
      $arrf[] = "a."._TABLE_RESTAURANT_."_LastUpdate AS LastUpdate";
      $arrf[] = "a."._TABLE_RESTAURANT_."_Branch AS _Branch";
      $arrf[] = "a."._TABLE_RESTAURANT_."_ApproveStatus AS _ApproveStatus";
      $arrf[] = "a."._TABLE_RESTAURANT_."_Approved_date AS _Approved_date";
      $arrf[] = "a."._TABLE_RESTAURANT_."_Reject_date AS _Reject_date";
      $arrf[] = "a."._TABLE_RESTAURANT_."_Expire_date AS _Expire_date";
      $arrf[] = "TBFile.FileName AS Picture";
      $arrf[] = "TBFile.FilAddIndex AS FilAddIndex";
      $arrf[] = "IF(TBMember.FullName IS NULL or TBMember.FullName = '', '-', TBMember.FullName) as FullMemberName";
      $arrf[] = "IF(".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ID IS NULL or ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ID = '', '0', ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ID) as SubjectID";
      $arrf[] = "IF(".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Subject IS NULL or ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Subject = '', '0', ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Subject) as Subject";
      $arrf[] = "IF(".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Status IS NULL or ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Status = '', '0', ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_Status) as StatusLang";
      $arrf[] = "IF(DATE(a."._TABLE_RESTAURANT_."_Approved_date)='0000-00-00',LAST_DAY( DATE_ADD( a."._TABLE_RESTAURANT_."_CreateDate, INTERVAL ".$YearExpire." )),a."._TABLE_RESTAURANT_."_Expire_date) AS RealLastDay";
    	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_RESTAURANT_." a";
      $sql .= " LEFT JOIN (";
        $arrjoinlang = array();
        $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ID";
        $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ContentID";
        $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Subject";
        $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Status";
        $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_RESTAURANT_DETAIL_;
        $sql .= " WHERE "._TABLE_RESTAURANT_DETAIL_."_Lang = '".$langkey."'";
        unset($arrjoinlang);
      $sql .= ") ".$langkey." ON (a."._TABLE_RESTAURANT_."_ID = ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ContentID)";
      $sql .= " LEFT JOIN (";
        $sql .= " SELECT "._TABLE_RESTAURANT_FILE_."_ContentID AS ResID,"._TABLE_RESTAURANT_FILE_."_FileName AS FileName,"._TABLE_RESTAURANT_FILE_."_AddIndex AS FilAddIndex FROM "._TABLE_RESTAURANT_FILE_;
        $sql .= " WHERE "._TABLE_RESTAURANT_FILE_."_Flag = 'restaurant_image'";
        $sql .= " AND "._TABLE_RESTAURANT_FILE_."_ID IN (SELECT MIN("._TABLE_RESTAURANT_FILE_."_ID) FROM "._TABLE_RESTAURANT_FILE_." WHERE  "._TABLE_RESTAURANT_FILE_."_Flag = 'restaurant_image' GROUP BY "._TABLE_RESTAURANT_FILE_."_ContentID)";
      $sql .= ") TBFile ON (a."._TABLE_RESTAURANT_."_ID = TBFile.ResID)";
      $sql .= " LEFT JOIN (";
        $arrfuser = array();
      	$arrfuser[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
        $arrfuser[] = "a."._TABLE_MEMBER_."_Name AS FullName";
        $arrfuser[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
      	$sql .= "SELECT  ".implode(',',$arrfuser)." FROM "._TABLE_MEMBER_." a";
        $sql .= " WHERE a."._TABLE_MEMBER_."_MemberType = 'Restaurant'";
        unset($arrfuser);
      $sql .= ") TBMember ON (a."._TABLE_RESTAURANT_."_MemberID = TBMember.MemberID)";
      $sql .= " WHERE a."._TABLE_RESTAURANT_."_ID = ".intval($itemid);
    	unset($arrf);
    $sql .= ") TBmain";
    $sql .= " WHERE 1";
    unset($ArrField);
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];
    $RealLastDay = $Row["RealLastDay"];
    $InStartDtae = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($RealLastDay)));
    $InExpireDtae = date('Y-m-d H:i:s', strtotime('+'.$YearExpire, strtotime($InStartDtae)));
    $StatusTo = 'Approve';
    $update = array();
    $update[_TABLE_RESTAURANT_."_Approved_date"] = "'".$InStartDtae."'";
    $update[_TABLE_RESTAURANT_."_Reject_date"] = "'0000-00-00 00:00:00'";
    $update[_TABLE_RESTAURANT_."_Expire_date"] = "'".$InExpireDtae."'";
    $update[_TABLE_RESTAURANT_."_ApproveStatus"] = "'".$StatusTo."'";
    $update[_TABLE_RESTAURANT_."_InStatus"] = "'".$enumStatus[$StatusTo]."'";
    $z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => $itemid));
    unset($update);
    // logs
    $Myremark = "Re New Data";
    $IP = get_real_ip();
    $ua = @getBrowser();
    $browser = $ua['name']." ".$ua['version'];
    $platform = $ua['platform'];
    $userAgent = $ua['userAgent'];
    $insert = array();
    // $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Status"] = "'".sql_safe($StatusTo)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Status"] = "'ReNew'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_ContentID"] = sql_safe($itemid,false,true);
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_CreateDate"] = "NOW()";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_Remark"] = "'".sql_safe($Myremark)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_StartDate"] = "'".sql_safe($InStartDtae)."'";
    $insert[_TABLE_RESTAURANT_STATUSLOGS_."_ExpireDate"] = "'".sql_safe($InExpireDtae)."'";
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
      "StatusText" => $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$StatusTo]
    );
    CloseDB();
    header('Content-Type: application/json');
    echo json_encode($output);
    exit();
    //
    // echo $RealLastDay;
    // echo "<br>";
    // echo $InStartDtae;
    // echo "<br>";
    // echo $InExpireDtae;
	break;case 'delete':
		$itemid = $itemid;
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

		$z = new __webctrl;
		$z->del(_TABLE_RESTAURANT_,array(_TABLE_RESTAURANT_."_ID=" => (int)$itemid));
		$z->del(_TABLE_RESTAURANT_DETAIL_,array(_TABLE_RESTAURANT_DETAIL_."_ContentID=" => (int)$itemid));
    $z->del(_TABLE_RESTAURANT_FILE_,array(_TABLE_RESTAURANT_FILE_."_ContentID=" => (int)$itemid));
    $z->del(_TABLE_RESTAURANT_WORK_,array(_TABLE_RESTAURANT_WORK_."_ContentID=" => (int)$itemid));
		echo "OK";
	break;case 'sort':
		$myorder = $_POST['tsort'];
		$ArrOrder = explode('|x|',$myorder);
		$counArr = count($ArrOrder);
		if($counArr>0){
			for($i=1;$i<$counArr;$i++){
				$value = str_replace("s","",$ArrOrder[$i]);
				if($value <> 'null'){
					$j = $counArr-$i;
					$update[_TABLE_RESTAURANT_."_Order"] = sql_safe($j,false,true);
					$z = new __webctrl;
					$z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => (int)$value));
					unset($update);
				}
			}
		}
	 echo "OK";
  break;case 'changethisratingstatus':
    $itemid = $itemid;
    $StatusTo = $status;

    $sql = "SELECT "._TABLE_RESTAURANT_RATING_."_ID AS ID,"._TABLE_RESTAURANT_RATING_."_StatusComment AS ListStatus FROM "._TABLE_RESTAURANT_RATING_." WHERE "._TABLE_RESTAURANT_RATING_."_ID = ".(int)$itemid;
    $z = new __webctrl;
    $z->sql($sql);
    $v = $z->row();
    $Row = $v[0];

    $ClassStatusFrom = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$Row["ListStatus"]];
    $ClassStatusTo = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$StatusTo];

    $update = array();
		$update[_TABLE_RESTAURANT_RATING_."_StatusComment"] = "'".$StatusTo."'";
		$z->update(_TABLE_RESTAURANT_RATING_,$update,array(_TABLE_RESTAURANT_RATING_."_ID=" => $itemid));
		unset($update);
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
	break; default:
}
CloseDB();
?>
