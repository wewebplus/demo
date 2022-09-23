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
$ArrField[] = "TBmain.ListView";
$ArrField[] = "TBmain.StartDate";
$ArrField[] = "TBmain.EndDate";
$ArrField[] = "TBmain.StatusHome";
$ArrField[] = "TBmain.ListRating";
$ArrField[] = "TBmain.ListComment";
$ArrField[] = "TBmain.ListPin";
$ArrField[] = "TBmain.ListPublic";
$ArrField[] = "TBmain.SubjectID".$_SESSION['Session_Admin_Language'];
$ArrField[] = "TBmain.Subject".$_SESSION['Session_Admin_Language'];
$ArrField[] = "TBmain.Status".$_SESSION['Session_Admin_Language'];
$ArrField[] = "TBJoinComment.CountRefAll";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
	$arrf[] = "a."._TABLE_CONTENT_."_GID AS GroupID";
	$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
	$arrf[] = "a."._TABLE_CONTENT_."_PictureAlt AS PictureAlt";
	$arrf[] = "a."._TABLE_CONTENT_."_Order AS ListOrder";
  // $arrf[] = "IF(TBJoinView.CountRefAll IS NULL or TBJoinView.CountRefAll = '', 0, TBJoinView.CountRefAll) as ListView";
  $arrf[] = "a."._TABLE_CONTENT_."_View AS ListView";
	$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
	$arrf[] = "a."._TABLE_CONTENT_."_End AS EndDate";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusHome AS StatusHome";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusRating AS ListRating";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusComment AS ListComment";
  $arrf[] = "a."._TABLE_CONTENT_."_Pin AS ListPin";
  $arrf[] = "a."._TABLE_CONTENT_."_Public AS ListPublic";
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$langkey;
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
  $sql .= " LEFT JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_CONTENT_DETAIL_;
    $sql .= " WHERE "._TABLE_CONTENT_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_CONTENT_."_ID = ".$langkey."."._TABLE_CONTENT_DETAIL_."_ContentID)";
  // $sql .= " LEFT JOIN (";
  //   $sql .= "SELECT * FROM ";
  //   $sql .= "(";
  //     $arrinnercount = array();
  //     $arrinnercount[] = "COUNT(*) AS CountRefAll";
  //     $arrinnercount[] = _TABLE_CONTENT_VIEW_."_ContentID AS JoinContentID";
  //     $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_CONTENT_VIEW_." WHERE 1 GROUP BY "._TABLE_CONTENT_VIEW_."_ContentID";
  //     unset($arrinnercount);
  //   $sql .= ") TBCount";
  // $sql .= ") TBJoinView ON ("._TABLE_CONTENT_."_ID = TBJoinView.JoinContentID)";
  $sql .= " WHERE a."._TABLE_CONTENT_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
  $sql .= "SELECT * FROM ";
  $sql .= "(";
    $arrinnercount = array();
    $arrinnercount[] = "COUNT(*) AS CountRefAll";
    $arrinnercount[] = _TABLE_CONTENT_COMMENT_."_ContentID AS JoinContentID";
    $arrinnercount[] = "SUM(IF("._TABLE_CONTENT_COMMENT_."_Status='On', 1, 0)) AS CountRefUsage";
    $arrinnercount[] = "SUM(IF("._TABLE_CONTENT_COMMENT_."_Status='Off', 1, 0)) AS CountRefNoUsage";
    $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_CONTENT_COMMENT_." WHERE 1 GROUP BY "._TABLE_CONTENT_COMMENT_."_ContentID";
    unset($arrinnercount);
  $sql .= ") TBCount";
$sql .= ") TBJoinComment ON (TBmain.ID = TBJoinComment.JoinContentID)";
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
// echo $sql;
// exit();
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
		$startDate = $Row['StartDate'];
		$endDate = $Row['EndDate'];
		$Dateshow = @dateformat($startDate,'j M Y')." - ".@dateformat($endDate,'j M Y');
    $StatusHome = $Row["StatusHome"];
    $ListView = $Row["ListView"];

    $ListRating = $Row["ListRating"];
    $ListComment = $Row["ListComment"];
    $ListPin = $Row["ListPin"];
    $ListPublic = $Row["ListPublic"];

    $CountRefAll = $Row["CountRefAll"];

    $Picturexxwebp = $PathUploadPicture.$Row["Picture"];
    $Picture = $PathUploadPicture.$ThumPreFix[0]."-".$Row["Picture"];
		if(is_file($Picture)){
			$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
			$showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Row["PictureAlt"].'" />';
		}else{
			$showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
		}
    /*
    if(is_file($Picturexxwebp)){
      if(!is_file($Picturexxwebp.'.webp')){
        $jw = new ImageToWebp();
        $jw->convert( $Picturexxwebp, $Picturexxwebp.'.webp' );
      }else{
        //echo "B";
      }
      $showPicture = str_replace(_RELATIVE_CONTENT_IMG_UPLOAD_,_HTTP_CONTENT_IMG_UPLOAD_,$Picturexxwebp.'.webp');
      $showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Row["PictureAlt"].'" />';
    }else{
      $showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
    }
    */
    $LangStatus = $Row["Status".$_SESSION['Session_Admin_Language']];
    if($LangStatus=='On'){
      $Fullname = $Row["Subject".$_SESSION['Session_Admin_Language']];
    }else{
      $Fullname = $Row["SubjectEnglish"];
    }
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
          $datainlink = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=link');
          $listmnubtn .='<a rev="'.$datainlink.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Link</a>';
        $listmnubtn .='</li>';
        $listmnubtn .='<li>';
          $dataincomment = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=comment');
          $listmnubtn .='<a rev="'.$dataincomment.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Comment '.($CountRefAll>0?'('.$CountRefAll.')':'').'</a>';
        $listmnubtn .='</li>';
        $listmnubtn .='<li>';
          $datainrating = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=rating');
          $listmnubtn .='<a rev="'.$datainrating.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Rating</a>';
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
    if($ListRating=='Yes'){
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=No&StatusType=StatusRating&actiontype=changeuseRating');
      $btnRating = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:Rating"][$_SESSION['Session_Admin_Language']].')</a>';
    }else{
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=Yes&StatusType=StatusRating&actiontype=changeuseRating');
      $btnRating = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:Rating"][$_SESSION['Session_Admin_Language']].')</a>';
    }
    if($ListComment=='Yes'){
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=No&StatusType=StatusComment&actiontype=changeusebtnComment');
      $btnComment = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOn" onclick="changeInStatus(this)"><i class="fa fa-toggle-on" aria-hidden="true"></i> แสดง ('.$Array_Mod_Lang["txt:Comment"][$_SESSION['Session_Admin_Language']].')</a>';
    }else{
      $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&statusto=Yes&StatusType=StatusComment&actiontype=changeusebtnComment');
      $btnComment = '<a rev="'.$datastatus.'" href="javascript:void(0);" class="chkUse statusOff" onclick="changeInStatus(this)"><i class="fa fa-toggle-off" aria-hidden="true"></i> ไม่แสดง ('.$Array_Mod_Lang["txt:Comment"][$_SESSION['Session_Admin_Language']].')</a>';
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
    $arr["btnRating"] = $btnRating;
    $arr["btnComment"] = $btnComment;
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
