<?php
$FolderKey = $menuFolder[substr($Login_MenuID,5)];
$KeyDocument = $defaultdata[$Login_MenuID]["group"]["menudoc"];
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);

$sql = "";
$ArrFieldMain[] = "TBmain.*";
$sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
$sql .= " (";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ID";
  $ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ListOrder";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Name AS Subject";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfMember AS NoOfMember";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfSend AS NoOfSend";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_CreateDate AS CreateDate";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Status AS ListStatus";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_DocumentID AS DocumentID";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_SendDate AS SendDate";
	$sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_MAIL_TASK_." TB";
	$sql .= " WHERE TB."._TABLE_MAIL_TASK_."_ID = ".(int)$itemid;
	unset($ArrField);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Name = $Row["Subject"];
$DocumentID = $Row["DocumentID"];
$SendDate = $Row["SendDate"];
$SendDate = dateformat($SendDate,'j F Y',"English");
$NewID = $ID;
$SessionID = "";//session_id();
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&myflag=Enew&SessionID='.$SessionID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:View"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitForm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="PathFileAtt" value="<?php echo $Module_Path_File?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $Name?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskDate"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $SendDate?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskNameList"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert">
						<?php
						$sqlmail = "SELECT "._TABLE_MAIL_TASKPROGRESS_."_Name,"._TABLE_MAIL_TASKPROGRESS_."_Email FROM "._TABLE_MAIL_TASKPROGRESS_." WHERE "._TABLE_MAIL_TASKPROGRESS_."_TaskID = ".intval($ID);
						$z = new __webctrl;
						$z->sql($sqlmail);
						$vMail = $z->row();
						$numMail = $z->num();
						?>
						<table id="listEmail">
								<tr class="listEmailHead">
										<td class="ipdel">&nbsp;</td>
										<td class="ipname">ชื่อ</td>
										<td class="ipemail">อีเมล์</td>
								</tr>
								<?php if($numMail>0){?>
									<?php foreach($vMail as $RowMail){?>
										<tr>
												<td class="ipdel">&nbsp;</td>
												<td class="ipname"><?php echo $RowMail[_TABLE_MAIL_TASKPROGRESS_."_Name"]?></td>
												<td class="ipemail"><?php echo $RowMail[_TABLE_MAIL_TASKPROGRESS_."_Email"]?></td>
										</tr>
										<?php }?>
								<?php }?>
						</table>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-10 frmalert">
						<?php
						$sql = "";
						$sql .= "SELECT * FROM ";
						$sql .= "("	;
							$arrf = array();
							$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_ID AS ID";
						  $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_CreateDate AS CreateDate";
							$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Status AS ListStatus";
							$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Order AS ListOrder";
							$arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_Subject AS Subject";
						  $arrf[] = "a."._TABLE_MAIL_DOCUMENT_."_HTMLFileName AS HTMLFileName";
							$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MAIL_DOCUMENT_." a";
							// $sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_Folder='".$KeyDocument."'";
							// $sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_Folder IN ('".$FolderKey ."','".$Login_MenuID."')";
						  $sql .= " WHERE "._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$DocumentID;
							unset($arrf);
						$sql .= ") TBmain";
						$sql .= " WHERE 1";
						$z->sql($sql);
						$v = $z->row();
						$Row = $v[0];
						$ID = $Row["ID"];

						$found = array();
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_ID AS ID";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_CID AS CID";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_Session AS Session";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_Subject AS Subject";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_Detail AS Detail";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_FileName AS FileName";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_FileType AS FileType";
						$ArrField[] = _TABLE_MAIL_DOCUMENT_FILE_."_Flag AS Flag";
						$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_MAIL_DOCUMENT_FILE_." WHERE 1 ";
						$sql .=" AND "._TABLE_MAIL_DOCUMENT_FILE_."_CID = ".(int)$ID;
						$sql .=" AND "._TABLE_MAIL_DOCUMENT_FILE_."_Flag = 'Enew'";
						$sql .="  ORDER BY "._TABLE_MAIL_DOCUMENT_FILE_."_Order ASC";
						unset($ArrField);
						$z->sql($sql);
						$RecordCountFile = $z->num();
						$vFile = $z->row();
						if($RecordCountFile>0) {
							foreach($vFile as $RowFile){
								$IDFile = $RowFile["ID"];
						    $ContentID = $RowFile["CID"];
						    $SessionID = $RowFile["Session"];
								$FileName = $RowFile["FileName"];
								$Detail = urldecode(!empty($RowFile["Detail"])?$RowFile["Detail"]:'');
						    $Subject = urldecode(!empty($RowFile["Subject"])?$RowFile["Subject"]:'');
						    $FileType = $RowFile["FileType"];
						    $FullpathFilePath = "../assets/img/file_ext/".$FileType.".png";
						    // if(intval($ContentID)>0){
						    //   $FilePathLogoFromDB = _RELATIVE_ENEW_UPLOAD_.$ContentID."/".$FileName;
						    // }else{
						    //   $FilePathLogoFromDB = _RELATIVE_ENEW_UPLOAD_.$SessionID."/".$FileName;
						    // }
								$FilePathLogoFromDB = $PathUploadFile.$FileName;
						    $datadwn = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$IDFile);
						    if (!is_file($FilePathLogoFromDB)) {
									$URLFile = "javascript:void(0)";
								}else{
									$URLFile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$FilePathLogoFromDB);
						      $URLFile = '<a href="'.$URLFile.'" target="_blank" download="'.$Subject.'">'.$Subject.'</a>';
								}
								$arr['ID'] = $IDFile;
								$arr['Detail'] = $Detail;
								$arr['URLFile'] = $URLFile;
						    $arr['FileType'] = $FileType;
						    $arr['FileTypeShow'] = $FullpathFilePath;
						    $arr['DataDWN'] = $datadwn;
								$found[] = $arr;
							}
						}

						$CarType = 1;
						$Name = $Row["Subject"];
						$html = "";
		        $html = $PathUploadHtml.$Row['HTMLFileName'];
		        if(is_file($html)){
		          $html = file_get_contents($html);
		        }else{
		          $html = "";
		        }
						echo '<h3>'.$Name.'</h3>';
						if(count($found)>0){
							echo '<div class="boxrelatefile">';
							foreach($found as $InFile){
								echo '<div class="boxinnerrelate" id="'.$InFile["ID"].'">';
					        echo '<div class="relatelineimg"><a href="javascript:void(0)" rev="'.$InFile["DataDWN"].'" onclick="DownloadDocument(this)"><img src="'.$InFile["FileTypeShow"].'" border="0" class="thumbgallery" /></a></div>';
					        echo '<div class="relatelineinfo">';
					          echo '<div class="relatelinedetail">'.$InFile["Detail"].'</div>';
										echo '<div class="relatelinebtn">';
											echo '<a href="javascript:void(0)" rev="'.$InFile["DataDWN"].'" class="relateicon" onclick="DownloadDocument(this)"><i class="fa fa-download"></i></a>';
										echo '</div>';
					        echo '</div>';
					      echo '</div>';
							}
							echo '</div>';
						}
						echo '<div>'.$html.'</div>';
						?>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
