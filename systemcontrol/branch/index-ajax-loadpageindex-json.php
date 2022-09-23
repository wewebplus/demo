<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../assets/lib/inc.config.php");
include("../home/inc-header-db.php");
// include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
// include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
//include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):'');
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
//$Login_MenuID;
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$PageSearch = "";
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
// $listMoDuleKey = $Login_MenuID.(!empty($dataModuleKey)?'':'');
$ThumPreFix = $defaultdata[$Login_MenuID]["thumb"]["P"];
$dataArrDay = $defaultdata[$Login_MenuID]["day"];

if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}

if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}

$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;

if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}

$found = array();
if($loadtype=='footable'){
	$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
	$PageSize = (empty($selectPerPage)?_DEFAULT_PAGESIZE_:$selectPerPage);
	$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
}else{
	$PageShow = (empty($selectPage)?_DEFAULT_PAGESHOW_:$selectPage);
	$PageSize = (empty($selectPerPage)?20:$selectPerPage);
	$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
}
$langkey = $_SESSION['Session_Admin_Language'];
// _TABLE_RESTAURANT_GROUP_
// _TABLE_RESTAURANT_WTIME_
// _TABLE_ADMIN_WDAY_
// print_r($dataArrGroup);
// print_r($dataArrDay);
$YearExpire = $arrINTERVAL["RestaurantExpire"];

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
  $arrf[] = "IF(DATE(a."._TABLE_RESTAURANT_."_Approved_date)='0000-00-00',LAST_DAY( DATE_ADD( a."._TABLE_RESTAURANT_."_CreateDate, INTERVAL ".$YearExpire.")),a."._TABLE_RESTAURANT_."_Expire_date) AS RealLastDay";
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
  $sql .= " WHERE a."._TABLE_RESTAURANT_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if(!empty($dataGroup)){
  $sql .= " AND TBmain.ResType = '".$dataGroup."'";
}
if(!empty($dataKeyword)){
  $arrkeyword = explode(" ",$dataKeyword);
  if(count($arrkeyword)>0){
    $sql .= " AND ";
    $sql .= "(";
    $ikeyword = 0;
    foreach($arrkeyword as $TKey=>$TVal){
      if(trim($TVal)!=''){
        $ikeyword++;
        if($ikeyword>1){
          $sql .= " AND ";
        }
        $sql .= "(";
  				$sql .= "TBmain.Name LIKE '%".$TVal."%'";
          $sql .= " OR TBmain._Branch LIKE '%".$TVal."%'";
          $sql .= " OR TBmain.FullMemberName LIKE '%".$TVal."%'";
        $sql .= ")";
      }
    }
    $sql .= ")";
  }
}
// $sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
$sql .= " ORDER BY TBmain.LastUpdate ".$ASCDESC." ,TBmain.ID DESC";
unset($ArrField);
// echo $sql;
// exit();
// echo $PathUploadPicture;
$z = new __webctrl;
$z->sql($sql,$PageSize,$PageShow);
$RecordCount = $z->num();
$RecordCountInpage = $z->numinpage();
$v = $z->row();
$NoOfPage = $z->totalpage();
$RecordStart = ($PageSize*($PageShow-1));
$index = 0;
if($RecordCount>0) {
	foreach($v as $Row){
		$index++;
    $ListIndex = $RecordCount-($RecordStart+($index-1));
		$ID = $Row["ID"];
    $LastUpdate = $Row["LastUpdate"];
		$CreateDate = $Row['CreateDate'];
		$Dateshow = @dateformat($LastUpdate,'j M Y');
    $CreateDateshow = @dateformat($CreateDate,'j M Y');
    $ListView = $Row["ListCountView"];
    $ListPin = $Row["ListPin"];
    $ResType = $Row["ResType"];
    $_Branch = $Row["_Branch"];
    $FullMemberName = $Row["FullMemberName"];
    $FilAddIndex = $Row["FilAddIndex"];
    $showPicture = "";
    if($FilAddIndex=="Old"){
      $Picture = $PathUploadPicture.$Row["Picture"];
    }else{
      $Picture = $PathUploadPicture.$ID."/".$Row["Picture"];
    }
    // echo $Picture;
		if(is_file($Picture)){
			$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
			$showPicture = '<img src="'.$showPicture.'" class="" alt="'.$Row["PictureAlt"].'" />';
		}else{
			$showPicture = '<img src="../assets/img/avatars/8.jpg" class="" alt="" />';
		}
    $LangStatus = $Row["Status".$_SESSION['Session_Admin_Language']];
    $Fullname = $Row["Name"];

    $_ApproveStatus = $Row["_ApproveStatus"];
    $_Approved_date = $Row["_Approved_date"];
    $_Reject_date = $Row["_Reject_date"];
    $_Expire_date = $Row["_Expire_date"];
    $Show_Approved_date = @dateformat($_Approved_date,'j M Y');
    $Show_Reject_date = @dateformat($_Reject_date,'j M Y');
    $Show_Expire_date = @dateformat($_Expire_date,'j M Y');
    $RealLastDay = $Row["RealLastDay"];
    $ChkStatusRetirement = $Row["ChkStatusRetirement"];

    $ShowOthInfo = "";
    switch($_ApproveStatus){
      case 'New':
        $ShowOthInfo .= '<div class="ShowOthInfo">';
          $ShowOthInfo .= '<div>CreateDate : '.$CreateDateshow.'</div>';
        $ShowOthInfo .= '</div>';
      break;case 'WaitApprove':
        $ShowOthInfo .= '<div class="ShowOthInfo">';
          $ShowOthInfo .= '<div>CreateDate : '.$CreateDateshow.'</div>';
        $ShowOthInfo .= '</div>';
      break;case 'Approve':
        $ShowOthInfo .= '<div class="ShowOthInfo">';
          $ShowOthInfo .= '<div>CreateDate : '.$CreateDateshow.'</div>';
          $ShowOthInfo .= '<div>ApprovedDate : '.$Show_Approved_date.'</div>';
          $ShowOthInfo .= '<div>ExpireDate : '.$Show_Expire_date.'</div>';
        $ShowOthInfo .= '</div>';
      break;case 'Reject':
        $ShowOthInfo .= '<div class="ShowOthInfo">';
          $ShowOthInfo .= '<div>CreateDate : '.$CreateDateshow.'</div>';
          $ShowOthInfo .= '<div>RejectDate : '.$Show_Reject_date.'</div>';
          // $ShowOthInfo .= '<div>ExpireDate : '.$Show_Expire_date.'</div>';
        $ShowOthInfo .= '</div>';
      break; default:
    }
    $approvestatuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$_ApproveStatus];
    $listapprovebtn = "";
    $listapprovebtn .='<ul class="dropdown-menu" role="menu">';
    if($pmaalllist){
      foreach($arrinStatusRestaurant[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
        if($skey=='Reject'){
          $listapprovebtn .='<li '.($_ApproveStatus==$skey?'class="active"':'').'>';
            $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisdialogstatus');
            $listapprovebtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeDialogStatus(this);">'.$sval.'</a>';
          $listapprovebtn .='</li>';
        }else{
          $listapprovebtn .='<li '.($_ApproveStatus==$skey?'class="active"':'').'>';
            $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisapprovestatus');
            $listapprovebtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeApproveStatus(this);">'.$sval.'</a>';
          $listapprovebtn .='</li>';
        }
      }
    }
    $listapprovebtn .='</ul>';

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      if($pmaalllist){
        // $listmnubtn .='<li>';
  			// 	$datagallery = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=gallery');
  			//   $listmnubtn .='<a rev="'.$datagallery.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Gallery</a>';
  			// $listmnubtn .='</li>';
        // $listmnubtn .='<li>';
  			// 	$datafileatt = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=fileatt');
  			//   $listmnubtn .='<a rev="'.$datafileatt.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">File Attached</a>';
  			// $listmnubtn .='</li>';
        $listmnubtn .='<li>';
  				$datahistory = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=history');
  			  $listmnubtn .='<a rev="'.$datahistory.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">History</a>';
  			$listmnubtn .='</li>';
        $listmnubtn .='<li>';
  				$datarating = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=rating');
  			  $listmnubtn .='<a rev="'.$datarating.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Rating</a>';
  			$listmnubtn .='</li>';
  			$listmnubtn .='<li>';
  				$dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
  			  $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
  			$listmnubtn .='</li>';
  			$listmnubtn .='<li>';
  				$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
  			  $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
  			$listmnubtn .='</li>';
  			$listmnubtn .='<li class="divider"></li>';
  			foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
  				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
  				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
  				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
  				$listmnubtn .='</li>';
  			}
      }
		$listmnubtn .='</ul>';
    if($ChkStatusRetirement=='Y'){
      $btnReNew = true;
      $btnDataReNew = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status=Renew&actiontype=changethisrenew');
    }else{
      $btnReNew = false;
      $btnDataReNew = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status=Renew&actiontype=changethisrenew');
    }

    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueGroupname"] = $FullGroupname;
		$arr["valueSubject"] = $Fullname;
		$arr["valueDateshow"] = $Dateshow;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valuePicture"] = $showPicture;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["ListView"] = $ListView;
    $arr["valueResType"] = $ResType;
    $arr["valueBranch"] = $_Branch;
    $arr["valueMemberName"] = $FullMemberName;
    $arr["ShowOthInfo"] = $ShowOthInfo;
    $arr["valueApproveBtn"] = $listapprovebtn;
		$arr["valueApproveStatus"] = strtolower($_ApproveStatus);
    $arr["valueApproveStatusCss"] = strtolower($approvestatuscss);
		$arr["valueApproveStatustxt"] = $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$_ApproveStatus];
    $arr["btnReNew"] = $btnReNew;
    $arr["btnDataReNew"] = $btnDataReNew;
    $arr["RealLastDay"] = $RealLastDay;
		$found[] = $arr;
	}
}
$nextpage = $selectPage+1;
$backpage = $selectPage-1;
$rpagestart = $selectPage-2;
$rpagestart = ($rpagestart>=1?$rpagestart:1);
$rpageend = $rpagestart+4;
$rpageend = ($rpageend<=$NoOfPage?$rpageend:$NoOfPage);

$foundgroup = $defaultdata[$Login_MenuID]["group"];
$foundgroupcount = count($defaultdata[$Login_MenuID]["group"]);
$output = array(
	"status" => "ok",
  "dataModuleKey" => $dataModuleKey,
	"resultgroup" => $foundgroup,
  "foundgroupcount" => $foundgroupcount,
  "pmaalllist" => $pmaalllist,
	"totalreccount" => number_format($RecordCount),
	"reccount" => (int)$RecordCount,
	"reccountinpage" => $RecordCountInpage,
	"pagesize" => $PageSize,
	"noofpage" => $NoOfPage,
	"spstart" => $rpagestart,
	"spend" => $rpageend,
	"nextpage" => intval($nextpage<=$NoOfPage?$nextpage:$selectPage),
	"backpage" => intval($backpage>0?$backpage:$selectPage),
	"result" => $found
);
CloseDB();
header('Content-Type: application/json');
echo json_encode($output);
exit();
?>
