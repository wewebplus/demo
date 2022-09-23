<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/datamember.php");
// decode_URL($_SERVER["QUERY_STRING"]);
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
$dataLevel = (!empty($_GET["selectLevel"])?$_GET["selectLevel"]:'');
$sessioncode = session_id();
$mytempfile = _RELATIVE_TEMP_UPLOAD_.$sessioncode;
if(!is_dir($mytempfile)) { mkdir($mytempfile,0777); }
$fname = "export-member.xlsx";
$fnamepath = $mytempfile."/".$fname;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', TRUE);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Disaster")->setLastModifiedBy("Disaster")->setTitle("Office 2007 XLSX Disaster Document")->setSubject("Office 2007 XLSX Disaster Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Disaster result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'No');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Name');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Username');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Email');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Tel');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'ประเภทสมาชิก');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Status');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Create');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
  $arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
  $arrf[] = "a."._TABLE_MEMBER_."_Name AS FullName";
  $arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '-', a."._TABLE_MEMBER_."_Email) as Email";
  $arrf[] = "a."._TABLE_MEMBER_."_ContactNo as Tel";
  $arrf[] = "a."._TABLE_MEMBER_."_Status AS ListStatus";
  $arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
  $arrf[] = "a."._TABLE_MEMBER_."_MemberType AS MemberType";
  $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE 1";
  if(!empty($dataLevel)){
    $sql .= " AND a."._TABLE_MEMBER_."_MemberType = '".trim($dataLevel)."'";
  }
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .= " ORDER BY TBmain.ListOrder DESC,TBmain.ID DESC";
unset($ArrField);
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
$index = 0;
$startindexrow = 1;
if($RecordCount>0) {
	foreach($v as $Row){
    $index++;
		$startindexrow++;
    $ListIndex = $RecordCount-($RecordStart+($index-1));
		$ID = $Row["ID"];
    $Email = $Row["Email"];
    $Name = $Row["FullName"];
    $Tel = $Row["Tel"];
    $CreateDate = $Row["CreateDate"];
    // $CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
    $Username = $Row["Username"];
		$ListStatus = $Row["ListStatus"];
		$MemberType = $Row["MemberType"];


		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $ListIndex);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startindexrow, $Name);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$startindexrow, $Username, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startindexrow, $Email);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$startindexrow, $Tel, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startindexrow, $MemberType);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startindexrow, $ListStatus);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startindexrow, $CreateDate);
	}
}
// exit();
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
