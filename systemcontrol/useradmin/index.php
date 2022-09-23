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
<link href="../vendor/plugins/footable-3/compiled/footable.standalone.min.css" rel="stylesheet">
<!-- Select2 Plugin CSS  -->
<link rel="stylesheet" type="text/css" href="../vendor/plugins/select2/css/core.css">
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
        <?php if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else{?>
        <!-- create new panel -->
        <div class="panel mb25 mt5">
          <div class="panel-heading">
            <span class="panel-title hidden-xs"> <?php echo $Array_Lang["txt:Addnew"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></span>
            <ul class="nav panel-tabs-border panel-tabs">
              <li class="active">
                <a href="#tab1_1" data-toggle="tab">General</a>
              </li>
            </ul>
          </div>
          <div class="panel-body p20 pb10">
					<form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post">
					  <input type="hidden" name="saveData" value="1" />
		              <div class="tab-content pn br-n admin-form">
		                <div id="tab1_1" class="tab-pane active">
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Lang["txt:Username"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-4">
              							<div class="bs-component">
                              <label for="firstname" class="field prepend-icon">
                                <input type="text" name="inputUsername" id="inputUsername" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Lang["txt:Username"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="firstname" class="field-icon">
                                  <i class="fa fa-user"></i>
                                </label>
                              </label>
              							</div>
              					</div>
                      </div>
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-4">
                            <div class="bs-component">
                              <label for="firstname" class="field prepend-icon">
                                <input type="password" name="inputPassword" id="inputPassword" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Lang["txt:Password"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="firstname" class="field-icon">
                                  <i class="fa fa-user"></i>
                                </label>
                              </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bs-component">
                              <label for="firstname" class="field prepend-icon">
                                <input type="password" name="inputConfirmPassword" id="inputConfirmPassword" class="event-name gui-input br-light light" placeholder="<?php echo $Array_Lang["txt:Confirm Password"][$_SESSION['Session_Admin_Language']]?>">
                                <label for="firstname" class="field-icon">
                                  <i class="fa fa-user"></i>
                                </label>
                              </label>
                            </div>
                        </div>
                      </div>
                      <div class="section-divider mb40" id="spy1">
                        <span>User Policy</span>
                      </div>
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select Employee"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-4">
                          <div class="bs-component">
                            <?php
                            		$arrEmployee = getEmployee(1,0,0,1000000);
                            		if($arrEmployee->mycount > 0){
                            			echo '<select name="SelectEmployee" id="SelectEmployee" class="form-control select2_single">';
                            				echo '<option value=""> - '.$Array_Mod_Lang["txt:Select Employee"][$_SESSION['Session_Admin_Language']].' - </option>';
                            				foreach($arrEmployee->ID as $key=>$val){
                            					echo '<option value="'.$val.'">'.$arrEmployee->FullName[$key].'</option>';
                            				}
                            			echo '</select>';
                            		}
                            ?>
                          </div>
                        </div>
                      </div>                      
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select User Type"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-4">
                          <div class="bs-component">
                            <?php
                            		$arrUserType = getusertype();
                            		if($arrUserType->mycount > 0){
                            			echo '<select name="SelectUserType" id="SelectUserType" class="form-control">';
                            				echo '<option value=""> - '.$Array_Mod_Lang["txt:Select User Type"][$_SESSION['Session_Admin_Language']].' - </option>';
                            				foreach($arrUserType->ID as $key=>$val){
                            					echo '<option value="'.$val.'">'.$arrUserType->Name[$key].'</option>';
                            				}
                            			echo '</select>';
                            		}
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputStandard" class="col-lg-2 control-label"><?php echo $Array_Mod_Lang["txt:Select User Level"][$_SESSION['Session_Admin_Language']]?></label>
                        <div class="col-md-4">
                          <div class="bs-component mt10">
                            <?php
                            $Level = "Staff";
                            foreach($systemuserlevel as $lkey=>$lval){
                              echo '<div class="col-xs-5">';
                                echo '<div class="radio-custom mb5">';
                                  echo '<input type="radio" id="uLevel'.$lkey.'" name="uLevel" '.($Level==$lkey?' checked="checked"':'').' value="'.$lkey.'">';
                                  echo '<label for="uLevel'.$lkey.'">'.$lval.'</label>';
                                echo '</div>';
                              echo '</div>';
                            }
                            ?>
                          </div>
                        </div>
                      </div>

		                  <div class="section row mbn">
		                    <div class="col-sm-8">&nbsp;</div>
		                    <div class="col-sm-4">
		                      <p class="text-right"><button type="submit" class="button btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button></p>
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
                <div class="col-sm-7">&nbsp;</div>
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

<!-- FileUpload JS -->
<script src="../vendor/plugins/fileupload/fileupload.js"></script>
<script src="../vendor/plugins/holder/holder.min.js"></script>

<!-- jQuery Validate Plugin-->
<script src="../assets/admin-tools/admin-forms/js/jquery.validate.min.js"></script>

<!-- jQuery Validate Addon -->
<script src="../assets/admin-tools/admin-forms/js/additional-methods.min.js"></script>

<!-- Select2 Plugin Plugin -->
<script src="../vendor/plugins/select2/select2.min.js"></script>

<script type="text/javascript" src="<?php echo 'index.js?v='.$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?v='.$myrand:'index-'.$actiontype.'.js?v='.$myrand);?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
