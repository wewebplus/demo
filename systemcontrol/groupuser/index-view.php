<?php
$sql="SELECT * FROM "._TABLE_ADMIN_USERGROUP_." WHERE "._TABLE_ADMIN_USERGROUP_."_ID = ".(int)$itemid;
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$num = $z->num();
$Row = $v[0];
$ID = $Row[_TABLE_ADMIN_USERGROUP_."_ID"];
$Name = $Row[_TABLE_ADMIN_USERGROUP_."_Name"];
$ShotName = $Row[_TABLE_ADMIN_USERGROUP_."_ShotName"];
$Title = echoDetailToediter($Row[_TABLE_ADMIN_USERGROUP_."_Title"]);
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="page-heading">
    <div class="media clearfix">
      <div class="media-body va-m">
        <h2 class="media-heading"><?php echo $Name?> <?php echo (!empty($ShotName)?"(".$ShotName.")":'')?></h2>
        <p class="lead"><?php echo $Title?></p>
      </div>
    </div>
</div>
<!-- edit panel -->
<div class="admin-form theme-primary">
  <div class="panel heading-border panel-primary">
    <div class="panel-body bg-light">
      <form name="myFrm" id="myFrm" action="?" method="post" id="form-ui">
        <input name="Permission" type="hidden" id="Permission" value="" />
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />

        <?php
        $sqlPM="SELECT "._TABLE_ADMIN_USERGROUPPMA_."_Permission AS PMA, "._TABLE_ADMIN_USERGROUPPMA_."_MenuID AS MenuID FROM "._TABLE_ADMIN_USERGROUPPMA_." WHERE "._TABLE_ADMIN_USERGROUPPMA_."_GroupUserID='".(int)$itemid."' AND  "._TABLE_ADMIN_USERGROUPPMA_."_Language = '".$_SESSION['Session_Admin_Language']."' " ;
        $zPMA = new __webctrl;
        $zPMA->sql($sqlPM);
        $vPMA = $zPMA->row();
        $numPMA = $zPMA->num();
        $arrPMA = array();
        if($numPMA>0){
          foreach($vPMA as $rowPMA){
            $arrPMA[$rowPMA["MenuID"]] = $rowPMA["PMA"];
          }
        }

        $sqlapp = "SELECT "._TABLE_ADMIN_USERGROUPAPPROVE_."_Permission AS PMA, "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID AS GroupMenuID FROM "._TABLE_ADMIN_USERGROUPAPPROVE_." WHERE "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID='".(int)$itemid."'" ;
        $zApp = new __webctrl;
        $zApp->sql($sqlapp);
        $vApp = $zApp->row();
        $numApp = $zApp->num();
        $arrApp = array();
        if($numApp>0){
          foreach($vApp as $rowApp){
            $arrApp[$rowApp["GroupMenuID"]] = $rowApp["PMA"];
          }
        }
        ?>

        <div class="section-divider mt40 mb25" id="spy2">
          <span>Group Permission</span>
        </div>
        <!-- .section-divider -->
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="countmnu" id="countmnu" value="<?php echo count($menuIndex);?>" />
            <table class="TablelistPma">
              <tr>
                <td class="colmenuhead">Menu List</td>
                <td class="colselect">&nbsp;</td>
                <td class="colselect">&nbsp;</td>
                <td class="colselect">&nbsp;</td>
                </tr>
                <?php foreach($MenuGroupName as $gkey=>$gval){?>
                    <tr>
                        <td class="colgroupmenu" colspan="3"><?php echo $gval?></td>
                        <td class="colgroupmenuchk">
                          <label class="option option-primary">
                            <input class="checkradios" disabled="disabled" name="groupchk_<?php echo $gkey?>"  id="groupchk_<?php echo $gkey?>" type="checkbox" <?php echo ($arrApp[$gkey]=="Yes"?'checked="checked"':'')?> value="Yes" />
                            <span class="checkbox"></span><span class="txtpma"><label for="groupchk_<?php echo $gkey?>">Approved</label></span>
                          </label>
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
                              <label class="option option-primary">
                                <input disabled="disabled" name="<?php echo $menuIndex[$key]?>" id="R<?php echo $menuIndex[$key]?>" type="radio" class="checkradios" <?php echo ($arrPMA[$key]=='R'?'checked="checked"':'')?> value="R" />
                                <span class="radio"></span><span class="txtpma"><label for="R<?php echo $menuIndex[$key]?>">Read</label></span>
                              </label>
                            </td>
                            <td class="colselect">
                              <label class="option option-primary">
                                <input disabled="disabled" name="<?php echo $menuIndex[$key]?>"  id="RW<?php echo $menuIndex[$key]?>" type="radio" class="checkradios" <?php echo ($arrPMA[$key]=='RW'?'checked="checked"':'')?> value="RW" />
                                <span class="radio"></span><span class="txtpma"><label for="RW<?php echo $menuIndex[$key]?>">Read/Write</label></span>
                              </label>
                            </td>
                            <td class="colselect">
                              <label class="option option-primary">
                                <input disabled="disabled" name="<?php echo $menuIndex[$key]?>" id="NA<?php echo $menuIndex[$key]?>" type="radio" class="checkradios" <?php echo ($arrPMA[$key]=='NA'?'checked="checked"':'')?> value="NA" />
                                <span class="radio"></span><span class="txtpma"><label for="NA<?php echo $menuIndex[$key]?>">Not Access</label></span>
                              </label>
                            </td>
                        </tr>
                        <?php }?>
                    <?php }?>
                <?php }?>
            </table>
          </div>
        </div>
        <!-- end .form-body section -->
        <div class="panel-footer">
        <p class="text-right">
          <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
          <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
        </p>
        </div>
        <!-- end .form-footer section -->
      </form>
    </div>
  </div>
</div>
