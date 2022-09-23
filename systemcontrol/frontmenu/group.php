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
<!-- Fancytree CSS -->
<link rel="stylesheet" type="text/css" href="../vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css">
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
        <div id="xxxxx"></div>
        <?php if($actiontype=="add"){?>
          <?php include("group-add.php");?>
        <?php }else{?>
        <!-- recent orders table -->
        <?php
        // $dataObj = array();
        // $catData = getSubCategories(0,0);
        // echo '<pre>';
        // print_r($catData);
        // echo '</pre>';
        ?>

        <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <?php if($btnaspma){?>
                  <div class="col-md-2"><button rel="1" type="button" class="btn btn-primary btn-block" onclick="AddnewMenu(this)"><i class="fas fa-plus-circle"></i> <?php echo "Add ".$mymenuname?></button></div>
                  <div class="col-md-2"><button rel="1" type="button" class="btn btn-primary btn-block" onclick="GenFrontendMenu(this)"><i class="fas fa-plus-circle"></i> Gen Frontend Menu</button></div>
                  <!-- <div class="col-md-1"><button rel="1" type="button" class="btn btn-danger btn-block" onclick="DeleteTreeMenu(this)"><i class="fas fa-trash-alt"></i> Delete</button></div> -->
                <?php }?>
                <div class="col-md-4"></div>
                <!-- <div class="col-md-3"><input id="fooFilter" type="text" class="form-control text-left" placeholder="Enter Table Filter Criteria Here..."></div>
                <div class="col-md-2"><button name="searchsubmit" type="submit" class="btn btn-hover btn-primary btn-block">Search</button></div>
                <div class="col-md-1"><button name="searchclear" type="button" class="btn btn-hover btn-primary btn-block">Clear</button></div> -->
              </form>
            </div>
          </div>
          <div class="panel-body pn">
            <div class="panel-body bg-light">

              <!-- Add a <table> element where the tree should appear: -->
              <table id="treegrid">
                <colgroup>
                  <col width="70px"></col>
                  <col width="*"></col>
                  <col width="50px"></col>
                </colgroup>
                <thead>
                  <tr> <th></th> <th></th><th></th> </tr>
                </thead>
                <!-- Optionally define a row that serves as template, when new nodes are created: -->
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td class="alignCenter"></td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
          <div class="panel-body pn">
            <div class="table-responsive" id="datatable">
              <table class="table admin-form table-striped table-hover table-fix" data-filtering="true" data-sorting="true" data-filter-connectors="false" cellspacing="0" width="100%" data-filter="#fooFilter"><!-- data-page-navigation=".pagination" data-page-size="5"-->
              </table>
            </div>
          </div>
        </div>
				<!-- end recent orders table -->
        <div id="modal-formmenu" class="popup-basic popup-importprd admin-form mfp-with-anim mfp-hide">
          <div class="panel">
              <form method="post" action="?" class="form-horizontal" id="FrmImport" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitFrmMenu(this)">
              <input type="hidden" name="saveData" value="<?php echo $LoginData?>" />
              <input type="hidden" name="myaction" value="addnew" />
              <input type="hidden" name="inputParentID" value="0" />
                <div class="panel-heading">
                  <span class="panel-title"><i class="fa fa-rocket"></i>Add Menu</span>
                </div>
                <div class="panel-body p25">
                  <!-- start section row section -->
                  <div class="form-group" id="mydataParentID" style="display:none">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:UnderMenu"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 frmalert field"><p class="form-control-static text-muted">email@example.com</p></div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:MenuName"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 frmalert field">
                      <?php
                      echo '<input type="text" name="inputMenuName" class="form-control reqs" value="" dataalert="กรุณากรอกขื่อเมนู">';
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:URL"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 frmalert field">
                      <?php
                      echo '<input type="text" name="inputMenuUrl" class="form-control reqs" value="javascript:void(0)" dataalert="กรุณากรอก URL ขื่อเมนู">';
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Target"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-4 frmalert field">
                      <?php
                        echo '<select class="form-control" name="selectTarget">';
                          echo '<option value="_self">_self</option>';
                          echo '<option value="_blank">_blank</option>';
                        echo '</select>';
                      ?>
                    </div>
                  </div>
                </div>
              <!-- end .form-body section -->
              <div class="panel-footer">
                <button type="submit" class="button btn-primary btn-block">Save</button>
              </div>
              <!-- end .form-footer section -->

            </form>
          </div>
        </div>

        <div id="modal-formmenutype" class="popup-basic popup-importprd admin-form mfp-with-anim mfp-hide">
          <div class="panel">
              <form method="post" action="?" class="form-horizontal" id="FrmManageImport" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitFrmManageMenu(this)">
              <input type="hidden" name="saveData" value="<?php echo $LoginData?>" />
              <input type="hidden" name="myaction" value="addnew" />
              <input type="hidden" name="inputParentID" value="0" />
                <div class="panel-heading">
                  <span class="panel-title"><i class="fa fa-rocket"></i>Manage Menu</span>
                </div>
                <div class="panel-body p25">
                  <!-- start section row section -->
                  <div class="form-group MenuName">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:MenuName"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 frmalert field">
                      <p class="form-control-static text-muted"></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:MenuType"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-4 frmalert field">
                      <?php
                        echo '<select class="form-control" name="selectMenuType" onchange="myselectMenuType(this)">';
                          foreach($ArrMenuType as $kx=>$vx){
                            echo '<option value="'.$kx.'">'.$vx.'</option>';
                          }
                        echo '</select>';
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:URL"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-10 frmalert field">
                      <?php
                      echo '<input type="text" name="inputMenuUrl" class="form-control reqs" value="" dataalert="กรุณากรอก URL ขื่อเมนู">';
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Target"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-4 frmalert field">
                      <?php
                        echo '<select class="form-control" name="selectTarget">';
                          echo '<option value="_self">_self</option>';
                          echo '<option value="_blank">_blank</option>';
                        echo '</select>';
                      ?>
                    </div>
                  </div>
                </div>
              <!-- end .form-body section -->
              <div class="panel-footer">
                <button type="submit" class="button btn-primary btn-block">Save</button>
              </div>
              <!-- end .form-footer section -->

            </form>
          </div>
        </div>

      <?php }?>
      <div id="ErrorOtherResult"></div>
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
<!-- FooTable Plugin -->
<script src="../vendor/plugins/footable-3/compiled/footable.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<!-- Page Plugins -->
<script src="../vendor/plugins/magnific/jquery.magnific-popup.js"></script>

<!-- Fancytree Plugin -->
<script src="../vendor/plugins/fancytree/jquery.fancytree-all.min.js"></script>

<!-- Fancytree Addon - Childcounter -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js"></script>

<!-- Fancytree Addon - ColumnView -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js"></script>

<!-- Fancytree Addon - Drag and Drop -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js"></script>

<!-- Fancytree Addon - Inline Edit -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js"></script>

<!-- Fancytree Addon - Inline Edit -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js"></script>

<!-- Fancytree Addon - Table -->
<script src="../vendor/plugins/fancytree/extensions/jquery.fancytree.table.js"></script>

<script type="text/javascript" src="<?php echo "group.js?v=".$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'group-list.js?v='.$myrand:'group-'.$actiontype.'.js?v='.$myrand);?>"></script>

</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
