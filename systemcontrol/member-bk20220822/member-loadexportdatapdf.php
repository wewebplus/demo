<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
decode_URL($_SERVER["QUERY_STRING"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$arrf = array();
$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
$arrf[] = "a."._TABLE_MEMBER_."_IDCard AS IDCard";
$arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
$arrf[] = "a."._TABLE_MEMBER_."_AName AS AName";
$arrf[] = "a."._TABLE_MEMBER_."_Name AS FName";
$arrf[] = "a."._TABLE_MEMBER_."_LName AS LName";
$arrf[] = "CONCAT(a."._TABLE_MEMBER_."_AName,a."._TABLE_MEMBER_."_Name, ' ', a."._TABLE_MEMBER_."_LName) AS FullName";
$arrf[] = "a."._TABLE_MEMBER_."_CompanyName AS CompanyName";
$arrf[] = "a."._TABLE_MEMBER_."_Address AS Address";
$arrf[] = "a."._TABLE_MEMBER_."_Province AS Province";
$arrf[] = "a."._TABLE_MEMBER_."_ProvinceCode AS ProvinceCode";
$arrf[] = "a."._TABLE_MEMBER_."_ZipCode AS ZipCode";
$arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '', a."._TABLE_MEMBER_."_Email) as Email";
$arrf[] = "IF(a."._TABLE_MEMBER_."_Telephone IS NULL or a."._TABLE_MEMBER_."_Telephone = '', '', a."._TABLE_MEMBER_."_Telephone) as Tel";
$arrf[] = "IF(a."._TABLE_MEMBER_."_Fax IS NULL or a."._TABLE_MEMBER_."_Fax = '', '', a."._TABLE_MEMBER_."_Fax) as Fax";
$arrf[] = "a."._TABLE_MEMBER_."_Birthday AS Birthday";
$arrf[] = "a."._TABLE_MEMBER_."_Sex AS Sex";
$arrf[] = "a."._TABLE_MEMBER_."_Member AS MLevel";
$arrf[] = "a."._TABLE_MEMBER_."_Membertxt AS Membertxt";
$arrf[] = "a."._TABLE_MEMBER_."_PictureFile AS PictureFile";
$arrf[] = "a."._TABLE_MEMBER_."_Position AS Position";
$arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
$arrf[] = "a."._TABLE_MEMBER_."_Level AS MemberLevel";
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
$sql .= " WHERE "._TABLE_MEMBER_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$RefNo = $Row["IDCard"];
$MyNo = $Row["IDCard"];
$MyDate = dateformat($Row["CreateDate"],'j F Y','English');
$MyName = $Row["FullName"];
$filename = $RefNo.".pdf";
$fpdfsave = _SYSTEM_DIRROOTPATH_."/upload/".$filename;
$setpdffont = "thsarabun";

$ID = $Row["ID"];
$MLevel = $Row["MLevel"];
$Gender = (!empty($Row["Sex"])?$ArrayGender[$Row["Sex"]]:'-');
$Birthday = dateformat($Row["Birthday"]." 00:00:00",'j M Y',$_SESSION['Session_Admin_Language']);
$FullName = $Row['FullName'];
$IDCard = $Row["IDCard"];
$Username = $Row['Username'];
$MLevelShow = $arrMemberType[$MLevel];
$Email = $Row['Email'];
$Tel = $Row['Tel'];
$Fax = $Row['Fax'];
$Position = $Row['Position'];
$Province = $Row['Province'];
$PictureFileHome = $PathUploadPicture.$Row["PictureFile"];
if(is_file($PictureFileHome)){
  $Picture = $PictureFileHome;
}else{
  $Picture = "./images/pdf/imgdefault.jpg";
}
$MemberLevel = $Row["MemberLevel"];
$MemberLevelText = $arrMemberLevel[$MemberLevel];

$Data01 = "สมาชิกเว็บไซต์ ".$MyNo;
define('LOGO_IMAGE', "./images/pdf/logo.jpg");
define('FONT', $setpdffont);
define('HEADTEXT', "สมาชิกเว็บไซต์");
define('HEADTEXTCOMPANY', "Department of Agriculture and Industrial Trade Ministry of Commerce.");
define('ADDRESSLine1', "563 Nonthaburi Rd., Bangkasor Nonthaburi 11000");
define('ADDRESSLine2', "โทรศัพท์ 02 507 8333, 02 507 8341,02 507 8394");
define('ADDRESSLine3', "อีเมล์ thaiselect.ditp@gmail.com");


define('NO', $MyNo);
define('DATE', $MyDate);

$html = '';
$html .= '<style>';
  $html .= '.tableinfo {border-spacing: 10px; border-collapse: separate; font-size:12pt;}';
  $html .= '.tableinfo tr.body td.tdcol1 { width:110px; text-align:right;}';
  $html .= '.tableinfo tr.body td.tdcol2 { width:3000px; text-align:left;}';
$html .= '</style>';
$html .= '<table class="tableinfo">';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">ชื่อสมาชิก</td>';
    $html .= '<td class="tdcol2">'.$FullName.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">หมายเลขบัตรประชาชน</td>';
    $html .= '<td class="tdcol2">'.$IDCard.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">เพศ</td>';
    $html .= '<td class="tdcol2">'.$Gender.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">วันเกิด</td>';
    $html .= '<td class="tdcol2">'.$Birthday.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">Username</td>';
    $html .= '<td class="tdcol2">'.$Username.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">ระดับสมาชิก</td>';
    $html .= '<td class="tdcol2">'.$MLevelShow.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">Email</td>';
    $html .= '<td class="tdcol2">'.$Email.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">Tel</td>';
    $html .= '<td class="tdcol2">'.$Tel.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">Fax</td>';
    $html .= '<td class="tdcol2">'.$Fax.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">จังหวัด</td>';
    $html .= '<td class="tdcol2">'.$Province.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">ตำแหน่ง</td>';
    $html .= '<td class="tdcol2">'.$Position.'</td>';
  $html .= '</tr>';
  $html .= '<tr class="body">';
    $html .= '<td class="tdcol1">'.$Array_Mod_Lang["txtinput:inputLevel"][$_SESSION['Session_Admin_Language']].'</td>';
    $html .= '<td class="tdcol2">'.$MemberLevelText.'</td>';
  $html .= '</tr>';
$html .= '</table>';

// exit();
include('member-printpdf.php');

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Content-type:application/pdf");
header("Content-Disposition: inline; filename=".$filename);
/*
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=".$filename);
*/
header("Content-Transfer-Encoding: binary ");
header("Content-Length: ".filesize($fpdfsave));
readfile($fpdfsave);
unlink($fpdfsave);
exit();
?>
