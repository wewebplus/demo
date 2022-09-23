<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$MemberLevel = "User";
$MemberLevelText = $arrMemberLevel[$MemberLevel];
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Addnew"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2 frmalert">
						<input type="text" name="<?php echo "inputAName"?>" class="gui-input reqs" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputAName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <div class="col-md-4 frmalert">
						<input type="text" name="<?php echo "inputFName"?>" class="gui-input reqs" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputFName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
          <div class="col-md-4 frmalert">
						<input type="text" name="<?php echo "inputLName"?>" class="gui-input reqs" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputLName"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputRefNo"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
						<input type="text" name="<?php echo "inputRefNo"?>" class="gui-input reqs" value="" maxlength="13" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputRefNo"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGender"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 mt10">
            <div class="radio-custom radio-primary mb5">
              <input type="radio" id="inputGenderM" name="inputGender" checked="checked" value="M">
              <label for="inputGenderM">เพศชาย</label>
            </div>
					</div>
          <div class="col-md-3 mt10">
            <div class="radio-custom radio-primary mb5">
              <input type="radio" id="inputGenderF" name="inputGender" value="F">
              <label for="inputGenderF">เพศหญิง</label>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBirthday"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-1">
            <?php
            echo '<select class="form-control" name="BirthdaySelectDay">';
              echo '<option value="00">วัน</option>';
              for($i=1;$i<=31;$i++){
                echo '<option value="'.formatStringtoZero($i,2).'">'.$i.'</option>';
              }
            echo '</select>';
            ?>
					</div>
          <div class="col-md-3">
            <?php
            echo '<select class="form-control" name="BirthdaySelectMonth">';
              foreach($Array_Lang['txt:monthNames'][$_SESSION['Session_Admin_Language']] as $km=>$vm){
                echo '<option value="'.formatStringtoZero($km,2).'">'.$vm.'</option>';
              }
            echo '</select>';
            ?>
					</div>
          <div class="col-md-2">
            <?php
            $yearstart = date("Y")-10;
            $yearend = date("Y")-90;
            echo '<select class="form-control" name="BirthdaySelectYear">';
              echo '<option value="0000">ปี</option>';
              for($i=$yearstart;$i>=$yearend;$i--){
                echo '<option value="'.formatStringtoZero($i,4).'">'.$i.'</option>';
              }
            echo '</select>';
            ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputUsername"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
						<input type="text" name="<?php echo "inputUsername"?>" class="gui-input reqs" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputUsername"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPassword"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
						<input type="password" name="<?php echo "inputPassword"?>" id="<?php echo "inputPassword"?>" class="gui-input reqs" value="" maxlength="100" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputPassword"][$_SESSION['Session_Admin_Language']]?>">
            <span toggle="#inputPassword" class="fa fa-lg fa-eye-slash field-icon toggle-password"></span>
					</div>
          <div class="col-md-7" id="ErrorPassResult"></div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputConfirmPassword"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3 frmalert">
						<input type="password" name="<?php echo "inputConfirmPassword"?>" id="<?php echo "inputConfirmPassword"?>" class="gui-input reqs" value="" maxlength="100" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputConfirmPassword"][$_SESSION['Session_Admin_Language']]?>">
            <span toggle="#inputConfirmPassword" class="fa fa-lg fa-eye-slash field-icon toggle-password"></span>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCountry"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-10 frmalert bs-component">
						<?php
            $dataCountry = getListCountry();
						echo '<label class="field select">';
              echo '<input type="hidden" name="inputCountry" class="gui-input" value="">';
							echo '<select name="selectCountry" data-rule-required="true" data-msg-required="Select Group">';
							echo '<option value=""> - - Select Country - - </option>';
              if($dataCountry->datacount>0){
                foreach($dataCountry->data as $gk=>$gv){
  								echo '<option value="'.$gv["code"].'">'.$gv["name"].'</option>';
  							}
              }
							echo '</select>';
							echo '<i class="arrow"></i>';
						echo '</label>';
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputEmail"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputTelephone"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputTelephone"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-6">
						<input type="text" name="<?php echo "inputFax"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputFax"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
						<input type="text" name="<?php echo "inputPosition"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputPosition"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
          <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputProvince"][$_SESSION['Session_Admin_Language']]?></label>
          <div class="col-lg-3">
            <div class="bs-component">
              <?php
              $ProvinceInfo = getListProvince();
              if($ProvinceInfo->datacount>0){
                echo '<input type="hidden" name="inputProvince" class="gui-input" value="">';
                echo '<select name="selectProvince" class="form-control">';
                echo '<option value=""> - - เลือกจังหวัด - - </option>';
                foreach($ProvinceInfo->data as $gk=>$gv){
                  echo '<option value="'.$gv["code"].'">'.$gv["name"].'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
						<input type="text" maxlength="5" name="<?php echo "inputZipCode"?>" class="gui-input" value="" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputZipCode"][$_SESSION['Session_Admin_Language']]?>">
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputLevel"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-2">
            <div class="bs-component">
              <?php
              if($ProvinceInfo->datacount>0){
                echo '<input type="hidden" name="inputLevel" class="gui-input" value="'.$MemberLevelText.'">';
                echo '<select name="selectLevel" class="form-control">';
                echo '<option value=""> - - Level - - </option>';
                foreach($arrMemberLevel as $gk=>$gv){
                  echo '<option value="'.$gk.'" '.($MemberLevel==$gk?'selected="selected"':'').'>'.$gv.'</option>';
                }
                echo '</select>';
              }
              ?>
            </div>
					</div>
				</div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 04"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
          <label for="inputStandard" class="col-lg-2 control-label">Images</label>
          <div class="col-lg-8">
            <div class="bs-component">
              <?php
              $lkeyindex = "Home";
              ?>
              <div id="progress<?php echo $lkeyindex?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
              <div id="output<?php echo $lkeyindex?>"><!-- error or success results --></div>
              <div class="showoption" id="showoption<?php echo $lkeyindex?>"></div>
              <div class="postuploadicon">
                <label for="fileToUpload<?php echo $lkeyindex?>" class="labeluploadfile">
                  <img src="./images/uploadnow.jpg" />
                </label> <span><?php echo "min size ".$defaultdata[$Login_MenuID]["imghome"]["W"]." * ".$defaultdata[$Login_MenuID]["imghome"]["H"]." px."?></span>
                <input name="fileToUpload<?php echo $lkeyindex?>" class="uploadFile" type="file" id="fileToUpload<?php echo $lkeyindex?>" accept="image/*" onChange="return ajaxuFileUploadProgressImg(this);" />
              </div>

            </div>
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
