<?php
  $sql="SELECT * FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $num = $z->num();
  $Row = $v[0];
  $ID = $Row[_TABLE_ADMIN_STAFF_."_ID"];
  $FName = $Row[_TABLE_ADMIN_STAFF_."_FName"];
  $LName = $Row[_TABLE_ADMIN_STAFF_."_LName"];
  $Email = $Row[_TABLE_ADMIN_STAFF_."_Email"];
  $Tel = $Row[_TABLE_ADMIN_STAFF_."_Tel"];
  $InType = $Row[_TABLE_ADMIN_STAFF_."_InType"];
  $Remark = decodetxterea($Row[_TABLE_ADMIN_STAFF_."_Remark"]);
  $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
  $oldPictureFile = _RELATIVE_EMPLOYEE_UPLOAD_.$Row[_TABLE_ADMIN_STAFF_."_PictureFile"];
?>
<div class="mw1200 center-block">
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
        <form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post">
          <input type="hidden" name="imageData" value="" />
          <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
          <input name="Gwidth" type="hidden" value="280" />
          <input name="Gheight" type="hidden" value="280" />
          <input name="thumbcrop" type="hidden" value="<?php echo $oldPictureFile?>" />
          <div class="form-group">
            <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:fullname"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-5">
  							<div class="bs-component">
                  <label for="firstname" class="field prepend-icon">
                    <input type="text" name="firstname" id="firstname" value="<?php echo $FName?>" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Mod_Lang["txtinput:firstname"][$_SESSION['Session_Admin_Language']]?>">
                    <label for="firstname" class="field-icon">
                      <i class="fa fa-user"></i>
                    </label>
                  </label>
  							</div>
  					</div>
            <div class="col-md-5">
  							<div class="bs-component">
                  <label for="lastname" class="field prepend-icon">
                    <input type="text" name="lastname" id="lastname" value="<?php echo $LName?>" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Mod_Lang["txtinput:lastname"][$_SESSION['Session_Admin_Language']]?>">
                    <label for="lastname" class="field-icon">
                      <i class="fa fa-user"></i>
                    </label>
                  </label>
  							</div>
  					</div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:useremail"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-5">
  							<div class="bs-component">
                  <label for="useremail" class="field prepend-icon">
                    <input type="text" name="useremail" id="useremail" value="<?php echo $Email?>" class="event-name gui-input br-light bg-light" placeholder="<?php echo $Array_Mod_Lang["txtinput:useremail"][$_SESSION['Session_Admin_Language']]?>">
                    <label for="useremail" class="field-icon">
                      <i class="fa fa-envelope-o"></i>
                    </label>
                  </label>
  							</div>
  					</div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:telephone"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-5">
  							<div class="bs-component">
                  <label for="telephone" class="field prepend-icon">
                    <input type="text" name="telephone" id="telephone" value="<?php echo $Tel?>" class="event-name gui-input br-light bg-light" placeholder="<?php echo $Array_Mod_Lang["txtinput:telephone"][$_SESSION['Session_Admin_Language']]?>">
                    <label for="telephone" class="field-icon">
                      <i class="fa fa-phone"></i>
                    </label>
                  </label>
  							</div>
  					</div>
          </div>
          <div class="form-group">
            <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Emp_Type"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-lg-5">
              <div class="bs-component">
                <select class="form-control" name="selectInType">
                  <?php
                  foreach($arrInType[$_SESSION['Session_Admin_Language']] as $iK=>$iV){
                    echo '<option value="'.$iK.'" '.($InType==$iK?'selected="selected"':'').'>'.$iV.'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-2 control-label"> </label>
            <div class="col-md-10">
  							<div class="bs-component">
                  <div class="image-editor">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="cropit-preview"></div>
                      </div>
                      <div class="col-md-8">
                        <div class="image-size-label">
                          Resize image
                        </div>
                        <table class="TableBoxUploadTool">
                          <tr>
                              <td>
                                <input type="range" class="cropit-image-zoom-input">
                                <input type="hidden" name="imageData" class="hidden-image-data" />
                              </td>
                              <td class="cc"><a href="javascript:void(0)" title="90&deg; CCW" class="rotate-ccw">Rotate counterclockwise</a></td>
                              <td class="cc"><a href="javascript:void(0)" title="90&deg; CW" class="rotate-cw">Rotate clockwise</a></td>
                          </tr>
                        </table>
                        <div class="upload"><input type="file" id="fileUpload" name="fileUpload" class="cropit-image-input"></div>
                        <div class="Recommended">Recommended : size as 280 * 280 pixel.</div>
                      </div>
                    </div>
                  </div>
  							</div>
  					</div>
          </div>
          <div class="form-group">
            <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Emp_note"][$_SESSION['Session_Admin_Language']]?></label>
            <div class="col-md-10">
  							<div class="bs-component">
                  <label class="field prepend-icon">
                    <textarea class="gui-textarea br-light bg-light" id="Emp_note" name="Emp_note" placeholder="<?php echo $Array_Mod_Lang["txtinput:Emp_note"][$_SESSION['Session_Admin_Language']]?>"><?php echo $Remark?></textarea>
                    <label for="Emp_note" class="field-icon">
                      <i class="fa fa-edit"></i>
                    </label>
                  </label>
  							</div>
  					</div>
          </div>
          <!-- end .form-body section -->
  				<div class="panel-footer text-right">
  					<button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
  					<button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
  				</div>
  				<!-- end .form-footer section -->
        </form>
      </div>
    </div>
  </div>
</div>
