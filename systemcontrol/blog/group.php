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
<link rel="stylesheet" type="text/css" href="../vendor/plugins/daterangepicker-master/daterangepicker.css">
<link href="../assets/js/FooTable-3/compiled/footable.bootstrap.min.css" rel="stylesheet">
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
        <?php if($actiontype=="add"){?>
          <?php include("group-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("group-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("group-view.php");?>
        <?php }else if($actiontype=="sort"){?>
          <?php include("group-sort.php");?>
        <?php }else if($actiontype=="viewlist"){?>
          <?php include("group-viewlist.php");?>
        <?php }else if($actiontype=="reportgroup"){?>
          <?php include("group-reportgroup.php");?>
        <?php }else{?>
        <!-- recent orders table -->
        <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-searchGroup" onsubmit="return submitFrmSearch(this);">
                <?php if($btnaspma){?>
                  <div class="col-sm-2">
                    <button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktorequestactiononly('add',this)"><i class="fas fa-plus-circle"></i> <?php echo $mymenuname?></button>
                  </div>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktorequestactiononly('sort',this)"><?php echo $Array_Lang["bt:Sorting"][$_SESSION['Session_Admin_Language']]?></button>
                  </div>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-danger btn-block" onclick="clicktodeletelistgroup(this)"><?php echo $Array_Lang["bt:Delete"][$_SESSION['Session_Admin_Language']]?></button>
                  </div>
                  <div class="col-sm-2">&nbsp;</div>
                <?php }else{?>
                  <div class="col-sm-6">&nbsp;</div>
                <?php }?>
                <div class="col-md-3"><input id="fooFilter" type="text" class="form-control text-left" placeholder="<?php echo $Array_Lang["txt:Search Keyword"][$_SESSION['Session_Admin_Language']]?>"></div>
                <div class="col-md-2"><button name="searchGroupsubmit" type="submit" class="btn btn-hover btn-primary btn-block"><i class="fas fa-search"></i> <?php echo $Array_Lang["bt:Search"][$_SESSION['Session_Admin_Language']]?></button></div>
                <div class="col-md-1"><button name="searchGroupclear" type="button" class="btn btn-hover btn-primary btn-block"><?php echo $Array_Lang["bt:Clear"][$_SESSION['Session_Admin_Language']]?></button></div>
              </form>
            </div>
          </div>
          <div class="panel-body pn">
           <div class="table-responsive" id="datatable">
            <table class="table admin-form table-striped table-hover" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
            </table>
          </div>
        </div>
      </div>
      <div id="ErrorResult"></div>
      <?php }?>
			</div>
			<!-- end: .tray-center -->
      <?php include("incright-group-aside".(empty($actiontype)?'':'-'.$actiontype).".php");?>

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
<!-- Time/Date Plugin Dependencies -->
<script src="../vendor/plugins/globalize/globalize.min.js"></script>
<script src="../vendor/plugins/moment/moment.min.js"></script>
<script src="../vendor/plugins/daterangepicker-master/moment.min.js"></script>
<!-- DateRange Plugin -->
<script src="../vendor/plugins/daterangepicker-master/daterangepicker.js"></script>

<!-- FooTable Plugin -->
<script src="../vendor/plugins/footable-3/compiled/footable.js"></script>
<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>
<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<!-- HighCharts Plugin -->
<script src="../vendor/plugins/highcharts/highcharts.js"></script>

<script type="text/javascript" src="<?php echo 'group.js?v='.$myrand?>"></script>

<script type="text/javascript" src="<?php echo (empty($actiontype)?'group-list.js?v='.$myrand:'group-'.$actiontype.'.js?v='.$myrand);?>"></script>

</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
