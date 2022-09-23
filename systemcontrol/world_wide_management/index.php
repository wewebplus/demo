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
<link rel="stylesheet" type="text/css" href="../vendor/plugins/bala.DualSelectList/css/bala.DualSelectList.css">
<link href="./css/css.css" rel="stylesheet" type="text/css">
</head>

<body class="dashboard-page sb-l-o sb-r-c">

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
          <?php include("index-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else if($actiontype=="user"){?>
          <?php include("index-user.php");?>
        <?php }else{?>
			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <div class="col-sm-2">
                  <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktorequestactiononly('add',this)"><i class="fas fa-plus-circle"></i> <?php echo $mymenuname?></button>
                </div>
                <div class="col-sm-1">
                  <button rel="1" type="button" class="btn btn-danger btn-block" onclick="clicktodeletelist(this)"><?php echo $Array_Lang["bt:Delete"][$_SESSION['Session_Admin_Language']]?></button>
                </div>
                <div class="col-sm-5">&nbsp;</div>
                <div class="col-md-2"><input id="fooFilter" type="text" class="form-control text-left" placeholder="<?php echo $Array_Lang["txt:Search Keyword"][$_SESSION['Session_Admin_Language']]?>"></div>
                <div class="col-md-1"><button name="searchsubmit" type="submit" class="btn btn-hover btn-primary btn-block"><i class="fas fa-search"></i> <?php echo $Array_Lang["bt:Search"][$_SESSION['Session_Admin_Language']]?></button></div>
                <div class="col-md-1"><button name="searchclear" type="button" class="btn btn-hover btn-primary btn-block"><?php echo $Array_Lang["bt:Clear"][$_SESSION['Session_Admin_Language']]?></button></div>
              </form>
            </div>
          </div>
					<div class="panel-body pn">
					  <div class="table-responsive" id="datatable">
						<table class="table admin-form table-striped table-hover table-fix table-bordered" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
						</table>
					  </div>
					</div>
			  </div>
				<!-- end recent orders table -->
        <?php }?>
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
<script src="../assets/js/FooTable-3/compiled/footable.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>
<!-- Bootstrap Maxlength plugin -->
<script src="../vendor/plugins/maxlength/bootstrap-maxlength.min.js"></script>

<script type="text/javascript" src="<?php echo 'index.js?v='.$myrand?>"></script>

<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?v='.$myrand:'index-'.$actiontype.'.js?v='.$myrand);?>"></script>

</body>
</html>
<?php include("../../lib/inc.footerconfig.php");?>
