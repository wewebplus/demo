<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");

$saveData = $_POST["saveData"];
decode_URL($saveData);

$myfolder = _RELATIVE_STOCKFILE_UPLOAD_;
if(!is_dir($myfolder)) { mkdir($myfolder,0777); }

$fileList = $_POST["fileList"];
//print_r($fileList);
//echo count($fileList);
//_TABLE_CMS_PIC_
if(count($fileList)>0){
  foreach($fileList as $picval){
    //print_r($picval);
    if(is_file($picval["serverFileName"])){
      $arphyfile = explode("/",$picval["serverFileName"]);
      $phyfile = $arphyfile[count($arphyfile)-1];
      $newpathfile = $myfolder.$phyfile;
      if(copy($picval["serverFileName"],$newpathfile)) {
        chmod($newpathfile,0777);

        $ext = pathinfo($newpathfile, PATHINFO_EXTENSION);

        $sql = "SELECT MAX("._TABLE_STOCKFILE_."_Order) AS MaxO FROM "._TABLE_STOCKFILE_." WHERE 1";
        $z = new __webctrl;
        $z->sql($sql);
        $v = $z->row();
        $Row = $v[0];
        $MaxOrder = $Row["MaxO"]+1;

        $insert[_TABLE_STOCKFILE_.'_Key'] = "'".$Login_MenuID."'";
        $insert[_TABLE_STOCKFILE_.'_CreateDate'] = "NOW()";
        $insert[_TABLE_STOCKFILE_.'_LastUpdate'] = "NOW()";
        $insert[_TABLE_STOCKFILE_.'_CreateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
        $insert[_TABLE_STOCKFILE_.'_UpdateByID'] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
        $insert[_TABLE_STOCKFILE_.'_Order'] = sql_safe($MaxOrder,false,true);
        $insert[_TABLE_STOCKFILE_.'_Status'] = "'On'";
        $insert[_TABLE_STOCKFILE_.'_Name'] = "'".sql_safe($picval["fileName"])."'";
        $insert[_TABLE_STOCKFILE_.'_File'] = "'".sql_safe($phyfile)."'";
        $insert[_TABLE_STOCKFILE_.'_FileType'] = "'".sql_safe($ext)."'";
        $z = new __webctrl;
        $z->insert(_TABLE_STOCKFILE_,$insert);
        $insertid = $z->insertid();
        unset($insert);
        unlink($picval["serverFileName"]);
      }
    }
    //echo $phyfile.":".$picval["fileName"].":".$picval["serverFileName"];//fileName
  }
}
echo "OK";
CloseDB();
?>
