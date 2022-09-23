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
$ArrField = array();
$ArrField[] = "TBmain.ID";
$ArrField[] = "TBmain.GroupID";
$ArrField[] = "TBmain.ListStatus";
$ArrField[] = "TBmain.Picture";
$ArrField[] = "TBmain.PictureAlt";
$ArrField[] = "TBmain.ListOrder";
$ArrField[] = "TBmain.ListCountView";
$ArrField[] = "TBmain.ListCountComment";
$ArrField[] = "TBmain.StartDate";
$ArrField[] = "TBmain.EndDate";
$ArrField[] = "TBmain.StatusHome";
$ArrField[] = "TBmain.ListRating";
$ArrField[] = "TBmain.ListComment";
$ArrField[] = "TBmain.ListPin";
$ArrField[] = "TBmain.ListPublic";
$ArrField[] = "IF(TBmain.SubjectID".$langkey." IS NULL or TBmain.SubjectID".$langkey." = '', '0', TBmain.SubjectID".$langkey.") as SubjectID";
$ArrField[] = "IF(TBmain.Subject".$langkey." IS NULL or TBmain.Subject".$langkey." = '', '-', TBmain.Subject".$langkey.") as Subject";
$ArrField[] = "IF(TBmain.Status".$langkey." IS NULL or TBmain.Status".$langkey." = '', '-', TBmain.Status".$langkey.") as StatusLang";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_INGREDIENTS_."_ID AS ID";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_GID AS GroupID";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_Status AS ListStatus";
	// $arrf[] = "a."._TABLE_INGREDIENTS_."_Picture AS Picture";
  $arrf[] = "IF("._TABLE_INGREDIENTS_."_Picture IS NULL or "._TABLE_INGREDIENTS_."_Picture = '', "._TABLE_INGREDIENTS_."_Picture02, "._TABLE_INGREDIENTS_."_Picture) AS Picture";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_PictureAlt AS PictureAlt";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_Order AS ListOrder";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_Start AS StartDate";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_End AS EndDate";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_StatusHome AS StatusHome";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_StatusRating AS ListRating";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_StatusComment AS ListComment";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_Pin AS ListPin";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_Public AS ListPublic";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_View AS ListCountView";
  $arrf[] = "a."._TABLE_INGREDIENTS_."_Comment AS ListCountComment";
  $arrf[] = $langkey."."._TABLE_INGREDIENTS_DETAIL_."_ID AS SubjectID".$langkey;
	$arrf[] = $langkey."."._TABLE_INGREDIENTS_DETAIL_."_Subject AS Subject".$langkey;
	$arrf[] = $langkey."."._TABLE_INGREDIENTS_DETAIL_."_Status AS Status".$langkey;
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_INGREDIENTS_." a";
  $sql .= " INNER JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_INGREDIENTS_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_INGREDIENTS_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_INGREDIENTS_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_INGREDIENTS_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_INGREDIENTS_DETAIL_;
    $sql .= " WHERE "._TABLE_INGREDIENTS_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_INGREDIENTS_."_ID = ".$langkey."."._TABLE_INGREDIENTS_DETAIL_."_ContentID)";
  $sql .= " WHERE a."._TABLE_INGREDIENTS_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if(!empty($dataGroup)){
  $sql .= " AND TBmain.GroupID = '".$dataGroup."'";
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
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
unset($ArrField);
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
    $GID = $Row["GroupID"];
		$startDate = $Row['StartDate']." 00:00:00";
		$endDate = $Row['EndDate']." 00:00:00";
		$Dateshow = @dateformat($startDate,'j M Y')." - ".@dateformat($endDate,'j M Y');
    $StatusHome = $Row["StatusHome"];
    $ListView = $Row["ListCountView"];
    $CountRefAll = $Row["ListCountComment"];
    $ListRating = $Row["ListRating"];
    $ListComment = $Row["ListComment"];
    $ListPin = $Row["ListPin"];
    $ListPublic = $Row["ListPublic"];

    $Picturexxwebp = $PathUploadPicture.$Row["Picture"];
    // $Picture = $PathUploadPicture.$ThumPreFix[0]."-".$Row["Picture"];
    $Picture = $PathUploadPicture.$Row["Picture"];
		if(is_file($Picture)){
			$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
			$showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Row["PictureAlt"].'" />';
		}else{
			$showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
		}
    $LangStatus = $Row["Status".$_SESSION['Session_Admin_Language']];
    $Fullname = $Row["Subject"];

		if(!empty($GID)){
      $query = "ID='".$GID."'";
      $mydata = @ArraySearch($dataArrGroup,$query,1);
      $FullGroupname = @$dataArrGroup[array_key_first($mydata)]["Name"];
		}else{
			$FullGroupname = "-";
		}
    $urlsubject = strlimitUrlEncode($Fullname,50);
    //$urlsubject = rawurlencode($Fullname);
    //$urlsubject = rand(000000,999999);
    //$linkpriview = _HTTP_PATH_."/thcontent/news/detail.".$ID.".1.".$GID.".".$urlsubject.".html";
    $linkpriview = _HTTP_PATH_."/th/news-detail.".$ID.".".$PageShow.".".$GID.".".$urlsubject.".html";

		$ListStatus = $Row["ListStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
      /*
      $listmnubtn .='<li>';
        $dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
        $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="'.$linkpriview.'" target="_blank">Preview</a>';
      $listmnubtn .='</li>';
      */
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      if($pmaalllist){
        $listmnubtn .='<li>';
  				$datagallery = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=gallery');
  			  $listmnubtn .='<a rev="'.$datagallery.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Gallery</a>';
  			$listmnubtn .='</li>';
        $listmnubtn .='<li>';
  				$datafileatt = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=fileatt');
  			  $listmnubtn .='<a rev="'.$datafileatt.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">File Attached</a>';
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

    if($StatusHome=='Yes'){
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=No&StatusType=StatusHome&actiontype=changeusestatushome');
      $btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:HomeStatus"][$_SESSION['Session_Admin_Language']].')</a>';
    }else{
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=Yes&StatusType=StatusHome&actiontype=changeusestatushome');
      $btnstatus = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:HomeStatus"][$_SESSION['Session_Admin_Language']].')</a>';
    }
    if($ListPin=='Yes'){
      $datapin = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=No&StatusType=Pin&actiontype=changeusebtnPin');
      $btnPin = '<a rev="'.$datapin.'" href="javascript:void(0);" class="chkUse pinYes" onclick="changeInPin(this)"><i class="fas fa-map-pin"></i> ปักหมุด</a>';
    }else{
      $datapin = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=Yes&StatusType=Pin&actiontype=changeusebtnPin');
      $btnPin = '<a rev="'.$datapin.'" href="javascript:void(0);" class="chkUse pinNo" onclick="changeInPin(this)"><i class="fas fa-map-pin"></i> ไม่ปักหมุด</a>';
    }
    if($ListPublic=='Yes'){
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=No&StatusType=StatusPublic&actiontype=changeusebtnPublic');
      $btnPublic = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse PublicOn" onclick="changeInStatus(this)"><i class="fas fa-user-friends"></i> '.$Array_Mod_Lang["txt:Public"][$_SESSION['Session_Admin_Language']].'</a>';
    }else{
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=Yes&StatusType=StatusPublic&actiontype=changeusebtnPublic');
      $btnPublic = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse PublicOff" onclick="changeInStatus(this)"><i class="fas fa-user-friends"></i> '.$Array_Mod_Lang["txt:Public"][$_SESSION['Session_Admin_Language']].'</a>';
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
    $arr["btnstatushome"] = $btnstatus;
    $arr["btnPin"] = $btnPin;
    $arr["btnPublic"] = $btnPublic;
    $arr["ListView"] = $ListView;
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
