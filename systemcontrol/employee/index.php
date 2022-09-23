<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<link href="../vendor/plugins/footable-3/compiled/footable.standalone.min.css" rel="stylesheet">
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
        <?php if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else{?>
        <!-- create new panel -->
        <div class="panel mb25 mt5">
          <div class="panel-heading">
            <span class="panel-title hidden-xs"><?php echo $Array_Lang["txt:Addnew"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></span>
            <ul class="nav panel-tabs-border panel-tabs">
              <li class="active">
                <a href="#tab1_1" data-toggle="tab">General</a>
              </li>
            </ul>
          </div>
          <div class="panel-body p20 pb10">
					<form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post">
					  <input type="hidden" name="imageData" value="" />
            <input name="Gwidth" type="hidden" value="280" />
            <input name="Gheight" type="hidden" value="280" />
		              <div class="tab-content pn br-n admin-form">
		                <div id="tab1_1" class="tab-pane active">
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:fullname"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-5">
              							<div class="bs-component">
                              <label for="firstname" class="field prepend-icon">
                                <input type="text" name="firstname" id="firstname" value="" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Mod_Lang["txtinput:firstname"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="firstname" class="field-icon">
                                  <i class="fa fa-user"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                        <div class="col-md-5">
              							<div class="bs-component">
                              <label for="lastname" class="field prepend-icon">
                                <input type="text" name="lastname" id="lastname" value="" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Mod_Lang["txtinput:lastname"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="lastname" class="field-icon">
                                  <i class="fa fa-user"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                      </div>
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:useremail"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-5">
              							<div class="bs-component">
                              <label for="useremail" class="field prepend-icon">
                                <input type="text" name="useremail" id="useremail" value="" class="event-name gui-input br-light bg-light" placeholder="<?php echo $Array_Mod_Lang["txtinput:useremail"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="useremail" class="field-icon">
                                  <i class="fa fa-envelope-o"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                        <div class="col-md-5">
              							<div class="bs-component">
                              <label for="telephone" class="field prepend-icon">
                                <input type="text" name="telephone" id="telephone" value="" class="event-name gui-input br-light bg-light" placeholder="<?php echo $Array_Mod_Lang["txtinput:telephone"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="telephone" class="field-icon">
                                  <i class="fa fa-phone"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                      </div>
                      <div class="form-group">
                        <label for="inputSelect" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Emp_Type"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-lg-5">
                          <div class="bs-component">
                            <select class="form-control" name="selectInType">
                              <?php
                              foreach($arrInType[$_SESSION['Session_Admin_Language']] as $iK=>$iV){
                                echo '<option value="'.$iK.'">'.$iV.'</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txtinput:Emp_note"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-10">
              							<div class="bs-component">
                              <label class="field prepend-icon">
                                <textarea class="gui-textarea br-light bg-light" id="Emp_note" name="Emp_note" placeholder="<?php echo $Array_Mod_Lang["txtinput:Emp_note"][$_SESSION['Session_Admin_Language']]?>"></textarea>
                                <label for="Emp_note" class="field-icon">
                                  <i class="fa fa-edit"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                      </div>
						  				<hr class="short alt mtn">
		                  <div class="section row mbn">
		                    <div class="col-sm-8">
		                      <label class="field option mt10 hidden">
		                        <input type="checkbox" name="info" checked>
		                        <span class="checkbox"></span>Save Employee
		                        <em class="small-text text-muted">- A Random Unique ID will be generated</em>
		                      </label>
		                    </div>
		                    <div class="col-sm-4">
		                      <p class="text-right">
                            <button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
                          </p>
		                    </div>
		                  </div>
		                  <!-- end section row -->

		                </div>
		              </div>
				 	</form>
          </div>
        </div>

			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <div class="col-sm-1">
                  <button rel="1" type="button" class="btn btn-danger btn-block" onclick="clicktodeletelist(this)"><?php echo $Array_Lang["bt:Delete"][$_SESSION['Session_Admin_Language']]?></button>
                </div>
                <div class="col-sm-5">&nbsp;</div>
                <?php
                echo '<div class="col-sm-2">';
                  echo '<select name="selectEmpType" class="form-control text-left">';
                    echo '<option value=""> - - Select '.$Array_Mod_Lang["txtinput:Emp_Type"][$_SESSION['Session_Admin_Language']].' - - </option>';
                    foreach($arrInType[$_SESSION['Session_Admin_Language']] as $iK=>$iV){
                      echo '<option value="'.$iK.'">'.$iV.'</option>';
                    }
                  echo '</select>';
                echo '</div>';
                ?>
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
        <div id="ErrorResult"></div>
			</div>
			<!-- end: .tray-center -->

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

<script src="../vendor/plugins/cropit-master/dist/jquery.cropit.js"></script>

<!-- FileUpload JS -->
<script src="../vendor/plugins/fileupload/fileupload.js"></script>
<script src="../vendor/plugins/holder/holder.min.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<script type="text/javascript" src="<?php echo 'index.js?v='.$myrand?>"></script>

<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?v='.$myrand:'index-'.$actiontype.'.js?v='.$myrand);?>"></script>

</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
