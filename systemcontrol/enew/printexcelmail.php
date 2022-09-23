<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$selectLevel = (!empty($_GET["selectLevel"])?$_GET["selectLevel"]:'');
$selectGroup = intval(!empty($_GET["selectGroup"])?$_GET["selectGroup"]:0);
decode_URL($_SERVER["QUERY_STRING"]);
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
$GroupData = $defaultdata[$Login_MenuID]["group"];
// echo '<pre>';
// print_r($GroupData);
$objPHPExcel = new PHPExcel();
$fname = "export-mail-".date("dmY_His").".xlsx";
$fnamepath = "../../upload/".$fname;
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', TRUE);
$GroupName = "All";

$objPHPExcel->getProperties()->setCreator("Bendix")
							 ->setLastModifiedBy("Bendix")
							 ->setTitle("Office 2007 XLSX Bendix Document")
							 ->setSubject("Office 2007 XLSX Bendix Document")
							 ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Bendix result file");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Export : '.$GroupName);
$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FFb7dee8');
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFill()->getStartColor()->setARGB('FFb7dee8');
$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$objPHPExcel->getActiveSheet()->getStyle("F2:F2")->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Content Name');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Content Email');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Create Date');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'Group');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ID";
  $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_CreateDate AS CreateDate";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_ID AS ListOrder";
	$arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Name AS Name";
  $arrf[] = "a."._TABLE_MAIL_MAILLIST_."_Email AS Email";
  $arrf[] = "TBGroup.GroupID AS GroupID";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_MAILLIST_." a";
  $sql .= " LEFT JOIN (";
    $sql .= "SELECT "._TABLE_MAIL_MAILLISTINGROUP_."_MailListID AS MailListID,GROUP_CONCAT("._TABLE_MAIL_MAILLISTINGROUP_."_GroupID) AS GroupID FROM "._TABLE_MAIL_MAILLISTINGROUP_." WHERE 1 GROUP BY "._TABLE_MAIL_MAILLISTINGROUP_."_MailListID";
  $sql .= ") TBGroup ON ("._TABLE_MAIL_MAILLIST_."_ID = TBGroup.MailListID)";
	$sql .= " WHERE a."._TABLE_MAIL_MAILLIST_."_Folder='".$FolderKey."'";
  if(!empty($selectLevel)){
    $sql .= " AND a."._TABLE_MAIL_MAILLIST_."_InType='".$selectLevel."'";
  }
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
if($selectGroup>0){
  $sql .= " AND ";
  $sql .= "FIND_IN_SET(".$selectGroup.", TBmain.GroupID)";
}
$sql .= " ORDER BY TBmain.ListOrder DESC,TBmain.ID DESC";
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
		$Name = $Row["Name"];
		$Email = $Row["Email"];
		$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');
    $GroupID = $Row["GroupID"];
    if(!empty($GroupID)){
      $query = "ID='".$GroupID."'";
      $mydata = ArraySearch($GroupData,$query,1);
      $FullGroupname = @$GroupData[array_key_first($mydata)]["Name"];
      $FullGroupname = echoDetailToediter($FullGroupname);
    }else{
      $FullGroupname = "";
    }
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startindexrow, $Name);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$startindexrow, $Email, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$startindexrow, $CreateDate, PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startindexrow, $FullGroupname);
		$index++;
	}
}
$objPHPExcel->getActiveSheet()->setTitle('Mail');
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
