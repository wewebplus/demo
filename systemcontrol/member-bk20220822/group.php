<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<!-- FooTable Plugin CSS -->
<!-- <link rel="stylesheet" type="text/css" href="../vendor/plugins/footable/css/footable.core.min.css">  -->
<link rel="stylesheet" type="text/css" href="../vendor/plugins/magnific/magnific-popup.css">
<link href="../vendor/plugins/footable-3/compiled/footable.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo './css/css.css?v='.$myrand?>" rel="stylesheet" type="text/css">
</head>

<body class="admin-elements-page" data-spy="scroll" data-target="#nav-spy" data-offset="200">

	<!-- Start: Main -->
  <div id="main">
		<?php include("../home/inc-header.php");?>
		<?php include("../home/inc-leftmenu.php");?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
			<?php include("../home/inc-topbar-dropmenu.php");?>
			<?php include("../home/inc-topbar.php");?>

      <!-- Begin: Content -->
      <section id="content" class="table-layout animated">

			<!-- begin: .tray-center -->
			<div class="tray tray-center">
        <div class="row">
          <div class="col-md-6">
            <div class="panel">
              <div class="panel-heading">
                <span class="panel-title"><?php echo $Array_Mod_Lang["txtinput:inputMainType"][$_SESSION['Session_Admin_Language']]?></span>
              </div>
              <div class="panel-body">
                <?php
                $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid=0&actiontype=update');
                ?>
                <form class="form-horizontal" role="form" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
                  <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
                  <?php
                  $arrf = array();
                  $arrf[] = _TABLE_MEMBER_USAGE_."_Index AS ID";
                  $arrf[] = _TABLE_MEMBER_USAGE_."_Name AS Name";
                  $arrf[] = _TABLE_MEMBER_USAGE_."_Seting AS UsageSeting";
                  $sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_MEMBER_USAGE_;
                  $z = new __webctrl;
                  $z->sql($sql);
                  $RecordCount = $z->num();
                  $dataUsage = array();
                  if($RecordCount>0){
                    $v = $z->row();
                    foreach($v as $Row){
                      $Index = $Row["ID"];
                      $Name = $Row["Name"];
                      $UsageSeting = $Row["UsageSeting"];
                      $UsageSeting = explode(",",$UsageSeting);
                      $arr = array();
                      $arr["Index"] = $Index;
                      $arr["Name"] = $Name;
                      $arr["UsageSeting"] = $UsageSeting;
                      $dataUsage[$Index] = $arr;
                    }
                  }
                  // echo '<pre>';
                  // print_r($dataUsage);
                  // echo '</pre>';

                  foreach($arrMemberType as $K=>$V){
                    echo '<div class="form-group">';
                      echo '<label class="col-lg-4 control-label">'.$V.'</label>';
                      echo '<div class="col-lg-8 mt10">';
                        // echo '<pre>';
                        // print_r($dataUsage[$K]["UsageSeting"]);
                        // echo '</pre>';
                        foreach($arrMemberUsage as $KCheck=>$VCheck){
                          if (in_array($KCheck, $dataUsage[$K]["UsageSeting"])) {
                            $datachk = 'checked="checked"';
                          }else{
                            $datachk = '';
                          }
                          echo '<div class="bs-component">';
                            echo '<div class="checkbox-custom checkbox-primary mb5">';
                              echo '<input type="checkbox" '.$datachk.' name="checkboxUsage'.$K.'[]" id="checkboxUsage'.$K.'_'.$KCheck.'" value="'.$KCheck.'">';
                              echo '<label for="checkboxUsage'.$K.'_'.$KCheck.'">'.$VCheck.'</label>';
                            echo '</div>';
                          echo '</div>';
                        }
                      echo '</div>';
                    echo '</div>';
                  }
                  ?>
                  <!-- end .form-body section -->
          				<div class="panel-footer text-right">
          					<button type="submit" class="btn btn-primary"><?php echo "Save ".$mymenuname?></button>
          				</div>
          				<!-- end .form-footer section -->
                </form>
              </div>
            </div>
          </div>
        </div>
        <div id="ErrorOtherResult"></div>
			</div>
			<!-- end: .tray-center -->
      <?php include("incright-aside".(empty($actiontype)?'':'-'.$actiontype).".php");?>

      </section>
      <!-- End: Content -->

			<?php include("../home/inc-footer.php");?>
    </section>
    <!-- End: Content-Wrapper -->

    <!-- Start: Right Sidebar -->
		<?php include("../home/inc-sidebar_right.php");?>
    <!-- End: Right Sidebar -->

  </div>
  <!-- End: Main -->
<?php
include("../home/inc-scriptjs.php");
?>
<script type="text/javascript" src="<?php echo "group.js?ver=".$myrand?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
