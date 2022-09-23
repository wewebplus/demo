<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = trim($_POST['saveData']);
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
$UserPermission = userPmaInfo();
$osmnupma = $UserPermission->osmnupma;

if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$found = array();
$sql = "";
$ArrMainField = array();
$ArrMainField[] = "TBmain.ID";
$ArrMainField[] = "TBmain.ContentID";
$ArrMainField[] = "TBmain.MemberID";
$ArrMainField[] = "TBmain.Rating";
$ArrMainField[] = "TBmain.CreateDate";
$ArrMainField[] = "TBmain._Comment";
$ArrMainField[] = "TBmain._StatusComment";
$ArrMainField[] = "IF(TBMember.FullName IS NULL or TBMember.FullName = '', '-', TBMember.FullName) AS MemberFullName";
$sql .= "SELECT ".implode(',',$ArrMainField)." FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_ID AS ID";
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_ContentID AS ContentID";
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_MemberID AS MemberID";
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_CreateDate AS CreateDate";
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_Rating AS Rating";
  // $ArrField[] = _TABLE_RESTAURANT_RATING_."_Comment AS _Comment";
  $ArrField[] = "IF("._TABLE_RESTAURANT_RATING_."_Comment IS NULL or "._TABLE_RESTAURANT_RATING_."_Comment = '', '-', "._TABLE_RESTAURANT_RATING_."_Comment) as _Comment";
  $ArrField[] = _TABLE_RESTAURANT_RATING_."_StatusComment AS _StatusComment";
  $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_RESTAURANT_RATING_." WHERE 1 ";
  $sql .=" AND "._TABLE_RESTAURANT_RATING_."_ContentID = ".(int)$ContentID;
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
  $arrf = array();
  $arrf[] = "a."._TABLE_MEMBER_."_ID AS MemberID";
  $arrf[] = "a."._TABLE_MEMBER_."_Name AS FullName";
  $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
  $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
  $sql .= " WHERE 1";
  unset($arrf);
$sql .= ") TBMember ON (TBmain.MemberID = TBMember.MemberID)";
$sql .= " WHERE 1";
$sql .="  ORDER BY TBmain.ID DESC";
unset($ArrMainField);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
if($RecordCount>0) {
  foreach($v as $Row){
    $ID = $Row["ID"];
    $ContentID = $Row["ContentID"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($CreateDate,'j M Y H:i');
    $MemberID = $Row["MemberID"];
    $MemberFullName = $Row["MemberFullName"];
    $Rating = $Row["Rating"];
    $showRating = '';
    for($r=1;$r<=intval($Rating);$r++){
      $showRating .= '<span class="fa fa-star"></span>';
    }
    $_Comment = $Row["_Comment"];
    // $_StatusComment = $Row["_StatusComment"];
    $ListStatus = $Row["_StatusComment"];
    $statuscss = $arrinStatusBtnClass[$_SESSION['Session_Admin_Language']][$ListStatus];
    $listmnubtn = '';
    $listmnubtn .='<ul class="dropdown-menu" role="menu">';
    if($pmaalllist){
      foreach($arrinStatus[$_SESSION['Session_Admin_Language']] as $skey=>$sval){
        $listmnubtn .='<li '.($ListStatus==$skey?'class="active"':'').'>';
          $datastatus = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&status='.$skey.'&actiontype=changethisratingstatus');
          $listmnubtn .='<a rel="'.strtolower($skey).'" rev="'.$datastatus.'" href="javascript:void(0);" onClick="changeRatingStatus(this);">'.$sval.'</a>';
        $listmnubtn .='</li>';
      }
    }
    $listmnubtn .='</ul>';
    $arr['ID'] = $ID;
    $arr['MemberFullName'] = $MemberFullName;
		$arr['Rating'] = $Rating;
    $arr['ShowRating'] = $showRating;
    $arr['CreateDate'] = $CreateDate;
    $arr['Comment'] = echoDetailToediter($_Comment);
    $arr["StatusCss"] = strtolower($statuscss);
    $arr["Status"] = strtolower($ListStatus);
		$arr["Statustxt"] = $arrinStatus[$_SESSION['Session_Admin_Language']][$ListStatus];
    $arr["StatusBtn"] = $listmnubtn;
    $found[] = $arr;
  }
}
$output = array(
	"status" => "ok",
	"reccount" => number_format($RecordCount),
	"result" => $found
);
CloseDB();
echo json_encode($output);
exit();
?>
