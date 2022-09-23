<?php
$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=sort&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
$dataModuleKey = $defaultdata[$Login_MenuID]["modulekey"];
if(empty($selectOrder)){
	$selectOrder = $menuDefaultList[substr($Login_MenuID,5)];
}
if(empty($selectASCDESC)){
	$selectASCDESC = $menuDefaultOrder[substr($Login_MenuID,5)];
}
$ASCDESC = (empty($selectASCDESC)?_DEFAULT_ASCDESC_:$selectASCDESC);
$langkey = $_SESSION['Session_Admin_Language'];
$sql = "";
$ArrField = array();
$ArrField[] = "TBmain.ID";
$ArrField[] = "TBmain.GroupID";
$ArrField[] = "TBmain.ListStatus";
$ArrField[] = "TBmain.Picture";
$ArrField[] = "TBmain.PictureAlt";
$ArrField[] = "TBmain.ListOrder";
$ArrField[] = "TBmain.ListCountView";
$ArrField[] = "TBmain.ListCountComment";
$ArrField[] = "TBmain.StartDate";
$ArrField[] = "TBmain.EndDate";
$ArrField[] = "TBmain.StatusHome";
$ArrField[] = "TBmain.ListRating";
$ArrField[] = "TBmain.ListComment";
$ArrField[] = "TBmain.ListPin";
$ArrField[] = "TBmain.ListPublic";
$ArrField[] = "IF(TBmain.SubjectID".$langkey." IS NULL or TBmain.SubjectID".$langkey." = '', '0', TBmain.SubjectID".$langkey.") as SubjectID";
$ArrField[] = "IF(TBmain.Subject".$langkey." IS NULL or TBmain.Subject".$langkey." = '', TBmain.SubjectDefault, TBmain.Subject".$langkey.") as Subject";
$ArrField[] = "IF(TBmain.Status".$langkey." IS NULL or TBmain.Status".$langkey." = '', '-', TBmain.Status".$langkey.") as StatusLang";
$sql .= "SELECT ".implode(',',$ArrField)." FROM ";
$sql .= "("	;
	$arrf = array();
	$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
	$arrf[] = "a."._TABLE_CONTENT_."_GID AS GroupID";
	$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
	$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
	$arrf[] = "a."._TABLE_CONTENT_."_PictureAlt AS PictureAlt";
	$arrf[] = "a."._TABLE_CONTENT_."_Order AS ListOrder";
	$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
	$arrf[] = "a."._TABLE_CONTENT_."_End AS EndDate";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusHome AS StatusHome";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusRating AS ListRating";
  $arrf[] = "a."._TABLE_CONTENT_."_StatusComment AS ListComment";
  $arrf[] = "a."._TABLE_CONTENT_."_Pin AS ListPin";
  $arrf[] = "a."._TABLE_CONTENT_."_Public AS ListPublic";
  $arrf[] = "a."._TABLE_CONTENT_."_View AS ListCountView";
  $arrf[] = "a."._TABLE_CONTENT_."_Comment AS ListCountComment";
  $arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$langkey;
	$arrf[] = $langkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$langkey;
  $arrf[] = "LangDefault."._TABLE_CONTENT_DETAIL_."_ID AS SubjectIDDefault";
  $arrf[] = "LangDefault."._TABLE_CONTENT_DETAIL_."_Subject AS SubjectDefault";
  $arrf[] = "LangDefault."._TABLE_CONTENT_DETAIL_."_Status AS StatusDefault";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
  $sql .= " INNER JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_CONTENT_DETAIL_;
    $sql .= " WHERE "._TABLE_CONTENT_DETAIL_."_Lang = '".$langkey."'";
    unset($arrjoinlang);
  $sql .= ") ".$langkey." ON (a."._TABLE_CONTENT_."_ID = ".$langkey."."._TABLE_CONTENT_DETAIL_."_ContentID)";
  $sql .= " INNER JOIN (";
    $arrjoinlang = array();
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_ContentID";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Subject";
    $arrjoinlang[] = _TABLE_CONTENT_DETAIL_."_Status";
    $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_CONTENT_DETAIL_;
    $sql .= " WHERE "._TABLE_CONTENT_DETAIL_."_Lang = 'EN'";
    unset($arrjoinlang);
  $sql .= ") LangDefault ON (a."._TABLE_CONTENT_."_ID = LangDefault."._TABLE_CONTENT_DETAIL_."_ContentID)";
  $sql .= " WHERE a."._TABLE_CONTENT_."_Key IN ('".implode("','",$dataModuleKey)."')";
	unset($arrf);
$sql .= ") TBmain";
$sql .= " WHERE 1";
$sql .= " ORDER BY TBmain.".$selectOrder." ".$ASCDESC." ,TBmain.ID DESC";
unset($ArrField);
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
								$Fullname = $Row["Subject"];
                echo '<li id="s'.$ID.'" class="ui-state-default">'.$Fullname.'</li>';
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
