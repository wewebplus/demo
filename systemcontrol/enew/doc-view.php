<?php
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
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
	$sql .= " WHERE a."._TABLE_MAIL_DOCUMENT_."_ID = ".(int)$itemid;
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$CarType = 1;
$Name = $Row["Subject"];
$NewID = $ID;
$SessionID = "";//session_id();
$PictureFile = "";
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
				<input type="hidden" name="PathFileAtt" value="<?php echo $PathUploadFile?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDocSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $Name?></p>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFileSubject"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <div class="bs-component">
              <?php
              $typeUpload = "Enew";
              echo '<input name="UploadToFile" type="hidden" value="'.$ArrFileUpload[$typeUpload].'" >';
              echo '<table class="boxuploadfile">';
              echo '<tr>';
                echo '<td class="colright">';
                  echo '<div class="Recommended">Recommended : extention file '.$ArrFileType[$typeUpload].'</div>';
                  echo '<div id="outputuploadFile'.$typeUpload.'"></div>';
                echo '</td>';
              echo '</tr>';
              echo '</table>';
              ?>
            </div>
					</div>
				</div>
        <?php
        $html = "";
        $html = $PathUploadHtml.$Row['HTMLFileName'];
        if(is_file($html)){
          $html = file_get_contents($html);
        }else{
          $html = "";
        }
        echo $html;
        ?>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="button" id="EditBtn" class="button btn-primary"><?php echo "Edit ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
