<?php
ob_start();
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
require_once(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/PHPExcel/Classes/PHPExcel.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
decode_URL($_SERVER["QUERY_STRING"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$DataRegion = $defaultdata[$Login_MenuID]["region"];

$sessioncode = session_id();
$mytempfile = _RELATIVE_TEMP_UPLOAD_.$sessioncode;
if(!is_dir($mytempfile)) { mkdir($mytempfile,0777); }
$fname = "export-territory.xlsx";
$fnamepath = $mytempfile."/".$fname;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', TRUE);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Thaiselect")->setLastModifiedBy("Thaiselect")->setTitle("Office 2007 XLSX Thaiselect Document")->setSubject("Office 2007 XLSX Thaiselect Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Thaiselect result file");

$MStyle = array(
  'borders' => array(
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'left' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'right' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    )
  )
);
$NStyle = array(
  'borders' => array(
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'left' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'right' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    ),
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '000000')
    )
  ),
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
         'rgb' => 'd9e1f2'
    )
  )
);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'No');
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->getStyle("A1:A2")->applyFromArray($MStyle);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'สคต.');
$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
$objPHPExcel->getActiveSheet()->getStyle("B1:B2")->applyFromArray($MStyle);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'ประเทศ');
$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
$objPHPExcel->getActiveSheet()->getStyle("C1:C2")->applyFromArray($MStyle);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'เขตอาณาความรับผิดชอบของสคต.');
$objPHPExcel->getActiveSheet()->mergeCells('D1:E1');
$objPHPExcel->getActiveSheet()->getStyle("D1:E1")->applyFromArray($MStyle);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'ภายในประเทศที่ประจำการ');
$objPHPExcel->getActiveSheet()->getStyle("D2")->applyFromArray($MStyle);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'ภายนอกประเทศที่ประจำการ');
$objPHPExcel->getActiveSheet()->getStyle("E2")->applyFromArray($MStyle);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$startindexrow = 3;
$index = 0;
$z = new __webctrl;
foreach($DataRegion as $RowRegion){
  $dataGroup = $RowRegion["ID"];
  $dataGroupName = $RowRegion["Name"];
  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$startindexrow,$dataGroupName,PHPExcel_Cell_DataType::TYPE_STRING);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$startindexrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$startindexrow.':E'.$startindexrow)->applyFromArray($NStyle);
  $objPHPExcel->getActiveSheet()->mergeCells('A'.$startindexrow.':E'.$startindexrow);
  $startindexrow++;

  $sql = "";
  $sql .= "SELECT * FROM ";
  $sql .= "("	;
    $ArrField = array();
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_ID AS ID";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionID AS _RegionID";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_RegionName AS _RegionName";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Name AS _Name";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CountryName AS CountryName";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_CreateDate AS CreateDate";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Order AS ListOrder";
    $ArrField[] = _TABLE_ADMIN_TERRITORY_."_Status AS ListStatus";
    $sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_;
    $sql .= " WHERE 1";
    $sql .= " AND "._TABLE_ADMIN_TERRITORY_."_RegionID = ".intval($dataGroup);
  	unset($ArrField);
  $sql .= ") TBmain";
  $sql .= " WHERE 1";
  $z->sql($sql);
  $RecordCount = $z->num();
  $v = $z->row();
  if($RecordCount>0) {
    foreach($v as $Row){
      $index++;
      $ID = $Row["ID"];
      $_RegionName = $Row["_RegionName"];
      $_Name = $Row["_Name"];
      $CountryName = $Row["CountryName"];
      $ArrField = array();
      $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_internal_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_internal_StateName , "._TABLE_ADMIN_TERRITORY_."_internal_CountryName) AS StateName";
      $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_internal WHERE "._TABLE_ADMIN_TERRITORY_."_internal_TerritoryID = ".intval($ID);
      unset($ArrField);
      $z->sql($sql);
      $vInternal = $z->row();
      $vArrProvince_I = array_column($vInternal, 'StateName');

      $ArrField = array();
      $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_external_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_external_StateName , "._TABLE_ADMIN_TERRITORY_."_external_CountryName) AS StateName";
      $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_external WHERE "._TABLE_ADMIN_TERRITORY_."_external_TerritoryID = ".intval($ID);
      unset($ArrField);
      $z->sql($sql);
      $vExternal = $z->row();
      $vArrCountru_E = array_column($vExternal, 'StateName');

      $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$startindexrow,$index,PHPExcel_Cell_DataType::TYPE_STRING);
      $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$startindexrow,$_Name,PHPExcel_Cell_DataType::TYPE_STRING);
      $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$startindexrow,$CountryName,PHPExcel_Cell_DataType::TYPE_STRING);
      $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$startindexrow,implode(",",$vArrProvince_I),PHPExcel_Cell_DataType::TYPE_STRING);
      $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$startindexrow,implode(",",$vArrCountru_E),PHPExcel_Cell_DataType::TYPE_STRING);

      $startindexrow++;
    }
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
