<?php
$FolderKey = $menuFolderModule[substr($Login_MenuID,5)];
// $FolderGroupKey = $defaultdata[$Login_MenuID]["group"]["menuid"];
$DataGroup = $defaultdata[$Login_MenuID]["group"];
$Name = "";
$Email = "";
$CarType = 1;
$Module_Path_FileAttach = _RELATIVE_ENEW_UPLOAD_;
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
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <input type="hidden" name="RegisterType" value="Member">
				<input type="hidden" name="PathFileAtt" value="<?php echo $Module_Path_FileAttach?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputName"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Name?>" >
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputEmail"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Email?>" >
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
						<?php
						if(count($DataGroup)>0){
							$indexgroup = 0;
							foreach($DataGroup as $RowGroup){
								$indexgroup++;
								echo '<div class="mb10">';
									echo '<div class="checkbox-custom mb5">';
									  echo '<input type="checkbox" id="inputGroupID_'.$indexgroup.'" name="inputGroupID[]" value="'.$RowGroup["ID"].'">';
									  echo '<label for="inputGroupID_'.$indexgroup.'">'.$RowGroup["Name"].'</label>';
									echo '</div>';
								echo '</div>';
							}
						}
						?>
					</div>
				</div>
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
