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
<link href="<?php echo './css/progress.php?v='.$myrand?>" rel="stylesheet" type="text/css">
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
<?php
// echo $StaffInfo->level;
// echo '<pre>';
// print_r($StaffInfo);
// echo '</pre>';
?>
        <?php if($actiontype=="view"){?>
          <?php include("pending-view.php");?>
        <?php }else if($actiontype=="score"){?>
          <?php include("pending-score.php");?>
        <?php }else if($actiontype=="scoreview"){?>
          <?php include("pending-scoreview.php");?>
        <?php }else{?>
			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <div class="col-sm-5">&nbsp;</div>
                <?php
                if(count($defaultdata[$Login_MenuID]["resgroup"])>0){
                  echo '<div class="col-md-2">';
                  echo '<select name="selectGroup" class="form-control text-left">';
                  echo '<option value=""> - - Select Group - - </option>';
                  foreach($defaultdata[$Login_MenuID]["resgroup"] as $gk=>$gv){
                    echo '<option value="'.$gv["Key"].'">'.$gv["Name"].'</option>';
                  }
                  echo '</select>';
                  echo '</div>';
                }else{
                  echo '<div class="col-sm-2">&nbsp;</div>';
                }
                ?>
                <div class="col-md-3"><input id="fooFilter" type="text" class="form-control text-left" placeholder="<?php echo $Array_Lang["txt:Search Keyword"][$_SESSION['Session_Admin_Language']]?>"></div>
                <div class="col-md-1"><button name="searchsubmit" type="submit" class="btn btn-hover btn-primary btn-block"><i class="fas fa-search"></i> <?php echo $Array_Lang["bt:Search"][$_SESSION['Session_Admin_Language']]?></button></div>
                <div class="col-md-1"><button name="searchclear" type="button" class="btn btn-hover btn-primary btn-block"><?php echo $Array_Lang["bt:Clear"][$_SESSION['Session_Admin_Language']]?></button></div>
            	</form>
            </div>
		      </div>
					<div class="panel-body pn">
					  <div class="table-responsive" id="datatable">
  						<table class="table tbpending admin-form table-striped table-hover" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
  						</table>
					  </div>
					</div>
			  </div>
				<!-- end recent orders table -->
        <div id="modal-formmanualupdatestatus" class=" popup-basic admin-form mfp-with-anim mfp-hide">
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-rocket"></i>Update Status</span>
            </div>
              <form method="post" action="?" class="form-horizontal" id="FrmManualUpdateStatus" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitFrmUpdateStatus(this)">
              <input type="hidden" name="saveData" value="<?php echo $LoginData?>" />
              <input type="hidden" name="MyData" value="" />
                <div class="panel-body p25">
                  <div class="row">
                    <div class="col-md-12 frmalert field">
                      <div class="bs-component">
                        <textarea class="form-control fieldreqs" name="textRemark" id="textRemark" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              <!-- end .form-body section -->
              <div class="panel-footer">
                <button type="submit" class="button btn-primary btn-block">Update</button>
              </div>
              <!-- end .form-footer section -->
            </form>
          </div>
        </div>        
        <?php }?>
        <div id="ErrorResult"></div>
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
<!-- FooTable Plugin -->
<script src="../vendor/plugins/footable-3/compiled/footable.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<!-- Bootstrap Maxlength plugin -->
<script src="../vendor/plugins/maxlength/bootstrap-maxlength.min.js"></script>
<!-- Page Plugins -->
<script src="../vendor/plugins/magnific/jquery.magnific-popup.js"></script>

<!-- MaskedInput Plugin -->
<script src="../vendor/plugins/jquerymask/jquery.maskedinput.min.js"></script>

<!-- Other JS -->
<script type="text/javascript" src="<?php echo "../vendor/plugins/jqueryfilter/jquery.filter_input.js?ver=".$myrand;?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileupload&filetype=pdf,doc,xls,ppt,docx,xlsx,pptx,zip,jpg,png"?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileuploadImport&filetype=xls,xlsx"?>"></script>
<script type="text/javascript" src="<?php echo "pending.js?ver=".$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'pending-list.js?ver='.$myrand:'pending-'.$actiontype.'.js?ver='.$myrand);?>"></script>
<?php
if(!empty($actiontype) && $actiontype=='view'){
  echo '<script src="https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAP_KEY.'&callback=initAutocomplete&libraries=places&v=weekly" async ></script>';
  echo '<script type="text/javascript" src="index-map.js?ver='.$myrand.'"></script>';
  echo '<script type="text/javascript" src="pending-multiupload.js?ver='.$myrand.'"></script>';
}
?>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
