
<form name="ajaxFrm" id="ajaxFrm" action="?" method="post">
	<input name="PathURL" type="hidden" id="PathURL" value="<?php echo _HTTP_PATH_."/"._MAIN_FOLDER_SYSTEM_."/"?>" />
	<input name="Login_MenuID" type="hidden" id="Login_MenuID" value="<?php echo (empty($Login_MenuID)?0:$Login_MenuID)?>" />
	<input name="LoginData" type="hidden" id="LoginData" value="<?php echo $LoginData?>" />
	<input name="actiontype" type="hidden" id="actiontype" />
	<input name="actionpage" type="hidden" id="actionpage" value="<?php echo (empty($actionpage)?1:$actionpage)?>" />
	<input name="actionlang" type="hidden" value="<?php echo $_SESSION['Session_Admin_Language']?>" />
</form>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top">
	<div class="navbar-branding">
		<a class="navbar-brand" href="../home/home.php"><img src="../assets/img/main/login-inner.png" Alt="" /></a>
		<span id="toggle_sidemenu_l" class="ad ad-lines"></span>
	</div>
	<ul class="nav navbar-nav navbar-left">
		<!--
		<li>
			<a class="sidebar-menu-toggle" href="#">
				<span class="ad ad-ruby fs18"></span>
			</a>
		</li>
		<li>
			<a class="topbar-menu-toggle" href="#">
				<span class="ad ad-wand fs16"></span>
			</a>
		</li>
		-->
		<li class="hidden-xs">
			<a class="request-fullscreen toggle-active" href="#">
				<span class="ad ad-screen-full fs18"></span>
			</a>
		</li>
	</ul>
	<form class="navbar-form navbar-left navbar-search hidden" role="search">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Search..." value="">
		</div>
	</form>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown hidden">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="ad ad-radio-tower fs18"></span>
			</a>
			<ul class="dropdown-menu media-list w350 animated animated-shorter fadeIn" role="menu">
				<li class="dropdown-header">
					<span class="dropdown-title"> Notifications</span>
					<span class="label label-warning">12</span>
				</li>
				<li class="media">
					<a class="media-left" href="#"> <img src="../assets/img/avatars/5.jpg" class="mw40" alt="avatar"> </a>
					<div class="media-body">
						<h5 class="media-heading">Article
							<small class="text-muted">- 08/16/22</small>
						</h5> Last Updated 36 days ago by
						<a class="text-system" href="#"> Max </a>
					</div>
				</li>
				<li class="media">
					<a class="media-left" href="#"> <img src="../assets/img/avatars/2.jpg" class="mw40" alt="avatar"> </a>
					<div class="media-body">
						<h5 class="media-heading mv5">Article
							<small> - 08/16/22</small>
						</h5>
						Last Updated 36 days ago by
						<a class="text-system" href="#"> Max </a>
					</div>
				</li>
				<li class="media">
					<a class="media-left" href="#"> <img src="../assets/img/avatars/3.jpg" class="mw40" alt="avatar"> </a>
					<div class="media-body">
						<h5 class="media-heading">Article
							<small class="text-muted">- 08/16/22</small>
						</h5> Last Updated 36 days ago by
						<a class="text-system" href="#"> Max </a>
					</div>
				</li>
				<li class="media">
					<a class="media-left" href="#"> <img src="../assets/img/avatars/4.jpg" class="mw40" alt="avatar"> </a>
					<div class="media-body">
						<h5 class="media-heading mv5">Article
							<small class="text-muted">- 08/16/22</small>
						</h5> Last Updated 36 days ago by
						<a class="text-system" href="#"> Max </a>
					</div>
				</li>
			</ul>
		</li>

<?php
$mysystemLang = $systemLang;
/*
if (($mykeylang = array_search($_SESSION['Session_Admin_Language'], $mysystemLang)) !== false) {
    unset($mysystemLang[$mykeylang]);
}
*/
if (array_key_exists($_SESSION['Session_Admin_Language'], $mysystemLang)) {
    unset($mysystemLang[$_SESSION['Session_Admin_Language']]);
}
?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="flaglist-xs <?php echo $Array_Lang["txt:Language Flag"][$_SESSION['Session_Admin_Language']];?>"></span> <?php echo $Array_Lang["txt:Language"][$_SESSION['Session_Admin_Language']]?>
			</a>
				<?php
				if(count($mysystemLang)>0){
					echo '<ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">';
					foreach($mysystemLang as $langkey=>$langval){
						echo '<li>';
							echo '<a href="javascript:void(0);" onclick="changeLanguage(\''.$langkey.'\')"><span class="flaglist-xs '.$Array_Lang["txt:Language Flag"][$langkey].' mr10"></span> '.$Array_Lang["txt:Language"][$langkey].' </a>';
						echo '</li>';
					}
					echo '</ul>';
				}
				?>
		</li>

		<li class="menu-divider hidden">
			<i class="fa fa-circle"></i>
		</li>
		<li class="dropdown">
			<?php
			if($_SESSION['Session_Admin_ID']>0){
				echo '<a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">';
					echo '<img src="'.$StaffImg.'" alt="avatar" class="mw30 br64 mr15"> ';
					echo $StaffFullname." (".$StaffUser.")";
					echo '<span class="caret caret-tp hidden-xs"></span>';
				echo '</a>';
			}else{
				echo "&nbsp";
			}
			?>
			<ul class="dropdown-menu list-group dropdown-persist w250" role="menu">
				<li class="dropdown-header clearfix hidden">
					<div class="pull-left ml10">
						<select id="user-status">
							<optgroup label="Current Status:">
								<option value="1-1">Away</option>
								<option value="1-2">Offline</option>
								<option value="1-3" selected="selected">Online</option>
							</optgroup>
						</select>
					</div>
					<div class="pull-right mr10">
						<select id="user-role">
							<optgroup label="Logged in As:">
								<option value="1-1">Client</option>
								<option value="1-2">Editor</option>
								<option value="1-3" selected="selected">Admin</option>
							</optgroup>
						</select>
					</div>
				</li>
				<li class="list-group-item hidden">
					<a href="#" class="animated animated-short fadeInUp">
						<span class="fa fa-envelope"></span> Messages
						<span class="label label-warning">2</span>
					</a>
				</li>
				<li class="list-group-item hidden">
					<a href="#" class="animated animated-short fadeInUp">
						<span class="fa fa-user"></span> Friends
						<span class="label label-warning">6</span>
					</a>
				</li>
				<li class="list-group-item">
					<a href="javascript:void(0)" class="animated animated-short fadeInUp">
						<span class="fa fa-gear"></span> Account Settings </a>
				</li>
				<li class="list-group-item hidden">
					<a href="#" class="animated animated-short fadeInUp">
						<span class="fa fa-bell"></span> Activity  </a>
				</li>
				<li class="dropdown-footer">
					<a href="javascript:void(0)" class="" onclick="frmlogout()">
					<span class="fa fa-power-off pr5"></span> Logout </a>
				</li>
			</ul>
		</li>
	</ul>

</header>
<!-- End: Header -->
