<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=addnew&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$startDate = "";
$endDate = "";
$DataCheckMemtype = "";
$Dimension = $defaultdata[$Login_MenuID]["Dimension"];
// echo '<pre>';
// print_r($Dimension);
// echo '</pre>';

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
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm">
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
                      <input type="text" id="datepickerFrom" name="datepickerFrom" readonly="readonly" class="gui-input" value="<?php echo $startDate?>" placeholder="Datepicker From" data-msg-required="Datepicker From">
                      <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
                  </label>
              </div>
          </div>
          <div class="col-md-3">
              <div class="section">
                  <label for="datepickerTo" class="field prepend-icon">
                      <input type="text" id="datepickerTo" name="datepickerTo" readonly="readonly" class="gui-input" value="<?php echo $endDate?>" placeholder="Datepicker To" data-msg-required="Datepicker To">
                      <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
                  </label>
              </div>
          </div>
        </div>
        <div class="section-divider mb40" id="spy2">
            <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
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
                  $IntroType = "P";
                  $IntroEmbed = "";
                  $IntroLink = "";
                  $IntroHTML = "";
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
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<input type="text" name="inputURL'.$lkey.'" class="form-control" value="" required data-msg-required="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'" placeholder="'.$Array_Mod_Lang["txtinput:inputURL"][$_SESSION['Session_Admin_Language']].' '.($countlang>1?"( ".$lval." Language )":"").'">';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:selectTarget"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-lg-4">
                      <div class="bs-component">
                        <?php
                        echo '<select name="selectTarget'.$lkey.'" class="form-control">';
                          echo '<option value="_self">_self</option>';
                          echo '<option value="_blank">_blank</option>';
                        echo '</select>';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputType"][$_SESSION['Session_Admin_Language']]?></label>
                    <?php
                    foreach($arrIntroType as $TKey=>$TVal){
                      echo '<div class="col-lg-2 mt10">';
                        echo '<div class="radio-custom square radio-primary mb5">';
                          echo '<input type="radio" class="checkradioI" id="IntroType'.$lkey.$TKey.'" name="IntroType'.$lkey.'" '.($IntroType==$TKey?'checked="checked"':'').' value="'.$TKey.'">';
                          echo '<label for="IntroType'.$lkey.$TKey.'">'.$TVal.'</label>';
                        echo '</div>';
                      echo '</div>';
                    }
                    ?>
                  </div>
                  <div class="form-group pictureintro">
                    <label for="inputStandard" class="col-lg-2 control-label">Images</label>
                    <div class="col-md-10">
                      <div class="section">
                        <div class="boximg" id="loadingfile">
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfile"?>" value="" />
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfilename"?>" value="" />
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowpathfile"?>" value="" />

                            <label class="field prepend-icon append-button file">
                              <span class="button">Choose File</span>
                              <input type="file" class="gui-file" name="<?php echo "ufileToUpload".$lkey?>" onChange="return ajaxuFileUploadProgress00(this);" accept="image/*">
                              <input type="text" class="gui-input" id="<?php echo "ufileToUpload".$lkey."showfile"?>" placeholder="Please Select A File">
                              <label class="field-icon">
                                <i class="fa fa-upload"></i>
                              </label>
                            </label>

                        </div>
                        <div class="showrecommend"><span><?php echo "min size ".$Dimension["W"]." * ".$Dimension["H"]." px."?></span></div>
                        <div id="<?php echo "ufileToUpload".$lkey."progress-wrp"?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                        <div class="showpreview" id="<?php echo "ufileToUpload".$lkey."popupoutput"?>"><!-- error or success results --></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group embedintro">
                    <label for="inputStandard" class="col-lg-2 control-label">Embed</label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <textarea class="form-control" name="<?php echo "inputEmbed".$lkey?>"><?php echo $IntroEmbed?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group linkintro">
                    <label for="inputStandard" class="col-lg-2 control-label">Link</label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <?php
                        echo '<input type="text" name="inputLink'.$lkey.'" class="form-control" value="'.$IntroLink.'">';
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group htmlintro">
                    <label for="inputStandard" class="col-lg-2 control-label">HTML</label>
                    <div class="col-lg-10">
                      <div class="bs-component">
                        <textarea class="form-control" name="<?php echo "inputHTML".$lkey?>"><?php echo $IntroHTML?></textarea>
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
