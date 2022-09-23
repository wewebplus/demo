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
          <?php include("index-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else{?>
			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search">
                <?php if($btnaspma){?>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-primary btn-block" onclick="clicktodeletelist(this)"><?php echo "Delete"?></button>
                  </div>
                <?php }?>
                <div class="col-md-5"></div>
                <?php
                $sql = "";
                $sqlsub = "";
                $sql .= "SELECT * FROM ";
                $sql .= " (";
                	$arrf = array();
                	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_ID AS ID';
                	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Status AS ListStatus';
                	$arrf[] = "a."._TABLE_CONTACT_GROUP_.'_Order AS ListOrder';
                	$sqlsub .= "a.*";
                	foreach($systemLang as $lkey=>$lval){
                		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
                		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Subject AS Subject".$lkey;
                		$arrf[] = $lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Status AS Status".$lkey;
                	}
                	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CONTACT_GROUP_." a";
                	foreach($systemLang as $lkey=>$lval){
                		$sql .= " LEFT JOIN "._TABLE_CONTACT_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_CONTACT_GROUP_."_ID = ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTACT_GROUP_DETAIL_."_Lang = '".$lkey."')";
                	}
                	$sql .= " WHERE a."._TABLE_CONTACT_GROUP_."_Key='Admin11'";
                	unset($arrf);
                $sql .= ") TB";
                $sql .= " ORDER BY TB.ListOrder DESC";
                $z = new __webctrl;
                $z->sql($sql);
                $RecordCount = $z->num();
                echo '<div class="col-md-2">';
                echo '<select name="selectGroup" class="form-control text-left">';
                  echo '<option value=""> - - Select Group - - </option>';
                  if($RecordCount>0) {
                  	$v = $z->row();
                  	foreach($v as $Row){
                      echo '<option value="'.$Row["Subject".$_SESSION['Session_Admin_Language']].'">'.$Row["Subject".$_SESSION['Session_Admin_Language']].'</option>';
                  	}
                  }
                echo '</select>';
                echo '</div>';
                ?>
                <div class="col-md-2"><input id="fooFilter" type="text" class="form-control text-left" placeholder="Enter Table Filter Criteria Here..."></div>
                <div class="col-md-1"><button name="searchclear" type="button" class="btn btn-hover btn-primary btn-block">Clear</button></div>
                <?php if($btnaspma){?>
                  <div class="col-md-1"><button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktoexportinfo(this)">Export</button></div>
                <?php }?>
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

<!-- Bootstrap Maxlength plugin -->
<script src="../vendor/plugins/maxlength/bootstrap-maxlength.min.js"></script>

<!-- Cropper Image Plugin -->
<!--<script src="../vendor/plugins/cropper/cropper.min.js"></script>-->
<script src="../vendor/plugins/cropper-master/dist/cropper.min.js"></script>

<!-- Ckeditor JS -->
<script src="../vendor/plugins/ck/ckeditor.js"></script>

<script type="text/javascript" src="index.js"></script>

<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js':'index-'.$actiontype.'.js');?>"></script>

</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
