<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<!-- FooTable Plugin CSS -->
<link rel="stylesheet" href="../vendor/plugins/dropzone/css/dropzone.css">
<link href="./css/css.css" rel="stylesheet" type="text/css">
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
        <div id="xxxxx"></div>
        <?php if($actiontype=="add"){?>

        <?php }else{?>
        <?php
        $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
        ?>
        <!-- create new panel -->
        <div class="mw1000 center-block">
          <!-- Begin: Content Header -->
          <div class="content-header">
            <h2> <b><?php echo $Array_Lang["txt:List"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
            <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
          </div>

          <!-- Begin: Admin Form -->
          <div class="admin-form theme-primary">
            <div class="panel heading-border panel-primary">
              <div class="panel-body bg-light">

        				<div class="section-divider mb40" id="spy1">
        				  <span><?php echo $Array_Mod_Lang["txt:Head 01"][$_SESSION['Session_Admin_Language']]?></span>
        				</div>
                <div class="row section pl40">
        					<div class="col-md-12">
        						<div id="showGallery"></div>
        					</div>
        				</div>

        				<!-- .section-divider -->
        				<div class="section-divider mb40" id="spy2">
        				  <span><?php echo $Array_Mod_Lang["txt:Head 02"][$_SESSION['Session_Admin_Language']]?></span>
        				</div>

        				<div class="row section">
        					<div class="col-md-12">
        						<div class="tray-bin pl10 mb10">
        							<h5 class="text-muted mt10 fw600 pl10"><i class="fa fa-exclamation-circle text-info fa-lg pr10"></i> Drag and Drop Uploader </h5>
        							<form action="./imgcardupload.php" class="dropzone dropzone-sm" id="dropZone">
        								<div class="fallback">
        									<input name="file" type="file" multiple />
        								</div>
        							</form>
        						</div>
        					</div>
        				</div>

        				<form name="myFrmBtn" id="myFrmBtn" action="?" method="post" id="form-ui">
        	        <input name="Permission" type="hidden" id="Permission" value="" />
        	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
        	        <!-- end .form-body section -->
        	        <div class="panel-footer text-right">
        						<button type="button" id="SaveBtn" class="button btn-primary" onclick="saveGallery();"><?php echo "Save ".$mymenuname?></button>
        	        </div>
        	        <!-- end .form-footer section -->
        	      </form>

              </div>
            </div>
          </div>
        </div>
				<!-- end recent orders table -->
        <?php }?>
			</div>
			<!-- end: .tray-center -->
      <?php include("incright-imgcard-aside".(empty($actiontype)?'':'-'.$actiontype).".php");?>

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
<!-- Dropzone JS -->
<script src="../vendor/plugins/dropzone/dropzone.min.js"></script>

<script type="text/javascript" src="imgcard.js"></script>

<script type="text/javascript" src="<?php echo (empty($actiontype)?'imgcard-list.js?ver='.rand():'imgcard-'.$actiontype.'.js');?>"></script>

</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
