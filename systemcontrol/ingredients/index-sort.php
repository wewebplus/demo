<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=sort&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}

if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);

$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_ID AS ID';
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_GID AS GID';
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_Status AS ListStatus';
	$arrf[] = "IF(a."._TABLE_INGREDIENTS_."_Picture IS NULL or a."._TABLE_INGREDIENTS_."_Picture = '', a."._TABLE_INGREDIENTS_."_Picture02, a."._TABLE_INGREDIENTS_."_Picture) AS Picture";
	$arrf[] = "a."._TABLE_INGREDIENTS_."_PictureAlt AS PictureAlt";
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_Order AS ListOrder';
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_Start AS StartDate';
	$arrf[] = "a."._TABLE_INGREDIENTS_.'_End AS EndDate';
	foreach($systemLang as $lkey=>$lval){
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_DETAIL_."_ID AS SubjectID".$lkey;
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_DETAIL_."_Subject AS Subject".$lkey;
		$arrf[] = $lkey."."._TABLE_INGREDIENTS_DETAIL_."_Status AS Status".$lkey;
	}
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_INGREDIENTS_." a";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN "._TABLE_INGREDIENTS_DETAIL_." ".$lkey." ON (a."._TABLE_INGREDIENTS_."_ID = ".$lkey."."._TABLE_INGREDIENTS_DETAIL_."_ContentID AND ".$lkey."."._TABLE_INGREDIENTS_DETAIL_."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE a."._TABLE_INGREDIENTS_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " ORDER BY TBmain.".$selectOrder." ".$selectASCDESC." ,TBmain.ID DESC";
unset($ArrField);
//echo $sql;
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$v = $z->row();
?>
<div class="mw1000 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:Sort"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
				<div class="section-divider mb40" id="spy1">
				  <span><?php echo $Array_Mod_Lang["txt:Group Head 01"][$_SESSION['Session_Admin_Language']]?></span>
				</div>
				<!-- .section-divider -->

        <div class="row section">
          <ul id="sortablecontent">
            <?php
            if($RecordCount>0){
              foreach($v as $Row){
                $ID = $Row["ID"];
								$Picture = $PathUploadPicture.$Row["Picture"];
								if(is_file($Picture)){
									$showPicture = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$Picture);
									$showPicture = '<img src="'.$showPicture.'" alt="'.$Row["PictureAlt"].'" />';
								}else{
									$showPicture = "";
								}
            		$Fullname = $Row["Subject".$_SESSION['Session_Admin_Language']];
                echo '<li id="s'.$ID.'" class="ui-state-default">'.$showPicture.' '.$Fullname.'</li>';
              }
            }
            ?>
          </ul>
        </div>
				<!-- end .form-body section -->
				<div class="panel-footer text-right">
          <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
				</div>
				<!-- end .form-footer section -->
			  </form>

      </div>
    </div>
  </div>
</div>
<div id="xxxxx"></div>
