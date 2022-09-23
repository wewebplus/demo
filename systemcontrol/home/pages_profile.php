<?php include("../../lib/inc.config.php");?>
<?php $adminprofile = "profile001";?>
<?php include("../home/inc-header-db.php");?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo _TITLE_SITENAME_?></title>
  <?php include("../home/inc-scriptcss.php");?>
</head>

<body class="profile-page">
  <!-- Start: Main -->
  <div id="main">
    <?php include("../home/inc-header.php");?>
		<?php include("../home/inc-leftmenu.php");?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
      <?php include("../home/inc-topbar-dropmenu.php");?>
			<?php include("../home/inc-topbar.php");?>

      <!-- Begin: Content -->
      <section id="content" class="animated fadeIn">

        <!-- Begin .page-heading -->
        <div class="page-heading">
            <div class="media clearfix">
              <div class="media-left pr30">
                <a href="#" class="boxviewprofileimages">
                  <img class="media-object mw150" src="<?php echo $StaffImg?>" alt="...">
                </a>
              </div>
              <div class="media-body va-m">
                <h2 class="media-heading"><?php echo $StaffFullname?> <small> - Profile</small></h2>
                <p class="lead"><?php echo $StaffUserRemark?></p>
                <div class="media-links">
                  <ul class="list-inline list-unstyled">
                    <li>
                      <a href="#" title="facebook link">
                        <span class="fa fa-facebook-square fs35 text-primary"></span>
                      </a>
                    </li>
                    <li>
                      <a href="#" title="twitter link">
                        <span class="fa fa-twitter-square fs35 text-info"></span>
                      </a>
                    </li>
                    <li>
                      <a href="#" title="google plus link">
                        <span class="fa fa-google-plus-square fs35 text-danger"></span>
                      </a>
                    </li>
                    <li class="hidden">
                      <a href="#" title="behance link">
                        <span class="fa fa-behance-square fs35 text-primary"></span>
                      </a>
                    </li>
                    <li class="hidden">
                      <a href="#" title="pinterest link">
                        <span class="fa fa-pinterest-square fs35 text-danger-light"></span>
                      </a>
                    </li>
                    <li class="hidden">
                      <a href="#" title="linkedin link">
                        <span class="fa fa-linkedin-square fs35 text-info"></span>
                      </a>
                    </li>
                    <li class="hidden">
                      <a href="#" title="github link">
                        <span class="fa fa-github-square fs35 text-dark"></span>
                      </a>
                    </li>
                    <li class="">
                      <a href="#" title="phone link">
                        <span class="fa fa-phone-square fs35 text-system"></span>
                      </a>
                    </li>
                    <li>
                      <a href="mailto:<?php echo $StaffInfo->email?>" title="email link">
                        <span class="fa fa-envelope-square fs35 text-muted"></span>
                      </a>
                    </li>
                    <li class="hidden">
                      <a href="#" title="external link : <?php echo $StaffInfo->tel?>">
                        <span class="fa fa-external-link-square fs35 text-muted"></span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
        <?php //print_r($StaffInfo)?>
        <div class="row">
            <div class="col-md-4">
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-icon">
                    <i class="fa fa-star"></i>
                  </span>
                  <span class="panel-title"> User Popularity</span>
                </div>
                <div class="panel-body pn">
                  <table class="table mbn tc-icon-1 tc-med-2 tc-bold-last">
                    <thead>
                      <tr class="hidden">
                        <th class="mw30">#</th>
                        <th>First Name</th>
                        <th>Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><span class="fa fa-user text-primary"></span></td>
                        <td>Create</td>
                        <td><?php echo datefotmat($StaffInfo->userCreate,'F j, Y H:i')?></td>
                      </tr>                      
                      <tr>
                        <td><span class="fa fa-clock-o text-warning"></span></td>
                        <td>Last Login</td>
                        <td><?php echo datefotmat($StaffInfo->userLastloginBefor,'F j, Y H:i')?></td>
                      </tr>
                      <tr>
                        <td><span class="fa fa-clock-o text-primary"></span></td>
                        <td>Now Login</td>
                        <td><?php echo datefotmat($StaffInfo->userLastlogin,'F j, Y H:i')?></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-icon">
                    <i class="fa fa-pencil"></i>
                  </span>
                  <span class="panel-title">About Me</span>
                </div>
                <div class="panel-body pb5">
                  <h4>Fullname</h4>
                  <p class="text-muted"><?php echo $StaffInfo->fullname?></p>
                  <hr class="short br-lighter">
                  <h4>Username</h4>
                  <p class="text-muted"><?php echo $StaffInfo->empuser?></p>
                  <hr class="short br-lighter">
                  <h4>Email</h4>
                  <p class="text-muted"><?php echo $StaffInfo->email?></p>
                  <hr class="short br-lighter">
                  <h4>Telephone</h4>
                  <p class="text-muted"><?php echo $StaffInfo->tel?></p>
                  <hr class="short br-lighter">
                  <h4>Employee Note</h4>
                  <p class="text-muted"><?php echo $StaffInfo->empRemark?></p>
                </div>
              </div>
            </div>
            <div class="col-md-8">

              <div class="tab-block">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#tab1" data-toggle="tab">Activity</a>
                  </li>
                  <li>
                    <a href="#tab2" data-toggle="tab">Social</a>
                  </li>
                  <li>
                    <a href="#tab3" data-toggle="tab">Media</a>
                  </li>
                </ul>
                <div class="tab-content p30" style="height: 730px;">
                  <div id="tab1" class="tab-pane active">A</div>
                  <div id="tab2" class="tab-pane">B</div>
                  <div id="tab3" class="tab-pane">C</div>
                </div>
              </div>
            </div>
          </div>

      </section>
      <!-- End: Content -->

      <?php include("../home/inc-footer.php");?>
    </section>

    <!-- Start: Right Sidebar -->
		<?php include("../home/inc-sidebar_right.php");?>
    <!-- End: Right Sidebar -->
  </div>
  <!-- End: Main -->
  <?php
  include("../home/inc-scriptjs.php");
  ?>
</body>
</html>
<?php include("../../lib/inc.footerconfig.php");?>
