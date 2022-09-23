<?php
$PathUploadPicture = (isset($defaultdata[$Login_MenuID]["path"]["PICTURE"])?$defaultdata[$Login_MenuID]["path"]["PICTURE"]:_RELATIVE_CONTENT_IMG_UPLOAD_);
$DataMaxScore = $defaultdata[$Login_MenuID]["maxscore"];
$AuditorsID = intval($_SESSION['Session_Admin_ID']);

$langkey = $_SESSION['Session_Admin_Language'];
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "("	;
  $ArrField = array();
  $ArrField[] = "TBList.ID";
  $ArrField[] = "TBList.ListStatus";
  $ArrField[] = "TBList.ListOrder";
  $ArrField[] = "TBList.CreateDate";
  $ArrField[] = "TBList.ResType";
  $ArrField[] = "TBList.Address";
  $ArrField[] = "TBList.MemberID";
  $ArrField[] = "IF(TBList.SubjectID".$langkey." IS NULL or TBList.SubjectID".$langkey." = '', '0', TBList.SubjectID".$langkey.") as SubjectID";
  $ArrField[] = "IF(TBList.Subject".$langkey." IS NULL or TBList.Subject".$langkey." = '', TBList.SubjectDefault, TBList.Subject".$langkey.") as Subject";
  $ArrField[] = "IF(TBList.Title".$langkey." IS NULL or TBList.Title".$langkey." = '', TBList.TitleDefault, TBList.Title".$langkey.") as Title";
  $ArrField[] = "IF(TBList.Status".$langkey." IS NULL or TBList.Status".$langkey." = '', '-', TBList.Status".$langkey.") as StatusLang";
  $ArrField[] = "TBMember.MemberName";
  $sql .= "SELECT ".implode(',',$ArrField)." FROM ";
  $sql .= "("	;
  	$arrf = array();
  	$arrf[] = "a."._TABLE_RESTAURANT_."_ID AS ID";
    $arrf[] = "a."._TABLE_RESTAURANT_."_MemberID AS MemberID";
  	$arrf[] = "a."._TABLE_RESTAURANT_."_Status AS ListStatus";
  	$arrf[] = "a."._TABLE_RESTAURANT_."_Order AS ListOrder";
    $arrf[] = "a."._TABLE_RESTAURANT_."_CreateDate AS CreateDate";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Type AS ResType";
    $arrf[] = "a."._TABLE_RESTAURANT_."_Address1 AS Address";
    $arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_ID AS SubjectID".$langkey;
  	$arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Subject AS Subject".$langkey;
    $arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Detail AS Title".$langkey;
  	$arrf[] = $langkey."."._TABLE_RESTAURANT_DETAIL_."_Status AS Status".$langkey;
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_ID AS SubjectIDDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Subject AS SubjectDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Detail AS TitleDefault";
    $arrf[] = "LangDefault."._TABLE_RESTAURANT_DETAIL_."_Status AS StatusDefault";
  	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_RESTAURANT_." a";
    $sql .= " INNER JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Detail";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_RESTAURANT_DETAIL_;
      $sql .= " WHERE "._TABLE_RESTAURANT_DETAIL_."_Lang = '".$langkey."'";
      unset($arrjoinlang);
    $sql .= ") ".$langkey." ON (a."._TABLE_RESTAURANT_."_ID = ".$langkey."."._TABLE_RESTAURANT_DETAIL_."_ContentID)";
    $sql .= " INNER JOIN (";
      $arrjoinlang = array();
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_ContentID";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Subject";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Detail";
      $arrjoinlang[] = _TABLE_RESTAURANT_DETAIL_."_Status";
      $sql .= "SELECT ".implode(',',$arrjoinlang)." FROM "._TABLE_RESTAURANT_DETAIL_;
      $sql .= " WHERE "._TABLE_RESTAURANT_DETAIL_."_Lang = 'EN'";
      unset($arrjoinlang);
    $sql .= ") LangDefault ON (a."._TABLE_RESTAURANT_."_ID = LangDefault."._TABLE_RESTAURANT_DETAIL_."_ContentID)";
    $sql .= " WHERE a."._TABLE_RESTAURANT_."_ID = ".(int)$itemid;
  	unset($arrf);
  $sql .= ") TBList";
  $sql .= " LEFT JOIN (";
    $sql .= "SELECT "._TABLE_MEMBER_."_ID AS MemberID ,"._TABLE_MEMBER_."_Name AS MemberName FROM "._TABLE_MEMBER_." WHERE "._TABLE_MEMBER_."_MemberType = 'Restaurant'";
  $sql .= ") TBMember ON (TBList.MemberID = TBMember.MemberID)";
  $sql .= " WHERE 1";
$sql .= ") TBmain";
$sql .= " WHERE 1";
$z = new __webctrl;
$z->sql($sql);
$v = $z->row();
$Row = $v[0];
$ID = $Row["ID"];
$ResType = $Row["ResType"];
$InDataMaxScore = $DataMaxScore[$ResType];
// echo '<pre>';
// print_r($InDataMaxScore);
// echo '</pre>';

// echo $itemscore;
$MemberName = $Row["MemberName"];
$Subject = $Row["Subject"];
$Address = $Row["Address"];
$MemberID = $Row["MemberID"];
$FileInfo = "pending-score-".strtolower($ResType).".php";
$FileForm = "pending-score-".strtolower($ResType)."-view.php";
$FileInfoSpecial = "pending-score-".strtolower($ResType)."-special.php";

$saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="mw1200 center-block">
  <!-- Begin: Content Header -->
  <div class="content-header">
    <h2> <b><?php echo $Array_Lang["txt:View"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
    <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
  </div>

  <!-- Begin: Admin Form -->
  <div class="admin-form theme-primary">
    <div class="panel heading-border panel-primary">
      <div class="panel-body bg-light">
			  <form method="post" class="form-horizontal" action="?" name="myFrm" id="myFrm">
        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        <div class="section-divider mb40" id="spy1">
            <span><?php echo $Array_Mod_Lang["txt:Head 03"][$_SESSION['Session_Admin_Language']]?></span>
        </div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:MemberName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $MemberName; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:restaurantName"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $Subject; ?></p>
            </div>
					</div>
				</div>
        <div class="form-group">
					<label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:ResType"][$_SESSION['Session_Admin_Language']]?></label>
					<div class="col-md-9">
            <div class="bs-component">
              <p class="form-control-static text-muted"><?php echo $ResType; ?></p>
            </div>
					</div>
				</div>
        <?php
        include($FileInfo);
        include($FileForm);
        include($FileInfoSpecial);
        ?>
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
