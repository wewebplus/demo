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
	   case 'deletephoto' :
        $PathUploadGallery = (isset($defaultdata[$Login_MenuID]["path"]["GALLERY"])?$defaultdata[$Login_MenuID]["path"]["GALLERY"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
				if($_SESSION['Session_Admin_ID']>0){
					if($dataitemid>0){

						$sql = "SELECT "._TABLE_CONTENT_PIC_."_ContentID,"._TABLE_CONTENT_PIC_."_FileName,"._TABLE_CONTENT_PIC_."_AddIndex AS AddIndex FROM "._TABLE_CONTENT_PIC_." WHERE "._TABLE_CONTENT_PIC_."_ID = ".(int)$dataitemid;
						$z = new __webctrl;
						$z->sql($sql);
						$RecordCount = $z->num();
						$v = $z->row();
						$Row = $v[0];
            $AddIndex = $Row["AddIndex"];
						// Path
						if(strlen($Row[_TABLE_CONTENT_PIC_."_FileName"])>0) {
              if($AddIndex=="Old"){
                $GalleryPath = $PathUploadGallery;
              }else{
                $GalleryPath = $PathUploadGallery."gallery".$mymenuinclude.$Row[_TABLE_CONTENT_PIC_."_ContentID"];
              }
							if(file_exists($GalleryPath."/".$Row[_TABLE_CONTENT_PIC_."_FileName"])) {
								unlink($GalleryPath."/".$Row[_TABLE_CONTENT_PIC_."_FileName"]);
							}
							if(file_exists($GalleryPath."/thm-".$defaultdata[$Login_MenuID]["gallery"]["W"]."-".$Row[_TABLE_CONTENT_PIC_."_FileName"])) {
								unlink($GalleryPath."/thm-".$defaultdata[$Login_MenuID]["gallery"]["W"]."-".$Row[_TABLE_CONTENT_PIC_."_FileName"]);
							}
						}
						$z = new __webctrl;
						$z->del(_TABLE_CONTENT_PIC_,array(_TABLE_CONTENT_PIC_."_ID=" => (int)$dataitemid));
						echo 1;
					}
				}
		  break;
			case 'selecttxtphoto' :
				$sql = "SELECT "._TABLE_CONTENT_PIC_."_ID AS ID,"._TABLE_CONTENT_PIC_."_ContentID AS CID,"._TABLE_CONTENT_PIC_."_Detail AS Detail FROM "._TABLE_CONTENT_PIC_." WHERE "._TABLE_CONTENT_PIC_."_ID = ".(int)$dataitemid;
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
			case 'savetxtphoto' :
				$detail = $_POST["datadetail"];
				$update[_TABLE_CONTENT_PIC_."_Detail"] = "'".sql_safe($detail)."'";
				$z = new __webctrl;
				$z->update(_TABLE_CONTENT_PIC_,$update,array(_TABLE_CONTENT_PIC_."_ID=" => $dataitemid));
				unset($update);

				$sql = "SELECT "._TABLE_CONTENT_PIC_."_ID AS ID,"._TABLE_CONTENT_PIC_."_ContentID AS CID,"._TABLE_CONTENT_PIC_."_Detail AS Detail FROM "._TABLE_CONTENT_PIC_." WHERE "._TABLE_CONTENT_PIC_."_ID = ".(int)$dataitemid;
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
				     $update[_TABLE_CONTENT_PIC_."_Order"] = "'".(int)$i."'";
				     $z = new __webctrl;
				     $z->update(_TABLE_CONTENT_PIC_,$update,array(_TABLE_CONTENT_PIC_."_ID=" => (int)$ArrOrder[$i]));
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
