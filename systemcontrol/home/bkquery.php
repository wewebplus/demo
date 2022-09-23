<?php
/*
$DM01Start = date('Y-m-d',mktime(0,0,0,1,1,date("Y")));
$DM01End = date('Y-m-t',mktime(0,0,0,1,1,date("Y")));

$DM02Start = date('Y-m-d',mktime(0,0,0,2,1,date("Y")));
$DM02End = date('Y-m-t',mktime(0,0,0,2,1,date("Y")));

$DM03Start = date('Y-m-d',mktime(0,0,0,3,1,date("Y")));
$DM03End = date('Y-m-t',mktime(0,0,0,3,1,date("Y")));

$DM04Start = date('Y-m-d',mktime(0,0,0,4,1,date("Y")));
$DM04End = date('Y-m-t',mktime(0,0,0,4,1,date("Y")));

$DM05Start = date('Y-m-d',mktime(0,0,0,5,1,date("Y")));
$DM05End = date('Y-m-t',mktime(0,0,0,5,1,date("Y")));

$DM06Start = date('Y-m-d',mktime(0,0,0,6,1,date("Y")));
$DM06End = date('Y-m-t',mktime(0,0,0,6,1,date("Y")));

$DM07Start = date('Y-m-d',mktime(0,0,0,7,1,date("Y")));
$DM07End = date('Y-m-t',mktime(0,0,0,7,1,date("Y")));

$DM08Start = date('Y-m-d',mktime(0,0,0,8,1,date("Y")));
$DM08End = date('Y-m-t',mktime(0,0,0,8,1,date("Y")));

$DM09Start = date('Y-m-d',mktime(0,0,0,9,1,date("Y")));
$DM09End = date('Y-m-t',mktime(0,0,0,9,1,date("Y")));

$DM10Start = date('Y-m-d',mktime(0,0,0,10,1,date("Y")));
$DM10End = date('Y-m-t',mktime(0,0,0,10,1,date("Y")));

$DM11Start = date('Y-m-d',mktime(0,0,0,11,1,date("Y")));
$DM11End = date('Y-m-t',mktime(0,0,0,11,1,date("Y")));

$DM12Start = date('Y-m-d',mktime(0,0,0,12,1,date("Y")));
$DM12End = date('Y-m-t',mktime(0,0,0,12,1,date("Y")));
*/
/*
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "(";
	$sql .= "SELECT ";
	$sql .= " COUNT(*) AS 'CountData'";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM01Start."' AND '".$DM01End."', 1, 0)) AS DM01";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM02Start."' AND '".$DM02End."', 1, 0)) AS DM02";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM03Start."' AND '".$DM03End."', 1, 0)) AS DM03";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM04Start."' AND '".$DM04End."', 1, 0)) AS DM04";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM05Start."' AND '".$DM05End."', 1, 0)) AS DM05";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM06Start."' AND '".$DM06End."', 1, 0)) AS DM06";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM07Start."' AND '".$DM07End."', 1, 0)) AS DM07";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM08Start."' AND '".$DM08End."', 1, 0)) AS DM08";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM09Start."' AND '".$DM09End."', 1, 0)) AS DM09";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM10Start."' AND '".$DM10End."', 1, 0)) AS DM10";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM11Start."' AND '".$DM11End."', 1, 0)) AS DM11";
  $sql .= " ,SUM(IF(DATE("._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM12Start."' AND '".$DM12End."', 1, 0)) AS DM12";
  $sql .= " ,SUM(IF("._TABLE_MEMBER_."_Sex = 'F', 1, 0)) AS Female";
  $sql .= " ,SUM(IF("._TABLE_MEMBER_."_Sex = 'M', 1, 0)) AS Male";
	$sql .= " FROM "._TABLE_MEMBER_." AS p";
	$sql .= " WHERE DATE(p."._TABLE_MEMBER_."_CreateDate) BETWEEN '".$DM01Start."' AND '".$DM12End."'";
$sql .= ") TB";
echo $sql;
*/
/*
$sql = "";
$sql .= "SELECT * FROM ";
$sql .= "(";
  $sql .= "(";
    $ArrField[] = "(SELECT 'Female') AS Sex";
    $ArrField[] = "COUNT(*) AS 'CountData'";
    $ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
    $ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
    $ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
    $ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
    $ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
    $ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
    $ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
    $sql .= "SELECT ".implode(",",$ArrField)." FROM ";
    $sql .= "(";
      $sql .= "SELECT ";
      $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
      $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
      //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
      $sql .= " FROM "._TABLE_MEMBER_." AS p";
      $sql .= " WHERE p."._TABLE_MEMBER_."_Sex = 'F'";
    $sql .= ") TB";
    unset($ArrField);
  $sql .= ") UNION (";
    $ArrField[] = "(SELECT 'Male') AS Sex";
    $ArrField[] = "COUNT(*) AS 'CountData'";
    $ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
    $ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
    $ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
    $ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
    $ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
    $ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
    $ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
    $sql .= "SELECT ".implode(",",$ArrField)." FROM ";
    $sql .= "(";
      $sql .= "SELECT ";
      $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
      $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
      //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
      $sql .= " FROM "._TABLE_MEMBER_." AS p";
      //$sql .= " WHERE LOWER(p."._TABLE_MEMBER_."_Sex) = 'M'";
      $sql .= " WHERE p."._TABLE_MEMBER_."_Sex = 'M'";
    $sql .= ") TB";
    unset($ArrField);
  $sql .= ") UNION (";
    $ArrField[] = "(SELECT 'Unknown') AS Sex";
    $ArrField[] = "COUNT(*) AS 'CountData'";
    $ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
    $ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
    $ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
    $ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
    $ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
    $ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
    $ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
    $sql .= "SELECT ".implode(",",$ArrField)." FROM ";
    $sql .= "(";
      $sql .= "SELECT ";
      $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
      $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
      //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
      $sql .= " FROM "._TABLE_MEMBER_." AS p";
      $sql .= " WHERE (p."._TABLE_MEMBER_."_Sex = '' OR p."._TABLE_MEMBER_."_Sex IS NULL)";
    $sql .= ") TB";
    unset($ArrField);
  $sql .= ")";
$sql .= ") TBUnion";
$z = new __webctrl;
$z->sql($sql);
$RecordCount = $z->num();
$Age = array();
if($RecordCount>0){
  $v = $z->row();
  foreach($v as $Row){
    $ar["visible"] = true;
    $ar["name"] = $Row["CountData"];
    $ar["incount"] = $Row["Sex"];
    $arrdata = array();
    for($i=1;$i<=7;$i++){
      $arrdata[] = $Row["Age".$i];
    }
    $ar["data"] = $arrdata;
    $Age[] = $ar;
  }
}
echo '<pre>';
print_r($Age);
echo '</pre>';
*/
//$ArrField[] = "TB.*";
/*
$ArrField[] = "(SELECT 'Female') AS Sex";
$ArrField[] = "COUNT(*) AS 'CountData'";
$ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
$ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
$ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
$ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
$ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
$ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
$ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
$sql .= "SELECT ".implode(",",$ArrField)." FROM ";
$sql .= "(";
  $sql .= "SELECT ";
  $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
  $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
  //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
  $sql .= " FROM "._TABLE_MEMBER_." AS p";
  $sql .= " WHERE p."._TABLE_MEMBER_."_Sex = 'F'";
$sql .= ") TB";
unset($ArrField);
*/
/*
$ArrField[] = "(SELECT 'Male') AS Sex";
$ArrField[] = "COUNT(*) AS 'CountData'";
$ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
$ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
$ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
$ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
$ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
$ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
$ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
$sql .= "SELECT ".implode(",",$ArrField)." FROM ";
$sql .= "(";
  $sql .= "SELECT ";
  $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
  $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
  //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
  $sql .= " FROM "._TABLE_MEMBER_." AS p";
  //$sql .= " WHERE LOWER(p."._TABLE_MEMBER_."_Sex) = 'M'";
  $sql .= " WHERE p."._TABLE_MEMBER_."_Sex = 'M'";
$sql .= ") TB";
unset($ArrField);
*/
/*
$ArrField[] = "(SELECT 'Unknown') AS Sex";
$ArrField[] = "COUNT(*) AS 'CountData'";
$ArrField[] = "SUM(IF(Age BETWEEN '0' AND '17', 1, 0)) AS Age1";
$ArrField[] = "SUM(IF(Age BETWEEN '18' AND '24', 1, 0)) AS Age2";
$ArrField[] = "SUM(IF(Age BETWEEN '25' AND '34', 1, 0)) AS Age3";
$ArrField[] = "SUM(IF(Age BETWEEN '35' AND '44', 1, 0)) AS Age4";
$ArrField[] = "SUM(IF(Age BETWEEN '45' AND '54', 1, 0)) AS Age5";
$ArrField[] = "SUM(IF(Age BETWEEN '55' AND '64', 1, 0)) AS Age6";
$ArrField[] = "SUM(IF(Age > 64, 1, 0)) AS Age7";
$sql .= "SELECT ".implode(",",$ArrField)." FROM ";
$sql .= "(";
  $sql .= "SELECT ";
  $sql .= "p."._TABLE_MEMBER_."_Sex AS SEX, p."._TABLE_MEMBER_."_Birthday AS Birthday";
  $sql .= ",IF(p."._TABLE_MEMBER_."_Birthday='0000-00-00',0,YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday)) AS Age";
  //$sql .= ",YEAR(CURDATE()) - YEAR(p."._TABLE_MEMBER_."_Birthday) AS InAge";
  $sql .= " FROM "._TABLE_MEMBER_." AS p";
  $sql .= " WHERE (p."._TABLE_MEMBER_."_Sex = '' OR p."._TABLE_MEMBER_."_Sex IS NULL)";
$sql .= ") TB";
unset($ArrField);
*/

