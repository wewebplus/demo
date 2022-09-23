<!-- Start: Sidebar Left -->
<aside id="sidebar_left" class="nano nano-primary affix">

  <!-- Start: Sidebar Left Content -->
  <div class="sidebar-left-content nano-content">

    <!-- Start: Sidebar Header -->
    <header class="sidebar-header">

      <!-- Sidebar Widget - Menu (Slidedown) -->
      <div class="sidebar-widget menu-widget">
        <div class="row text-center mbn">
          <div class="col-xs-4">
            <a href="../home/home.php" class="text-primary" data-toggle="tooltip" data-placement="top" title="Dashboard">
              <span class="glyphicon glyphicon-home"></span>
            </a>
          </div>
          <div class="col-xs-4">
            <a href="#s" class="text-info" data-toggle="tooltip" data-placement="top" title="Messages">
              <span class="glyphicon glyphicon-inbox"></span>
            </a>
          </div>
          <div class="col-xs-4">
            <a href="#s" class="text-alert" data-toggle="tooltip" data-placement="top" title="Tasks">
              <span class="glyphicon glyphicon-bell"></span>
            </a>
          </div>
          <div class="col-xs-4">
            <a href="#s" class="text-system" data-toggle="tooltip" data-placement="top" title="Activity">
              <span class="fa fa-desktop"></span>
            </a>
          </div>
          <div class="col-xs-4">
            <a href="../home/pages_profile.php" class="text-danger" data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="fa fa-gears"></span>
            </a>
          </div>
          <div class="col-xs-4">
            <a href="#s" class="text-warning" data-toggle="tooltip" data-placement="top" title="Cron Jobs">
              <span class="fa fa-flask"></span>
            </a>
          </div>
        </div>
      </div>

      <!-- Sidebar Widget - Author (hidden)  -->
      <?php
      if($_SESSION['Session_Admin_ID']>0){
        echo '<div class="sidebar-widget author-widget">';
          echo '<div class="media">';
            echo '<a class="media-left" href="#">';
              echo '<img src="'.$StaffImg.'" class="img-responsive">';
            echo '</a>';
            echo '<div class="media-body">';
              echo '<div class="media-links">';
                 echo '<a href="#" class="sidebar-menu-toggle">'.$StaffUser.' -</a> <a href="javascript:void(0)" onclick="frmlogout()">Logout</a>';
              echo '</div>';
              echo '<div class="media-author">'.$StaffFullname.'xx</div>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
      }
      ?>
      <div class="sidebar-widget author-widget hidden"><!--hidden-->
        <div class="media">
          <a class="media-left" href="#">
            <img src="../assets/img/avatars/3.jpg" class="img-responsive">
          </a>
          <div class="media-body">
            <div class="media-links">
               <a href="#" class="sidebar-menu-toggle">User Menu -</a> <a href="pages_login(alt).html">Logout</a>
            </div>
            <div class="media-author">Michael Richards</div>
          </div>
        </div>
      </div>

      <!-- Sidebar Widget - Search (hidden) -->
      <div class="sidebar-widget search-widget hidden">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-search"></i>
          </span>
          <input type="text" id="sidebar-search" class="form-control" placeholder="Search...">
        </div>
      </div>

    </header>
    <!-- End: Sidebar Header -->

    <!-- Start: Sidebar Left Menu -->
    <ul class="nav sidebar-menu">
      <li class="sidebar-label pt20">Menu</li>
      <!--
      <li <?php echo (!empty($adminprofile)=='profile002'?'class="active"':'')?>>
        <a href="../home/pages_calendar.php">
          <span class="fa fa-calendar"></span>
          <span class="sidebar-title">Calendar</span>
          <span class="sidebar-title-tray">
            <span class="label label-xs bg-primary">New</span>
          </span>
        </a>
      </li>
      -->
      <li <?php echo (empty($adminprofile)?'class="active"':'')?>>
        <a href="../home/home.php">
          <span class="glyphicon glyphicon-home"></span>
          <span class="sidebar-title">Dashboard</span>
        </a>
      </li>

      <?php
      foreach($MenuGroupMain as $lmkey=>$lmval){
        if(in_array($lmval,$osmain)){
          echo '<li class="sidebar-label pt15">'.$MenuGroupMainName[$lmval].'</li>';
          $countGroupMenu = count($MenuGroup);
          for($G=1;$G<=$countGroupMenu;$G++){
            if($MenuMainGroup[$G]==$lmval){
              if(in_array($G,$os)){
                echo '<li>'; //menu-open
                  $countMenu=count($menuIndex);
                  $xreplace = str_replace("Admin","",$Login_MenuID);
        				  if(!empty($xreplace)){
        					  if($menuInGroup[$xreplace]==$G){
        						  $cssoppmnu = "menu-open";
        					  }else{
        						   $cssoppmnu = "";
        					  }
        				  }else{
        					  $cssoppmnu = "";
        				  }
                  echo '<a class="accordion-toggle '.$cssoppmnu.'" href="#"><span class="fa '.$MenuGroupIcon[$G].'"></span><span class="sidebar-title">'.$MenuGroupName[$G].'</span><span class="caret"></span></a>';
                  echo '<ul class="nav sub-nav">';
                  foreach($menuIndex as $i=>$ival){
                    if($menuInGroup[$i]==$G){
                      if(in_array($menuIndex[$i],$osmnu)){
                        $inLietMenuType = $menuType[$i];
                        $inLietMenuTarget = $menuTarget[$i];
                        if($inLietMenuType=='link'){
                          echo '<li><a href="'.$menuLink[$i].'" target="'.$inLietMenuTarget.'"><span class="fa '.$menuDefaultIcon[$i].'"></span> '.$menuName[$i].' </a></li>';//<span class="glyphicon glyphicon-book"></span>
                        }else{
                          if($Login_MenuID==$menuIndex[$i]){
                            echo '<li class="active"><a href="'.$menuLink[$i].'?'.encode_URL('Login_MenuID='.$menuIndex[$i]).'" target="'.$inLietMenuTarget.'"><span class="fa '.$menuDefaultIcon[$i].'"></span> '.$menuName[$i].'</a></li>';
                          }else{
                            echo '<li><a href="'.$menuLink[$i].'?'.encode_URL('Login_MenuID='.$menuIndex[$i]).'" target="'.$inLietMenuTarget.'"><span class="fa '.$menuDefaultIcon[$i].'"></span> '.$menuName[$i].' </a></li>';//<span class="glyphicon glyphicon-book"></span>
                          }
                        }
                      }
                    }
                  }
                  echo '</ul>';
                echo '</li>';
              }
            }
          }
        }
      }
      ?>
    </ul>
    <!-- End: Sidebar Menu -->

    <!-- Start: Sidebar Collapse Button -->
    <div class="sidebar-toggle-mini">
      <a href="#">
        <span class="fa fa-sign-out"></span>
      </a>
    </div>
    <!-- End: Sidebar Collapse Button -->

  </div>
  <!-- End: Sidebar Left Content -->

</aside>
<!-- End: Sidebar Left -->
