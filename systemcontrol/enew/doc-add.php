<?php
$Name = "";
$CarType = 1;
$PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
$PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ENEW_UPLOAD_);
$PathUploadFile = (isset($defaultdata[$Login_MenuID]["path"]["FILE"])?$defaultdata[$Login_MenuID]["path"]["FILE"]:_RELATIVE_ENEW_UPLOAD_);
if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }
if(!is_dir($PathUploadFile)) { mkdir($PathUploadFile,0777); }
$NewID = 0;
$SessionID = session_id();
$PictureFile = "";
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID=0&itemid=0&myflag=Enew&SessionID='.$SessionID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
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
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputDocSubject"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputDocSubject"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Name?>" >
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
                  echo '<div id="progressuploadFile'.$typeUpload.'" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>';
                  echo '<div id="outputuploadFile'.$typeUpload.'Error"><!-- error or success results --></div>';
                echo '</td>';
              echo '</tr>';
              echo '<tr>';
                echo '<td class="colright">';
                  echo '<div class="postuploadicon">';
                    echo '<label for="uploadFile'.$typeUpload.'" class="labeluploadfile">';
                      echo '<img src="./img/button/uploadnow.jpg" alt="" />';
                    echo '</label>';
                    echo '<input id="uploadFile'.$typeUpload.'" name="uploadFile'.$typeUpload.'" type="file" class="uploadFile" />';
                  echo '</div>';
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
        echo '<div class="row section">';
          echo '<div class="col-md-12">';
            echo '<h4>'.$Array_Mod_Lang["txtinput:inputDetail"][$_SESSION['Session_Admin_Language']].'</h4>';
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="col-md-12">';
          echo '<div class="section">';
            echo '<textarea id="inputDetail" name="inputDetail" rows="12">'.$html.'</textarea>';
          echo '</div>';
          echo '</div>';
        echo '</div>';
        ?>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="submit" class="button btn-primary"><?php echo "Save ".$mymenuname?></button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