/*
$P = array();
$P["table"] = _TABLE_PRIVILEGE_GROUP_;
$P["lang"] = $systemLang;
$P["selectid"] = 0;
$P["modkey"] = "Admin5";
$P["modtextselect"] = array('Thai'=>"Select Group ...",'English'=>"Select Group ...");
$arrgroup = getGroup($P);
$sql = "";
$sql .= "SELECT ";
  //$sql .= " * ";
  $sql .= " COUNT(*) AS 'CountData'";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '00:00' AND '02:59', 1, 0)) AS TM01";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '03:00' AND '05:59', 1, 0)) AS TM02";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '06:00' AND '08:59', 1, 0)) AS TM03";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '09:00' AND '11:59', 1, 0)) AS TM04";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '12:00' AND '14:59', 1, 0)) AS TM05";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '15:00' AND '17:59', 1, 0)) AS TM06";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '18:00' AND '20:59', 1, 0)) AS TM07";
  $sql .= " ,SUM(IF(TIME(TBMain.InUpdateDate) BETWEEN '21:00' AND '23:59', 1, 0)) AS TM08";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 1, 1, 0)) AS TW01";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 2, 1, 0)) AS TW02";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 3, 1, 0)) AS TW03";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 4, 1, 0)) AS TW04";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 5, 1, 0)) AS TW05";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 6, 1, 0)) AS TW06";
  $sql .= " ,SUM(IF(TIME(TBMain.MyDate) = 7, 1, 0)) AS TW07";
  foreach($arrgroup->data as $xk=>$xv){
    $sql .= " ,SUM(IF(FIND_IN_SET('".$xv["id"]."', TBMain.MemberLifeStyle), 1, 0)) AS TL".$xv["id"];
  }
$sql .= " FROM ";
$sql .= "(";
  $arrfmain[] = "SUBSTRING(TB.UsageUpdateDate,12,5) AS InUpdateDate";
  $arrfmain[] = "SUBSTRING(TB.UsageUpdateDate,1,10) AS InDate";
  $arrfmain[] = "DAYOFWEEK(TB.UsageUpdateDate) AS MyDate";
  $arrfmain[] = "TB.*";
  $arrfmain[] = "TBMJoin.*";
  $arrfmain[] = "(SELECT "._TABLE_MEMBER_LOOKUP_."_Type FROM "._TABLE_MEMBER_LOOKUP_." WHERE "._TABLE_MEMBER_LOOKUP_."_IDCard COLLATE utf8_general_ci = TBMJoin.IDCard) AS CHKIDCARD";
  $sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
  $sql .= "(";

  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_ID AS ID';
  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_ContentID AS ContentID';
  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_Code AS Code';
  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_ByMembID AS ByMembID';
  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_ByMembType AS ByMembType';
  	$arrf[] = "a."._TABLE_PRIVILEGE_IMPORT_.'_UpdateDate AS CreateDate';
  	$arrf[] = "TBJoin.*";
  	$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_PRIVILEGE_IMPORT_." a";

  	$sql .= " LEFT JOIN (";
  		$sql .= "SELECT * FROM ";
      $sql .= "(";
  			$sql .= "(";
  				$sql .= "SELECT "._TABLE_PRIVILEGE_CODE_."_Code AS UsageCode,"._TABLE_PRIVILEGE_CODE_."_UpdateDate AS UsageUpdateDate,"._TABLE_PRIVILEGE_CODE_."_ByMembID AS UsageByMembID,"._TABLE_PRIVILEGE_CODE_."_ByMembType AS UsageByMembType,(SELECT 'Usage') AS Type FROM "._TABLE_PRIVILEGE_CODE_;
  				$sql .= " WHERE "._TABLE_PRIVILEGE_CODE_."_ContentID > 0 ";
  			$sql .= ")";
  			$sql .= " UNION ";
  			$sql .= "(";
  				$sql .= "SELECT "._TABLE_PRIVILEGE_IMPORT_."_Code AS UsageCode,"._TABLE_PRIVILEGE_IMPORT_."_UpdateDate AS UsageUpdateDate,"._TABLE_PRIVILEGE_IMPORT_."_ByMembID AS UsageByMembID,"._TABLE_PRIVILEGE_IMPORT_."_ByMembType AS UsageByMembType,(SELECT 'Base') AS Type FROM "._TABLE_PRIVILEGE_IMPORT_;
  				$sql .= " WHERE "._TABLE_PRIVILEGE_IMPORT_."_ContentID > 0 ";
  			$sql .= ")";
  		$sql .= ") TBUnion GROUP BY TBUnion.UsageCode";
  	$sql .= ") TBJoin ON (a."._TABLE_PRIVILEGE_IMPORT_."_Code = TBJoin.UsageCode)";
  	$sql .= " WHERE "._TABLE_PRIVILEGE_IMPORT_."_ContentID > 0 ";
  	unset($arrf);
  $sql .= ") TB ";
  $sql .= " LEFT JOIN (";
  	$sql .= "SELECT member_id AS MTIMemberID,idcard AS IDCard,name AS FName,surname AS LName,tel AS Tel,email AS Email,member_type AS MemLevel";
    $sql .= ",TBMJoin.*";
  	$sql .= " FROM "._TABLE_MEMBER_MTICONNECT_;
    $sql .= " LEFT JOIN (";
      $sql .= "SELECT "._TABLE_MEMBER_."_ID AS MemberID, "._TABLE_MEMBER_."_MTIMemberID AS JoinMTIMemberID, "._TABLE_MEMBER_."_MemberCode AS MemberCode";
      $sql .= ",CONCAT("._TABLE_MEMBER_."_FName, ' ', "._TABLE_MEMBER_."_LName) AS FullName";
      $sql .= ",GROUP_CONCAT(TMD."._TABLE_MEMBER_DETAIL_."_SubjectKey) AS MemberLifeStyle";
      $sql .= " FROM "._TABLE_MEMBER_;
      $sql .= " LEFT JOIN "._TABLE_MEMBER_DETAIL_." TMD ON ("._TABLE_MEMBER_DETAIL_."_MemberID = "._TABLE_MEMBER_."_ID AND "._TABLE_MEMBER_DETAIL_."_Type = 'Lifestyle')";
      $sql .= " WHERE 1";
      $sql .= " GROUP BY TMD."._TABLE_MEMBER_DETAIL_."_MemberID";
    $sql .= ") TBMJoin ON (member_id=TBMJoin.JoinMTIMemberID)";

  $sql .= ") TBMJoin ON (TB.UsageByMembID = TBMJoin.MTIMemberID)";
  unset($arrfmain);
$sql .= ") TBMain";
$sql .= " WHERE (TIME(TBMain.InUpdateDate) BETWEEN '00:00' AND '23:59')";
$sql .= " ORDER BY TIME(TBMain.MyDate) ASC";
echo $sql;

$arrLifestyle = array();
foreach($arrgroup->data as $xk=>$xv){
  if($xk>0){
		$arr = array();
		$arr["name"] = HTMLEntityTocharacter($xv["SubjectThai"]);
		$arr["y"] = intval($xv["id"]);
		$arr["sliced"] = ($xk==5?true:false);
		$arr["selected"] = ($xk==5?true:false);
    $arrLifestyle[] = $arr;
  }
}
echo "<pre>";
print_r($arrLifestyle);
echo "</pre>";
*/

//echo $sql;
?>
