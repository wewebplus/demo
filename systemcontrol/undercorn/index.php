<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
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
      <section id="content" class="animated">
        <div class="tray tray-center">
          <div class="panel">
            <div class="panel-body p20 text-center">
              <h2>อยู่ในระหว่างปรับปรุง</h2>
            </div>
          </div>
        </div>
      </section>
      <!-- End: Content -->

			<?php include("../home/inc-footer.php");?>
    </section>
    <!-- End: Content-Wrapper -->

  </div>
  <!-- End: Main -->
<?php
include("../home/inc-scriptjs.php");
?>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
