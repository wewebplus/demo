<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/databanner.php");
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
decode_URL($_SERVER["QUERY_STRING"]);
$sessioncode = session_id();
$mytempfile = _RELATIVE_TEMP_UPLOAD_.$sessioncode;
if(!is_dir($mytempfile)) { mkdir($mytempfile,0777); }
$fname = "export-contact.xlsx";
$fnamepath = $mytempfile."/".$fname;
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$arrf = array();
$arrf[] = "a."._TABLE_BANNER_.'_ID AS ID';
$arrf[] = "a."._TABLE_BANNER_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_BANNER_.'_Status AS status';
$arrf[] = "a."._TABLE_BANNER_.'_Ignore AS allignore';
$arrf[] = "a."._TABLE_BANNER_.'_Start AS StartDate';
$arrf[] = "a."._TABLE_BANNER_.'_End AS ExpireDate';
$arrf[] = "a."._TABLE_BANNER_.'_GroupBanner AS GroupBanner';
$arrf[] = "a."._TABLE_BANNER_.'_Public AS ContentPublic';
$arrf[] = "a."._TABLE_BANNER_.'_SeeOnlyType AS SeeOnlyType';
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_URL AS URL".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_Target AS Target".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_PictureFile AS PictureFile".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_Status AS Status".$lkey;
	$arrf[] = $lkey."."._TABLE_BANNER_DETAIL_."_BannerCode AS BannerCode".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_BANNER_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_BANNER_DETAIL_." ".$lkey." ON (a."._TABLE_BANNER_."_ID = ".$lkey."."._TABLE_BANNER_DETAIL_."_ContentID AND ".$lkey."."._TABLE_BANNER_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_BANNER_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GroupBanner = $Row["GroupBanner"];
$BannerName = $Row["Subject".$_SESSION['Session_Admin_Language']];

$query = "Key='".$GroupBanner."'";
$mydata = @ArraySearch($dataArrGroup,$query,1);
$GroupName = $dataArrGroup[array_key_first($mydata)]["Name"];
$GroupKey = $dataArrGroup[array_key_first($mydata)]["Key"];
$GroupID = $dataArrGroup[array_key_first($mydata)]["ID"];

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Disaster")->setLastModifiedBy("Disaster")->setTitle("Office 2007 XLSX Disaster Document")->setSubject("Office 2007 XLSX Disaster Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Disaster result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $BannerName);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Group');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'FromURL');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'IP');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'Browser');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', 'Platform');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

// _TABLE_BANNER_LOGS_
$sql = "";
$arrf = array();
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_ID AS ID';
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_FromURL AS FromURL';
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_CreateDate AS CreateDate';
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_IP AS IP';
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_Browser AS Browser';
$arrf[] = "a."._TABLE_BANNER_LOGS_.'_Platform AS Platform';
$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_BANNER_LOGS_." a";
$sql .= " WHERE a."._TABLE_BANNER_LOGS_."_BannerID = ".intval($itemid);
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$index = 0;
$startindexrow = 2;
if($RecordCount>0) {
	foreach($v as $Row){
		$startindexrow++;
		$ID = $Row["ID"];
		$FromURL = $Row["FromURL"];
		$FullGroupname = $GroupName;
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');
		$IP = $Row["IP"];
		$Browser = $Row["Browser"];
		$Platform = $Row["Platform"];

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $CreateDate);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startindexrow, $FullGroupname);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startindexrow, $FromURL);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$startindexrow, $IP, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$startindexrow, $Browser, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$startindexrow, $Platform, PHPExcel_Cell_DataType::TYPE_STRING);
		$index++;
	}
}

$objPHPExcel->getActiveSheet()->setTitle('Export');
$objPHPExcel->setActiveSheetIndex(0);
/*
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: inline;filename="'.$fname.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
*/
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($fnamepath);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=".basename($fname).";");
header("Content-Transfer-Encoding: binary ");
header("Content-Length: ".filesize($fnamepath));
readfile($fnamepath);
unlink($fnamepath);
CloseDB();
exit();
?>
