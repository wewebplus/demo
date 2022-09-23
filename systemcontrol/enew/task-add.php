<?php
$Name = "";
$CarType = 1;
$Module_Path_FileAttach = _RELATIVE_ENEW_UPLOAD_;
$NewID = 0;
$SessionID = session_id();
$PictureFile = "";
$inputStart = date("Y-m-d");
$inputStart = convertdatefromdb($inputStart,"English");
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
				<input type="hidden" name="PathFileAtt" value="<?php echo $Module_Path_FileAttach?>" />
				<input type="hidden" name="SessionID" value="<?php echo $SessionID?>" >
        <input type="hidden" name="myselect" value="0" />
        <input type="hidden" name="mygroupselect" value="0" />
        <input type="hidden" name="myothselect" value="0" />
        <input type="hidden" name="myselectdoc" value="0" />
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskName"][$_SESSION['Session_Admin_Language']]?> <span class="text-danger mn">*</span></label>
					<div class="col-md-9 frmalert">
            <input type="text" class="form-control fieldreqs" name="<?php echo "inputTaskName"?>" dataalert="<?php echo $Array_Mod_Lang["txtinput:inputTaskName"][$_SESSION['Session_Admin_Language']]?>" value="<?php echo $Name?>" >
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskDate"][$_SESSION['Session_Admin_Language']]?> <span class="text-danger mn">*</span></label>
					<div class="col-md-3">
            <div class="input-group date">
              <label class="input-group-addon cursor" for="dateinputStart">
                <i class="fa fa-calendar"></i>
              </label>
              <input type="text" readonly name="inputStart" id="dateinputStart" value="<?php echo $inputStart?>" class="form-control fieldreqs">
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-2 frmalert">
            <button type="button" id="btnSelectDoc" class="button btn-primary btn-block" onclick="PopupListDoc(this)">เพิ่มเอกสาร</button>
					</div>
				</div>
        <div class="form-group">
          <label class="col-md-2 control-label"> </label>
          <div class="col-md-10 frmalert" id="showResultListDoc"></div>
        </div>        
        <div class="form-group">
					<label class="col-md-2 control-label"> </label>
					<div class="col-md-2 frmalert">
            <button type="button" id="btnSelectMain" class="button btn-primary btn-block" onclick="PopupListEmail(this)">เพิ่มอีเมล์</button>
					</div>
          <div class="col-md-2 frmalert">
            <button type="button" id="btnSelectGroupMain" class="button btn-primary btn-block" onclick="PopupListEmail(this)">เพิ่มกลุ่มอีเมล์</button>
					</div>
          <div class="col-md-2 frmalert">
            <button type="button" id="btnSelect_Oth" class="button btn-primary btn-block" onclick="PopupListEmail(this)">เพิ่มอีเมล์ (สมาชิก)</button>
					</div>
				</div>
        <div class="form-group">
          <label class="col-md-2 control-label"> </label>
          <div class="col-md-10 frmalert" id="showResultListMail"></div>
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
<div id="modal-formsearchEmail" class="popup-basic admin-form mfp-with-anim mfp-hide">
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-rocket"></i>Select Email</span>
    </div>
      <form method="post" action="?" id="frmselectdataemail" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitfrmselectdataemail(this)">
      <input type="hidden" name="MyData" value="" />
      <input type="hidden" name="myaction" value="selectemail" />
        <div class="panel-body p25">
          <!-- start section row section -->
          <div class="row">
            <div class="col-md-6">
              <div class="section">
                <label class="field prepend-icon frmalert">
                    <input type="text" name="<?php echo "popupSearch"?>"  id="<?php echo "popupSearch"?>" class="gui-input fieldreqs" value="" placeholder="">
                    <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
                </label>
              </div><!-- end section row section -->
            </div>
            <div class="col-md-3">
              <button type="button" id="frmdataemail_search" class="button btn-primary btn-block" onclick="popupBtnSearch(this)">Search</button>
            </div>
            <div class="col-md-3">
              <button type="button" id="frmdataemail_clear" class="button btn-primary btn-block" onclick="popupBtnClear(this)">Clear</button>
            </div>
          </div>
          <div class="row admin-form">
            <div id="showResultPopup"></div>
          </div>
        </div>
      <!-- end .form-body section -->
      <div class="panel-footer">
        <button type="button" class="button btn-primary btn-block" onclick="popupBtnSelectClose(this)">เลือก</button>
      </div>
      <!-- end .form-footer section -->
    </form>
  </div>
</div>
<div id="modal-formsearchDoc" class="popup-basic admin-form mfp-with-anim mfp-hide">
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-rocket"></i>Select Document</span>
    </div>
      <form method="post" action="?" id="frmselectdatadoc" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitfrmselectdatadoc(this)">
      <input type="hidden" name="MyData" value="" />
      <input type="hidden" name="myaction" value="selectdoc" />
        <div class="panel-body p25">
          <!-- start section row section -->
          <div class="row">
            <div class="col-md-6">
              <div class="section">
                <label class="field prepend-icon frmalert">
                    <input type="text" name="<?php echo "popupDocSearch"?>"  id="<?php echo "popupSearch"?>" class="gui-input fieldreqs" value="" placeholder="">
                    <label for="firstname" class="field-icon"><i class="fa fa-bullhorn"></i></label>
                </label>
              </div><!-- end section row section -->
            </div>
            <div class="col-md-3">
              <button type="button" id="frmdataemail_search" class="button btn-primary btn-block" onclick="popupBtnDocSearch(this)">Search</button>
            </div>
            <div class="col-md-3">
              <button type="button" id="frmdataemail_clear" class="button btn-primary btn-block" onclick="popupBtnDocClear(this)">Clear</button>
            </div>
          </div>
          <div class="row admin-form">
            <div id="showResultDocPopup"></div>
          </div>
        </div>
      <!-- end .form-body section -->
      <div class="panel-footer">
        <button type="button" class="button btn-primary btn-block" onclick="popupBtnSelectClose(this)">เลือก</button>
      </div>
      <!-- end .form-footer section -->
    </form>
  </div>
</div>
