<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$startDate = "";
$endDate = "";
$DataCheckMemtype = "";

$LangDisable["Thai"] = false;
$LangDisable["English"] = true;
$DataGroup = $defaultdata[$Login_MenuID]["group"];
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
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <input type="hidden" name="DataCheckMemtype" value="<?php echo $DataCheckMemtype?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputDesDate"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-3">
							<div class="section">
									<label for="datepickerFrom" class="field prepend-icon">
											<input type="text" id="datepickerFrom" name="datepickerFrom" readonly="readonly" class="gui-input" value="<?php echo $startDate?>" placeholder="Datepicker From">
											<label class="field-icon"><i class="fa fa-calendar-o"></i></label>
									</label>
							</div>
					</div>
					<div class="col-md-3">
							<div class="section">
									<label for="datepickerTo" class="field prepend-icon">
											<input type="text" id="datepickerTo" name="datepickerTo" readonly="readonly" class="gui-input" value="<?php echo $endDate?>" placeholder="Datepicker To">
											<label class="field-icon"><i class="fa fa-calendar-o"></i></label>
									</label>
							</div>
					</div>
				</div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectGroup"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-lg-6">
						<div class="bs-component">
							<?php
							echo '<select name="selectGroup" class="form-control" data-rule-required="true" data-msg-required="'.$Array_Mod_Lang["txtinput:selectGroup"][$_SESSION['Session_Admin_Language']].'" onchange="selectgroupbanner(this)">';
              echo '<option value=""> - - '.$Array_Mod_Lang["txtinput:selectGroup"][$_SESSION['Session_Admin_Language']].' - - </option>';
              foreach($DataGroup as $gk=>$gv){
								echo '<option value="'.$gv["Key"].'">'.$gv["Name"].'</option>';
              }
              echo '</select>';
							?>
						</div>
					</div>
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
          				<?php
                  if($countlang>1){
                    echo '<div class="row section">';
                      echo '<div class="col-md-12">';
                        echo '<div class="checkbox-custom mb5">';
                          echo '<input name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" type="checkbox" title="'.$lkey.'" class="text checkLang" '.($LangDisable[$lkey]?'checked':'').' value="Off" />';
                          echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  }
          				?>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<input type="text" name="inputSubject'.$lkey.'" class="form-control" value="" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txtinput:inputSubject"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<textarea name="inputTitle'.$lkey.'" class="form-control" id="inputTitle'.$lkey.'" placeholder="'.$Array_Mod_Lang["txtinput:inputTitle"][$_SESSION['Session_Admin_Language']].'" rows="3"></textarea>';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<input type="url" name="inputURL'.$lkey.'" class="form-control" value="" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectTarget"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<select class="form-control" name="selectTarget'.$lkey.'">';
                          echo '<option value="_self">_self</option>';
                          echo '<option value="_blank">_blank</option>';
                        echo '</select>';
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputPicture"][$_SESSION['Session_Admin_Language']]?></label>
          					<div class="col-md-10">
          						<div class="section">
          							<div id="progress<?php echo $lkey?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
          							<div id="output<?php echo $lkey?>"><!-- error or success results --></div>
          							<div class="showoption" id="showoption<?php echo $lkey?>"></div>
          							<div class="postuploadicon">
          								<label for="fileToUpload<?php echo $lkey?>" class="labeluploadfile">
          									<img src="./img/uploadnow.jpg" />
          								</label>  <span>min size xx * xx px. please select group</span>
          								<input name="fileToUpload<?php echo $lkey?>" class="uploadFile" type="file" id="fileToUpload<?php echo $lkey?>" accept="image/*" onChange="return ajaxuFileUploadProgress(this);" />
          							</div>
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
        <br />
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
