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
<!-- Select2 Plugin CSS  -->
<link rel="stylesheet" type="text/css" href="../vendor/plugins/select2/css/core.css">

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
        <?php if($actiontype=="add"){?>
          <?php include("territory-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("territory-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("territory-view.php");?>
        <?php }else if($actiontype=="sort"){?>
          <?php include("territory-sort.php");?>
        <?php }else{?>
			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <?php if($btnaspma){?>
                  <div class="col-sm-2">
                    <button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktorequestactiononly('add',this)"><i class="fas fa-plus-circle"></i> <?php echo $mymenuname?></button>
                  </div>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktorequestactiononly('sort',this)"><?php echo $Array_Lang["bt:Sorting"][$_SESSION['Session_Admin_Language']]?></button>
                  </div>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-danger btn-block" onclick="clicktodeletelist(this)"><?php echo $Array_Lang["bt:Delete"][$_SESSION['Session_Admin_Language']]?></button>
                  </div>
                  <div class="col-md-1"><button name="ExportMat" type="button" class="btn btn-hover btn-primary btn-block" onclick="clicktoexportexcel(this)"><?php echo $Array_Lang["bt:Export"][$_SESSION['Session_Admin_Language']]?></button></div>
                <?php }else{?>
                  <div class="col-sm-5">&nbsp;</div>
                <?php }?>
                <?php
                if(count($defaultdata[$Login_MenuID]["region"])>0){
                  echo '<div class="col-md-2">';
                  echo '<select name="selectGroup" class="form-control text-left">';
                  echo '<option value=""> - - Select Group - - </option>';
                  foreach($defaultdata[$Login_MenuID]["region"] as $gk=>$gv){
                    echo '<option value="'.$gv["ID"].'">'.$gv["Name"].'</option>';
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
  						<table class="table admin-form table-striped table-hover" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
  						</table>
					  </div>
					</div>
			  </div>
				<!-- end recent orders table -->
        <?php }?>
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
<!-- FooTable Plugin -->
<script src="../vendor/plugins/footable-3/compiled/footable.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<!-- Select2 Plugin Plugin -->
<script src="../vendor/plugins/select2/select2.min.js"></script>

<!-- Other JS -->
<script type="text/javascript" src="<?php echo "../vendor/plugins/jqueryfilter/jquery.filter_input.js?ver=".$myrand;?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileupload&filetype=pdf,doc,xls,ppt,docx,xlsx,pptx,zip,jpg,png"?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileuploadImport&filetype=xls,xlsx"?>"></script>
<script type="text/javascript" src="<?php echo "territory.js?ver=".$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'territory-list.js?ver='.$myrand:'territory-'.$actiontype.'.js?ver='.$myrand);?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
