<?php
  $sql = "";
  $arrMainField = array();
  $arrMainField[] = 'TBUser.*';
  $arrMainField[] = 'JoinTBStaff.*';
  $arrMainField[] = "CASE WHEN TBUser.UserCreateByID = 1000 THEN '"._UserRoot_."' ELSE CONCAT(TBUser.JoinFName, ' ', TBUser.JoinLName) END AS CreateNameShow";
	$sql .= "SELECT ".implode(',',$arrMainField)." FROM (";
    $arrf = array();
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_ID AS UserID";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_EmpID AS EmpID";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_UserName AS UserName";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_Type AS uType";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_Level AS uLevel";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_CreateDate AS uCreateDate";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_LastUpdate AS uLastUpdate";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_Remark AS uRemark";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_Status AS uStatus";
    $arrf[] = "TBmain."._TABLE_ADMIN_USER_."_CreateByID AS UserCreateByID";
    $arrf[] = "TBJoin.*";
    $arrf[] = "TBJoinPassword.*";
    $arrf[] = "TBJoinLog.LastLogin";
    $arrf[] = "TBType.GroupName";
		$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_USER_." TBmain";
    $sql .= " LEFT JOIN (";
      $arrfjoin = array();
      $arrfjoin[] = _TABLE_ADMIN_STAFF_."_ID AS JoinID";
      $arrfjoin[] = _TABLE_ADMIN_STAFF_."_FName AS JoinFName";
      $arrfjoin[] = _TABLE_ADMIN_STAFF_."_LName AS JoinLName";
      $arrfjoin[] = "CONCAT("._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS JoinFullName";
      $sql .= "SELECT ".implode(',',$arrfjoin)." FROM "._TABLE_ADMIN_STAFF_;
      unset($arrfjoin);
    $sql .= ") TBJoin ON (TBmain."._TABLE_ADMIN_USER_."_CreateByID = TBJoin.JoinID)";
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT "._TABLE_ADMIN_USERHISTORYPASS_."_UserID AS JoinUserID ,"._TABLE_ADMIN_USERHISTORYPASS_."_Password AS JoinPassword,"._TABLE_ADMIN_USERHISTORYPASS_."_OrgPass AS JoinOrgPass,"._TABLE_ADMIN_USERHISTORYPASS_."_CreateDate AS JoinCreateDate FROM "._TABLE_ADMIN_USERHISTORYPASS_;
      $sql .= " WHERE 1";
      $sql .= " AND "._TABLE_ADMIN_USERHISTORYPASS_."_UserID = ".intval($itemid);
      $sql .= " AND "._TABLE_ADMIN_USERHISTORYPASS_."_CreateDate IN (SELECT max("._TABLE_ADMIN_USERHISTORYPASS_."_CreateDate) FROM "._TABLE_ADMIN_USERHISTORYPASS_." WHERE "._TABLE_ADMIN_USERHISTORYPASS_."_UserID = ".intval($itemid)." GROUP BY "._TABLE_ADMIN_USERHISTORYPASS_."_UserID)";
    $sql .= ") TBJoinPassword ON (TBmain."._TABLE_ADMIN_USER_."_ID = TBJoinPassword.JoinUserID)";
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT "._TABLE_ADMIN_USERLOGIN_."_UserID AS LogUserID,"._TABLE_ADMIN_USERLOGIN_."_CreateDate AS LastLogin FROM "._TABLE_ADMIN_USERLOGIN_;
      $sql .= " WHERE 1";
      $sql .= " AND "._TABLE_ADMIN_USERLOGIN_."_UserID = ".intval($itemid);
      $sql .= " AND "._TABLE_ADMIN_USERLOGIN_."_Type = 'Login'";
      $sql .= " ORDER BY "._TABLE_ADMIN_USERLOGIN_."_CreateDate DESC";
      $sql .= " limit 1,2";
    $sql .= ") TBJoinLog ON (TBmain."._TABLE_ADMIN_USER_."_ID = TBJoinPassword.JoinUserID)";
    $sql .= " LEFT JOIN (";
  		$sql .= "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS ID, "._TABLE_ADMIN_USERGROUP_."_Name AS GroupName FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
  	$sql .= ") TBType ON ("._TABLE_ADMIN_USER_."_Type = TBType.ID)";
		$sql .= " WHERE TBmain."._TABLE_ADMIN_USER_."_ID = ".(int)$itemid;
    unset($arrf);
	$sql .= ") TBUser";
	$sql .= " LEFT JOIN (";
		$ArrJoinField = array();
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_ID AS StaffID";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Level AS SLevel";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Remark AS Remark";
    $ArrJoinField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS StaffFullName";
		$sql .= "SELECT ".implode(",",$ArrJoinField)." FROM "._TABLE_ADMIN_STAFF_." WHERE 1";
		unset($ArrJoinField);
	$sql.= ") JoinTBStaff ON (TBUser.EmpID = JoinTBStaff.StaffID)";
  unset($arrMainField);
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $num = $z->num();
  $Row = $v[0];
  $ID = $Row["UserID"];
  $Username = $Row["UserName"];
  $Fullname = $Row["StaffFullName"];
  $SelectUserType = $Row["uType"];
  $SelectEmployee = $Row["EmpID"];
  $Level = $Row["uLevel"];
  $Email = $Row["Email"];
  $Tel = $Row["Tel"];
  $SStatus = $Row["uStatus"];
  $JoinPassword = $Row["JoinPassword"];
  if($SStatus=="On"){
    $SStatusText = '<span class="text-primary">'.$arrinStatus[$_SESSION['Session_Admin_Language']][$SStatus].'</span>';
  }else{
    $SStatusText = '<span class="text-danger">'.$arrinStatus[$_SESSION['Session_Admin_Language']][$SStatus].'</span>';
  }
  $UserType = $Row["GroupName"];
  $Remark = echoDetailToediter($Row["uRemark"]);
  $CreateDate = $Row["uCreateDate"];
  $LastUpdate = $Row["uLastUpdate"];
	$userLastlogin = $Row["LastLogin"];
  $CreateBy = $Row["CreateNameShow"];

  $thumb = _RELATIVE_EMPLOYEE_UPLOAD_.$Row["PictureFile"];
  if(is_file($thumb)){
    $picturefile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$thumb);
  }else{
    $picturefile = _HTTP_PATH_."/"._MAIN_FOLDER_SYSTEM_."/assets/img/avatars/1.jpg";
  }

  $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
