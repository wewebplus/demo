<?php
  //$sql="SELECT * FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_ID = ".(int)$itemid;
  $sql = "";
  $sql .= "SELECT TB.*";
  $sql .= ",CASE WHEN TB.CreateByID = 1000 THEN '"._UserRoot_."' ELSE CONCAT(TB.JoinFName, ' ', TB.JoinLName) END AS CreateNameShow";
  $sql .= " FROM (";
    $sql .= "SELECT "._TABLE_ADMIN_STAFF_."_ID AS ID,"._TABLE_ADMIN_STAFF_."_FName AS FName,"._TABLE_ADMIN_STAFF_."_LName AS LName,"._TABLE_ADMIN_STAFF_."_Email AS Email,"._TABLE_ADMIN_STAFF_."_Tel AS Tel,"._TABLE_ADMIN_STAFF_."_Remark AS Remark,"._TABLE_ADMIN_STAFF_."_CreateByID AS CreateByID,"._TABLE_ADMIN_STAFF_."_CreateDate AS CreateDate,"._TABLE_ADMIN_STAFF_."_LastUpdate AS LastUpdate,"._TABLE_ADMIN_STAFF_."_PictureFileSrc AS PictureFileSrc,"._TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile,"._TABLE_ADMIN_STAFF_."_Status AS SStatus,"._TABLE_ADMIN_STAFF_."_InType AS InType,TBJoin.* FROM "._TABLE_ADMIN_STAFF_." TBmain";
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT "._TABLE_ADMIN_STAFF_."_ID AS JoinID,"._TABLE_ADMIN_STAFF_."_FName AS JoinFName,"._TABLE_ADMIN_STAFF_."_LName AS JoinLName FROM "._TABLE_ADMIN_STAFF_;
    $sql .= ") TBJoin ON (TBmain."._TABLE_ADMIN_STAFF_."_CreateByID = TBJoin.JoinID)";
  $sql .= ") TB";
  $sql .= " WHERE TB.ID = ".(int)$itemid;
  $z = new __webctrl;
  $z->sql($sql);
  $v = $z->row();
  $num = $z->num();
  $Row = $v[0];
  $ID = $Row["ID"];
  $FName = $Row["FName"];
  $LName = $Row["LName"];
  $Email = $Row["Email"];
  $Tel = $Row["Tel"];
  $InType = $Row["InType"];
  $Remark = echoDetailToediter($Row["Remark"]);
  $CreateDate = $Row["CreateDate"];
  $LastUpdate = $Row["LastUpdate"];
  $CreateByID = $Row["CreateByID"];
  $CreateBy = $Row["CreateNameShow"];
  $SStatus = $Row["SStatus"];
  if($SStatus=="On"){
    $SStatusText = '<span class="text-primary">'.$arrinStatus[$_SESSION['Session_Admin_Language']][$SStatus].'</span>';
  }else{
    $SStatusText = '<span class="text-danger">'.$arrinStatus[$_SESSION['Session_Admin_Language']][$SStatus].'</span>';
  }
  $oldPictureFile = _RELATIVE_EMPLOYEE_UPLOAD_.$Row["PictureFile"];
  $saveData = encode_URL('Login_MenuID='.$Login_MenuID.'&itemid='.$ID.'&actiontype=edit&actionpage='.(empty($_GET["page"])?$actionpage:$_GET["page"]));
  if(is_file($oldPictureFile)){
    $thumbImg = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$oldPictureFile);
  }else{
    $thumbImg = "../assets/img/avatars/profile_avatar.jpg";
  }
  $Fullname = $FName." ".$LName;
?>
<div class="page-heading">
    <div class="media clearfix">
      <div class="media-left pr30">
        <a href="#" class="boxviewimages">
          <img class="media-object mw150" src="<?php echo $thumbImg?>" alt="...">
        </a>
      </div>
      <div class="media-body va-m">
        <?php //echo   $sql;?>
        <h2 class="media-heading"><?php echo $Fullname?> <small> - Profile</small>
        </h2>
        <p class="lead"><?php echo $Remark?></p>
        <div class="media-links">
          <ul class="list-inline list-unstyled">
            <li class="hidden">
              <a href="#" title="facebook link">
                <span class="fa fa-facebook-square fs35 text-primary"></span>
              </a>
            </li>
            <li class="hidden">
              <a href="#" title="twitter link">
                <span class="fa fa-twitter-square fs35 text-info"></span>
              </a>
            </li>
            <li class="hidden">
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
                <td><?php echo dateformat($CreateDate,'j F Y H:i',$_SESSION['Session_Admin_Language'])?></td>
              </tr>
              <tr>
                <td><span class="fa fa-clock-o text-warning"></span></td>
                <td><?php echo $Array_Lang["txt:Last Update"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo dateformat($LastUpdate,'j F Y H:i',$_SESSION['Session_Admin_Language'])?></td>
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
              <tr>
                <td><span class="fa fa-repeat text-primary"></span></td>
                <td><?php echo $Array_Mod_Lang["txtinput:Emp_Type"][$_SESSION['Session_Admin_Language']]?></td>
                <td><?php echo $arrInType[$_SESSION['Session_Admin_Language']][$InType]?></td>
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
          <span class="panel-title">Employee Detail</span>
        </div>
        <div class="panel-body pb5">
          <h4><?php echo $Array_Mod_Lang["txtinput:fullname"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Fullname?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txtinput:useremail"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Email?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txtinput:telephone"][$_SESSION['Session_Admin_Language']]?></h4>
          <p class="text-muted"><?php echo $Tel?></p>
          <hr class="short br-lighter">
          <h4><?php echo $Array_Mod_Lang["txtinput:Emp_note"][$_SESSION['Session_Admin_Language']]?></h4>
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
                <div class="col-sm-8">&nbsp;</div>
                <div class="col-sm-4">
                  <p class="text-right">
                    <button type="button" id="EditBtn" class="button btn-primary"><?php echo $Array_Lang["bt:Edit"][$_SESSION['Session_Admin_Language']]." ".$mymenuname?></button>
                    <button type="button" id="ListBtn" class="button btn-default"><?php echo $Array_Lang["bt:Return to List"][$_SESSION['Session_Admin_Language']]?></button></p>
                </div>
              </div>
            </div>
          </div>
  </form>
  </div>
</div>
