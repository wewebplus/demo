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
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
$Lang = "Lang";
$myrand = md5(rand(11111,99999));
$lkey = "Mat";
$ushowfile = (!empty($_POST["ufileToUpload".$lkey."ushowfile"])?$_POST["ufileToUpload".$lkey."ushowfile"]:'');
$ushowfilename = (!empty($_POST["ufileToUpload".$lkey."ushowfilename"])?$_POST["ufileToUpload".$lkey."ushowfilename"]:'');
$ushowpathfile = (!empty($_POST["ufileToUpload".$lkey."ushowpathfile"])?$_POST["ufileToUpload".$lkey."ushowpathfile"]:'');
$tmpfile = $ushowpathfile.$ushowfile;
if(is_file($tmpfile)){
  $ext = pathinfo($tmpfile, PATHINFO_EXTENSION);
  if($ext == "xlsx" || $ext == "xls"){
    try {
  	  $inputFileType = PHPExcel_IOFactory::identify($tmpfile);
  	  $objReader = PHPExcel_IOFactory::createReader($inputFileType);
  	  $objReader->setReadDataOnly(false);
  	  $objPHPExcel = $objReader->load($tmpfile);
  	} catch (Exception $e) {
  		die('Error loading file "' . pathinfo($tempfileexcel, PATHINFO_BASENAME)
  		. '": ' . $e->getMessage());
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
      $selectMainGroup = (empty($_POST["selectMainGroup"])?0:$_POST["selectMainGroup"]);

      for($iix=$pageindexF;$iix<=$pageindexT;$iix++){
        $vv = $namedDataArray[$iix];
        $IDCard = trim($vv['A']);
        $Level = trim($vv['B']);
        $sql = "SELECT "._TABLE_MEMBER_."_ID AS ID,"._TABLE_MEMBER_."_Membertype AS Membertype,"._TABLE_MEMBER_."_Member AS Member FROM "._TABLE_MEMBER_." WHERE "._TABLE_MEMBER_."_IDCard = '".$IDCard."'";
        $z->sql($sql);
        $v = $z->row();
        $NumRow = $z->num();
        if($NumRow>0){
          $v = $z->row();
          $UpdateID = $v[0]["ID"];
          $update = array();
          $update[_TABLE_MEMBER_."_Level"] = "'".sql_safe($Level)."'";
          $update[_TABLE_MEMBER_."_LastUpdate"] = "NOW()";
        	$z->update(_TABLE_MEMBER_,$update,array(_TABLE_MEMBER_."_ID=" => (int)$UpdateID));
        	unset($update);
        }else{

        }
        // echo '<div>'.$IDCard.' '.$Level.'</div>';
      }
    }
    $row = count($namedDataArray);
  }else{
    $row = 0;
  }
  if(is_file($tmpfile)) {
    unlink($tmpfile);
  }
  echo "????????????????????????????????????????????????????????????????????? ".$row." ??????????????????";
}
?>
