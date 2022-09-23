<?php include("../assets/lib/inc.config.php");?>
<?php include("../home/inc-header-db.php");?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo _TITLE_SITENAME_?></title>
<?php include("../home/inc-scriptcss.php");?>
<!-- FooTable Plugin CSS -->
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
        // echo '<pre>';
        // print_r($defaultdata);
        // echo '</pre>';
        // echo strlen('information_center');
        ?>
        <?php if($actiontype=="add"){?>

        <?php }else{?>
        <?php
        if(!empty($Login_MenuID)){
          $indexLogin_MenuID = substr($Login_MenuID,5);
          $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
          $mymenukey = @$menuModuleKey[$indexLogin_MenuID];
        }else{
          $mymenuinclude = "";
          $mymenukey = "";
        }
        $arrf = array();
        $arrf[] = "a."._TABLE_ABOUT_.'_ID AS ID';
        $arrf[] = "a."._TABLE_ABOUT_.'_Key AS ModKey';
        $arrf[] = "a."._TABLE_ABOUT_.'_Status AS status';
        $arrf[] = "a."._TABLE_ABOUT_.'_Ignore AS allignore';
        foreach($systemLang as $lkey=>$lval){
        	$arrf[] = $lkey."."._TABLE_ABOUT_DETAIL_."_ID AS SubjectID".$lkey;
        	$arrf[] = $lkey."."._TABLE_ABOUT_DETAIL_."_HTMLFileName AS HTMLFileName01".$lkey;
        	$arrf[] = $lkey."."._TABLE_ABOUT_DETAIL_."_Status AS Status".$lkey;
        }
        $sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ABOUT_." a";
        foreach($systemLang as $lkey=>$lval){
        	$sql .= " LEFT JOIN "._TABLE_ABOUT_DETAIL_." ".$lkey." ON (a."._TABLE_ABOUT_."_ID = ".$lkey."."._TABLE_ABOUT_DETAIL_."_ContentID AND ".$lkey."."._TABLE_ABOUT_DETAIL_."_Lang = '".$lkey."')";
        }
        $sql .= " WHERE a."._TABLE_ABOUT_."_Key='".$mymenukey."'";
        $sql .= " ORDER BY a."._TABLE_ABOUT_."_ID DESC";
        unset($arrf);
        $z = new __webctrl;
        $z->sql($sql,1,1);
        $RecordCount = $z->num();
        if($RecordCount>0){
          $v = $z->row();
          $Row = $v[0];
          $itemid = $Row["ID"];
          $html = "";
        }else{
          $itemid = 0;
          $html = "";
        }
        $PathUpload = (isset($defaultdata[$Login_MenuID]["path"]["PATH"])?$defaultdata[$Login_MenuID]["path"]["PATH"]:_RELATIVE_ABOUT_UPLOAD_);
        if(!is_dir($PathUpload)) { mkdir($PathUpload,0777); }
        $PathUploadHtml = (isset($defaultdata[$Login_MenuID]["path"]["HTML"])?$defaultdata[$Login_MenuID]["path"]["HTML"]:_RELATIVE_ABOUT_HTML_UPLOAD_);
        if(!is_dir($PathUploadHtml)) { mkdir($PathUploadHtml,0777); }

        $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&actiontype=edit&itemid='.$itemid.'&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
        ?>
        <!-- create new panel -->
        <div class="mw1200 center-block">
          <!-- Begin: Content Header -->
          <div class="content-header">
            <h2> <b><?php echo $Array_Lang["txt:List"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></b></h2>
            <p class="lead"><?php echo $Array_Mod_Lang["txt:Detail Head"][$_SESSION['Session_Admin_Language']]?></p>
          </div>

          <!-- Begin: Admin Form -->
          <div class="admin-form theme-primary">
            <div class="panel heading-border panel-primary">
              <div class="panel-body bg-light">

    				<form name="myFrm" id="myFrm" class="form-horizontal" action="?" method="post" id="form-ui">
    	        <input name="Permission" type="hidden" id="Permission" value="" />
    	        <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
              <?php $countlang = count($systemLang);?>
              <div class="row">
                <div class="paneltab">
                  <ul class="nav nav-tabs nav-justified nav-inline">
                    <?php
                    foreach($systemLang as $lkey=>$lval){
                      $tabactive = ($lkey==$systemdefaultTab?'active':'');
                      $tabflag = "flag-".strtolower($lkey);
                      echo '<li class="'.$tabactive.'">';
                        echo '<a href="#tab'.$lkey.'" data-toggle="tab" aria-expanded="true"><span class="flaglist-xs '.$tabflag.'"></span> '.$Array_Mod_Lang["tab:TabLang"][$lkey].'</a>';
                      echo '</li>';
                    }
                    ?>
                  </ul>
                </div>
                <div class="paneltabbody">
                  <div class="tab-content tab-validate pn br-n">
                    <?php foreach($systemLang as $lkey=>$lval){?>
                      <?php $tabactive = ($lkey==$systemdefaultTab?'active':'');?>
                      <div id="<?php echo 'tab'.$lkey?>" class="tab-pane <?php echo $tabactive?>">
                        <div class="boxlang">
                          <input name="<?php echo "detailid".$lkey?>" type="hidden" value="<?php echo $Row['SubjectID'.$lkey]; ?>" />
                          <?php
                  				if($countlang>1){
                            echo '<div class="checkbox-custom mb20">';
                						  echo '<input type="checkbox" class="checkLang" name="inputIgnore'.$lkey.'" id="inputIgnore'.$lkey.'" title="'.$lkey.'" value="Off" '.($LangDisable[$lkey]?'checked':'').'>';
                						  echo '<label for="inputIgnore'.$lkey.'">ไม่ใช้งาน '.$lval.' Language</label>';
                						echo '</div>';
                  				}
                          if($RecordCount>0){
                            $html = "";
                    				$html = $PathUploadHtml.$Row['HTMLFileName01'.$lkey];
                    				if(is_file($html)){
                    					$html = file_get_contents($html);
                    				}else{
                    					$html = "";
                    				}
                          }
                          echo '<div class="row">';
                            echo '<div class="col-md-12">';
                            echo '<div class="section">';
                              echo '<textarea id="inputDetail'.$lkey.'" name="inputDetail'.$lkey.'" rows="12">'.$html.'</textarea>';
                            echo '</div>';
                            echo '</div>';
                          echo '</div>';
                  				?>
                        </div>
                      </div>
                    <?php }?>
                  </div>
                </div>
              </div>


        	        <!-- end .form-body section -->
        	        <div class="panel-footer text-right">
        						<button type="button" id="SaveBtn" class="button btn-primary" onclick="saveDataHtml(this);"><?php echo $Array_Lang["bt:Save"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
        	        </div>
        	        <!-- end .form-footer section -->
        	      </form>
                <div id="errorresult"></div>

              </div>
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
<!-- Ckeditor JS -->
<script src="<?php echo '../vendor/plugins/ck/ckeditor.js'?>"></script>
<script type="text/javascript" src="<?php echo 'index.js?ver='.$myrand?>"></script>
<script type="text/javascript" src="<?php echo (empty($actiontype)?'index-list.js?ver='.$myrand:'index-'.$actiontype.'.js');?>"></script>
</body>
</html>
<?php include("../assets/lib/inc.footerconfig.php");?>
