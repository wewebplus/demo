<!-- Start: Topbar -->
<header id="topbar">
  <div class="topbar-left">
    <ol class="breadcrumb">
      <li class="crumb-active">
        <a href="javascript:void(0)"><?php echo $mymenuname?></a>
      </li>
      <li class="crumb-icon">
        <a href="../home/home.php">
          <span class="glyphicon glyphicon-home"></span>
        </a>
      </li>
      <li class="crumb-link">
        <a href="../home/home.php"><?php echo $Array_Lang["txt:Home"][$_SESSION['Session_Admin_Language']]?></a>
      </li>
      <li class="crumb-trail"><?php echo $mymenuname?></li>
    </ol>
  </div>
  <div class="topbar-right">
    <div class="ib topbar-dropdown hidden">
      <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
      <select id="topbar-multiple" class="hidden">
        <optgroup label="Filter By:">
          <option value="1-1">Last 30 Days</option>
          <option value="1-2" selected="selected">Last 60 Days</option>
          <option value="1-3">Last Year</option>
        </optgroup>
      </select>
    </div>
    <div class="ml15 ib va-m hidden" id="toggle_sidemenu_r">
      <a href="#" class="pl5">
        <i class="fa fa-sign-in fs22 text-primary"></i>
        <span class="badge badge-danger badge-hero">3</span>
      </a>
    </div>
  </div>
</header>
<!-- End: Topbar -->
