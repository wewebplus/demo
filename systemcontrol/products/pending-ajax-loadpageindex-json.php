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
$PathUploadPicture = str_replace("ProductsPending","memberProduct",$PathUploadPicture);

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

// _TABLE_PRODUCTS_GROUP_
// _TABLE_PRODUCTS_WTIME_
// _TABLE_ADMIN_WDAY_
// print_r($dataArrGroup);
// print_r($dataArrDay);
$sql = "";
$ArrField = array();
$ArrField[] = "TBmain.ID";
$ArrField[] = "TBmain.ListStatus";
$ArrField[] = "TBmain.ListOrder";
$ArrField[] = "TBmain.ListCountView";
$ArrField[] = "TBmain.ProductType";
$ArrField[] = "TBmain.ProductTypeName";
$ArrField[] = "TBmain.Picture";
$ArrField[] = "TBmain.FilAddIndex";
$ArrField[] = "TBmain.CreateDate";
$ArrField[] = "TBmain.LastUpdate";
$ArrField[] = "TBmain.FullMemberName";
$ArrField[] = "TBmain.SubjectID";
$ArrField[] = "TBmain.Subject01";
$ArrField[] = "TBmain.Subject02";
$ArrField[] = "TBmain.StatusLang";
$ArrField[] = "TBmain.DefaultSubject01";
$ArrField[] = "TBmain.DefaultSubject02";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_PRODUCTS_."_ID AS ID";
	$arrf[] = "a."._TABLE_PRODUCTS_."_MemberID AS MemberID";
  $arrf[] = "a."._TABLE_PRODUCTS_."_TypeID AS ProductType";
	$arrf[] = "a."._TABLE_PRODUCTS_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_PRODUCTS_."_Order AS ListOrder";
  $arrf[] = "a."._TABLE_PRODUCTS_."_View AS ListCountView";
  $arrf[] = "a."._TABLE_PRODUCTS_."_CreateDate AS CreateDate";
  $arrf[] = "a."._TABLE_PRODUCTS_."_LastUpdate AS LastUpdate";
  $arrf[] = "TBFile.FileName AS Picture";
  $arrf[] = "TBFile.FilAddIndex AS FilAddIndex";
  $arrf[] = "IF(TBMember.FullName IS NULL or TBMember.FullName = '', '-', TBMember.FullName) as FullMemberName";
  $arrf[] = "IF(TBType.TypeName IS NULL or TBType.TypeName = '', '-', TBType.TypeName) as ProductTypeName";
  $arrf[] = "IF(".$langkey."."._TABLE_PRODUCTS_DETAIL_."_ID IS NULL or ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_ID = '', '0', ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_ID) as SubjectID";
  $arrf[] = "IF(".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject01 IS NULL or ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject01 = '', '-', ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject01) as Subject01";
  $arrf[] = "IF(".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject02 IS NULL or ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject02 = '', '-', ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Subject02) as Subject02";
  $arrf[] = "IF(".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Status IS NULL or ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Status = '', '0', ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_Status) as StatusLang";
  $arrf[] = "IF(DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject01 IS NULL or DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject01 = '', '-', DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject01) as DefaultSubject01";
  $arrf[] = "IF(DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject02 IS NULL or DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject02 = '', '-', DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_Subject02) as DefaultSubject02";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_PRODUCTS_." a";
  $sql .= " LEFT JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject01";
    $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject02";
    $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_PRODUCTS_DETAIL_;
    $sql .= " WHERE "._TABLE_PRODUCTS_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_PRODUCTS_."_ID = ".$langkey."."._TABLE_PRODUCTS_DETAIL_."_ContentID)";
  if($langkey=='TH'){
    $sql .= " LEFT JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject01";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject02";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_PRODUCTS_DETAIL_;
      $sql .= " WHERE "._TABLE_PRODUCTS_DETAIL_."_Lang = 'EN'";
      unset($arrjoinlang);
    $sql .= ") DefaultDetail ON (a."._TABLE_PRODUCTS_."_ID = DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_ContentID)";
  }else{
    $sql .= " LEFT JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject01";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Subject02";
      $arrjoinlang[] = _TABLE_PRODUCTS_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_PRODUCTS_DETAIL_;
      $sql .= " WHERE "._TABLE_PRODUCTS_DETAIL_."_Lang = 'TH'";
      unset($arrjoinlang);
    $sql .= ") DefaultDetail ON (a."._TABLE_PRODUCTS_."_ID = DefaultDetail."._TABLE_PRODUCTS_DETAIL_."_ContentID)";
  }
  $sql .= " LEFT JOIN (";
    $sql .= " SELECT "._TABLE_PRODUCTS_FILE_."_ContentID AS ResID,"._TABLE_PRODUCTS_FILE_."_FileName AS FileName,"._TABLE_PRODUCTS_FILE_."_AddIndex AS FilAddIndex FROM "._TABLE_PRODUCTS_FILE_;
    $sql .= " WHERE "._TABLE_PRODUCTS_FILE_."_Flag = 'product'";
    $sql .= " AND "._TABLE_PRODUCTS_FILE_."_ID IN (SELECT MIN("._TABLE_PRODUCTS_FILE_."_ID) FROM "._TABLE_PRODUCTS_FILE_." WHERE  "._TABLE_PRODUCTS_FILE_."_Flag = 'product' GROUP BY "._TABLE_PRODUCTS_FILE_."_ContentID)";
  $sql .= ") TBFile ON (a."._TABLE_PRODUCTS_."_ID = TBFile.ResID)";
  $sql .= " LEFT JOIN (";
    $arrfuser = array();
  	$arrfuser[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
    $arrfuser[] = "a."._TABLE_MEMBER_."_Name AS FullName";
    $arrfuser[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
  	$sql .= "SELECT  ".implode(',',$arrfuser)." FROM "._TABLE_MEMBER_." a";
    $sql .= " WHERE a."._TABLE_MEMBER_."_MemberType = 'Company'";
    unset($arrfuser);
  $sql .= ") TBMember ON (a."._TABLE_PRODUCTS_."_MemberID = TBMember.MemberID)";
  $sql .= " LEFT JOIN (";
    $arrftype = array();
  	$arrftype[] = _TABLE_PRODUCTS_TYPE_."_ID AS TypeID";
    $arrftype[] = _TABLE_PRODUCTS_TYPE_."_Name AS TypeName";
  	$sql .= "SELECT  ".implode(',',$arrftype)." FROM "._TABLE_PRODUCTS_TYPE_;
    $sql .= " WHERE 1";
    unset($arrftype);
  $sql .= ") TBType ON (a."._TABLE_PRODUCTS_."_TypeID = TBType.TypeID)";
  $sql .= " WHERE a."._TABLE_PRODUCTS_."_Key IN ('memberProduct')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if(!empty($dataGroup)){
  $sql .= " AND TBmain.ProductType = '".$dataGroup."'";
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
  				$sql .= "TBmain.Subject01 LIKE '%".$TVal."%'";
          $sql .= " OR TBmain.Subject02 LIKE '%".$TVal."%'";
          $sql .= " OR TBmain.FullMemberName LIKE '%".$TVal."%'";
        $sql .= ")";
      }
    }
    $sql .= ")";
  }
}
// $sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
$sql .= " ORDER BY TBmain.CreateDate ".$ASCDESC;
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
    $ListView = $Row["ListCountView"];
    $ProductType = $Row["ProductTypeName"];
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
    $LangStatus = $Row["StatusLang"];
    $BrandDefault = $Row["DefaultSubject01"];
    $SubjectDefault = $Row["DefaultSubject02"];
    $Brand = $Row["Subject01"];
    $Subject = $Row["Subject02"];
    $urlsubject = strlimitUrlEncode($Fullname,50);
    //$urlsubject = rawurlencode($Fullname);
    //$urlsubject = rand(000000,999999);
    //$linkpriview = _HTTP_PATH_."/thcontent/news/detail.".$ID.".1.".$GID.".".$urlsubject.".html";
    $linkpriview = _HTTP_PATH_."/th/news-detail.".$ID.".".$PageShow.".".$GID.".".$urlsubject.".html";

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
  			// 	$dataedit = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit');
  			//   $listmnubtn .='<a rev="'.$dataedit.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">Edit</a>';
  			// $listmnubtn .='</li>';
  			// $listmnubtn .='<li>';
  			// 	$datadelete = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=delete');
  			//   $listmnubtn .='<a rev="'.$datadelete.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktodelete(this);">Delete</a>';
  			// $listmnubtn .='</li>';
  			$listmnubtn .='<li class="divider"></li>';
  			foreach($arrinStatusRestaurant[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
  				$listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
  				  $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
  				  $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
  				$listmnubtn .='</li>';
  			}
      }
		$listmnubtn .='</ul>';

    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueGroupname"] = $FullGroupname;
    $arr["valueBrand"] = $Brand;
		$arr["valueSubject"] = $Subject;
    $arr["valueBrandDefault"] = $BrandDefault;
    $arr["valueSubjectDefault"] = $SubjectDefault;
		$arr["valueDateshow"] = $Dateshow;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valuePicture"] = $showPicture;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["ListView"] = $ListView;
    $arr["valueProductType"] = $ProductType;
    $arr["valueBranch"] = $_Branch;
    $arr["valueMemberName"] = $FullMemberName;
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
