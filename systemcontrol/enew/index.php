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
        // print_r($defaultdata[$Login_MenuID]["group"]);
        // echo '</pre>';
        ?>
        <?php if($actiontype=="add"){?>
          <?php include("index-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else{?>
          <!-- create new panel -->
          <!-- recent orders table -->
          <div class="panel">
            <div class="panel-body">
              <div class="section">
                <form class="form-search" onsubmit="return submitFrmSearch(this);">
                  <?php if($btnaspma){?>
                    <div class="col-sm-1">
                      <button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktorequestaction('add',this)"><?php echo "Add"?></button>
                    </div>
                    <div class="col-sm-1">
                      <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktodeletelist(this)"><?php echo "Delete"?></button>
                    </div>
                    <div class="col-sm-1">
                      <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktoexportlist(this)"><?php echo "Export"?></button>
                    </div>
                    <div class="col-sm-1">&nbsp;</div>
                  <?php }else{?>
                    <div class="col-sm-2">&nbsp;</div>
                  <?php }?>
                  <?php
                  if(count($arrMemberType)>0){
                    echo '<div class="col-md-2">';
                      echo '<select name="selectLevel" class="form-control text-left">';
                      echo '<option value=""> - - Select Level - - </option>';
                      foreach($arrMemberType as $gk=>$gv){
                        echo '<option value="'.$gk.'">'.$gv.'</option>';
                      }
                      echo '</select>';
                    echo '</div>';
                  }
                  $GroupData = $defaultdata[$Login_MenuID]["group"];
                  // echo '<pre>';
                  // print_r($GroupData);
                  // echo '</pre>';
                  if(count($GroupData)>0){
                    echo '<div class="col-md-2">';
                    echo '<select name="selectGroup" class="form-control text-left">';
                    echo '<option value=""> - Select Group - </option>';
                    foreach($GroupData as $gk=>$gv){
                      echo '<option value="'.$gv["ID"].'">'.$gv["Name"].'</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                  }
                  ?>
                  <div class="col-md-2"><input id="fooFilter" type="text" class="form-control text-left" placeholder="Enter Table Filter Criteria Here..."></div>
                  <div class="col-md-1"><button name="searchsubmit" type="submit" class="btn btn-hover btn-primary btn-block">Search</button></div>
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

<!-- Other JS -->
<script type="text/javascript" src="<?php echo "../vendor/plugins/jqueryfilter/jquery.filter_input.js?ver=".rand();?>"></script>
<script type="text/javascript" src="<?php echo "index.js?ver=".rand()?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?ver='.rand():'index-'.$actiontype.'.js?ver='.rand());?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
