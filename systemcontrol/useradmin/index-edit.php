<?php
  $sql="SELECT * FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $num = $z->num();
  $Row = $v[0];
  $ID = $Row[_TABLE_ADMIN_USER_."_ID"];
  $Username = $Row[_TABLE_ADMIN_USER_."_UserName"];
  $SelectUserType = $Row[_TABLE_ADMIN_USER_."_Type"];
  $SelectEmployee = $Row[_TABLE_ADMIN_USER_."_EmpID"];
  $Level = $Row[_TABLE_ADMIN_USER_."_Level"];
  $Remark = decodetxterea($Row[_TABLE_ADMIN_USER_."_Remark"]);

  $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<!-- edit panel -->
<div class="panel mb25 mt5">
  <div class="panel-heading">
    <span class="panel-title hidden-xs"> Edit <?php echo $mymenuname?></span>
  </div>
  <div class="panel-body p20 pb10">
  <form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post">
    <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
      <div class="tab-content pn br-n admin-form">
        <div class="tab-pane active">
          <div id="tab1_1" class="tab-pane active">
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Lang["txt:Username"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-4">
                  <div class="bs-component">
                    <label for="firstname" class="field prepend-icon">
                      <input type="text" name="inputUsername" id="inputUsername" class="event-name gui-input br-light light" value="<?php echo $Username?>" placeholder="<?php echo $Array_Lang["txt:Username"][$_SESSION['Session_Admin_Language']]?>">
                      <label for="firstname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-4">
                  <div class="bs-component">
                    <label for="firstname" class="field prepend-icon">
                      <input type="password" name="inputPassword" id="inputPassword" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?>">
                      <label for="firstname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="bs-component">
                    <label for="firstname" class="field prepend-icon">
                      <input type="password" name="inputConfirmPassword" id="inputConfirmPassword" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Lang["txt:Confirm Password"][$_SESSION['Session_Admin_Language']]?>">
                      <label for="firstname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
              </div>
            </div>
            <div class="section-divider mb40" id="spy1">
              <span>User Policy</span>
            </div>
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select Employee"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-4">
                <div class="bs-component">
                  <?php
                      $arrEmployee = getEmployee(1,0,0,intval($SelectEmployee));
                      if($arrEmployee->mycount > 0){
                        echo '<select name="SelectEmployee" id="SelectEmployee" class="form-control select2_single">';
                          echo '<option value=""> - '.$Array_Mod_Lang["txt:Select Employee"][$_SESSION['Session_Admin_Language']].' - </option>';
                          foreach($arrEmployee->ID as $key=>$val){
                            echo '<option value="'.$val.'" '.($SelectEmployee==$val?'selected="selected"':'').'>'.$arrEmployee->FullName[$key].'</option>';
                          }
                        echo '</select>';
                      }
                  ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select User Type"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-4">
                <div class="bs-component">
                  <?php
                      $arrUserType = getusertype();
                      if($arrUserType->mycount > 0){
                        echo '<select name="SelectUserType" id="SelectUserType" class="form-control">';
                          echo '<option value=""> - '.$Array_Mod_Lang["txt:Select User Type"][$_SESSION['Session_Admin_Language']].' - </option>';
                          foreach($arrUserType->ID as $key=>$val){
                            echo '<option value="'.$val.'" '.($SelectUserType==$val?'selected="selected"':'').'>'.$arrUserType->Name[$key].'</option>';
                          }
                        echo '</select>';
                      }
                  ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select User Level"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-4">
                <div class="bs-component mt10">
                  <?php
                  foreach($systemuserlevel as $lkey=>$lval){
                    echo '<div class="col-xs-5">';
                      echo '<div class="radio-custom mb5">';
                        echo '<input type="radio" id="uLevel'.$lkey.'" name="uLevel" '.($Level==$lkey?' checked="checked"':'').' value="'.$lkey.'">';
                        echo '<label for="uLevel'.$lkey.'">'.$lval.'</label>';
                      echo '</div>';
                    echo '</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Note"][$_SESSION['Session_Admin_Language']]?></label>
              <div class="col-md-10">
                <label class="field prepend-icon">
                  <textarea class="gui-textarea br-light bg-light" id="Remark" name="Remark" placeholder="User Notes"><?php echo $Remark?></textarea>
                  <label for="Emp_note" class="field-icon">
                    <i class="fa fa-edit"></i>
                  </label>
                </label>
              </div>
            </div>
          <hr class="short alt mtn">
          <div class="panel-footer text-right">
  					<button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]?></button>
  					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
  				</div>
          <!-- end section row -->

        </div>
      </div>
  </form>
  </div>
</div>
