<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
//$Login_MenuID;
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
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
// echo '<pre>';
// print_r($dataArrGroup);
// echo '</pre>';

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
$sql = "";
$arrfmain = array();
$arrfmain[] = "TBmain.*";
$arrfmain[] = "TBJoinGroup.JoinName AS GroupName";
$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_WEBLINK_.'_ID AS ID';
	$arrf[] = "a."._TABLE_WEBLINK_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_WEBLINK_.'_Order AS ListOrder';
	$arrf[] = "a."._TABLE_WEBLINK_.'_Start AS StartDate';
	$arrf[] = "a."._TABLE_WEBLINK_.'_End AS EndDate';
  $arrf[] = "a."._TABLE_WEBLINK_.'_GroupID AS GroupID';
	$arrf[] = "a."._TABLE_WEBLINK_.'_GroupBanner AS GroupBanner';
  $arrf[] = "IF(TBJoinView.CountRefView IS NULL or TBJoinView.CountRefView = '', 0, TBJoinView.CountRefView) as CountRefView";
  $arrf[] = $langkey."."._TABLE_WEBLINK_DETAIL_."_ID AS SubjectID".$langkey;
  $arrf[] = $langkey."."._TABLE_WEBLINK_DETAIL_."_Subject AS Subject".$langkey;
  $arrf[] = $langkey."."._TABLE_WEBLINK_DETAIL_."_Status AS Status".$langkey;
  $arrf[] = $langkey."."._TABLE_WEBLINK_DETAIL_."_PictureFile AS PictureFile".$langkey;
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_WEBLINK_." a";
  $sql .= " LEFT JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_WEBLINK_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_WEBLINK_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_WEBLINK_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_WEBLINK_DETAIL_."_PictureFile";
    $arrjoinlang[] = _TABLE_WEBLINK_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_WEBLINK_DETAIL_;
    $sql .= " WHERE "._TABLE_WEBLINK_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_WEBLINK_."_ID = ".$langkey."."._TABLE_WEBLINK_DETAIL_."_ContentID)";
  $sql .= " LEFT JOIN (";
    $sql .= "SELECT * FROM ";
    $sql .= "(";
      $arrinnercount = array();
      $arrinnercount[] = "COUNT(*) AS CountRefView";
      $arrinnercount[] = _TABLE_WEBLINK_LOGS_."_BannerID AS JoinContentID";
      $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_WEBLINK_LOGS_." WHERE 1 GROUP BY "._TABLE_WEBLINK_LOGS_."_BannerID";
      unset($arrinnercount);
    $sql .= ") TBCount";
  $sql .= ") TBJoinView ON (a."._TABLE_WEBLINK_."_ID = TBJoinView.JoinContentID)";
  $sql .= " WHERE a."._TABLE_WEBLINK_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
  $sql .= "SELECT "._TABLE_WEBLINK_GROUP_."_ID AS JoinContentID,"._TABLE_WEBLINK_GROUP_."_Name AS JoinName FROM "._TABLE_WEBLINK_GROUP_;
  $sql .= " WHERE 1";
$sql .= ") TBJoinGroup ON (TBmain.GroupID = TBJoinGroup.JoinContentID)";
$sql .= " WHERE 1";
if(!empty($dataGroup)){
  $sql .= " AND TBmain.GroupBanner = '".$dataGroup."'";
}
if(!empty($dataKeyword)){
  $arrkeyword = explode(" ",$dataKeyword);
  if(count($arrkeyword)>0){
    $sql .= " AND ";
    $sql .= "(";
    foreach($arrkeyword as $TKey=>$TVal){
      if($TKey>0){
        $sql .= " OR ";
      }
      $sql .= "(";
				$sql .= "TBmain.Subject".$_SESSION['Session_Admin_Language']." LIKE '%".$TVal."%'";
        $sql .= " OR TBJoinGroup.JoinName LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " GROUP BY TBmain.ID";
$sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
unset($arrfmain);
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
		// $Fullname = $Row["Subject".$_SESSION['Session_Admin_Language']];
    $LangStatus = $Row["Status".$_SESSION['Session_Admin_Language']];
    if($LangStatus=='On'){
      $Fullname = $Row["Subject".$_SESSION['Session_Admin_Language']];
    }else{
      $Fullname = (!empty($Row["SubjectEnglish"])?$Row["SubjectEnglish"]:'');
    }
		// $InGroup = $Row["GroupBanner"];
    // $query = "Key='".$InGroup."'";
    // $mydata = @ArraySearch($dataArrGroup,$query,1);
    // $GroupBanner = $dataArrGroup[array_key_first($mydata)]["Name"];
    $GroupBanner = $Row["GroupName"];

    $CountLogs = $Row["CountRefView"];
		$startDate = $Row['StartDate'];
		$endDate = $Row['EndDate'];
		$Dateshow = @dateformat($startDate,'j F Y')." - ".@dateformat($endDate,'j F Y');
		$PictureFile = $Row["PictureFile".$_SESSION['Session_Admin_Language']];
		$myExtensionArray = explode(".",$PictureFile);
		$myExtension = strtolower($myExtensionArray[sizeof($myExtensionArray)-1]);
		if(strtolower($myExtension)=='gif'){
			$Picture = $PathUploadPicture.$PictureFile;
			if(is_file($Picture)){
				$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
				$showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Fullname.'" />';
			}else{
				$showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
			}
		}else{
			$Picture = $PathUploadPicture."crop-".$PictureFile;
      $Picture = $PathUploadPicture.$PictureFile;
			$Picturexxwebp = $PathUploadPicture."crop-".$PictureFile;
			if(is_file($Picture)){
				$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
				$showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Fullname.'" />';
			}else{
				$showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
			}
		}

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
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

				  //$listmnubtn .='<a rev="'.$skey.'" rel="'.$ID.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';

				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueGroupBanner"] = $GroupBanner;
		$arr["valueSubject"] = $Fullname;
		$arr["valueDateshow"] = $Dateshow;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valuePicture"] = $showPicture;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["CountLogs"] = number_format($CountLogs);
		$found[] = $arr;
	}
}
$nextpage = $selectPage+1;
$backpage = $selectPage-1;
$rpagestart = $selectPage-2;
$rpagestart = ($rpagestart>=1?$rpagestart:1);
$rpageend = $rpagestart+4;
$rpageend = ($rpageend<=$NoOfPage?$rpageend:$NoOfPage);

$output = array(
	"status" => "ok",
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
