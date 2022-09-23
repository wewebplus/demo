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
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }

$dataitemid = (int)$_POST["dataitemid"];
$action = trim($_POST["action"]);
	switch ($action) {
	   case 'delete' :
				if($_SESSION['Session_Admin_ID']>0){
					if($dataitemid>0){
						$sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_CID,"._TABLE_MAIL_DOCUMENT_FILE_."_FileName,"._TABLE_MAIL_DOCUMENT_FILE_."_Session FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE "._TABLE_MAIL_DOCUMENT_FILE_."_ID = ".(int)$dataitemid;
						$z = new __webctrl;
						$z->sql($sql);
						$RecordCount = $z->num();
						$v = $z->row();
						$Row = $v[0];
						// Path
            $ContentID = $Row[_TABLE_MAIL_DOCUMENT_FILE_."_CID"];
            $FileName = $Row[_TABLE_MAIL_DOCUMENT_FILE_."_FileName"];
            $SessionID = $Row[_TABLE_MAIL_DOCUMENT_FILE_."_Session"];
						if(strlen($FileName)>0) {
              // if(intval($ContentID)>0){
              //   $ThumbFile = _RELATIVE_ENEW_UPLOAD_.$ContentID."/".$FileName;
              // }else{
              //   $ThumbFile = _RELATIVE_ENEW_UPLOAD_.$SessionID."/".$FileName;
              // }
              $ThumbFile = $PathUploadFile.$FileName;
							if(is_file($ThumbFile)) {
								unlink($ThumbFile);
							}
						}
						$z = new __webctrl;
						$z->del(_TABLE_MAIL_DOCUMENT_FILE_,array(_TABLE_MAIL_DOCUMENT_FILE_."_ID=" => (int)$dataitemid));
						echo 1;
					}
				}
		  break;
			case 'selecttxt' :
				$sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_ID AS ID,"._TABLE_MAIL_DOCUMENT_FILE_."_CID AS CID,"._TABLE_MAIL_DOCUMENT_FILE_."_Detail AS Detail FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE "._TABLE_MAIL_DOCUMENT_FILE_."_ID = ".(int)$dataitemid;
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
				$update[_TABLE_MAIL_DOCUMENT_FILE_."_Detail"] = "'".sql_safe($detail)."'";
				$z = new __webctrl;
				$z->update(_TABLE_MAIL_DOCUMENT_FILE_,$update,array(_TABLE_MAIL_DOCUMENT_FILE_."_ID=" => $dataitemid));
				unset($update);

				$sql = "SELECT "._TABLE_MAIL_DOCUMENT_FILE_."_ID AS ID,"._TABLE_MAIL_DOCUMENT_FILE_."_CID AS CID,"._TABLE_MAIL_DOCUMENT_FILE_."_Detail AS Detail FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE "._TABLE_MAIL_DOCUMENT_FILE_."_ID = ".(int)$dataitemid;
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
				     $update[_TABLE_MAIL_DOCUMENT_FILE_."_Order"] = "'".(int)$i."'";
				     $z = new __webctrl;
				     $z->update(_TABLE_MAIL_DOCUMENT_FILE_,$update,array(_TABLE_MAIL_DOCUMENT_FILE_."_ID=" => (int)$ArrOrder[$i]));
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
