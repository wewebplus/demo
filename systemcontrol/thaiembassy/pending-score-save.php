<?php
include("../assets/lib/inc.config.php");
include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
decode_URL($_POST["saveData"]);
if(!empty($Login_MenuID)){
  $indexLogin_MenuID = substr($Login_MenuID,5);
  $mymenuinclude = @$menuFolder[$indexLogin_MenuID];
}else{
  $mymenuinclude = "";
}
include(_DIRROOTPATH_SYSTEM_."/dataarray/data".$mymenuinclude.".php");
decode_URL($_POST["saveAuditors"]);
// echo $AuditorsID;
// echo ":".$RestaurantID;
// echo $actiontype;
// _TABLE_RESTAURANT_SCORE_
if($actiontype=='savescore'){
  $saveResType = $_POST["saveResType"];
  $RestaurantName = $_POST["RestaurantName"];
  $Address = $_POST["Address"];
  $OpenClose = $_POST["OpenClose"];
  $CityID = (!empty($_POST["CityID"])?$_POST["CityID"]:0);
  $CityName = $_POST["CityName"];
  $CountryID = (!empty($_POST["CountryID"])?$_POST["CountryID"]:0);
  $Country = $_POST["Country"];
  $Fullname = $_POST["Fullname"];
  $Position = $_POST["Position"];
  $InspectionID = (!empty($_POST["InspectionID"])?$_POST["InspectionID"]:0);
  $InspectionName = $_POST["InspectionName"];
  $InspectionDate = convertdatetodb($_POST["InspectionDate"],'EN')." ".date("H:i:s");
  $PassTheCriteria = (!empty($_POST["PassTheCriteria"])?$_POST["PassTheCriteria"]:'F');

  $arrField = array();
  $arrField["Section2No1_1Score"] = floatval(str_replace(",","",$_POST["Section2No1_1Score"]));
  $arrField["Section2No1_1Remark"] = $_POST["Section2No1_1Remark"];
  $arrField["Section2No1_2Score"] = floatval(str_replace(",","",$_POST["Section2No1_2Score"]));
  $arrField["Section2No1_2Remark"] = $_POST["Section2No1_2Remark"];
  $arrField["Section2No2_1Score"] = floatval(str_replace(",","",$_POST["Section2No2_1Score"]));
  $arrField["Section2No2_1Remark"] = $_POST["Section2No2_1Remark"];
  $arrField["Section2No3_1Score"] = floatval(str_replace(",","",$_POST["Section2No3_1Score"]));
  $arrField["Section2No3_1Remark"] = $_POST["Section2No3_1Remark"];
  $arrField["Section2No4_1Score"] = floatval(str_replace(",","",$_POST["Section2No4_1Score"]));
  $arrField["Section2No4_1Remark"] = $_POST["Section2No4_1Remark"];
  $arrField["Section2No4_2Score"] = floatval(str_replace(",","",$_POST["Section2No4_2Score"]));
  $arrField["Section2No4_2Remark"] = $_POST["Section2No4_2Remark"];
  $arrField["Section2No5_1Score"] = floatval(str_replace(",","",$_POST["Section2No5_1Score"]));
  $arrField["Section2No5_1Remark"] = $_POST["Section2No5_1Remark"];
  $arrField["Section2No6_1Score"] = floatval(str_replace(",","",$_POST["Section2No6_1Score"]));
  $arrField["Section2No6_1Remark"] = $_POST["Section2No6_1Remark"];
  $arrField["Section2No6_2Score"] = floatval(str_replace(",","",$_POST["Section2No6_2Score"]));
  $arrField["Section2No6_2Remark"] = $_POST["Section2No6_2Remark"];
  $arrField["Section3No7_1Score"] = floatval(str_replace(",","",$_POST["Section3No7_1Score"]));
  $arrField["Section3No7_1Remark"] = $_POST["Section3No7_1Remark"];
  $arrField["Section3No7_2Score"] = floatval(str_replace(",","",$_POST["Section3No7_2Score"]));
  $arrField["Section3No7_2Remark"] = $_POST["Section3No7_2Remark"];
  $arrField["Section3No8_1Score"] = floatval(str_replace(",","",$_POST["Section3No8_1Score"]));
  $arrField["Section3No8_1Remark"] = $_POST["Section3No8_1Remark"];
  $arrField["Section3No8_2Score"] = floatval(str_replace(",","",$_POST["Section3No8_2Score"]));
  $arrField["Section3No8_2Remark"] = $_POST["Section3No8_2Remark"];
  $arrField["Section3No9_1Score"] = floatval(str_replace(",","",$_POST["Section3No9_1Score"]));
  $arrField["Section3No9_1Remark"] = $_POST["Section3No9_1Remark"];
  $arrField["Section3No9_2Score"] = floatval(str_replace(",","",$_POST["Section3No9_2Score"]));
  $arrField["Section3No9_2Remark"] = $_POST["Section3No9_2Remark"];

  $Section2Total = (!empty($_POST["Section2Total"])?$_POST["Section2Total"]:0);
  $Section3Total = (!empty($_POST["Section3Total"])?$_POST["Section3Total"]:0);
  $SectionTotalAll = (!empty($_POST["SectionTotalAll"])?$_POST["SectionTotalAll"]:0);

  /*
  $Section2No1_1Score = $_POST["Section2No1_1Score"];
  $Section2No1_1Score = floatval(str_replace(",","",$Section2No1_1Score));
  $Section2No1_1Remark = $_POST["Section2No1_1Remark"];
  $Section2No1_2Score = $_POST["Section2No1_2Score"];
  $Section2No1_2Score = floatval(str_replace(",","",$Section2No1_2Score));
  $Section2No1_2Remark = $_POST["Section2No1_2Remark"];
  */


  $IP = get_real_ip();
  $ua = @getBrowser();
  $browser = $ua['name']." ".$ua['version'];
  $platform = $ua['platform'];
  $userAgent = $ua['userAgent'];

  $insert = array();
  $insert[_TABLE_RESTAURANT_SCORE_.'_CreateDate'] = "NOW()";
  $insert[_TABLE_RESTAURANT_SCORE_.'_IP'] = "'".sql_safe($IP)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Browser'] = "'".sql_safe($browser)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Platform'] = "'".sql_safe($platform)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_userAgent'] = "'".sql_safe($userAgent)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Type'] = "'".sql_safe($saveResType)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_PassTheCriteria'] = "'".sql_safe($PassTheCriteria)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_ContentID'] = sql_safe($RestaurantID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_FromMemberID'] = sql_safe($AuditorsID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_MemberID'] = sql_safe($AuditorsID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_RestaurantName'] = "'".sql_safe($RestaurantName)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Address'] = "'".sql_safe($Address)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_OpenClose'] = "'".sql_safe($OpenClose)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_CountryID'] = sql_safe($CountryID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_Country'] = "'".sql_safe($Country)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_CityID'] = sql_safe($CityID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_CityName'] = "'".sql_safe($CityName)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Fullname'] = "'".sql_safe($Fullname)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_Position'] = sql_safe($Position,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_InspectionID'] = sql_safe($InspectionID,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_InspectionName'] = "'".sql_safe($InspectionName)."'";
  $insert[_TABLE_RESTAURANT_SCORE_.'_InspectionDate'] = "'".sql_safe($InspectionDate)."'";
  foreach($arrField as $KField=>$VField){
    $insert[_TABLE_RESTAURANT_SCORE_.'_'.$KField] = sql_safe($VField,false,true);
  }
  $insert[_TABLE_RESTAURANT_SCORE_.'_Section2Total'] = sql_safe($Section2Total,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_Section3Total'] = sql_safe($Section3Total,false,true);
  $insert[_TABLE_RESTAURANT_SCORE_.'_SectionTotalAll'] = sql_safe($SectionTotalAll,false,true);
  // echo '<pre>';
  // print_r($insert);
  // echo '</pre>';
  $z = new __webctrl;
  $z->insert(_TABLE_RESTAURANT_SCORE_,$insert);
  $insertid = $z->insertid();
  unset($insert);
  // echo $insertid;
  if($insertid>0){
    if(isset($_POST["Section2No4_2Detail"])){
      foreach($_POST["Section2No4_2Detail"] as $KK=>$RSection2No4_2Detail){
        // echo $RSection2No4_2Detail;
        $insert = array();
        $insert[_TABLE_RESTAURANT_SCORE_DETAIL_.'_Type'] = "'Section2No4_2Detail'";
        $insert[_TABLE_RESTAURANT_SCORE_DETAIL_.'_ContentID'] = sql_safe($insertid,false,true);
        $insert[_TABLE_RESTAURANT_SCORE_DETAIL_.'_Detail'] = "'".sql_safe($RSection2No4_2Detail)."'";
        $insert[_TABLE_RESTAURANT_SCORE_DETAIL_.'_UpdateDate'] = "NOW()";
        $insert[_TABLE_RESTAURANT_SCORE_DETAIL_.'_Order'] = sql_safe($KK,false,true);
        $z->insert(_TABLE_RESTAURANT_SCORE_DETAIL_,$insert);
        unset($insert);
        //
        // echo '<pre>';
        // print_r($insert);
        // echo '</pre>';
      }
    }
  }
  if(intval($RestaurantID)>0){
    $sql = "SELECT COUNT(*) AS CountScore FROM "._TABLE_RESTAURANT_SCORE_." WHERE "._TABLE_RESTAURANT_SCORE_."_ContentID = ".intval($RestaurantID);
    $z->sql($sql);
    $vCountR = $z->row();
    if($vCountR[0]["CountScore"]==1){
      $Percen = 25;
    }else if($vCountR[0]["CountScore"]>1){
      $Percen = 50;
    }
    $update[_TABLE_RESTAURANT_.'_ApproveStatus'] = "'WaitApprove'";
    $update[_TABLE_RESTAURANT_."_Percen"] = sql_safe($Percen,false,true);
    $z = new __webctrl;
    $z->update(_TABLE_RESTAURANT_,$update,array(_TABLE_RESTAURANT_."_ID=" => intval($RestaurantID)));
    unset($update);
  }
}
?>
