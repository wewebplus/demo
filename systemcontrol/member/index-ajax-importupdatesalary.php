<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
include(_DIRROOTPATH_SYSTEM_.'/assets/lib/phpclass/PHPExcel/Classes/PHPExcel/IOFactory.php');
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$lkey = "Mat";
$ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
$ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
$ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');
$tmpfile = $ushowpathfile.$ushowfile;
if(is_file($tmpfile)){
  $ext = pathinfo($tmpfile, PATHINFO_EXTENSION);
  // Folder
    $pathfileimport = _RELATIVE_MEMBER_SLIP_;
    if(!is_dir($pathfileimport)) { mkdir($pathfileimport,0777); }
    $pathfileimport = _RELATIVE_MEMBER_SLIP_."fileimportsalary/";
    if(!is_dir($pathfileimport)) { mkdir($pathfileimport,0777); }
  // Folder
  $PhyFile = "import-".date("Y-m-d")."-".$myrand.".".$ext;
  if(copy($tmpfile,$pathfileimport.$PhyFile)) {
    chmod($pathfileimport.$PhyFile,0777);
    $FileSize = filesize($pathfileimport.$PhyFile);
    if(is_file($tmpfile)){unlink($tmpfile);}
    $newtmpfile = $pathfileimport.$PhyFile;
  }else{
    $newtmpfile = $tmpfile;
  }
  if($ext == "xlsx" || $ext == "xls"){
    try {
  	  $inputFileType = PHPExcel_IOFactory::identify($newtmpfile);
  	  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  	  $objReader->setReadDataOnly(false);
  	  $objPHPExcel = $objReader->load($newtmpfile);
  	} catch (Exception $e) {
  		die('Error loading file "' . pathinfo($newtmpfile, PATHINFO_BASENAME).'": '.$e->getMessage());
  	}
    //  Get worksheet dimensions
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
    $headingsArray = $headingsArray[1];
    $shiprow = 2;
    $r = 0;
    $namedDataArray = array();
    for ($row = $shiprow; $row <= $highestRow; ++$row) {
      $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
      if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
        ++$r;
        foreach($headingsArray as $columnKey => $columnHeading) {
          $namedDataArray[$r][$columnKey] = $dataRow[$row][$columnKey];
        }
      }
    }
    $pageindexF = 1;
    $pageindexT = count($namedDataArray);
    $z = new __webctrl;
    if(count($namedDataArray)>0){
      for($iix=$pageindexF;$iix<=$pageindexT;$iix++){
        $vv = $namedDataArray[$iix];
        $IDCard = trim($vv['A']);
        $Date = trim($vv['B']);
        $DateToDB = convertdatetodb($Date);
        $selectCreateMonth = date("m",strtotime($DateToDB));
        $selectCreateYear = date("Y",strtotime($DateToDB));
        $Salary = trim($vv['C']);
        $Salary = floatval(str_replace(",","",$Salary));

        // _TABLE_MEMBER_SALARY_
        $insert[_TABLE_MEMBER_SALARY_."_Filename"] = "'".sql_safe($ushowfilename)."'";
        $insert[_TABLE_MEMBER_SALARY_."_PhyFilename"] = "'".sql_safe($PhyFile)."'";
        $insert[_TABLE_MEMBER_SALARY_."_FileSize"] = "'".sql_safe($FileSize)."'";
        $insert[_TABLE_MEMBER_SALARY_."_Language"] = "'".sql_safe($_SESSION['Session_Admin_Language'])."'";
        $insert[_TABLE_MEMBER_SALARY_."_Folder"] = "'".sql_safe($FolderKey)."'";
        $insert[_TABLE_MEMBER_SALARY_."_Month"] = "'".sql_safe($selectCreateMonth)."'";
        $insert[_TABLE_MEMBER_SALARY_."_Year"] = "'".sql_safe($selectCreateYear)."'";
        $insert[_TABLE_MEMBER_SALARY_."_CreateDate"] = "NOW()";
        $insert[_TABLE_MEMBER_SALARY_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
        $insert[_TABLE_MEMBER_SALARY_."_Status"] = "'On'";
        $insert[_TABLE_MEMBER_SALARY_."_IDCard"] = "'".sql_safe($IDCard)."'";
        $insert[_TABLE_MEMBER_SALARY_."_Date"] = "'".sql_safe($DateToDB)."'";
        $insert[_TABLE_MEMBER_SALARY_."_Salary"] = sql_safe($Salary,false,true);
        $z->insert(_TABLE_MEMBER_SALARY_,$insert);
        $FileID = $z->insertid();
        unset($insert);
        // echo '<div>'.$IDCard.' '.$Date.' '.$DateToDB.' '.$Salary.'</div>';
      }
    }
    $row = count($namedDataArray);
  }else{
    $row = 0;
  }
  if(is_file($tmpfile)) {
    unlink($tmpfile);
  }
  echo "ทำการอัพเดตข้อมูลรายการ ".$row." รายการ";
}
?>
