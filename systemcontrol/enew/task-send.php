<?php
$sql = "";
$ArrFieldMain[] = "TBmain.*";
$sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
$sql .= " (";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ID";
  $ArrField[] = "TB."._TABLE_MAIL_TASK_."_ID AS ListOrder";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Name AS Subject";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfMember AS NoOfMember";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_NoOfSend AS NoOfSend";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_CreateDate AS CreateDate";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_Status AS ListStatus";
	$ArrField[] = "TB."._TABLE_MAIL_TASK_."_DocumentID AS DocumentID";
	$sql .= "SELECT ".implode(",",$ArrField)." FROM "._TABLE_MAIL_TASK_." TB";
	$sql .= " WHERE TB."._TABLE_MAIL_TASK_."_ID = ".(int)$itemid;
	unset($ArrField);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Name = $Row["Subject"];
$DocumentID = $Row["DocumentID"];
$NewID = $ID;

//_TABLE_MAIL_TASKPROGRESS_
$sql = "";
$ArrFieldMain = array();
$ArrFieldMain[] = "TBmain.*";
$sql .= "SELECT ".implode(",",$ArrFieldMain)." FROM ";
$sql .= " (";
	$sql .= "SELECT ";
	$sql .= " COUNT(*) AS CountData";
	$sql .= " ,SUM(IF("._TABLE_MAIL_TASKPROGRESS_."_Status = 'Waiting', 1, 0)) AS CountWaiting";
	$sql .= " ,SUM(IF("._TABLE_MAIL_TASKPROGRESS_."_Status = 'Send', 1, 0)) AS CountSend";
	$sql .= " FROM "._TABLE_MAIL_TASKPROGRESS_;
	$sql .= " WHERE "._TABLE_MAIL_TASKPROGRESS_."_TaskID = ".intval($ID);
$sql .= ") TBmain";
$sql .= " WHERE 1";
unset($ArrFieldMain);
$z->sql($sql);
$v = $z->row();
$RowCount = $v[0];
$TotalAccount = $RowCount["CountData"];
$WaitingAccount = $RowCount["CountWaiting"];
$SendAccount = $RowCount["CountSend"];

$SessionID = session_id();
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&ContentID='.$ID.'&itemid='.$ID.'&myflag=Enew&SessionID='.$SessionID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b>Send Mail Task Setting</b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm" onsubmit="return submitForm(this)">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<input type="hidden" name="PathFileAtt" value="<?php echo $Module_Path_File?>" />
				<input name="SessionID" type="hidden" value="<?php echo $SessionID?>" >
				<input name="actiontype" type="hidden" value="send">
				<input name="inputWaitingAccount" type="hidden" id="inputWaitingAccount" value="<?php echo $WaitingAccount?>">
				<input name="inputSendAccount" type="hidden" id="inputSendAccount" value="<?php echo $SendAccount?>">
				<input name="inputTotalAccount" type="hidden" id="inputTotalAccount" value="<?php echo $TotalAccount?>">
				<input name="inputTotalSend" type="hidden" id="inputTotalSend" value="0">
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTaskName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $Name?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-12">Account Information</label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Unsend Status</label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $WaitingAccount?> account</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Send Status</label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $SendAccount?> account</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Total</label>
					<div class="col-md-9 frmalert">
            <p class="form-control-static text-muted"><?php echo $TotalAccount?> account</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Send Configuration</label>
					<div class="col-md-3 mt10">
						<div class="radio-custom mb5">
						  <input type="radio" id="inputSendType_1" name="inputSendType" checked="checked" value="Waiting" onClick="calEstimate()">
						  <label for="inputSendType_1">Send only unsend account.</label>
						</div>
					</div>
					<div class="col-md-3 mt10">
						<div class="radio-custom mb5">
						  <input type="radio" id="inputSendType_2" name="inputSendType" value="Reset" onClick="calEstimate()">
						  <label for="inputSendType_2">Reset all account status and send.</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Send Size</label>
					<div class="col-md-2 frmalert">
						<select class="form-control" name="inputSendSize" onChange="calEstimate()">
							<option value="20">20</option>
							<option value="50" selected>50</option>
							<option value="100">100</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>
					</div>
					<div class="col-md-2 frmalert">
            <p class="form-control-static text-muted">account</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Time Delay</label>
					<div class="col-md-2 frmalert">
						<select class="form-control" name="inputTimeDelay" onChange="calEstimate()">
							<option value="10" selected>10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="60">60</option>
							<option value="90">90</option>
							<option value="120">120</option>
						</select>
					</div>
					<div class="col-md-2 frmalert">
            <p class="form-control-static text-muted">account</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Send Estimate</label>
					<div class="col-md-2 frmalert">
            <p class="form-control-static text-muted"></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Total Send</label>
					<div class="col-md-2 frmalert">
            <p class="form-control-static text-muted" id="txtTotalSend"></p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Total Send Time</label>
					<div class="col-md-2 frmalert">
            <p class="form-control-static text-muted" id="txtTotalSendTime"></p>
					</div>
				</div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
					<button type="submit" class="button btn-primary">Send</button>
					<button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>


      </div>
    </div>
  </div>
</div>
<div id="ErrorOtherResult"></div>
