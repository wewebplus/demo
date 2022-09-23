<?php
$arrf = array();
$arrf[] = "a."._TABLE_CONTACT_.'_ID AS ID';
$arrf[] = "a."._TABLE_CONTACT_.'_GroupID AS GroupID';
$arrf[] = "a."._TABLE_CONTACT_.'_Key AS ModKey';
$arrf[] = "a."._TABLE_CONTACT_.'_Status AS status';
$arrf[] = "a."._TABLE_CONTACT_.'_CreateDate AS CreateDate';
$arrf[] = "a."._TABLE_CONTACT_.'_Name AS ContactName';
$arrf[] = "a."._TABLE_CONTACT_.'_Email AS ContactEmail';
$arrf[] = "a."._TABLE_CONTACT_.'_Tel AS ContactTel';
$arrf[] = "a."._TABLE_CONTACT_.'_Message AS ContactMessage';
$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTACT_." a";
$sql .= " WHERE "._TABLE_CONTACT_."_ID = ".(int)$itemid;
unset($arrf);
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$GID = $Row["GroupID"];
$ContactName = $Row["ContactName"];
$ContactEmail = $Row["ContactEmail"];
$ContactMessage = $Row["ContactMessage"];
$ContactTel = $Row["ContactTel"];



$CreateDate = dateformat($Row["CreateDate"],'j F Y H:i');

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
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
			  <form method="post" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
            <div class="section-divider mb40" id="spy1">
                <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
            </div>
            <div class="hh01"><?php echo $Array_Mod_Lang["txtinput:inputContactDate"][$_SESSION['Session_Admin_Language']]?></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="section">
                        <label class="field-icon">
                            <i class="fa fa-calendar-o"></i> <?php echo $CreateDate?>
                        </label>
                    </div>
                </div>
            </div>

				<div class="section-divider mb40" id="spy2">
				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<!-- .section-divider -->
				<div class="section">
<?php
$P = array();
$P["table"] = _TABLE_CONTACT_GROUP_;
$P["lang"] = $systemLang;
$P["selectid"] = $GID;
$P["modkey"] = "Admin9";
$P["modtextselect"] = array('Thai'=>"Select Group ...",'English'=>"Select Group ...");
$arrgroup = getGroup($P);
if($arrgroup->num>0){
	foreach($arrgroup->data as $vall){
		if($vall["selected"]){
			echo '<label class="field prepend-icon">';
				echo '<div class="viewtextinput">'.$vall["Subject".$_SESSION['Session_Admin_Language']].'</div>';
				echo '<label for="inputSubject" class="field-icon">';
					echo '<i class="fa fa-cogs"></i>';
				echo '</label>';
			echo '</label>';
		}
	}
}

?>
				</div>
				<div class="row">
				  <div class="col-md-12">
					<div class="section">
						<label class="field prepend-icon">
  						<div class="viewtextinput"><?php echo $ContactName; ?></div>
  						<label for="inputSubject" class="field-icon">
  						  <i class="fa fa-bullhorn"></i>
  						</label>
					  </label>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-12">
					<div class="section">
						<label class="field prepend-icon">
  						<div class="viewtextinput"><?php echo $ContactEmail; ?></div>
  						<label for="inputSubject" class="field-icon">
  						  <i class="fas fa-envelope-square"></i>
  						</label>
					  </label>
					</div>
				  </div>
				</div>
        <div class="row">
				  <div class="col-md-12">
					<div class="section">
						<label class="field prepend-icon">
  						<div class="viewtextinput"><?php echo $ContactTel; ?></div>
  						<label for="inputSubject" class="field-icon">
  						  <i class="fas fa-phone-square"></i>
  						</label>
					  </label>
					</div>
				  </div>
				</div>
        		<!-- Text Areas -->
						<div class="row">
						  <div class="col-md-12">
							<div class="section">
								<label class="field prepend-icon">
		  						<div class="viewtextinput"><?php echo echoDetailToediter($ContactMessage); ?></div>
		  						<label for="inputSubject" class="field-icon">
		  						  <i class="fa fa-bullhorn"></i>
		  						</label>
							  </label>
							</div>
						  </div>
						</div>
			  </form>

				<form name="myFrmBtn" id="myFrmBtn" action="?" method="post" id="form-ui">
	        <input name="Permission" type="hidden" id="Permission" value="" />
	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
	        <!-- end .form-body section -->
	        <div class="panel-footer text-right">
	          <button type="button" id="ListBtn" class="button btn-default"><?php echo "Return to List ".$mymenuname?></button>
	        </div>
	        <!-- end .form-footer section -->
	      </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
