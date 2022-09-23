<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontactus.php");
// decode_URL($_SERVER["QUERY_STRING"]);
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
decode_URL($_SERVER["QUERY_STRING"]);
$dataArrGroup = $defaultdata[$Login_MenuID]["group"];
$sessioncode = session_id();
$mytempfile = _RELATIVE_TEMP_UPLOAD_.$sessioncode;
if(!is_dir($mytempfile)) { mkdir($mytempfile,0777); }
$fname = "export-contact.xlsx";
$fnamepath = $mytempfile."/".$fname;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$query = "ID='".$itemid."'";
$mydata = @ArraySearch($dataArrGroup,$query,1);
$GroupName = $dataArrGroup[array_key_first($mydata)]["Name"];
$GroupID = intval($itemid);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Disaster")->setLastModifiedBy("Disaster")->setTitle("Office 2007 XLSX Disaster Document")->setSubject("Office 2007 XLSX Disaster Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Disaster result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $GroupName);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Group');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Contact Name');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'Contact Email');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'Contact Tel');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', 'Contact Message');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= " (";
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTACT_.'_ID AS ID';
	$arrf[] = "a."._TABLE_CONTACT_.'_GroupID AS GroupID';
	$arrf[] = "a."._TABLE_CONTACT_.'_Name AS ContactName';
	$arrf[] = "a."._TABLE_CONTACT_.'_Status AS ListStatus';
	$arrf[] = "a."._TABLE_CONTACT_.'_ID AS ListOrder';
	$arrf[] = "a."._TABLE_CONTACT_.'_CreateDate AS CreateDate';
	$arrf[] = "a."._TABLE_CONTACT_.'_Email AS CreateEmail';
	$arrf[] = "a."._TABLE_CONTACT_.'_Tel AS CreateTel';
	$arrf[] = "a."._TABLE_CONTACT_.'_Message AS CreateMessage';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTACT_." a";
	$sql .= " WHERE a."._TABLE_CONTACT_."_Key='".$Login_MenuID."'";
	$sql .= " AND a."._TABLE_CONTACT_."_GroupID = ".intval($GroupID);
	unset($arrf);
$sql .= ") TBmain";
$sql .= " LEFT JOIN (";
	$sqlsub = "";
	foreach($systemLang as $lkey=>$lval){
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS GSubject".$lkey;
		$sqlsub .= ",".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS GStatus".$lkey;
	}
	$sql .= "SELECT b."._TABLE_CONTACT_GROUP_."_ID as groupid".$sqlsub." FROM "._TABLE_CONTACT_GROUP_." b";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (b."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE b."._TABLE_CONTACT_GROUP_."_Key = '".$Login_MenuID."'";
$sql .= ") TBJoin ON (TBmain.GroupID = TBJoin.groupid)";
$sql .= " ORDER BY TBmain.CreateDate DESC";
unset($ArrField);
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
		$ContactName = $Row["ContactName"];
		$FullGroupname = $Row["GSubject".$_SESSION['Session_Admin_Language']];
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

		$CreateEmail = $Row["CreateEmail"];
		$CreateTel = $Row["CreateTel"];
		$CreateMessage = $Row["CreateMessage"];


		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $CreateDate);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startindexrow, $FullGroupname);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startindexrow, $ContactName);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startindexrow, $CreateEmail);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$startindexrow, $CreateTel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startindexrow, decodetxterea($CreateMessage));

		//$objPHPExcel->getActiveSheet()->getStyle('F'.$startindexrow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
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
