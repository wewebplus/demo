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
$objPHPExcel->getProperties()->setCreator("Thaiselect")->setLastModifiedBy("Thaiselect")->setTitle("Office 2007 XLSX Thaiselect Document")->setSubject("Office 2007 XLSX Thaiselect Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Thaiselect result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'No');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Register Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'AName');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'FName');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'LName');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Email');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Email info');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Tel');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Country Name');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$ArrField = array();
	$ArrField[] = "CONCAT(REPLACE(LEFT("._TABLE_ADMIN_STAFF_."_EmpCode, 1), '_', ''),SUBSTRING("._TABLE_ADMIN_STAFF_."_EmpCode, 2)) AS NewNo";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ID";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
	$ArrField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_AName,"._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_EmailInfo AS EmailInfo";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Status AS ListStatus";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ListOrder";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_InType AS InType";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_CreateDate AS CreateDate";
	$ArrField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryName IS NULL or "._TABLE_ADMIN_STAFF_."_CountryName = '', '-', "._TABLE_ADMIN_STAFF_."_CountryName) AS CountryName";
	$ArrField[] = "IF(TBCheck.CountRefAll IS NULL or TBCheck.CountRefAll = '', 0, TBCheck.CountRefAll) AS CountRefAll";
	$sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_STAFF_;
	$sql .= " LEFT JOIN (";
		$arrinnercount = array();
		$arrinnercount[] = "COUNT(*) AS CountRefAll";
		$arrinnercount[] = _TABLE_ADMIN_USER_."_EmpID AS JoinContentID";
		$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADMIN_USER_." WHERE 1 GROUP BY "._TABLE_ADMIN_USER_."_EmpID";
		unset($arrinnercount);
	$sql .= ") TBCheck ON ("._TABLE_ADMIN_STAFF_."_ID = TBCheck.JoinContentID)";
	$sql .= " WHERE 1";
	$sql .= " AND "._TABLE_ADMIN_STAFF_."_InType = 'Embassy'";
	unset($ArrField);
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
    $Email = $Row["Email"];
		$EmailInfo = $Row["EmailInfo"];
    $Tel = $Row["Tel"];
    $CreateDate = $Row["CreateDate"];
    $CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
    $AName = $Row["AName"];
    $FName = $Row["FName"];
    $LName = $Row["LName"];
		$CountryName = $Row["CountryName"];

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $ListIndex);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startindexrow, $CreateDate);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startindexrow, $AName);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startindexrow, $FName);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startindexrow, $LName);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$startindexrow, $Email, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$startindexrow, $EmailInfo, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$startindexrow, $Tel, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$startindexrow, $CountryName);
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
