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

  <link href="../vendor/plugins/footable-3/compiled/footable.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo './css/css.css?ver='.rand()?>" rel="stylesheet" type="text/css">
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
        <?php
        // echo '<pre>';
        // print_r($defaultdata);
        // echo '</pre>';
        ?>
        <?php if($actiontype=="add"){?>
          <?php include("doc-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("doc-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("doc-view.php");?>
        <?php }else{?>
          <!-- create new panel -->
          <!-- recent orders table -->
          <div class="panel">
            <div class="panel-body">
              <div class="section">
                <form class="form-search" onsubmit="return submitFrmSearch(this);">
                  <?php if($btnaspma){?>
                    <div class="col-md-1"><button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktorequestaction('add',this)"><?php echo "Add"?></button></div>
                    <div class="col-md-1"><button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktodeletelist(this)"><?php echo "Delete"?></button></div>
                  <?php }?>
                  <div class="col-md-5"></div>
                  <div class="col-md-2"><input id="fooFilter" type="text" class="form-control text-left" placeholder="Enter Table Filter Criteria Here..."></div>
                  <div class="col-md-2"><button name="searchsubmit" type="submit" class="btn btn-hover btn-primary btn-block">Search</button></div>
                  <div class="col-md-1"><button name="searchclear" type="button" class="btn btn-hover btn-primary btn-block">Clear</button></div>
                </form>
              </div>
            </div>
            <div class="panel-body pn">
             <div class="table-responsive" id="datatable">
              <table class="footable table admin-form table-striped table-hover" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
              </table>
            </div>
          </div>
        </div>
        <!-- end recent orders table -->
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

<script src="../assets/admin-tools/admin-forms/js/jquery-ui-datepicker.min.js"></script>


<!-- Ckeditor JS -->
<script src="../vendor/plugins/ck/ckeditor.js"></script>

<!-- Other JS -->
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileupload&filetype=pdf,doc,xls,ppt,docx,xlsx,pptx,zip,jpg,png"?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/upload.js?ver=".rand();?>"></script>

<script type="text/javascript" src="<?php echo "doc-multiupload.js?ver=".rand()?>"></script>
<script type="text/javascript" src="<?php echo "doc.js?ver=".rand()?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'doc-list.js?ver='.rand():'doc-'.$actiontype.'.js?ver='.rand());?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
