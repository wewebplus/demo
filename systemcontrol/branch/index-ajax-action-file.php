<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
include(_DIRROOTPATH_SYSTEM_."/dataarray/dataarray.php");
$saveData = trim($_POST['saveData']);
decode_URL($saveData);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");

$dataitemid = (int)$_POST["dataitemid"];
$action = trim($_POST["action"]);
	switch ($action) {
	   case 'delete' :
        $PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_TEMP_UPLOAD_);
        $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_TEMP_UPLOAD_);
				if($_SESSION['Session_Admin_ID']>0){
					if($dataitemid>0){
						$sql = "SELECT "._TABLE_RESTAURANT_FILE_."_ContentID,"._TABLE_RESTAURANT_FILE_."_FileName,"._TABLE_RESTAURANT_FILE_."_FileType AS FileType,"._TABLE_RESTAURANT_FILE_."_Session,"._TABLE_RESTAURANT_FILE_."_AddIndex AS AddIndex FROM "._TABLE_RESTAURANT_FILE_." WHERE "._TABLE_RESTAURANT_FILE_."_ID = ".(int)$dataitemid;
						$z = new __webctrl;
						$z->sql($sql);
						$RecordCount = $z->num();
						$v = $z->row();
						$Row = $v[0];
						// Path
            $ContentID = $Row[_TABLE_RESTAURANT_FILE_."_ContentID"];
            $FileName = $Row[_TABLE_RESTAURANT_FILE_."_FileName"];
            $SessionID = $Row[_TABLE_RESTAURANT_FILE_."_Session"];
            $FileType = $Row["FileType"];
            $AddIndex = $Row["AddIndex"];
            if($FileType=='jpg' || $FileType=='jpeg' || $FileType=='png'){
              $PathUpload = $PathUploadPicture;
            }else{
              $PathUpload = $PathUploadFile;
            }
						if(strlen($FileName)>0) {
              if(intval($ContentID)>0){
                if($AddIndex=="Old"){
                  $ThumbFile = $PathUpload.$FileName;
                }else{
                  $ThumbFile = $PathUpload.$ContentID."/".$FileName;
                }
              }else{
                $ThumbFile = $PathUpload.$SessionID."/".$FileName;
              }
							if(is_file($ThumbFile)) {
								unlink($ThumbFile);
							}
						}
						$z = new __webctrl;
						$z->del(_TABLE_RESTAURANT_FILE_,array(_TABLE_RESTAURANT_FILE_."_ID=" => (int)$dataitemid));
						echo 1;
					}
				}
		  break;
			case 'selecttxt' :
				$sql = "SELECT "._TABLE_RESTAURANT_FILE_."_ID AS ID,"._TABLE_RESTAURANT_FILE_."_ContentID AS CID,"._TABLE_RESTAURANT_FILE_."_Subject AS Detail FROM "._TABLE_RESTAURANT_FILE_." WHERE "._TABLE_RESTAURANT_FILE_."_ID = ".(int)$dataitemid;
        $z = new __webctrl;
				$z->sql($sql);
				$RecordCount = $z->num();
				$v = $z->row();
				$Row = $v[0];
				$ID = $Row["ID"];
				$Detail = (!empty($Row["Detail"])?$Row["Detail"]:'');
				$output['ID'] = $ID;
				$output['Detail'] = $Detail;
				echo json_encode($output);
				exit();
			break;
			case 'savetxt' :
				$detail = $_POST["datadetail"];
				$update[_TABLE_RESTAURANT_FILE_."_Subject"] = "'".sql_safe($detail)."'";
				$z = new __webctrl;
				$z->update(_TABLE_RESTAURANT_FILE_,$update,array(_TABLE_RESTAURANT_FILE_."_ID=" => $dataitemid));
				unset($update);

				$sql = "SELECT "._TABLE_RESTAURANT_FILE_."_ID AS ID,"._TABLE_RESTAURANT_FILE_."_ContentID AS CID,"._TABLE_RESTAURANT_FILE_."_Subject AS Detail FROM "._TABLE_RESTAURANT_FILE_." WHERE "._TABLE_RESTAURANT_FILE_."_ID = ".(int)$dataitemid;
				$z = new __webctrl;
				$z->sql($sql);
				$RecordCount = $z->num();
				$v = $z->row();
				$Row = $v[0];
				$ID = $Row["ID"];
				$Detail = (!empty($Row["Detail"])?$Row["Detail"]:'');
				$output['ID'] = $ID;
				$output['Detail'] = $Detail;
				echo json_encode($output);
				exit();
			break;
			case 'sortcontent' :
				$myorder = $_POST['dataorder'];
				$ArrOrder = explode('|x|',$myorder);
				$counArr = count($ArrOrder);
				if($counArr>0){
				 for($i=1;$i<$counArr;$i++){
				   if($value <> 'null'){
				     $update[_TABLE_RESTAURANT_FILE_."_Order"] = "'".(int)$i."'";
				     $z = new __webctrl;
				     $z->update(_TABLE_RESTAURANT_FILE_,$update,array(_TABLE_RESTAURANT_FILE_."_ID=" => (int)$ArrOrder[$i]));
				     unset($update);
				   }
				 }
				}
				$output['ID'] = 0;
				$output['Detail'] = $myorder;
				echo json_encode($output);
				exit();
			break;
	   default :
		  echo "error\n";
	}

CloseDB();
?>
