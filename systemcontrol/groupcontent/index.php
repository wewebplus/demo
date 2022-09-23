<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<!-- FooTable Plugin CSS -->
<link rel="stylesheet" type="text/css" href="../vendor/plugins/magnific/magnific-popup.css">
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
        <?php
        $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid=0&actiontype=update');
        ?>
        <form role="form" name="myFrm" id="myFrm" onsubmit="return submitFrm(this)">
          <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
          <div class="row">
            <div class="col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-title"><?php echo $Array_Mod_Lang["txtinput:inputMainType"][$_SESSION['Session_Admin_Language']]?></span>
                </div>
                <div class="panel-body">
                  <div class="form-horizontal">
                    <?php
                    $inmodulekey = array_keys($menuFolder, "content");
                    $arrListMenu = array();
                    foreach($inmodulekey as $kM=>$vM){
                      $inGroupMenu = $menuInGroup[$vM];
                      $inMenuName = $menuName[$vM];
                      $inMenuIndex = $vM;
                      $arr = array();
                      $arr["Index"] = $inMenuIndex;
                      $arr["InName"] = $inMenuName;
                      $arr["InGroup"] = $inGroupMenu;
                      $arr["InGroupName"] = $MenuGroupName[$inGroupMenu];
                      $arrListMenu[$inGroupMenu][] = $arr;
                      unset($arr);
                    }
                    // echo '<pre>';
                    // print_r($arrListMenu);
                    // echo '</pre>';
                    ?>
                    <div class="form-group">
                      <label for="inputSelect" class="col-lg-3 control-label">Select Menu</label>
                      <div class="col-lg-8">
                        <div class="bs-component">
                          <select class="form-control" name="SelectMenu">
                            <?php
                            if(count($arrListMenu)>0){
                              foreach($arrListMenu as $kM=>$vM){
                                if(count($vM)>0){
                                  echo '<optgroup label="'.$vM[0]["InGroupName"].'">';
                                    foreach($vM as $kkM=>$vvM){
                                      echo '<option value="'.$vvM["Index"].'">'.$vvM["InName"].'</option>';
                                    }
                                  echo '</optgroup>';
                                }
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-title"><?php echo $Array_Mod_Lang["txtinput:inputMainType"][$_SESSION['Session_Admin_Language']]?></span>
                </div>
                <div class="panel-body">
                  <ul class="ShowResult" id="ShowResult"></ul>
                </div>
              </div>
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-title"><?php echo $Array_Mod_Lang["txtinput:inputMainType"][$_SESSION['Session_Admin_Language']]?></span>
                </div>
                <div class="panel-body">
                  <div class="form-horizontal forminput">
                    <?php
                    foreach($Array_Lang["txt:Language"] as $k=>$v){
                      $tabflag = "flag-".strtolower($k);
                      echo '<div class="form-group">';
                        echo '<label for="inputStandard" class="col-lg-3 control-label">Group '.$v.' <span class="flaglist-xs '.$tabflag.'"></span></label>';
                        echo '<div class="col-lg-8">';
                          echo '<div class="bs-component">';
                            echo '<input type="text" name="inputGroup_'.$k.'" class="form-control" placeholder="Type Here...">';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    }
                    ?>
                    <div class="form-group">
                      <label for="inputStandard" class="col-lg-3 control-label"> </label>
                      <div class="col-lg-8">
                        <button type="submit" class="btn btn-primary"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div id="ErrorOtherResult"></div>
        <div id="modal-formedit" class="popup-basic popup-importprd admin-form mfp-with-anim mfp-hide">
          <div class="panel">
            <form method="post" action="?" class="form-horizontal" id="FrmEdit" enctype="multipart/form-data" autocomplete="off" onSubmit="return summitFrmEdit(this)">
              <input type="hidden" name="saveData" value="<?php echo $LoginData?>" />
              <input type="hidden" name="editData" value="" />
              <div class="panel-heading">
                <span class="panel-title"><i class="fa fa-rocket"></i>Edit Group</span>
              </div>
              <div class="panel-body p25">
                <?php
                foreach($Array_Lang["txt:Language"] as $k=>$v){
                  $tabflag = "flag-".strtolower($k);
                  echo '<div class="form-group">';
                    echo '<label for="inputStandard" class="col-lg-3 control-label">Group '.$v.' <span class="flaglist-xs '.$tabflag.'"></span></label>';
                    echo '<div class="col-lg-8">';
                      echo '<div class="bs-component">';
                        echo '<input type="text" name="inputEditGroup_'.$k.'" class="form-control" placeholder="Type Here...">';
                      echo '</div>';
                    echo '</div>';
                  echo '</div>';
                }
                ?>
              </div>
              <div class="panel-footer">
                <button type="submit" class="button btn-primary btn-block"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
              </div>
            </form>
          </div>
        </div>
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
<script src="../vendor/plugins/magnific/jquery.magnific-popup.js"></script>
<!-- Ckeditor JS -->
<script src="<?php echo '../vendor/plugins/ck/ckeditor.js'?>"></script>
<script type="text/javascript" src="<?php echo 'index.js?ver='.$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?ver='.$myrand:'index-'.$actiontype.'.js');?>"></script>
</body>
</html>
<?php include("../../lib/inc.footerconfig.php");?>
