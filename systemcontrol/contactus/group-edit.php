<?php
$arrf = array();
$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_ID AS ID';
$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Status AS status';
$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Ignore AS allignore';
foreach($systemLang as $lkey=>$lval){
	$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS Subject".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Email AS Email".$lkey;
  $arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Title AS Title".$lkey;
	$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS Status".$lkey;
}
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTACT_GROUP_." a";
foreach($systemLang as $lkey=>$lval){
	$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
}
$sql .= " WHERE "._TABLE_CONTACT_GROUP_."_ID = ".(int)$itemid;
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=update&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<div class="section-divider mb40" id="spy1">
				  <span><?php echo $Array_Mod_Lang["txt:Group Head 01"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php $countlang = count($systemLang);?>
				<div class="row">
					<div class="paneltab">
            <ul class="nav nav-tabs nav-justified nav-inline">
              <?php
              foreach($systemLang as $lkey=>$lval){
								$tabactive = ($lkey==$systemdefaultTab?'active':'');
                $tabflag = "flag-".strtolower($lkey);
                echo '<li class="'.$tabactive.'">';
                  echo '<a href="#tab'.$lkey.'" data-toggle="tab" aria-expanded="true"><span class="flaglist-xs '.$tabflag.'"></span> '.$Array_Mod_Lang["tab:TabLang"][$lkey].'</a>';
                echo '</li>';
              }
              ?>
            </ul>
          </div>
					<div class="paneltabbody">
						<div class="tab-content tab-validate pn br-n">
							<?php foreach($systemLang as $lkey=>$lval){?>
								<?php $tabactive = ($lkey==$systemdefaultTab?'active':'');?>
                <div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
										<div class="boxlang">
						        <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
										<?php
										if($countlang>1){
											echo '<div class="checkbox-custom checkbox-primary mb5">';
												echo '<input name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" type="checkbox" title="'.$lkey.'" class="text checkLang" '.($Row['Status'.$lkey]=='Off'?'checked="checked"':'').' value="Off" />';
												echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
											echo '</div>';
										}
										?>
										<div class="form-group">
											<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?></label>
											<div class="col-lg-8">
												<div class="bs-component">
													<input type="text" name="<?php echo "inputGroupSubject".$lkey?>" class="form-control" value="<?php echo $Row['Subject'.$lkey]; ?>" required data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputGroupSubject"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
												</div>
											</div>
										</div>
										<div class="form-group">
                      <label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGroupEmail"][$_SESSION['Session_Admin_Language']]?></label>
                      <div class="col-lg-8">
                        <div class="bs-component">
                          <input type="email" name="<?php echo "inputGroupEmail".$lkey?>" class="form-control" value="<?php echo $Row['Email'.$lkey]; ?>" required data-msg-required="<?php echo $Array_Mod_Lang["txtinput:inputGroupEmail"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputGroupEmail"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label" for="textArea1"><?php echo $Array_Mod_Lang["txtinput:inputGroupTitle"][$_SESSION['Session_Admin_Language']]?></label>
                      <div class="col-lg-8">
                        <div class="bs-component">
                          <textarea class="form-control" name="<?php echo "inputGroupTitle".$lkey?>" rows="4" placeholder="<?php echo $Array_Mod_Lang["txtinput:inputGroupTitle"][$_SESSION['Session_Admin_Language']]?> <?php echo ($countlang>1?"( ".$lval." Language )":"");?>"><?php echo decodetxterea($Row['Title'.$lkey]); ?></textarea>
                        </div>
                      </div>
                    </div>
									</div>
								</div>
			        <?php }?>
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
<div id="xxxxx"></div>
