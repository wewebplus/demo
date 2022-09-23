<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ImageToWebp.php");
$selectPage = trim($_POST['page']);
$LoginData = trim($_POST['LoginData']);
decode_URL($LoginData);
$loadtype = (!empty($_POST["loadtype"])?trim($_POST['loadtype']):'footable');
$dataKeyword = (!empty($_POST["dataKeyword"])?$_POST["dataKeyword"]:'');
$dataGroup = (!empty($_POST["dataGroup"])?trim($_POST["dataGroup"]):'');
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadPictureRes = (isset($defaultdata[$Login_MenuID]["path"]["PICTURERES"])?$defaultdata[$Login_MenuID]["path"]["PICTURERES"]:_RELATIVE_TEMP_UPLOAD_);
$PathUploadFileRes = (isset($defaultdata[$Login_MenuID]["path"]["RESFILE"])?$defaultdata[$Login_MenuID]["path"]["RESFILE"]:_RELATIVE_TEMP_UPLOAD_);

$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
array_push($dataModuleKey,"RestaurantBranch");

$StaffInfo = getStaffInfo((int)$_SESSION['Session_Admin_ID']);
// echo $StaffInfo->level;
// print_r($StaffInfo->inCountry);
// echo '<pre>';
// print_r($StaffInfo);
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
$sql .= "SELECT * FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = "TBList.ID";
  $ArrField[] = "TBList.ListStatus";
  $ArrField[] = "TBList.ListOrder";
  $ArrField[] = "TBList.CreateDate";
  $ArrField[] = "TBList.ListApproveStatus";
  $ArrField[] = "TBList.ResType";
  $ArrField[] = "TBList.Name";
  $ArrField[] = "TBList._Percen";
  $ArrField[] = "TBList._Country";
  $ArrField[] = "TBList._Province";
  $ArrField[] = "TBList.Picture";
  $ArrField[] = "TBList.FilAddIndex";
  $ArrField[] = "IF(TBList.SubjectID".$langkey." IS NULL or TBList.SubjectID".$langkey." = '', '0', TBList.SubjectID".$langkey.") as SubjectID";
  $ArrField[] = "IF(TBList.Subject".$langkey." IS NULL or TBList.Subject".$langkey." = '', TBList.SubjectDefault, TBList.Subject".$langkey.") as Subject";
  $ArrField[] = "IF(TBList.Title".$langkey." IS NULL or TBList.Title".$langkey." = '', TBList.TitleDefault, TBList.Title".$langkey.") as Title";
  $ArrField[] = "IF(TBList.Status".$langkey." IS NULL or TBList.Status".$langkey." = '', '-', TBList.Status".$langkey.") as StatusLang";
  $sql .= "SELECT ".implode(',',$ArrField)." FROM ";
  $sql .= "("	;
  	$arrf = array();
  	$arrf[] = "a."._TABLE_RESTAURANT_."_ID AS ID";
  	$arrf[] = "a."._TABLE_RESTAURANT_."_Status AS ListStatus";
  	$arrf[] = "a."._TABLE_RESTAURANT_."_Order AS ListOrder";
    $arrf[] = "a."._TABLE_RESTAURANT_."_CreateDate AS CreateDate";
    $arrf[] = "a."._TABLE_RESTAURANT_."_ApproveStatus AS ListApproveStatus";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Name AS Name";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Type AS ResType";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Percen AS _Percen";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Country AS _Country";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Province AS _Province";
    $arrf[] = "TBFile.FileName AS Picture";
    $arrf[] = "TBFile.FilAddIndex AS FilAddIndex";
    $arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_ID AS SubjectID".$langkey;
  	$arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Subject AS Subject".$langkey;
    $arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Detail AS Title".$langkey;
  	$arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Status AS Status".$langkey;
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_ID AS SubjectIDDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Subject AS SubjectDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Detail AS TitleDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Status AS StatusDefault";
  	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_RESTAURANT_." a";
    $sql .= " LEFT JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Detail";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_RESTAURANT_DETAIL_;
      $sql .= " WHERE "._TABLE_RESTAURANT_DETAIL_."_Lang = '".$langkey."'";
      unset($arrjoinlang);
    $sql .= ") ".$langkey." ON (a."._TABLE_RESTAURANT_."_ID = ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ContentID)";
    $sql .= " LEFT JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Detail";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_RESTAURANT_DETAIL_;
      $sql .= " WHERE "._TABLE_RESTAURANT_DETAIL_."_Lang = 'EN'";
      unset($arrjoinlang);
    $sql .= ") LangDefault ON (a."._TABLE_RESTAURANT_."_ID = LangDefault."._TABLE_RESTAURANT_DETAIL_."_ContentID)";
    $sql .= " LEFT JOIN (";
      $sql .= " SELECT "._TABLE_RESTAURANT_FILE_."_ContentID AS ResID,"._TABLE_RESTAURANT_FILE_."_FileName AS FileName,"._TABLE_RESTAURANT_FILE_."_AddIndex AS FilAddIndex FROM "._TABLE_RESTAURANT_FILE_;
      $sql .= " WHERE "._TABLE_RESTAURANT_FILE_."_Flag = 'restaurant_image'";
      $sql .= " AND "._TABLE_RESTAURANT_FILE_."_ID IN (SELECT MIN("._TABLE_RESTAURANT_FILE_."_ID) FROM "._TABLE_RESTAURANT_FILE_." WHERE "._TABLE_RESTAURANT_FILE_."_Flag = 'restaurant_image' GROUP BY "._TABLE_RESTAURANT_FILE_."_ContentID)";
    $sql .= ") TBFile ON (a."._TABLE_RESTAURANT_."_ID = TBFile.ResID)";
    $sql .= " WHERE a."._TABLE_RESTAURANT_."_Key IN ('".implode("','",$dataModuleKey)."')";
    if($StaffInfo->level == 'Admin'){

    }else{
      // Staff
      if(count($StaffInfo->inCountry)>0){
        $sql .= " AND ";
        $sql .= "(";
        foreach($StaffInfo->inCountry as $KC=>$VC){
          if($KC>0){
            $sql .= " OR ";
          }
          $CountryID = $VC["CountryID"];
          $StateID = $VC["StateID"];
          $sql .= "(";
            $sql .= "a."._TABLE_RESTAURANT_."_Country = ".$CountryID;
            if($StateID>0){
              $sql .= " OR a."._TABLE_RESTAURANT_."_Province = ".$StateID;
            }
          $sql .= ")";
        }
        $sql .= ")";
      }
    }
    // echo $StaffInfo->level;
    // print_r($StaffInfo->inCountry);
    // echo '<pre>';
    // print_r($StaffInfo);
    // echo '</pre>';
  	unset($arrf);
  $sql .= ") TBList";
  $sql .= " WHERE 1";
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
    foreach($arrkeyword as $TKey=>$TVal){
      if($TKey>0){
        $sql .= " OR ";
      }
      $sql .= "(";
				$sql .= "TBmain.Name LIKE '%".$TVal."%'";
      $sql .= ")";
    }
    $sql .= ")";
  }
}
$sql .= " ORDER BY TBmain.CreateDate DESC";
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
    $ResType = $Row["ResType"];
    $Email = "";
    $Name = $Row["Name"];
    $Tel = "";
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j M Y');
    $PercentProgress = $Row["_Percen"];
    if($PercentProgress>1 && $PercentProgress<=50){
      $PercentProgressTitle = "อยู่ระหว่างการพิจารณาให้คะแนน";
    }else if($PercentProgress>50){
      $PercentProgressTitle = "อยู่ระหว่างการพิจารณาให้คะแนน";
    }else{
      $PercentProgressTitle = "รอการพิจารณาให้คะแนน";
    }
    $FilAddIndex = $Row["FilAddIndex"];
    if($FilAddIndex=="Old"){
      $Picture = $PathUploadPictureRes.$Row["Picture"];
    }else{
      $Picture = $PathUploadPictureRes.$ID."/".$Row["Picture"];
    }
    if(is_file($Picture)){
      $showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
      $showPicture = '<img src="'.$showPicture.'" class="" alt="" />';
    }else{
      $showPicture = '<img src="../assets/img/avatars/8.jpg" class="" alt="" />';
    }
    $Score = 0;
    $ResScore = array();
    $arrscore = array();
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_ID AS ID";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_MemberID AS MemberID";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_RestaurantName AS RestaurantName";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_PassTheCriteria AS PassTheCriteria";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_Section2Total AS Section2Total";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_Section3Total AS Section3Total";
    $arrscore[] = _TABLE_RESTAURANT_SCORE_."_SectionTotalAll AS SectionTotalAll";
    $arrscore[] = "TBMember.FullName";
    $sql = "SELECT ".implode(',',$arrscore)." FROM "._TABLE_RESTAURANT_SCORE_;
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT * FROM";
    	$sql .= " (";
    		$sql .= "SELECT TBmain."._TABLE_ADMIN_USER_."_ID AS UserID,TBmain."._TABLE_ADMIN_USER_."_EmpID AS EmpID,TBmain."._TABLE_ADMIN_USER_."_UserName AS UserName,TBmain."._TABLE_ADMIN_USER_."_Type AS uType,TBmain."._TABLE_ADMIN_USER_."_CreateDate AS uCreateDate,TBmain."._TABLE_ADMIN_USER_."_Remark AS uRemark";
    		$sql .= ",(SELECT MAX("._TABLE_ADMIN_USERLOGIN_."_CreateDate) FROM "._TABLE_ADMIN_USERLOGIN_." WHERE "._TABLE_ADMIN_USERLOGIN_."_Type = 'Login' AND "._TABLE_ADMIN_USERLOGIN_."_UserID = TBmain."._TABLE_ADMIN_USER_."_ID) AS LastLogin";
    		$sql .= ",(SELECT MAX("._TABLE_ADMIN_USERLOGIN_."_CreateDate) FROM "._TABLE_ADMIN_USERLOGIN_." WHERE "._TABLE_ADMIN_USERLOGIN_."_Type = 'Login' AND "._TABLE_ADMIN_USERLOGIN_."_UserID = TBmain."._TABLE_ADMIN_USER_."_ID AND "._TABLE_ADMIN_USERLOGIN_."_CreateDate <> TBmain."._TABLE_ADMIN_USER_."_LastLoginDate) AS LastLoginBefor";
    		$sql .= ",TBJoinToken.*";
    		$sql .= " FROM "._TABLE_ADMIN_USER_." TBmain";
    		$sql .= " LEFT JOIN (";
    			$sql .= "SELECT "._TABLE_ADMIN_USERTOKEN_."_TokenID AS JoinTokenID,"._TABLE_ADMIN_USERTOKEN_."_UserID AS JoinUserID,"._TABLE_ADMIN_USERTOKEN_."_CreateDate AS JoinCreateDate FROM "._TABLE_ADMIN_USERTOKEN_." WHERE "._TABLE_ADMIN_USERTOKEN_."_Status = 'Active' AND "._TABLE_ADMIN_USERTOKEN_."_CreateDate IN (SELECT max("._TABLE_ADMIN_USERTOKEN_."_CreateDate) FROM "._TABLE_ADMIN_USERTOKEN_." GROUP BY "._TABLE_ADMIN_USERTOKEN_."_UserID)";
    		$sql .= ") TBJoinToken ON (TBmain."._TABLE_ADMIN_USER_."_ID = TBJoinToken.JoinUserID)";
    		$sql .= " WHERE 1";
    	$sql .= ") TBUser";
    	$sql .= " LEFT JOIN (";
    		$ArrJoinField = array();
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_ID AS StaffID";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
    		$ArrJoinField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_AName,"._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_AName AS AName";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Level AS SLevel";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Remark AS Remark";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Position AS Position";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_InType AS InType";
    		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Country AS CountryID";
    		$ArrJoinField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryCode IS NULL or "._TABLE_ADMIN_STAFF_."_CountryCode = '', '-', "._TABLE_ADMIN_STAFF_."_CountryCode) AS CountryCode";
    		$ArrJoinField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryName IS NULL or "._TABLE_ADMIN_STAFF_."_CountryName = '', '-', "._TABLE_ADMIN_STAFF_."_CountryName) AS CountryName";
    		$sql .= "SELECT ".implode(",",$ArrJoinField)." FROM "._TABLE_ADMIN_STAFF_;
    		$sql .= " WHERE 1";
    		unset($ArrJoinField);
    	$sql.= ") JoinTBStaff ON (TBUser.EmpID = JoinTBStaff.StaffID)";
    	$sql .= " LEFT JOIN (";
    		$sql .= "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS TypeID,"._TABLE_ADMIN_USERGROUP_."_Name AS TypeName FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
    	$sql .= ") JoinTBType ON (TBUser.uType = JoinTBType.TypeID)";
    $sql .= ") TBMember ON ("._TABLE_RESTAURANT_SCORE_."_MemberID = TBMember.UserID)";
    $sql .= " WHERE "._TABLE_RESTAURANT_SCORE_."_ContentID = ".intval($ID);
    $sql .= " ORDER BY "._TABLE_RESTAURANT_SCORE_."_CreateDate ASC";
    unset($arrscore);
    $z->sql($sql);
    $RecordCountScore = $z->num();
    if($RecordCountScore>0){
      $vScore = $z->row();
      foreach($vScore as $RowScore){
        $ScoreID = $RowScore["ID"];
        $datascoreview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&itemscore='.$ScoreID.'&actiontype=scoreview');
        $ars = array();
        $ars["ID"] = $ScoreID;
        $ars["LinkScore"] = $datascoreview;
        $ars["MemberID"] = $RowScore["MemberID"];
        $ars["Member"] =  $RowScore["FullName"];
        $ars["RestaurantName"] = $RowScore["RestaurantName"];
        $ars["PassTheCriteria"] = ($RowScore["PassTheCriteria"]=='P'?'ผ่านเกณฑ์':'ไม่ผ่านเกณฑ์');//$RowScore["PassTheCriteria"];
        $ars["Section2Total"] = number_format($RowScore["Section2Total"]);
        $ars["Section3Total"] = number_format($RowScore["Section3Total"]);
        $ars["SectionTotalAll"] = number_format($RowScore["SectionTotalAll"]);
        $ResScore[] = $ars;
      }
    }

		$ListStatus = $Row["ListApproveStatus"];
		$statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
		$listmnubtn = '';
		$listmnubtn .='<ul class="dropdown-menu" role="menu">';
			$listmnubtn .='<li>';
				$dataview = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=view');
			  $listmnubtn .='<a rev="'.$dataview.'" rel="'.$index.'" href="javascript:void(0);" onclick="clicktoaction(this);">View</a>';
			$listmnubtn .='</li>';
      if($StaffInfo->level == 'Admin'){
        $listmnubtn .='<li class="divider"></li>';
        foreach($arrinStatusRestaurant[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
          if($skey=='Reject'){
            $listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
              $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisdialogstatus');
              $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeDialogStatus(this);">'.$sval.'</a>';
            $listmnubtn .='</li>';
          }else{
            $listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
              $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisstatus');
              $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeStatus(this);">'.$sval.'</a>';
            $listmnubtn .='</li>';
          }
        }
      }
		$listmnubtn .='</ul>';
    $LinkScore = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=score');
    $arr["ListIndex"] = $ListIndex;
		$arr["valueid"] = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=lineid');
		$arr["valueEmail"] = $Email;
		$arr["valueName"] = $Name;//." ".$ID;
    $arr["valueTel"] = $Tel;
    $arr["valueCreateDate"] = $CreateDate;
		$arr["valueStatusCss"] = strtolower($statuscss);
		$arr["valueBtn"] = $listmnubtn;
		$arr["valueStatus"] = strtolower($ListStatus);
		$arr["valueStatustxt"] = $arrinStatusRestaurant[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["valuePicture"] = $showPicture;
    $arr["valuePercentProgress"] = $PercentProgress;
    $arr["valuePercentProgressTitle"] = $PercentProgressTitle;
    $arr["valueScore"] = $Score;
    $arr["valueResType"] = $ResType;
    $arr["valueResScore"] = $ResScore;
    $arr["LinkScore"] = $LinkScore;
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
