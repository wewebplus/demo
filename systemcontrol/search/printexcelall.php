<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$GroupID = intval(!empty($_GET["Group"])?$_GET["Group"]:0);
decode_URL($_SERVER["QUERY_STRING"]);
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$objPHPExcel = new PHPExcel();
$fname = "export-search-".date("dmY_His").".xlsx";
$fnamepath = "../../upload/".$fname;
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', TRUE);

$GroupName = "All";
$objPHPExcel->getProperties()->setCreator("Disaster")
							 ->setLastModifiedBy("Disaster")
							 ->setTitle("Office 2007 XLSX Disaster Document")
							 ->setSubject("Office 2007 XLSX Disaster Document")
							 ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Disaster result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Export : '.$GroupName);
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->getStartColor()->setARGB('FFb7dee8');
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->getStartColor()->setARGB('FFb7dee8');
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->getActiveSheet()->getStyle("F2:F2")->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Last Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'KeyWord');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Count');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= " (";
  $arrf = array();
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ID';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_Keyword AS ListKeyword';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_IP AS ListIP';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_ID AS ListOrder';
	$arrf[] = _TABLE_SEARCH_LOGS_.'_SearchDate AS CreateDate';
  $arrf[] = 'TBJoin.cnt AS ListCount';
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_SEARCH_LOGS_;
  $sql .= " INNER JOIN (";
    $sql .= "SELECT "._TABLE_SEARCH_LOGS_."_Keyword AS InJoinKey,max("._TABLE_SEARCH_LOGS_."_SearchDate) max_created_at,COUNT(*) cnt FROM "._TABLE_SEARCH_LOGS_." GROUP BY "._TABLE_SEARCH_LOGS_."_Keyword";
  $sql .= ") TBJoin ON ("._TABLE_SEARCH_LOGS_."_Keyword = TBJoin.InJoinKey AND "._TABLE_SEARCH_LOGS_."_SearchDate = TBJoin.max_created_at)";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .= " ORDER BY TBmain.ListCount DESC";
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
		$ListKeyword = $Row["ListKeyword"];
		$ListCount = $Row["ListCount"];
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $CreateDate);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$startindexrow, $ListKeyword, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startindexrow, $ListCount);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$index++;
	}
}

$objPHPExcel->getActiveSheet()->setTitle('Keyword');
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
