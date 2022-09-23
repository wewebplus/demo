<?php
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a.id AS ID";
  $arrf[] = "a.email AS Email";
  $arrf[] = "a.name AS Name";
  $arrf[] = "a.birthday AS Birthday";
  $arrf[] = "a.gender AS Gender";
  $arrf[] = "a.phone_number AS Tel";
  $arrf[] = "a.id AS ListOrder";
  $arrf[] = "(SELECT 'On') AS ListStatus";
	$arrf[] = "a.user_id AS User_id";
  $arrf[] = "a.create_date AS CreateDate";
	$arrf[] = "a.flagmail AS flagmail";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
	$sql .= " WHERE 1";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE TBmain.ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$Name = $Row["Name"];
$Email = $Row["Email"];
$Tel = $Row["Tel"];
$Birthday = dateformat($Row["Birthday"]." 00:00:00",'j M Y');
$Gender = $Row["Gender"];
$CreateDate = $Row["CreateDate"];
$CreateDate = dateformat($Row["CreateDate"],'j M Y H:i');
$User_id = $Row["User_id"];
$flagmail = $Row["flagmail"];
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=actionmail&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$datamail = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=actionmail');
if($osmnupma[$Login_MenuID]=='RW'){
	$pmaalllist = true;
}else{
	$pmaalllist = false;
}
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:View"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" action="?" class="form-horizontal" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<div class="section-divider mb40" id="spy1">
				  <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<?php if($pmaalllist){?>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputCreateDate"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $CreateDate?></p>
						</div>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputUserID"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $User_id?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputName"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $Name?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputEmail"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $Email?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTel"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $Tel?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputBirthday"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $Birthday?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"><?php echo $Array_Mod_Lang["txtinput:inputGender"][$_SESSION['Session_Admin_Language']]?> <?php //echo ($countlang>1?"( ".$lval." Language )":"");?></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<p class="form-control-static text-muted"><?php echo $Gender?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStandard" class="col-lg-3 control-label"></label>
					<div class="col-lg-4 field">
						<div class="bs-component">
							<a href="javascript:void(0)" rev="<?php echo $datamail?>" class="button <?php echo ($flagmail=='W'?'btn-primary':'btn-default')?>" onclick="sendEmailList(this)"><?php echo "ส่ง email ยืนยันสมาชิก"?></a>
						</div>
					</div>
				</div>


				<!-- .section-divider -->

			  </form>

				<form name="myFrmBtn" id="myFrmBtn" action="?" method="post" id="form-ui">
	        <input name="Permission" type="hidden" id="Permission" value="" />
	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
	        <!-- end .form-body section -->
	        <div class="panel-footer text-right">
          <!--<button type="button" id="EditBtn" class="button btn-primary"><?php echo "Edit ".$mymenuname?></button>-->
	          <button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
	        </div>
	        <!-- end .form-footer section -->
	      </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
