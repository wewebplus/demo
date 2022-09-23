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
        <div id="xxxxx"></div>
        <?php if($actiontype=="add"){?>
          <?php include("index-add.php");?>
        <?php }else if($actiontype=="edit"){?>
          <?php include("index-edit.php");?>
        <?php }else if($actiontype=="view"){?>
          <?php include("index-view.php");?>
        <?php }else if($actiontype=="actionmail"){?>
          <?php include("index-actionmail.php");?>
        <?php }else if($actiontype=="sort"){?>
          <?php include("index-sort.php");?>
        <?php }else{?>
			  <!-- recent orders table -->
			  <div class="panel">
          <div class="panel-body">
            <div class="section">
              <form class="form-search" onsubmit="return submitFrmSearch(this);">
                <?php if($btnaspma){?>
                  <div class="col-sm-2"><button rel="1" type="button" class="btn btn-primary btn-block" onClick="clicktorequestactiononly('add',this)"><span class="fa fa-plus-circle"></span> <?php echo $mymenuname?></button></div>
                  <div class="col-sm-1">
                    <button rel="1" type="button" class="btn btn-hover btn-danger btn-block" onclick="clicktodeletelist(this)"><?php echo $Array_Lang["bt:Delete"][$_SESSION['Session_Admin_Language']]?></button>
                  </div>
                  <!-- <div class="col-md-1"><button name="ImportMat" type="button" class="btn btn-hover btn-primary btn-block" onclick="ImportMember(this)"><?php echo $Array_Lang["bt:Import"][$_SESSION['Session_Admin_Language']]?></button></div> -->
                  <div class="col-md-1"><button name="ExportMat" type="button" class="btn btn-hover btn-primary btn-block" onclick="clicktoexportexcel(this)"><?php echo $Array_Lang["bt:Export"][$_SESSION['Session_Admin_Language']]?></button></div>
                <?php }else{?>
                  <div class="col-sm-5">&nbsp;</div>
                <?php }?>
                <div class="col-sm-1">&nbsp;</div>
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
        <div id="modal-formimport" class="popup-basic popup-importprd admin-form mfp-with-anim mfp-hide">
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-rocket"></i>Import Member</span>
            </div>
              <form method="post" action="?" class="form-horizontal" id="FrmImport" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitFrmImport(this)">
              <input type="hidden" name="saveData" value="<?php echo $LoginData?>" />
              <input type="hidden" name="myaction" value="gencode" />
                <div class="panel-body p25">
                  <!-- start section row section -->
                  <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo $Array_Mod_Lang["txtinput:inputTypeMember"][$_SESSION['Session_Admin_Language']]?></label>
                    <div class="col-md-8 frmalert field">
                      <?php
                      if(count($arrMemberType)>0){
                        echo '<select name="selectMainGroup" class="form-control text-left reqs" dataalert="กรุณาเลือก'.$Array_Mod_Lang["txtinput:inputTypeMember"][$_SESSION['Session_Admin_Language']].'" onchange="changeimportmaingroup(this)">';
                        echo '<option value=""> - - Select Group - - </option>';
                        foreach($arrMemberType as $gk=>$gv){
                          echo '<option value="'.$gk.'">'.$gv.'</option>';
                        }
                        echo '</select>';
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="section">
                        <?php
                        $lkey = "Mat";
                        ?>
                        <div class="boximg" id="loadingfile">
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfile"?>" value="" />
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowfilename"?>" value="" />
                            <input type="hidden" name="<?php echo "ufileToUpload".$lkey."ushowpathfile"?>" value="" />

                            <label class="field prepend-icon append-button file">
                              <span class="button">Choose File</span>
                              <input type="file" class="gui-file" name="<?php echo "ufileToUpload".$lkey?>" onChange="return ajaxuFileUploadProgressImport(this);" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                              <input type="text" class="gui-input" id="<?php echo "ufileToUpload".$lkey."showfile"?>" placeholder="Please Select A File">
                              <label class="field-icon">
                                <i class="fa fa-upload"></i>
                              </label>
                            </label>
                        </div>
                        <div id="<?php echo "ufileToUpload".$lkey."progress-wrp"?>" class="progress_wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                        <div id="<?php echo "ufileToUpload".$lkey."popupoutput"?>"><!-- error or success results --></div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="form-control-static text-muted">จะต้องเป็น file ที่มีนามสกุลเป็น .xlsx (ตัวอย่าง File .xlsx Recommended : File .xlsx  Only  <a href="./doc/member.xlsx" target="_blank">example</a>)</p>
                    </div>
                  </div>
                </div>
              <!-- end .form-body section -->
              <div class="panel-footer">
                <button type="submit" class="button btn-primary btn-block">Import</button>
              </div>
              <!-- end .form-footer section -->

            </form>
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

<!-- Bootstrap Maxlength plugin -->
<script src="../vendor/plugins/maxlength/bootstrap-maxlength.min.js"></script>
<!-- Page Plugins -->
<script src="../vendor/plugins/magnific/jquery.magnific-popup.js"></script>

<!-- Other JS -->
<script type="text/javascript" src="<?php echo "../vendor/plugins/jqueryfilter/jquery.filter_input.js?ver=".rand();?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileupload&filetype=pdf,doc,zip,jpg"?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/inc.jsfiletype.php?myval=arrfileuploadImport&filetype=xls,xlsx"?>"></script>
<script type="text/javascript" src="<?php echo "../vendor/plugins/myuploadplugin/upload.js?ver=".$myrand;?>"></script>
<script type="text/javascript" src="<?php echo "index.js?ver=".rand()?>"></script>
<script type="text/javascript" src="<?php echo "index-multiupload.js?ver=".$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js':'index-'.$actiontype.'.js?ver='.rand());?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
