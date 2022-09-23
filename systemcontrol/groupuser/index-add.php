<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid=0&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
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
        <form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post" id="form-ui">
          <input name="Permission" type="hidden" id="Permission" value="" />
          <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
          <!-- start .section row  section -->
          <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
          </div>
          <!-- .section-divider -->
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Group Management Name"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-9">
  							<div class="section">
  									<label for="inputGName" class="field prepend-icon">
  											<input type="text" name="inputGName" id="inputGName" class="gui-input" value="" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Group Management Name"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Group Management Name"][$_SESSION['Session_Admin_Language']]?>">
  											<label class="field-icon"><i class="fa fa-users"></i></label>
  									</label>
  							</div>
  					</div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Group Shot Name"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-3">
  							<div class="section">
  									<label for="inputShotGName" class="field prepend-icon">
  											<input type="text" name="inputShotGName" id="inputShotGName" class="gui-input" value="" maxlength="50" required data-msg-required="<?php echo $Array_Lang["txt:Please Input"][$_SESSION['Session_Admin_Language']]." ".$Array_Mod_Lang["txt:Group Shot Name"][$_SESSION['Session_Admin_Language']]?>" placeholder="<?php echo $Array_Mod_Lang["txt:Group Shot Name"][$_SESSION['Session_Admin_Language']]?>" onkeypress="checktpyingeng(event)" onblur="chkdatashotname(this)">
  											<label class="field-icon"><i class="fa fa-users"></i></label>
  									</label>
  							</div>
  					</div>
            <div class="col-md-6">
              <p class="form-control-static" id="ErrorShotname"></p>
            </div>
  				</div>
          <div class="form-group">
  					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txt:Group Management Detail"][$_SESSION['Session_Admin_Language']]?></label>
  					<div class="col-md-9">
  							<div class="section">
                  <label for="Detail" class="field prepend-icon">
                    <textarea class="form-control" name="Detail" id="Detail" rows="3" placeholder="<?php echo $Array_Mod_Lang["txt:Group Management Detail"][$_SESSION['Session_Admin_Language']]?>"></textarea>
                    <label class="field-icon"><i class="fa fa-comments"></i></label>
                  </label>

  							</div>
  					</div>
  				</div>
          <div class="section-divider mt40 mb25" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
          </div>
          <!-- .section-divider -->
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="countmnu" id="countmnu" value="<?php echo count($menuIndex);?>" />
              <table class="TablelistPma">
                <tr>
                    <td class="colmenuhead"><?php echo $Array_Lang["txt:Menu List"][$_SESSION['Session_Admin_Language']]?></td>
                      <td class="colselect"><a href="javascript:void(0)" onClick="checkAll('R');"><?php echo $Array_Lang["bt:Select All"][$_SESSION['Session_Admin_Language']]?></a></td>
                      <td class="colselect"><a href="javascript:void(0)" onClick="checkAll('RW');"><?php echo $Array_Lang["bt:Select All"][$_SESSION['Session_Admin_Language']]?></a></td>
                      <td class="colselect"><a href="javascript:void(0)" onClick="checkAll('NA');"><?php echo $Array_Lang["bt:Select All"][$_SESSION['Session_Admin_Language']]?></a></td>
                  </tr>
                  <?php foreach($MenuGroupName as $gkey=>$gval){?>
                      <tr>
                          <td class="colgroupmenu" colspan="3"><?php echo $gval?></td>
                          <td class="colgroupmenuchk">
                            <div class="checkbox-custom checkbox-primary mb5">
                              <input class="checkradios" name="groupchk_<?php echo $gkey?>"  id="groupchk_<?php echo $gkey?>" type="checkbox" value="Yes" />
                              <label for="groupchk_<?php echo $gkey?>">Approved</label>
                            </div>
                          </td>
                      </tr>
                      <?php $indexmnu = 0;?>
                      <?php foreach($menuName as $key=>$val){?>
                        <?php if($menuInGroup[$key]==$gkey){?>
                          <?php
                          $indexmnu++;
                          $tmp = $indexmnu%2;
                          ?>
                          <tr class="trrowpma trrowpma0<?php echo $tmp?>">
                              <td class="colmenu"><?php echo $val?></td>
                              <td class="colselect">
                                <div class="radio-custom radio-primary mb5">
                                  <input name="<?php echo $menuIndex[$key]?>" id="R<?php echo $menuIndex[$key]?>" type="radio" value="R" />
                                  <label for="R<?php echo $menuIndex[$key]?>">Read</label>
                                </div>
                              </td>
                              <td class="colselect">
                                <div class="radio-custom radio-primary mb5">
                                  <input name="<?php echo $menuIndex[$key]?>"  id="RW<?php echo $menuIndex[$key]?>" type="radio" class="checkradios" value="RW" />
                                  <label for="RW<?php echo $menuIndex[$key]?>">Read/Write</label>
                                </div>
                              </td>
                              <td class="colselect">
                                <div class="radio-custom radio-primary mb5">
                                  <input name="<?php echo $menuIndex[$key]?>" id="NA<?php echo $menuIndex[$key]?>" type="radio" class="checkradios" value="NA" />
                                  <label for="NA<?php echo $menuIndex[$key]?>">Not Access</label>
                                </div>
                              </td>
                          </tr>
                          <?php }?>
                      <?php }?>
                  <?php }?>
              </table>
            </div>
          </div>
          <!-- end .section row  section -->
          <!-- end .form-body section -->
          <div class="panel-footer">
            <p class="text-right">
              <button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
              <button type="reset" class="button btn-default"><?php echo $Array_Lang["bt:Clear"][$_SESSION['Session_Admin_Language']]?></button>
              <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
            </p>
          </div>
          <!-- end .form-footer section -->
        </form>
      </div>
    </div>
  </div>
</div>