?>
<div class="page-heading">
    <div class="media clearfix">
      <div class="media-left pr30">
        <a href="#" class="boxviewimages">
          <img class="media-object mw150" src="<?php echo $picturefile?>" alt="...">
        </a>
      </div>
      <div class="media-body va-m">
        <h2 class="media-heading"><?php echo $Fullname?> <small> - Profile</small></h2>
        <p class="lead">Username : <?php echo $Username?></p>
        <div class="media-links">
          <ul class="list-inline list-unstyled">
            <li class="">
              <a href="#" title="phone link <?php echo $Tel?>">
                <span class="fa fa-phone-square fs35 text-system"></span>
              </a>
            </li>
            <li>
              <a href="mailto:<?php echo $Email?>" title="email link <?php echo $Email?>">
                <span class="fa fa-envelope-square fs35 text-muted"></span>
              </a>
            </li>
            <li class="hidden">
              <a href="#" title="external link">
                <span class="fa fa-external-link-square fs35 text-muted"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>
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
                <td><?php echo $Array_Lang["txt:Create Date"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo dateformat($CreateDate,'F j, Y H:i')?></td>
              </tr>
              <tr>
                <td><span class="fa fa-clock-o text-warning"></span></td>
                <td><?php echo $Array_Lang["txt:Last Update"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo dateformat($LastUpdate,'F j, Y H:i')?></td>
              </tr>
              <tr>
                <td><span class="fa fa-clock-o text-warning"></span></td>
                <td><?php echo $Array_Lang["txt:Last Login"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo dateformat($userLastlogin,'F j, Y H:i')?></td>
              </tr>
              <tr>
                <td><span class="fa fa-user text-primary"></span></td>
                <td><?php echo $Array_Lang["txt:Create By"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo $CreateBy?></td>
              </tr>
              <tr>
                <td><span class="fa fa-repeat text-primary"></span></td>
                <td><?php echo $Array_Lang["txt:Status"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo $SStatusText?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel">
        <div class="panel-heading">
          <span class="panel-icon">
            <i class="fa fa-pencil"></i>
          </span>
          <span class="panel-title">User Detail</span>
        </div>
        <div class="panel-body pb5">
          <h4><?php echo $Array_Mod_Lang["txt:fullname"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Fullname?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:UserName"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Username?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:User Type"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $UserType?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:User Level"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $systemuserlevel[$Level]?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:useremail"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Email?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:telephone"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Tel?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txt:Note"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Remark?></p>
        </div>
      </div>
    </div>
  </div>

<!-- edit panel -->
<div class="panel mb25 mt5">
  <div class="panel-body p20 pb10">
  <form name="myFrm" id="myFrm" action="?" method="post">
    <input type="hidden" name="imageData" value="" />
    <input type="hidden" name="saveData" value="<?php echo $saveData?>" />
          <div class="tab-content pn br-n admin-form">
            <div id="tab1_1" class="tab-pane active">
              <div class="section row mbn">
                <div class="col-sm-4">&nbsp;</div>
                <div class="col-sm-8">
                  <p class="text-right">
                    <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
                    <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button>
                  </p>
                </div>
              </div>
            </div>
          </div>
  </form>
  </div>
</div>
