<?php
include("../assets/lib/inc.config.php");
include("../home/inc-header-db.php");
// include("../assets/lib/inc.config.php");
// include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
// include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");

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
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_DOWNLOAD_IMG_UPLOAD_);

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
$sql .= "SELECT * FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = "TBList.ID";
  $ArrField[] = "TBList.GroupID";
  $ArrField[] = "TBList.ListStatus";
  $ArrField[] = "TBList.Picture";
  $ArrField[] = "TBList.PictureAlt";
  $ArrField[] = "TBList.ListOrder";
  $ArrField[] = "TBList.ListView";
  $ArrField[] = "TBList.StartDate";
  $ArrField[] = "TBList.EndDate";
  $ArrField[] = "TBList.ListPublic";
  $ArrField[] = "TBList.CountFile";
  $ArrField[] = "TBList.CountLogs";
  $ArrField[] = "IF(TBList.SubjectID".$langkey." IS NULL or TBList.SubjectID".$langkey." = '', '0', TBList.SubjectID".$langkey.") as SubjectID";
  $ArrField[] = "IF(TBList.Subject".$langkey." IS NULL or TBList.Subject".$langkey." = '', TBList.SubjectDefault, TBList.Subject".$langkey.") as Subject";
  $ArrField[] = "IF(TBList.Status".$langkey." IS NULL or TBList.Status".$langkey." = '', '-', TBList.Status".$langkey.") as StatusLang";
  $ArrField[] = "IF(TBGroup.GroupName IS NULL or TBGroup.GroupName = '', '-', TBGroup.GroupName) as GroupName";
  $sql .= "SELECT ".implode(',',$ArrField)." FROM ";
  $sql .= "("	;
  	$arrf = array();
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_ID AS ID";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_GID AS GroupID";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_Status AS ListStatus";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_Picture AS Picture";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_PictureAlt AS PictureAlt";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_Order AS ListOrder";
    $arrf[] = "a."._TABLE_DOWNLOAD_."_View AS ListView";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_Start AS StartDate";
  	$arrf[] = "a."._TABLE_DOWNLOAD_."_End AS EndDate";
    $arrf[] = "a."._TABLE_DOWNLOAD_."_Public AS ListPublic";
    $arrf[] = $langkey."."._TABLE_DOWNLOAD_DETAIL_."_ID AS SubjectID".$langkey;
  	$arrf[] = $langkey."."._TABLE_DOWNLOAD_DETAIL_."_Subject AS Subject".$langkey;
  	$arrf[] = $langkey."."._TABLE_DOWNLOAD_DETAIL_."_Status AS Status".$langkey;
    $arrf[] = "LangDefault."._TABLE_DOWNLOAD_DETAIL_."_ID AS SubjectIDDefault";
    $arrf[] = "LangDefault."._TABLE_DOWNLOAD_DETAIL_."_Subject AS SubjectDefault";
    $arrf[] = "LangDefault."._TABLE_DOWNLOAD_DETAIL_."_Status AS StatusDefault";
    $arrf[] = "IF(TBJoinFile.CountRefAll IS NULL or TBJoinFile.CountRefAll = '', 0, TBJoinFile.CountRefAll) as CountFile";
    $arrf[] = "IF(TBJoinLogs.CountLogs IS NULL or TBJoinLogs.CountLogs = '', 0, TBJoinLogs.CountLogs) as CountLogs";
  	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_DOWNLOAD_." a";
    $sql .= " LEFT JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_DOWNLOAD_DETAIL_;
      $sql .= " WHERE "._TABLE_DOWNLOAD_DETAIL_."_Lang = '".$langkey."'";
      unset($arrjoinlang);
    $sql .= ") ".$langkey." ON (a."._TABLE_DOWNLOAD_."_ID = ".$langkey."."._TABLE_DOWNLOAD_DETAIL_."_ContentID)";
    $sql .= " INNER JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_DOWNLOAD_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_DOWNLOAD_DETAIL_;
      $sql .= " WHERE "._TABLE_DOWNLOAD_DETAIL_."_Lang = 'EN'";
      unset($arrjoinlang);
    $sql .= ") LangDefault ON (a."._TABLE_DOWNLOAD_."_ID = LangDefault."._TABLE_DOWNLOAD_DETAIL_."_ContentID)";
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT * FROM ";
      $sql .= "(";
        $arrinnercount = array();
        $arrinnercount[] = "COUNT(*) AS CountRefAll";
        $arrinnercount[] = _TABLE_DOWNLOAD_FILE_."_ContentID AS JoinContentID";
        $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_DOWNLOAD_FILE_." WHERE 1 GROUP BY "._TABLE_DOWNLOAD_FILE_."_ContentID";
        unset($arrinnercount);
      $sql .= ") TBCount";
    $sql .= ") TBJoinFile ON ("._TABLE_DOWNLOAD_."_ID = TBJoinFile.JoinContentID)";
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT * FROM ";
      $sql .= "(";
        $arrinnercount = array();
        $arrinnercount[] = "COUNT(*) AS CountLogs";
        $arrinnercount[] = _TABLE_DOWNLOAD_LOGS_."_DID AS JoinContentID";
        $sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_DOWNLOAD_LOGS_." WHERE 1 GROUP BY "._TABLE_DOWNLOAD_LOGS_."_DID";
        unset($arrinnercount);
      $sql .= ") TBCount";
    $sql .= ") TBJoinLogs ON ("._TABLE_DOWNLOAD_."_ID = TBJoinLogs.JoinContentID)";
    $sql .= " WHERE a."._TABLE_DOWNLOAD_."_Key IN ('".implode("','",$dataModuleKey)."')";
  	unset($arrf);
  $sql .= ") TBList";
  $sql .= " LEFT JOIN (";
    $sql .= "SELECT "._TABLE_DOWNLOAD_GROUP_."_ID AS ID,"._TABLE_DOWNLOAD_GROUP_."_".$langkey." AS GroupName FROM "._TABLE_DOWNLOAD_GROUP_;
    $sql .= " WHERE "._TABLE_DOWNLOAD_GROUP_."_Folder IN ('".implode("','",$dataModuleKey)."')";
  $sql .= ") TBGroup ON (TBList.GroupID = TBGroup.ID)";
  unset($ArrField);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if(!empty($dataGroup)){
  $sql .= " AND TBmain.GroupID = ".intval($dataGroup);
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
				$sql .= "TBmain.Subject LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
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
    $ListView = $Row["ListView"];
		$startDate = $Row['StartDate'];
		$endDate = $Row['EndDate'];
		$Dateshow = @dateformat($startDate,'j M Y')." - ".@dateformat($endDate,'j M Y');
    $ListPublic = $Row["ListPublic"];
    $CountFile = $Row["CountFile"];
    $CountLogs = $Row["CountLogs"];

    $Picturexxwebp = $PathUploadPicture.$Row["Picture"];
    $Picture = $PathUploadPicture.$Row["Picture"];
		if(is_file($Picture)){
			$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
			$showPicture = '<img src="'.$showPicture.'" class="imglist" alt="'.$Row["PictureAlt"].'" />';
		}else{
			$showPicture = '<img src="../assets/img/avatars/7.jpg" class="imglist" alt="" />';
		}
		$Fullname = $Row["Subject"];
    $FullGroupname = $Row["GroupName"];
    $urlsubject = str_replace(" ","+",$Fullname);
    $linkpriview = _HTTP_PATH_."/thcontent/content/detail.".$ID.".1.".$GID.".".$urlsubject.".html";

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

				  //$listmnubtn .='<a rev="'.$skey.'" rel="'.$ID.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';

				$listmnubtn .='</li>';
			}
		$listmnubtn .='</ul>';

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
    $arr["ListView"] = $ListView;
    $arr["btnPublic"] = $btnPublic;
    $arr["CountFile"] = $CountFile;
    $arr["CountDWN"] = number_format($CountLogs);
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
