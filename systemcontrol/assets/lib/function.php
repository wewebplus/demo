<?php
function encode_URL($variable) {
//-- ฟังก์ชั่นการเข้ารหัส ตัวแปรแบบ GET ผ่าน URL
		$key = "xitgmLwmp";
		$index = 0;
		$temp="";
		$variable = str_replace("=","รฐO",$variable);
		for($i=0; $i < strlen($variable); $i++)
		{
				$temp .= $variable[$i].$key[$index];
				$index++;
				if($index >= strlen($key)) $index = 0;
		}
		$variable = strrev($temp);
		$variable = base64_encode($variable);
		$variable = utf8_encode($variable);
		$variable = urlencode($variable);
		$variable = str_rot13($variable);

		$variable = str_replace("%","o7o",$variable);
		return "valueID=".$variable;
}

function decode_URL($enVariable) {
//-- ฟังก์ชั่นการถอดรหัส ตัวแปรแบบ GET ผ่าน URL
// การใช้งาน decode_URL($_SERVER["QUERY_STRING"]);
		$key = "xitgmLwmp";
		if(!empty($enVariable)){
			$ex = explode("valueID=",$enVariable);
			$enVariable = $ex[1];
		}else{
			$enVariable = "";
		}
		$enVariable = str_replace("o7o","%",$enVariable);

		$enVariable = str_rot13($enVariable);
		$enVariable = urldecode($enVariable);
		$enVariable = utf8_decode($enVariable);
		$enVariable = base64_decode($enVariable);
		$enVariable = strrev($enVariable);

		$current = 0;
		$temp="";
		for($i=0; $i < strlen($enVariable); $i++)
		{
				if($current%2==0)
				{
					$temp .= $enVariable[$i];
				}
				$current++;
		}
		$temp = str_replace("รฐO","=",$temp);

		parse_str($temp, $variable);
		//echo "temp=".$temp;
		foreach($variable as $key=>$value)
		{
				$_REQUEST[$key]=$value;
				global $$key;
				$$key=$value;
		}
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function get_URL_Parameter() {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	global $Login_MenuID;
	$Parameter = (strlen($_SERVER["QUERY_STRING"]) > 0) ? "?".$_SERVER["QUERY_STRING"] : "?".encode_URL("Login_MenuID=".$Login_MenuID);
	return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"] . $Parameter ;
}
function strDec($str,$dot=1){
  $mynumber = number_format($str,$dot);
  $zero = formatStringtoZero("0",$dot);
  $mynumber = str_replace(".".$zero,"",$mynumber);
  $dec =  $mynumber;
  return $dec;
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function formatStringtoZero($num,$length) {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// การทำงาน สร้างรูปแบบดังนี้ '000000' โดยความยาวนั้นขึ้นอยู่กับ ค่า length แต่ต้องกำหนดให้มากกว่า 1
	$formated_num = strval($num);
	while (strlen($formated_num) < $length) {
		$formated_num = "0".$formated_num;
	}
	return $formated_num;
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function changeQuot($Data) {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	return str_replace("'","&rsquo;",str_replace('"','&quot;',$Data));
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function rechangeQuot($Data) {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	return str_replace("&rsquo;","'",str_replace('&quot;','"',$Data));
}
function convertdatetodb($mydate,$lang="Thai",$spd="/"){
	if(!empty($mydate)){
		$arrdate = explode($spd,$mydate);
		if($lang=="Thai"){
			$newdate = ($arrdate[2]-543)."-".formatStringtoZero($arrdate[1],2)."-".formatStringtoZero($arrdate[0],2);
		}else{
			$newdate = $arrdate[2]."-".formatStringtoZero($arrdate[1],2)."-".formatStringtoZero($arrdate[0],2);
		}
		return $newdate;
	}else{
		return '0000-00-00';
	}
}
function convertdatefromdb($mydate,$lang="Thai",$spd="/"){
	if($mydate=='0000-00-00' || $mydate=='0000-00-00 00:00:00'){
		return '';
	}else{
		if(!empty($mydate)){
			$arrdate = explode("-",$mydate);
			if($lang=="Thai"){
				$newdate = substr($arrdate[2],0,2).$spd.$arrdate[1].$spd.(intval($arrdate[0])+543);
			}else{
				$newdate = substr($arrdate[2],0,2).$spd.$arrdate[1].$spd.intval($arrdate[0]);
			}
/*
			if($lang=="Thai"){
				$newdate = intval($arrdate[2]).$spd.intval($arrdate[1]).$spd.(intval($arrdate[0])+543);
			}else{
				$newdate = intval($arrdate[2]).$spd.intval($arrdate[1]).$spd.intval($arrdate[0]);
			}
*/
			return $newdate;
		}else{
			return '';
		}
	}
}
function dateformat($d,$t='F j, Y',$lang='English'){
	$t = str_replace(array('Y','y','F'),array('__{Y}__','__{y}__','{F}'),$t);
	if(!empty($d)){
		if(trim($d)=="0000-00-00" || trim($d)=="0000-00-00 00:00:00"){
			return 'N/A';
		}else{
			list($date,$time)=explode(' ',$d); //2011-01-01 01:23:45 => [2011-01-01,01:23:45]
			list($y,$m,$d)=explode('-',$date); //2011-01-01 => [2011,01,01]
			list($h,$i,$s)=explode(':',$time); //01:23:45 => [01,23,45]
			if($h==''){$h=0;}
			if($i==''){$i=0;}
			if($s==''){$s=0;}
			$date = date($t,mktime($h,$i,$s,$m,$d,$y));
			if($lang<>'English'){
				$date=convertdatelang($date);
			}
			$date = str_replace(array('__{','}__','{','}'),'',$date);
			return $date;
		}
	}else{
		return 'N/A';
	}
}
function convertdatelang($date){
	$end = current(array_slice(explode('__{',$date), -1));
	$findYear = $end;
	$first = explode('}__',$findYear);
	$findYear = $first[0];
	//$findYear = end(explode('__{',$date)); //__{2011}__-01-01 01:02:03 => 2011}__-01-01 01:02:03
	//$findYear = reset(explode('}__',$findYear)); //2011}__-01-01 01:02:03 => 2011
	$yearDigit = strlen($findYear);

	//default
	$arrFullTxtDay = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$arrTxtDay = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
	$arrFullTxtMonth = array('{January}','{February}','{March}','{April}','{May}','{June}','{July}','{August}','{September}','{October}','{November}','{December}');
	$arrTxtMonth = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

	//convert
	$arrFullTxtDayConv = array('จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
	$arrTxtDayConv = array('จ','อ','พ','พฤ','ศ','ส','อา');
	$arrFullTxtMonthConv = array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$arrTxtMonthConv = array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

	$date = str_replace($arrFullTxtDay,$arrFullTxtDayConv,$date);
	$date = str_replace($arrTxtDay,$arrTxtDayConv,$date);
	$date = str_replace($arrFullTxtMonth,$arrFullTxtMonthConv,$date);
	$date = str_replace($arrTxtMonth,$arrTxtMonthConv,$date);
	if($yearDigit=='2'){$yth=$findYear+43;}
	if($yearDigit=='4'){$yth=$findYear+543;}
	$date = str_replace('__{'.$findYear.'}__',$yth,$date);

	return $date;
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function ShowDateLong($myDate,$Language="Thai") {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	if(trim($myDate)=="0000-00-00" || trim($myDate)=="0000-00-00 00:00:00"){
		return "N/A";
	}else{
	if($Language=="Thai"){
		$myDateArray=explode("-",$myDate);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "มกราคม";  break;
			case "02" : $myMonth = "กุมภาพันธ์";  break;
			case "03" : $myMonth = "มีนาคม"; break;
			case "04" : $myMonth = "เมษายน"; break;
			case "05" : $myMonth = "พฤษภาคม";   break;
			case "06" : $myMonth = "มิถุนายน";  break;
			case "07" : $myMonth = "กรกฎาคม";   break;
			case "08" : $myMonth = "สิงหาคม";  break;
			case "09" : $myMonth = "กันยายน";  break;
			case "10" : $myMonth = "ตุลาคม";  break;
			case "11" : $myMonth = "พฤศจิกายน";   break;
			case "12" : $myMonth = "ธันวาคม";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myDay . " " . $myMonth . " " . $myYear);
	}else{
		$myDateArray=explode("-",$myDate);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "January";   break;
			case "02" : $myMonth = "February";  break;
			case "03" : $myMonth = "March";     break;
			case "04" : $myMonth = "April";     break;
			case "05" : $myMonth = "May";       break;
			case "06" : $myMonth = "June";      break;
			case "07" : $myMonth = "July";      break;
			case "08" : $myMonth = "August";    break;
			case "09" : $myMonth = "September"; break;
			case "10" : $myMonth = "October";   break;
			case "11" : $myMonth = "November";  break;
			case "12" : $myMonth = "December";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0]);
        return($myDay . " " . $myMonth . " " . $myYear);
	}
	}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function ShowDateShot($myDate,$Language="Thai") {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	if(trim($myDate)=="0000-00-00" || trim($myDate)=="0000-00-00 00:00:00"){
		return "N/A";
	}else{
	if($Language=="Thai"){
		$myDateArray=explode("-",$myDate);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "ม.ค.";  break;
			case "02" : $myMonth = "ก.พ.";  break;
			case "03" : $myMonth = "มี.ค."; break;
			case "04" : $myMonth = "เม.ย."; break;
			case "05" : $myMonth = "พ.ค.";   break;
			case "06" : $myMonth = "มิ.ย.";  break;
			case "07" : $myMonth = "ก.ค.";   break;
			case "08" : $myMonth = "ส.ค.";  break;
			case "09" : $myMonth = "ก.ย.";  break;
			case "10" : $myMonth = "ต.ค.";  break;
			case "11" : $myMonth = "พ.ย.";   break;
			case "12" : $myMonth = "ธ.ค.";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0])+543;
        return($myDay . " " . $myMonth . " " . substr($myYear,1,2));
	}else{
		$myDateArray=explode("-",$myDate);
		$myDay = sprintf("%d",$myDateArray[2]);
		switch($myDateArray[1]) {
			case "01" : $myMonth = "Jan";   break;
			case "02" : $myMonth = "Feb";  break;
			case "03" : $myMonth = "Mar";     break;
			case "04" : $myMonth = "Apr";     break;
			case "05" : $myMonth = "May";       break;
			case "06" : $myMonth = "June";      break;
			case "07" : $myMonth = "July";      break;
			case "08" : $myMonth = "Aug";    break;
			case "09" : $myMonth = "Sep"; break;
			case "10" : $myMonth = "Oct";   break;
			case "11" : $myMonth = "Nov";  break;
			case "12" : $myMonth = "Dec";  break;
		}
		$myYear = sprintf("%d",$myDateArray[0]);
        return($myDay . " " . $myMonth . " " . substr($myYear,1,2));
	}
	}
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function ShowampmDate($myTime){
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	if(trim($myTime)<>"0000-00-00 00:00:00"){
		$TmpTime=explode(" ",$myTime);
		$timeArr=explode(":",$TmpTime[1]);
		$hour=intval($timeArr[0]);
		if($hour<13){
			$ampm="AM";
			if(strlen($hour)==1){
				$newHour="0".$hour;
			}else{
				$newHour=$hour;
			}
		}else{
			$ampm="PM";
			$newHour=$hour-12;

			if(strlen($newHour)==1){
				$newHour="0".$newHour;
			}else{
				$newHour=$newHour;
			}
		}

		$newTime=$newHour.":".$timeArr[1]." ".$ampm;
		return $newTime;
	}
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function setQuoteSql($value) {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	# copy มาจากเน็ต เอาไว้ใช้ป้องกัน อักขระ แปลกๆก่อนนำไปใช้ในการ Query
	# Stripslashes if quoted
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	return $value;
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function getHtmlFile($myFile, $length=0){
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		if(file_exists($myFile) && is_file($myFile))
		{
			$content = file_get_contents($myFile);
			if($length > 0)
			{
					$content = substr($content , 0 , $length);
			}

			return $content ;
		}
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
function UTF8toiso8859_11($string) {
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
       if ( ! ereg("[\241-\377]", $string) )
         return $string;

			 $UTF8 = array(
		"\xe0\xb8\x81" => "\xa1",
		"\xe0\xb8\x82" => "\xa2",
		"\xe0\xb8\x83" => "\xa3",
		"\xe0\xb8\x84" => "\xa4",
		"\xe0\xb8\x85" => "\xa5",
		"\xe0\xb8\x86" => "\xa6",
		"\xe0\xb8\x87" => "\xa7",
		"\xe0\xb8\x88" => "\xa8",
		"\xe0\xb8\x89" => "\xa9",
		"\xe0\xb8\x8a" => "\xaa",
		"\xe0\xb8\x8b" => "\xab",
		"\xe0\xb8\x8c" => "\xac",
		"\xe0\xb8\x8d" => "\xad",
		"\xe0\xb8\x8e" => "\xae",
		"\xe0\xb8\x8f" => "\xaf",
		"\xe0\xb8\x90" => "\xb0",
		"\xe0\xb8\x91" => "\xb1",
		"\xe0\xb8\x92" => "\xb2",
		"\xe0\xb8\x93" => "\xb3",
		"\xe0\xb8\x94" => "\xb4",
		"\xe0\xb8\x95" => "\xb5",
		"\xe0\xb8\x96" => "\xb6",
		"\xe0\xb8\x97" => "\xb7",
		"\xe0\xb8\x98" => "\xb8",
		"\xe0\xb8\x99" => "\xb9",
		"\xe0\xb8\x9a" => "\xba",
		"\xe0\xb8\x9b" => "\xbb",
		"\xe0\xb8\x9c" => "\xbc",
		"\xe0\xb8\x9d" => "\xbd",
		"\xe0\xb8\x9e" => "\xbe",
		"\xe0\xb8\x9f" => "\xbf",
		"\xe0\xb8\xa0" => "\xc0",
		"\xe0\xb8\xa1" => "\xc1",
		"\xe0\xb8\xa2" => "\xc2",
		"\xe0\xb8\xa3" => "\xc3",
		"\xe0\xb8\xa4" => "\xc4",
		"\xe0\xb8\xa5" => "\xc5",
		"\xe0\xb8\xa6" => "\xc6",
		"\xe0\xb8\xa7" => "\xc7",
		"\xe0\xb8\xa8" => "\xc8",
		"\xe0\xb8\xa9" => "\xc9",
		"\xe0\xb8\xaa" => "\xca",
		"\xe0\xb8\xab" => "\xcb",
		"\xe0\xb8\xac" => "\xcc",
		"\xe0\xb8\xad" => "\xcd",
		"\xe0\xb8\xae" => "\xce",
		"\xe0\xb8\xaf" => "\xcf",
		"\xe0\xb8\xb0" => "\xd0",
		"\xe0\xb8\xb1" => "\xd1",
		"\xe0\xb8\xb2" => "\xd2",
		"\xe0\xb8\xb3" => "\xd3",
		"\xe0\xb8\xb4" => "\xd4",
		"\xe0\xb8\xb5" => "\xd5",
		"\xe0\xb8\xb6" => "\xd6",
		"\xe0\xb8\xb7" => "\xd7",
		"\xe0\xb8\xb8" => "\xd8",
		"\xe0\xb8\xb9" => "\xd9",
		"\xe0\xb8\xba" => "\xda",
		"\xe0\xb8\xbf" => "\xdf",
		"\xe0\xb9\x80" => "\xe0",
		"\xe0\xb9\x81" => "\xe1",
		"\xe0\xb9\x82" => "\xe2",
		"\xe0\xb9\x83" => "\xe3",
		"\xe0\xb9\x84" => "\xe4",
		"\xe0\xb9\x85" => "\xe5",
		"\xe0\xb9\x86" => "\xe6",
		"\xe0\xb9\x87" => "\xe7",
		"\xe0\xb9\x88" => "\xe8",
		"\xe0\xb9\x89" => "\xe9",
		"\xe0\xb9\x8a" => "\xea",
		"\xe0\xb9\x8b" => "\xeb",
		"\xe0\xb9\x8c" => "\xec",
		"\xe0\xb9\x8d" => "\xed",
		"\xe0\xb9\x8e" => "\xee",
		"\xe0\xb9\x8f" => "\xef",
		"\xe0\xb9\x90" => "\xf0",
		"\xe0\xb9\x91" => "\xf1",
		"\xe0\xb9\x92" => "\xf2",
		"\xe0\xb9\x93" => "\xf3",
		"\xe0\xb9\x94" => "\xf4",
		"\xe0\xb9\x95" => "\xf5",
		"\xe0\xb9\x96" => "\xf6",
		"\xe0\xb9\x97" => "\xf7",
		"\xe0\xb9\x98" => "\xf8",
		"\xe0\xb9\x99" => "\xf9",
		"\xe0\xb9\x9a" => "\xfa",
		"\xe0\xb9\x9b" => "\xfb",
		 );

     $string=strtr($string,$UTF8);
     return $string;
 }

function getDateNow() {
        $today=getdate();
        $Day=$today[mday];
        $Month=$today[mon];
        $Year=$today[year];
        $DateIs=sprintf("%04d-%02d-%02d",$Year,$Month,$Day);
        return($DateIs);
}

function getTimeNow() {
        $today=getdate();
        $SS=$today[seconds];
        $MM=$today[minutes];
        $HH=$today[hours];
        $DateIs=sprintf("%02d:%02d:%02d",$HH,$MM,$SS);
        return($DateIs);
}

//#################################################
function getEndDayOfMonth($myDate) {
//#################################################
	$myEndOfMonth = array(0,31,0,31,30,31,30,31,31,30,31,30,31);
	$myDateArray = explode("-",$myDate);
	$myMonth = $myDateArray[1]*1;
	$myYear = $myDateArray[0]*1;
	if( $myMonth>=1 && $myMonth<=12 ) {
		if($myMonth==2) {
			//check leap year ---
			if( ($myYear%4)==0 ) {
				return 29;
			} else {
				return 28;
			}
		} else {
			return $myEndOfMonth[$myMonth];
		}
	} else {
		return 0;
	}
}

function getPHPVersion($int='full'){
	if($int=='short'){
		return (int)phpversion();
	}else{
		return phpversion();
	}
}

function getDBVersion(){
	$t=mysql_query("select version() as ve");
	$r=mysql_fetch_object($t);
	$iArray = explode('.', $r->ve);
	$iVersion = $iArray[0].$iArray[1];
	return (int)$iVersion;
}
function sql_safe($value,$allow_wildcards = false, $detect_numeric = false) {
	//return htmlspecialchars($value,ENT_QUOTES);
	if($detect_numeric){
		if (is_numeric($value)) {
			$value = addslashes(stripslashes($value));
		}else{
			$value = "'".addslashes(stripslashes($value))."'";
		}
	}else{
		if (get_magic_quotes_gpc()) {
			if(ini_get('magic_quotes_sybase')) {
			  $value = addslashes(str_replace("''", "'", $value));
			} else {
			  $value = addslashes(stripslashes($value));
			}
		}
	}
	return $value;
}
function echoDetailIntitle($data){
	$mydetail = htmlspecialchars_decode(stripcslashes($data), ENT_NOQUOTES);
	$HTMLData=strip_tags($mydetail);
	$HTMLData=strlimit($HTMLData,250);
	return $HTMLData;
}

function echoDetailCKEditer($data){
	$mydetail = htmlspecialchars_decode(rechangeQuot($data), ENT_NOQUOTES);
	return $mydetail;
}
function echoDetailToediter($data){
	$mydetail = rechangeQuot(htmlspecialchars_decode(stripcslashes($data), ENT_NOQUOTES));
	return $mydetail;
}
function echoDetailTooneline($data){
	$mydetail = str_replace('<br />',' ', rechangeQuot(htmlspecialchars_decode(stripcslashes($data), ENT_NOQUOTES)));
	return $mydetail;
}
function encodeFromCKEditer($value){
	$detail = preg_replace("/[\n\r]/","", $value);
	//$detail = str_replace('<br /><br />','<br />', $detail);
	return $detail;
}
function encodetxterea($value){
	$detail = str_replace(PHP_EOL,"<br />",$value);
	$detail = preg_replace("/[\n\r]/","<br />", $value);
	$detail = str_replace('<br /><br />','<br />', $detail);
	return $detail;
}
function decodetxterea($value){
	$detail = str_replace("&lt;br /&gt;",PHP_EOL,$value);
	return $detail;
}

function BBCode($str) {
		$myUID =  uniqid();
        $simple_search = array(
										'/\[b\](.*?)\[\/b\]/is',
										'/\[i\](.*?)\[\/i\]/is',
										'/\[u\](.*?)\[\/u\]/is',
										'/\[url\=(.*?)\](.*?)\[\/url\]/is',
										'/\[url\](.*?)\[\/url\]/is',
										'/(&gt;&gt;)([0-9]+)/',
										'/\[img\](.*?)\[\/img\]/is',
										'/\[youtube\]http:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/i',
										'/\[youtube\]http:\/\/?youtu\.be\/(.*?)\[\/youtube\]/i',
										'/\[flash=(.*?),(.*?)\](.*?)\[\/flash\]/is',
										'/\[flv\](.*?)\[\/flv\]/is',
										'/\[em\](.*?)\[\/em\]/is',
										'/\[txt\](.*?)\[\/txt\]/is'
                                );
        $simple_replace = array(
										'<strong>$1</strong>',
										'<em>$1</em>',
										'<u>$1</u>',
										'<a href="$1">$2</a>',
										'<a href="$1">[link]</a>',
										'<a href=\'index.php#$2\'>$1$2</a>',
										'<a href="$1"><img src="$1" boarder=0 /></a>',
										'<iframe width="480" height="385" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
										'<iframe width="480" height="385" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
										'<object width="$1" height="$2"><param name="movie" value="$3"></param><param name="wmode" value="transparent"></param><embed src="$3" type="application/x-shockwave-flash" wmode="transparent" width="$1" height="$2"></embed></object>',
										'<a  href="$1" style="display:block;width:480px;height:385px" id="player'.$myUID.'"></a><script> flowplayer("player'.$myUID.'", "js/flowplayer-3.1.5.swf");</script>',
										'<div class="code">$1</div>'
                                );
        // Do simple BBCode's
        $str = preg_replace ($simple_search, $simple_replace, trim(remove_newline($str)));

        return $str;
}
function remove_newline($document){
	$pat[0] = "/^\s+/";
	$pat[1] = "/\s{2,}/";
	$pat[2] = "/\s+\$/";
	$rep[0] = "";
	$rep[1] = " ";
	$rep[2] = "";

	if (stristr($_SERVER['HTTP_USER_AGENT'], 'WIN')) {
		$document = str_replace("\r\n", "<br/>", $document);
	} else {
		$document = str_replace("\n", "<br/>", $document);
	}
	$document = preg_replace($pat,$rep,$document);
	return $document;
}
function setObjectWH($mSrc, $mW="320", $mH="240"){
	$pattern = "/width=\"[0-9]*\"/";
	$content = preg_replace($pattern, 'width="'.$mW.'"', $mSrc);
	$pattern = "/height=\"[0-9]*\"/";
	$content = preg_replace($pattern, 'height="'.$mH.'"', $content);

	$pattern = "/width=\'[0-9]*\'/";
	$content = preg_replace($pattern, "width='".$mW."'", $content);
	$pattern = "/height=\'[0-9]*\'/";
	$content = preg_replace($pattern, "height='".$mH."'", $content);

	return $content;
}

function get_real_ip(){
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips, $ip);
			$ip = false;
		}
		for($i = 0; $i < count($ips); $i++){
			if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
				if(version_compare(phpversion(), "5.0.0", ">=")){
					if(ip2long($ips[$i]) != false){
						$ip = $ips[$i];
						break;
					}
				}else{
					if(ip2long($ips[$i]) != - 1){
						$ip = $ips[$i];
						break;
					}
				}
			}
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

function getPrivateIP() {
		# ฟังก์ชั่นการ ดึงเอา IP ปลอม ออกมา
		if (isset($_SERVER))
		{
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			elseif (isset($_SERVER['HTTP_CLIENT_IP']))
				$IP = $_SERVER['HTTP_CLIENT_IP'];
			else
				$IP = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
				$IP = getenv('HTTP_X_FORWARDED_FOR');
			elseif (getenv('HTTP_CLIENT_IP'))
				$IP = getenv('HTTP_CLIENT_IP');
			else
				$IP = getenv('REMOTE_ADDR');
		}
		$IP=spliti(",", $IP, 2);
		return $IP[0];
  }
function checkBBCodeVDO($str) {
		$str = "[Link]".$str."[/Link]";
		$myUID =  uniqid();
        $simple_search = array(
										'/\[Link\]http:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/Link\]/i',
										'/\[Link\]https:\/\/(?:www\.)?youtube\.com\/watch\?v=(.*?)\[\/Link\]/i',
										'/\[Link\]http:\/\/?youtu\.be\/(.*?)\[\/Link\]/i',
										'/\[Link\]https:\/\/?youtu\.be\/(.*?)\[\/Link\]/i'
                                );
        $simple_replace = array(
										'<iframe width="480" height="385" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
										'<iframe width="480" height="385" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
										'<iframe width="480" height="385" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
										'<iframe width="480" height="385" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>'
                                );
        // Do simple BBCode's
        $str = preg_replace ($simple_search, $simple_replace, trim(remove_newline($str)));

        return $str;
}
function strlimit($s,$n){
	if(iconv_strlen($s,'UTF-8')>$n)
		return iconv_substr($s, 0, $n, "UTF-8")."..";
	else
		return $s;
}
function tis620_to_utf8 ( $string ) {
 for( $i=0 ; $i< strlen ( $string ) ; $i++ ){
  $s = substr ( $string, $i, 1);
  $val = ord ( $s );
  if ( $val < 0x80 ) {
   $utf8 .= $s;
  } elseif ( ( 0xA1 <= $val and $val <= 0xDA ) or ( 0xDF <= $val and $val <= 0xFB ) ){
   $unicode = 0x0E00 + $val - 0xA0;
   $utf8 .= chr ( 0xE0 | ($unicode >> 12) );
   $utf8 .= chr ( 0x80 | ( ($unicode >> 6) & 0x3F) );
   $utf8 .= chr ( 0x80 | ($unicode & 0x3F) );
  }
 }
 return $utf8;
}
function utf8_to_tis620 ( $string ) {
 $str = $string;
 $res = '';
 for ( $i = 0; $i < strlen ( $str ); $i++ ) {
  if ( ord ( $str[$i] ) == 224 ) {
   $unicode = ord ( $str[$i+2] ) & 0x3F;
   $unicode |= ( ord ( $str[$i+1] ) & 0x3F ) << 6;
   $unicode |= ( ord ( $str[$i] ) & 0x0F ) << 12;
   $res .= chr ( $unicode - 0x0E00 + 0xA0 );
   $i += 2;
  } else {
   $res .= $str[$i];
  }
 }
 return $res;
}
function imageManip($data) {
	// match all image tags (thanks to Jan Reiter)
	@preg_match_all("/\< *[img][^\>]*[.]*\>/i", $data, $matches);

	if( is_array($matches[0]) )
	{
	// put all those image tags in one string, since preg match all needs the data
	// to be in a string format
	foreach($matches[0] as $match)
	{
	$imageMatch .= $match;
	}

	// match all source links within the original preg match all output
	@preg_match_all("/src=\"(.+?)\"/i", $imageMatch, $m);

	// for each match that has the same key as the second match, replace the entire
	// tag with my <img> tag that includes width, height and border="0"
	foreach($matches[0] as $imageTagKey => $imageTag)
	{
	foreach($m[1] as $imageSrcKey => $imageSrc)
	{
	if($imageTagKey == $imageSrcKey)
	{
	//$imageStats = imageProportions($imageSrc);

	$data = str_replace($imageTag, "<img src=\"".$imageSrc."\"  border=\"0\" />", $data);
	}
	}
	}
	}

	return $data;
}

function wordWrapIgnoreHTML($string, $length = 45, $wrapString = "\n")
   {
     $wrapped = '';
     $word = '';
     $html = false;
     $string = (string) $string;
     for($i=0;$i<strlen($string);$i+=1)
     {
       $char = $string[$i];

       /** HTML Begins */
       if($char === '<')
       {
         if(!empty($word))
         {
           $wrapped .= $word;
           $word = '';
         }

         $html = true;
         $wrapped .= $char;
       }

       /** HTML ends */
       elseif($char === '>')
       {
         $html = false;
         $wrapped .= $char;
       }

       /** If this is inside HTML -> append to the wrapped string */
       elseif($html)
       {
         $wrapped .= $char;
       }

       /** Whitespace characted / new line */
       elseif($char === ' ' || $char === "\t" || $char === "\n")
       {
         $wrapped .= $word.$char;
         $word = '';
       }

       /** Check chars */
       else
       {
         $word .= $char;

         if(strlen($word) > $length)
         {
           $wrapped .= $word.$wrapString;
           $word = '';
         }
       }
     }

    if($word !== ''){
        $wrapped .= $word;
    }

     return $wrapped;
   }

function formatSizeUnits($bytes){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
}

function getBadWord(){
	$sql = "SELECT "._TABLE_ADMIN_BADWORD_."_Badword AS Badword , "._TABLE_ADMIN_BADWORD_."_Changeto AS Changeto FROM "._TABLE_ADMIN_BADWORD_." WHERE "._TABLE_ADMIN_BADWORD_."_Status = 'On'";
	$z = new __webctrl;
	$z->sql($sql);
	$Num = $z->num();
	$v = $z->row();
	$ReturnArr = array();
	if($Num>0){
		foreach($v as $Row){
			$ReturnArr[$Row["Changeto"]] = $Row["Badword"];
		}
	}
	return $ReturnArr;
}

function postWithBadword($str){
	$bad_words = getBadWord();
	$filtered_string = str_ireplace(array_values($bad_words), array_keys($bad_words), $str);
	return $filtered_string;
}
function getURL() {
	$Parameter = (strlen($_SERVER["QUERY_STRING"]) > 0) ? "?".$_SERVER["QUERY_STRING"] : "";
	return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"] . $Parameter ; #$_SERVER['REQUEST_URI'];
}
function date_diff_d($start,$end="now"){
	if($end=="now"){
		$end = date("Y-m-d H:i:s");
	}else{
		$end = $end;
	}
	$sdate = strtotime($start);
	$edate = strtotime($end);
	$time = $edate - $sdate;
	if($time>=86400) {
		// Days + Hours + Minutes
		$pday = ($edate - $sdate) / 86400;
		$preday = explode('.',$pday);
		$timeshift = $preday[0];
	}
	return $timeshift;
}
function openaccordion($index){
	$Marray = new StdClass;
	$arrfmnu["listinv"] = "invoicelist";
	$arrfmnu["listrev"] = "receiptlist";
	$arrfmnu["rev"] = "receipt";

	if(!empty($index)){
		include("include_menu.php");
		$key = array_search($arrfmnu[$index], $menuFolder);
		$keygroup = $menuInGroup[$key];
		$keylink = $menuLink[$key];

		$sql = "SELECT "._TABLE_ADMIN_USER_."_EmpID AS EmpID,"._TABLE_ADMIN_USER_."_UserName AS UserName,"._TABLE_ADMIN_USER_."_Type AS uType FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_ID = ".(int)$_SESSION["Session_Admin_ID"];
		$z = new __webctrl;
		$z->sql($sql,'1','1');
		$v = $z->row();
		$RecordCount = $z->num();
		$Row = $v[0];
		$EmpID = $Row["EmpID"];
		$uType = $Row["uType"];

		$sql = "SELECT "._TABLE_ADMIN_USERGROUPPMA_."_MenuID AS MenuID,"._TABLE_ADMIN_USERGROUPPMA_."_Permission AS Permission FROM "._TABLE_ADMIN_USERGROUPPMA_." WHERE "._TABLE_ADMIN_USERGROUPPMA_."_GroupUserID = ".(int)$uType;
		$sql .= " AND "._TABLE_ADMIN_USERGROUPPMA_."_Language = '".$_SESSION['Session_Admin_Language']."'";
		$sql .= " ORDER BY "._TABLE_ADMIN_USERGROUPPMA_."_MenuID ASC";
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$RecordCount = $z->num();
		$os = array();
		$osmnu = array();
		$osmnupma = array();
		if($RecordCount>0){
			foreach($v as $RPermission){
				if($RPermission['Permission']<>'NA'){
					$osmnupma["Admin".$RPermission['MenuID']] = $RPermission['Permission'];
					$LGID = $menuInGroup[$RPermission['MenuID']];
					if (!in_array($LGID, $os)) {
						$os[] = $LGID;
					}
				}
			}
		}
		$countaccordion = array_search($keygroup, $os);
		$Marray->accordion = $countaccordion;
		$Marray->menu = $osmnupma;
		$Marray->menuindex = "Admin".$key;
		$Marray->menulink = $keylink;
	}else{
		$Marray->accordion = 0;
		$Marray->menu = "";
		$Marray->menuindex = "";
		$Marray->menulink = "javascript:void(0)";
	}
	return $Marray;
}

function array_merge_default($default, $data) {
        $intersect = array_intersect_key($data, $default); //Get data for which a default exists
        $diff = array_diff_key($default, $data); //Get defaults which are not present in data
        return $diff + $intersect; //Arrays have different keys, return the union of the two
}
function getUser($status=1){
	$Marray = new StdClass;
	$sql = "SELECT TBUsr."._TABLE_ADMIN_USER_."_ID AS ID,TBUsr."._TABLE_ADMIN_USER_."_EmpID AS EmpID,TBUsr."._TABLE_ADMIN_USER_."_UserName AS UserName,TBUsr."._TABLE_ADMIN_USER_."_Type AS uType";
	$sql .= ",TBStaff."._TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode,TBStaff."._TABLE_ADMIN_STAFF_."_FName AS FName,TBStaff."._TABLE_ADMIN_STAFF_."_LName AS LName";
	$sql .= " FROM "._TABLE_ADMIN_USER_." TBUsr";
	$sql .= " LEFT JOIN "._TABLE_ADMIN_STAFF_." TBStaff ON (TBUsr."._TABLE_ADMIN_USER_."_EmpID = TBStaff."._TABLE_ADMIN_STAFF_."_ID)";
	$sql .= " WHERE 1";
	if($status==1){
		$sql .= " AND "._TABLE_ADMIN_USER_."_Status = 'On'";
	}
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$Marray->ID[] = $Row["ID"];
			$Marray->EmpID[] = $Row["EmpID"];
			$Marray->UserName[] = $Row["UserName"];
			$Marray->Fullname[] = $Row["FName"]." ".$Row["LName"];
			$Marray->uType[] = $Row["uType"];
		}
	}
	$Marray->mycount = $RecordCount;
	return $Marray;
}
function getStaffInfo($id){
	$Marray = new StdClass;
	$sql = "";
	$sql .= "SELECT * FROM";
	$sql .= " (";
		$sql .= "SELECT TBmain."._TABLE_ADMIN_USER_."_ID AS UserID,TBmain."._TABLE_ADMIN_USER_."_EmpID AS EmpID,TBmain."._TABLE_ADMIN_USER_."_UserName AS UserName,TBmain."._TABLE_ADMIN_USER_."_Type AS uType,TBmain."._TABLE_ADMIN_USER_."_CreateDate AS uCreateDate,TBmain."._TABLE_ADMIN_USER_."_Remark AS uRemark";
		$sql .= ",(SELECT MAX("._TABLE_ADMIN_USERLOGIN_."_CreateDate) FROM "._TABLE_ADMIN_USERLOGIN_." WHERE "._TABLE_ADMIN_USERLOGIN_."_Type = 'Login' AND "._TABLE_ADMIN_USERLOGIN_."_UserID = TBmain."._TABLE_ADMIN_USER_."_ID) AS LastLogin";
		$sql .= ",(SELECT MAX("._TABLE_ADMIN_USERLOGIN_."_CreateDate) FROM "._TABLE_ADMIN_USERLOGIN_." WHERE "._TABLE_ADMIN_USERLOGIN_."_Type = 'Login' AND "._TABLE_ADMIN_USERLOGIN_."_UserID = TBmain."._TABLE_ADMIN_USER_."_ID AND "._TABLE_ADMIN_USERLOGIN_."_CreateDate <> TBmain."._TABLE_ADMIN_USER_."_LastLoginDate) AS LastLoginBefor";
		$sql .= ",TBJoinToken.*";
		$sql .= " FROM "._TABLE_ADMIN_USER_." TBmain";
		$sql .= " LEFT JOIN (";
			$sql .= "SELECT "._TABLE_ADMIN_USERTOKEN_."_TokenID AS JoinTokenID,"._TABLE_ADMIN_USERTOKEN_."_UserID AS JoinUserID,"._TABLE_ADMIN_USERTOKEN_."_CreateDate AS JoinCreateDate FROM "._TABLE_ADMIN_USERTOKEN_." WHERE "._TABLE_ADMIN_USERTOKEN_."_Status = 'Active' AND "._TABLE_ADMIN_USERTOKEN_."_CreateDate IN (SELECT max("._TABLE_ADMIN_USERTOKEN_."_CreateDate) FROM "._TABLE_ADMIN_USERTOKEN_." GROUP BY "._TABLE_ADMIN_USERTOKEN_."_UserID)";
		$sql .= ") TBJoinToken ON (TBmain."._TABLE_ADMIN_USER_."_ID = TBJoinToken.JoinUserID)";
		$sql .= " WHERE TBmain."._TABLE_ADMIN_USER_."_ID = ".(int)$id;
	$sql .= ") TBUser";
	$sql .= " LEFT JOIN (";
		$ArrJoinField = array();
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_ID AS StaffID";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
		$ArrJoinField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_AName,"._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_AName AS AName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Level AS SLevel";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_PictureFile AS PictureFile";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Remark AS Remark";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Position AS Position";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_InType AS InType";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Country AS CountryID";
		$ArrJoinField[] = _TABLE_ADMIN_STAFF_."_Territory AS Territory";
		$ArrJoinField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryCode IS NULL or "._TABLE_ADMIN_STAFF_."_CountryCode = '', '-', "._TABLE_ADMIN_STAFF_."_CountryCode) AS CountryCode";
		$ArrJoinField[] = "IF("._TABLE_ADMIN_STAFF_."_CountryName IS NULL or "._TABLE_ADMIN_STAFF_."_CountryName = '', '-', "._TABLE_ADMIN_STAFF_."_CountryName) AS CountryName";
		$sql .= "SELECT ".implode(",",$ArrJoinField)." FROM "._TABLE_ADMIN_STAFF_;
		$sql .= " WHERE 1";
		unset($ArrJoinField);
	$sql.= ") JoinTBStaff ON (TBUser.EmpID = JoinTBStaff.StaffID)";
	$sql .= " LEFT JOIN (";
		$sql .= "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS TypeID,"._TABLE_ADMIN_USERGROUP_."_Name AS TypeName FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
	$sql .= ") JoinTBType ON (TBUser.uType = JoinTBType.TypeID)";
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	$Row = $v[0];
	$EmpID = $Row["EmpID"];
	$InType = $Row["InType"];
	$uType = $Row["uType"];
	$uRemark = echoDetailToediter($Row["uRemark"]);
	$Territory = $Row["Territory"];
	$Marray->id = $id;
	$Marray->empid = $EmpID;
	$Marray->stafftype = $InType;
	$Marray->empuser = $Row["UserName"];
	$Marray->userRemark = $uRemark;
	$Marray->usertype = $uType;
	$Marray->usertypename = $Row["TypeName"];
	$Marray->userCreate = $Row["uCreateDate"];
	$Marray->userLastlogin = $Row["LastLogin"];
	$Marray->userLastloginBefor = $Row["LastLoginBefor"];

	$thumb = _RELATIVE_EMPLOYEE_UPLOAD_.$Row["PictureFile"];
	if(is_file($thumb)){
		$picturefile = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_PATH_UPLOAD_,$thumb);
	}else{
		$picturefile = _HTTP_PATH_."/"._MAIN_FOLDER_SYSTEM_."/assets/img/avatars/1.jpg";
	}

	$Marray->empcode = $Row["EmpCode"];
	$Marray->fullname = $Row["FullName"];
	$Marray->fname = $Row["FName"];
	$Marray->lname = $Row["LName"];
	$Marray->email = $Row["Email"];
	$Marray->tel = $Row["Tel"];
	$Marray->position = (!empty($Row["Position"])?$Row["Position"]:$Row["SLevel"]);
	$Marray->level = $Row["SLevel"];
	$Marray->picture = $picturefile;
	$Marray->empRemark = echoDetailToediter($Row["Remark"]);
	$Marray->CountryID = $Row["CountryID"];
	$Marray->Country = $Row["CountryName"];
	$Marray->CountryCode = $Row["CountryCode"];
	$Marray->Territory = $Territory;
	$inCountry = array();
	$inStateID = 0;
	$CityID = 0;
	$CityName = "Head office";
	if($InType=='Embassy'){
		if($Territory>0){
			$arrf = array();
			$arrf[] = _TABLE_ADMIN_TERRITORY_."_ID AS ID";
			$arrf[] = _TABLE_ADMIN_TERRITORY_."_Name AS _Name";
			$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADMIN_TERRITORY_;
			$sql .= " WHERE "._TABLE_ADMIN_TERRITORY_."_ID = ".(int)$Territory;
			unset($arrf);
			$z->sql($sql,'1','1');
			$vCity = $z->row();
			$CityID = $vCity[0]["ID"];
			$CityName = $vCity[0]["_Name"];

			$ArrField = array();
			$ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_internal_CountryID > 0 , "._TABLE_ADMIN_TERRITORY_."_internal_CountryID , 0) AS CountryID";
      $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_internal_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_internal_StateID , 0) AS StateID";
      $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_internal WHERE "._TABLE_ADMIN_TERRITORY_."_internal_TerritoryID = ".intval($Territory);
      unset($ArrField);
      $z->sql($sql);
      $vInternal = $z->row();
			$inCountry = $vInternal;

			$ArrField = array();
			$ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_external_CountryID > 0 , "._TABLE_ADMIN_TERRITORY_."_external_CountryID , 0) AS CountryID";
      $ArrField[] = "IF("._TABLE_ADMIN_TERRITORY_."_external_StateID > 0 , "._TABLE_ADMIN_TERRITORY_."_external_StateID , 0) AS StateID";
      $sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_TERRITORY_."_external WHERE "._TABLE_ADMIN_TERRITORY_."_external_TerritoryID = ".intval($Territory);
      unset($ArrField);
      $z->sql($sql);
      $vExternal = $z->row();
			if(count($vExternal)>0){
				foreach($vExternal AS $VE){
					array_push($inCountry, $VE);
				}
			}
		}else{
			$sql = "";
			$arrf = array();
			$arrf[] = _TABLE_THAIEMBASSY_CITY_."_EmbassyID AS EmbassyID";
			$arrf[] = _TABLE_THAIEMBASSY_CITY_."_CountryID AS CountryID";
			$arrf[] = _TABLE_THAIEMBASSY_CITY_."_StateID AS StateID";
			$arrf[] = _TABLE_THAIEMBASSY_CITY_."_CityID AS CityID";
			$arrf[] = "IF(TBCity.CityName IS NULL or TBCity.CityName = '', '-', TBCity.CityName) AS CityName";
			$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_THAIEMBASSY_CITY_;
			$sql .= " LEFT JOIN (";
				$sql .= "SELECT "._TABLE_ADDRDISTRICT_."_DistrictID AS CityID,"._TABLE_ADDRDISTRICT_."_NameEN AS CityName FROM "._TABLE_ADDRDISTRICT_;
			$sql .= ") TBCity ON ("._TABLE_THAIEMBASSY_CITY_."_CityID = TBCity.CityID)";
			$sql .= " WHERE "._TABLE_THAIEMBASSY_CITY_."_EmbassyID = ".intval($id);
			$sql .= " AND "._TABLE_THAIEMBASSY_CITY_."_CountryID > 0";
			unset($arrf);
			$z->sql($sql,'1','1');
			$vCity = $z->row();
			if(count($vCity)>0){
				$inCountryID = $vCity[0]["CountryID"];
				$inStateID = $vCity[0]["StateID"];
				$CityID = $vCity[0]["CityID"];
				$CityName = $vCity[0]["CityName"];
				$arr = array();
				$arr["CountryID"] = $inCountryID;
				$arr["StateID"] = $inStateID;
				$inCountry[] = $arr;
				unset($arr);
			}
		}
	}
	$Marray->inCountry = $inCountry;
	$Marray->CityID = $CityID;
	$Marray->CityName = $CityName;
	$sql = "SELECT "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID,"._TABLE_ADMIN_USERGROUPAPPROVE_."_Permission FROM "._TABLE_ADMIN_USERGROUPAPPROVE_." WHERE "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID = ".(int)$uType;
	$zApp = new __webctrl;
	$zApp->sql($sql);
	$vApp = $zApp->row();
	$RecordCountApp = $zApp->num();
	$arrapprove = array();
	if($RecordCountApp>0){
		foreach($vApp as $RowApp){
			$arrapprove[$RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID"]] = $RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_Permission"];
		}
	}
	$Marray->groupapprove = $arrapprove;

	$sql = "SELECT "._TABLE_ADMIN_USERGROUPPMA_."_MenuID AS MenuID,"._TABLE_ADMIN_USERGROUPPMA_."_Permission AS Permission FROM "._TABLE_ADMIN_USERGROUPPMA_." WHERE "._TABLE_ADMIN_USERGROUPPMA_."_GroupUserID = ".(int)$uType;
	$sql .= " AND "._TABLE_ADMIN_USERGROUPPMA_."_Language = '".$_SESSION['Session_Admin_Language']."'";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$RecordCount = $z->num();
	$os = array();
	$osmnu = array();
	$osmnupma = array();
	if($RecordCount>0){
		foreach($v as $RPermission){
			$osmnupma["Admin".$RPermission['MenuID']] = $RPermission['Permission'];
		}
	}
	$Marray->osmnupma = $osmnupma;
	return $Marray;
}
function getusertype($status=1){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS ID,"._TABLE_ADMIN_USERGROUP_."_Name AS Name FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
	if($status==1){
		$sql .= " AND "._TABLE_ADMIN_USERGROUP_."_Status = 'On'";
	}
	$sql .= " ORDER BY "._TABLE_ADMIN_USERGROUP_."_Order ASC";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$RecordCount = $z->num();
	if($RecordCount>0){
		foreach($v as $Row){
			$Marray->ID[] = $Row["ID"];
			$Marray->Name[] = $Row["Name"];
		}
	}
	$Marray->mycount = $RecordCount;
	return $Marray;
}
function getusertypeinfo($data){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADMIN_USERGROUP_."_ID AS ID,"._TABLE_ADMIN_USERGROUP_."_Name AS Name FROM "._TABLE_ADMIN_USERGROUP_." WHERE 1";
	$sql .= " AND "._TABLE_ADMIN_USERGROUP_."_ID = '".(int)$data."'";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$Marray->ID = $v[0]["ID"];
	$Marray->Name = $v[0]["Name"];
	return $Marray;
}
function getEmployee($status=1,$approve=0,$group=0,$use=0){
	$Marray = new StdClass;
	$ArrField = array();
	$ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ID";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
	$ArrField[] = "CONCAT("._TABLE_ADMIN_STAFF_."_FName, ' ', "._TABLE_ADMIN_STAFF_."_LName) AS FullName";
	$ArrField[] = "IF(TBCheck.CountRefAll IS NULL or TBCheck.CountRefAll = '', 0, TBCheck.CountRefAll) AS CountRefAll";
	$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_STAFF_;
	$sql .= " LEFT JOIN (";
		$arrinnercount = array();
		$arrinnercount[] = "COUNT(*) AS CountRefAll";
		$arrinnercount[] = _TABLE_ADMIN_USER_."_EmpID AS JoinContentID";
		$sql .= "SELECT ".implode(',',$arrinnercount)." FROM "._TABLE_ADMIN_USER_." WHERE 1 GROUP BY "._TABLE_ADMIN_USER_."_EmpID";
		unset($arrinnercount);
	$sql .= ") TBCheck ON ("._TABLE_ADMIN_STAFF_."_ID = TBCheck.JoinContentID)";
	$sql .= " WHERE 1";
	if($status==1){
		$sql .= " AND "._TABLE_ADMIN_STAFF_."_Status = 'On'";
	}
	$sql .= " ORDER BY "._TABLE_ADMIN_STAFF_."_ID ASC";
	unset($ArrField);
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$RecordCount = $z->num();
	$data = array();
	if($RecordCount>0){
		foreach($v as $Row){
			$ID = $Row["ID"];
			$CountRefAll = $Row["CountRefAll"];
			$FullName = $Row["FullName"];
			if($approve==1){
				global $Login_MenuID,$menuInGroup;
				$mymenuingroup = $menuInGroup[substr($Login_MenuID,5)];
				$sql = "SELECT "._TABLE_ADMIN_USER_."_EmpID AS EmpID,"._TABLE_ADMIN_USER_."_Type FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_EmpID = ".(int)$ID;
				$zType = new __webctrl;
				$zType->sql($sql);
				$vType = $zType->row();
				$RecordCountType = $zType->num();
				$foundemp = array();
				if($RecordCountType>0){
					foreach($vType as $RowType){
						$empid = $RowType["EmpID"];
						$emptype = $RowType[_TABLE_ADMIN_USER_."_Type"];
						$arr["EmpID"] = $empid;
						$arr["EmpType"] = $emptype;
						$sql = "SELECT "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID,"._TABLE_ADMIN_USERGROUPAPPROVE_."_Permission FROM "._TABLE_ADMIN_USERGROUPAPPROVE_." WHERE "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID = ".(int)$emptype;
						$zApp = new __webctrl;
						$zApp->sql($sql);
						$vApp = $zApp->row();
						$RecordCountApp = $zApp->num();
						$arrapprove = array();
						if($RecordCountApp>0){
							foreach($vApp as $RowApp){
								$arrapprove[$RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID"]] = $RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_Permission"];
							}
						}
						$arr["EmpApprove"] = $arrapprove;
						$foundemp[] = $arr;
					}
				}
				foreach($foundemp as $myval){
					if($myval["EmpApprove"][$mymenuingroup]=="Yes"){
						$Marray->ID[] = $myval["EmpID"];
						$Empinfo = getEmployeeInfo($myval["EmpID"]);
						$Marray->FullName[] = $Empinfo->fullname;
					}
				}
			}else if($group>0){
				$sql = "SELECT "._TABLE_ADMIN_USER_."_EmpID AS EmpID,"._TABLE_ADMIN_USER_."_Type FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_EmpID = ".(int)$ID;
				$sql .= " AND "._TABLE_ADMIN_USER_."_Type = ".(int)$group;
				$zType = new __webctrl;
				$zType->sql($sql);
				$vType = $zType->row();
				$RecordCountType = $zType->num();
				$foundemp = array();
				if($RecordCountType>0){
					foreach($vType as $RowType){
						$empid = $RowType["EmpID"];
						$emptype = $RowType[_TABLE_ADMIN_USER_."_Type"];
						$Empinfo = getEmployeeInfo($empid);
						$arr["EmpID"] = $empid;
						$arr["EmpType"] = $emptype;
						$arr["Name"] = $Empinfo->fullname;
						$arr["Email"] = $Empinfo->email;
						$data[] = $arr;
					}
				}
			}else{
				if($use>0){
					if($CountRefAll==0 || $use==$ID){
						$Marray->ID[] = $ID;
						$Marray->FullName[] = $Row["FName"]." ".$Row["LName"];
					}
				}else{
					$Marray->ID[] = $ID;
					$Marray->FullName[] = $Row["FName"]." ".$Row["LName"];
				}
			}
		}
	}
	$Marray->mycount = $RecordCount;
	$Marray->mydata = $data;
	return $Marray;
}
function getEmployeeInfo($id){
	$Marray = new StdClass;

	$ArrField[] = _TABLE_ADMIN_STAFF_."_ID AS ID";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_EmpCode AS EmpCode";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_FName AS FName";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_LName AS LName";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Level AS SLevel";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Email AS Email";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Position AS SPosition";
	$ArrField[] = _TABLE_ADMIN_STAFF_."_Tel AS Tel";

	$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_ADMIN_STAFF_." WHERE "._TABLE_ADMIN_STAFF_."_Status = 'On' AND "._TABLE_ADMIN_STAFF_."_ID = ".(int)$id;
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	$Row = $v[0];
	unset($ArrField);

	$Marray->empcode = $Row["EmpCode"];
	$Marray->fullname = $Row["FName"]." ".$Row["LName"];
	$Marray->fname = $Row["FName"];
	$Marray->lname = $Row["LName"];
	$Marray->email = $Row["Email"];
	$Marray->level = $Row["SLevel"];
	$Marray->email = $Row["Email"];
	$Marray->position = $Row["SPosition"];
	$Marray->tel = $Row["Tel"];
	$Marray->sign = _HTTP_PATH_."/images/signature/signmaster.png";
	$Marray->signrelative = "../images/signature/signmaster.png";
	return $Marray;
}
function getUserInEmployeeInfo($empid,$status=1){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADMIN_USER_."_ID AS UserID FROM "._TABLE_ADMIN_USER_." WHERE "._TABLE_ADMIN_USER_."_EmpID = ".(int)$empid;
	if($status==1){
		$sql .= " AND "._TABLE_ADMIN_USER_."_Status = 'On'";
	}
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$RecordCount = $z->num();
	$Marray->mycount = $RecordCount;
	$arr = array();
	if($RecordCount>0){
		foreach($v as $Row){
			$arr["UserID"] = $Row["UserID"];
		}
	}
	$Marray->user = $arr;
	return $Marray;
}

function userPma(){
	$Marray = new StdClass;
	global $menuIndex,$menuInGroup,$MenuMainGroup;
	if($_SESSION['Session_Admin_ID']==1000){
		$Marray->employeeid = 1000;
		$Marray->usertype = 0;
		$Marray->usertypename = "";
		$Marray->userlevel = "superAdmin";
		$osmain = array();
		$os = array();
		$osmnu = array();
		$osmnupma = array();
		foreach($menuIndex as $keymid=>$mid){
			if (!in_array($MenuMainGroup[$menuInGroup[$keymid]], $osmain)) {
				$osmain[] = $MenuMainGroup[$menuInGroup[$keymid]];
			}
			if (!in_array($menuInGroup[$keymid], $os)) {
				$os[] = $menuInGroup[$keymid];
			}
			if (!in_array($menuIndex[$keymid], $osmnu)) {
				$osmnu[] = $menuIndex[$keymid];
			}
			$osmnupma[$menuIndex[$keymid]] = "RW";
		}
		$Marray->osmain = $osmain;
		$Marray->os = $os;
		$Marray->osmnu = $osmnu;
		$Marray->osmnupma = $osmnupma;
		$Marray->editfield = true;
		$Marray->delfield = true;
		$Marray->adminbtn = true;
		$arrapprove[0] = "Yes";
		$arrapprove[1] = "Yes";
		$arrapprove[2] = "Yes";
		$arrapprove[3] = "Yes";
		$arrapprove[4] = "Yes";
		$arrapprove[5] = "Yes";
		$arrapprove[6] = "Yes";
		$Marray->approve = $arrapprove;
	}else if($_SESSION['Session_Admin_ID']>0){

		$sql = "SELECT "._TABLE_ADMIN_USER_."_ID AS ID, "._TABLE_ADMIN_USER_."_EmpID AS EmpID, "._TABLE_ADMIN_USER_."_Type AS uType, "._TABLE_ADMIN_USER_."_UserName AS UserName, "._TABLE_ADMIN_USER_."_Status AS ListStatus, "._TABLE_ADMIN_USER_."_LastLoginDate AS LastLoginDate, "._TABLE_ADMIN_USER_."_Level AS uLevel, "._TABLE_ADMIN_USERGROUP_."_Name AS GroupName";
		$sql .= " FROM "._TABLE_ADMIN_USER_;
		$sql .= " LEFT JOIN "._TABLE_ADMIN_USERGROUP_." ON ("._TABLE_ADMIN_USER_."_Type = "._TABLE_ADMIN_USERGROUP_."_ID)";
		$sql .= " WHERE ("._TABLE_ADMIN_USER_."_ID = '".(int)$_SESSION['Session_Admin_ID']."')";
		$sql .= " AND "._TABLE_ADMIN_USERGROUP_."_Status = 'On'";
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$EmpID = $Row["EmpID"];
		$uType = $Row["uType"];
		$ID = $Row["ID"];
		$uLevel = $Row["uLevel"];
		$Marray->employeeid = $EmpID;
		$Marray->usertype = $uType;
		$Marray->usertypename = $Row["GroupName"];
		$Marray->userlevel = $uLevel;
		$sql = "SELECT "._TABLE_ADMIN_USERGROUPPMA_."_MenuID AS MenuID,"._TABLE_ADMIN_USERGROUPPMA_."_Permission AS Permission FROM "._TABLE_ADMIN_USERGROUPPMA_." WHERE "._TABLE_ADMIN_USERGROUPPMA_."_GroupUserID = ".(int)$uType;
		$sql .= " AND "._TABLE_ADMIN_USERGROUPPMA_."_Language = '".$_SESSION['Session_Admin_Language']."'";
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$RecordCount = $z->num();
		$osmain = array();
		$os = array();
		$osmnu = array();
		$osmnupma = array();
		if($RecordCount>0){
			foreach($v as $RPermission){
				$osmnupma[$menuIndex[$RPermission['MenuID']]] = $RPermission['Permission'];
				if($RPermission['Permission']<>'NA'){
					if (!in_array($MenuMainGroup[$menuInGroup[$RPermission['MenuID']]], $osmain)) {
						$osmain[] = $MenuMainGroup[$menuInGroup[$RPermission['MenuID']]];
					}
					if (!in_array($menuIndex[$RPermission['MenuID']], $osmnu)) {
						$osmnu[] = $menuIndex[$RPermission['MenuID']];
					}
					if (!in_array($menuInGroup[$RPermission['MenuID']], $os)) {
						$os[] = $menuInGroup[$RPermission['MenuID']];
					}
				}
			}
		}
		$Marray->osmain = $osmain;
		$Marray->os = $os;
		$Marray->osmnu = $osmnu;
		$Marray->osmnupma = $osmnupma;

		if($uLevel=='Admin'){
			$Marray->editfield = true;
			$Marray->delfield = true;
			$Marray->adminbtn = true;
		}else{
			$Marray->editfield = false;
			$Marray->delfield = false;
			$Marray->adminbtn = false;
		}

		$sql = "SELECT "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID,"._TABLE_ADMIN_USERGROUPAPPROVE_."_Permission FROM "._TABLE_ADMIN_USERGROUPAPPROVE_." WHERE "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID = ".(int)$uType;
		$zApp = new __webctrl;
		$zApp->sql($sql);
		$vApp = $zApp->row();
		$RecordCountApp = $zApp->num();
		$arrapprove = array();
		$arrapprove[0] = "No";
		if($RecordCountApp>0){
			foreach($vApp as $RowApp){
				$arrapprove[$RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID"]] = $RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_Permission"];
			}
		}
		$Marray->approve = $arrapprove;
	}
	return $Marray;
}
function userPmaInfo(){
	$Marray = new StdClass;
	global $menuIndex,$menuInGroup,$MenuMainGroup;
	if($_SESSION['Session_Admin_ID']==1000){
		$Marray->employeeid = 1000;
		$Marray->usertype = 0;
		$Marray->usertypename = "";
		$Marray->userlevel = "superAdmin";
		$osmain = array();
		$os = array();
		$osmnu = array();
		$osmnupma = array();
		foreach($menuIndex as $keymid=>$mid){
			if (!in_array($MenuMainGroup[$menuInGroup[$keymid]], $osmain)) {
				$osmain[] = $MenuMainGroup[$menuInGroup[$keymid]];
			}
			if (!in_array($menuInGroup[$keymid], $os)) {
				$os[] = $menuInGroup[$keymid];
			}
			if (!in_array($menuIndex[$keymid], $osmnu)) {
				$osmnu[] = $menuIndex[$keymid];
			}
			$osmnupma[$menuIndex[$keymid]] = "RW";
		}
		$Marray->osmain = $osmain;
		$Marray->os = $os;
		$Marray->osmnu = $osmnu;
		$Marray->osmnupma = $osmnupma;
		$Marray->editfield = true;
		$Marray->delfield = true;
		$Marray->adminbtn = true;
		$arrapprove[0] = "Yes";
		$arrapprove[1] = "Yes";
		$arrapprove[2] = "Yes";
		$arrapprove[3] = "Yes";
		$arrapprove[4] = "Yes";
		$arrapprove[5] = "Yes";
		$arrapprove[6] = "Yes";
		$Marray->approve = $arrapprove;
	}else if($_SESSION['Session_Admin_ID']>0){

		$sql = "SELECT "._TABLE_ADMIN_USER_."_ID AS ID, "._TABLE_ADMIN_USER_."_EmpID AS EmpID, "._TABLE_ADMIN_USER_."_Type AS uType, "._TABLE_ADMIN_USER_."_UserName AS UserName, "._TABLE_ADMIN_USER_."_Status AS ListStatus, "._TABLE_ADMIN_USER_."_LastLoginDate AS LastLoginDate, "._TABLE_ADMIN_USER_."_Level AS uLevel, "._TABLE_ADMIN_USERGROUP_."_Name AS GroupName";
		$sql .= " FROM "._TABLE_ADMIN_USER_;
		$sql .= " LEFT JOIN "._TABLE_ADMIN_USERGROUP_." ON ("._TABLE_ADMIN_USER_."_Type = "._TABLE_ADMIN_USERGROUP_."_ID)";
		$sql .= " WHERE ("._TABLE_ADMIN_USER_."_ID = '".(int)$_SESSION['Session_Admin_ID']."')";
		$sql .= " AND "._TABLE_ADMIN_USERGROUP_."_Status = 'On'";
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$Row = $v[0];
		$EmpID = $Row["EmpID"];
		$uType = $Row["uType"];
		$ID = $Row["ID"];
		$uLevel = $Row["uLevel"];
		$Marray->employeeid = $EmpID;
		$Marray->usertype = $uType;
		$Marray->usertypename = $Row["GroupName"];
		$Marray->userlevel = $uLevel;

		$sql = "SELECT "._TABLE_ADMIN_USERGROUPPMA_."_MenuID AS MenuID,"._TABLE_ADMIN_USERGROUPPMA_."_Permission AS Permission FROM "._TABLE_ADMIN_USERGROUPPMA_." WHERE "._TABLE_ADMIN_USERGROUPPMA_."_GroupUserID = ".(int)$uType;
		$sql .= " AND "._TABLE_ADMIN_USERGROUPPMA_."_Language = '".$_SESSION['Session_Admin_Language']."'";
		$z = new __webctrl;
		$z->sql($sql);
		$v = $z->row();
		$RecordCount = $z->num();
		$osmain = array();
		$os = array();
		$osmnu = array();
		$osmnupma = array();
		if($RecordCount>0){
			foreach($v as $RPermission){
				$osmnupma[$menuIndex[$RPermission['MenuID']]] = $RPermission['Permission'];
				if($RPermission['Permission']<>'NA'){
					if (!in_array($MenuMainGroup[$menuInGroup[$RPermission['MenuID']]], $osmain)) {
						$osmain[] = $MenuMainGroup[$menuInGroup[$RPermission['MenuID']]];
					}
					if (!in_array($menuIndex[$RPermission['MenuID']], $osmnu)) {
						$osmnu[] = $menuIndex[$RPermission['MenuID']];
					}
					if (!in_array($menuInGroup[$RPermission['MenuID']], $os)) {
						$os[] = $menuInGroup[$RPermission['MenuID']];
					}
				}
			}
		}
		$Marray->osmain = $osmain;
		$Marray->os = $os;
		$Marray->osmnu = $osmnu;
		$Marray->osmnupma = $osmnupma;
		if($uLevel=='Admin'){
			$Marray->editfield = true;
			$Marray->delfield = true;
			$Marray->adminbtn = true;
		}else{
			$Marray->editfield = false;
			$Marray->delfield = false;
			$Marray->adminbtn = false;
		}
		$sql = "SELECT "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID,"._TABLE_ADMIN_USERGROUPAPPROVE_."_Permission FROM "._TABLE_ADMIN_USERGROUPAPPROVE_." WHERE "._TABLE_ADMIN_USERGROUPAPPROVE_."_GroupUserID = ".(int)$uType;
		$zApp = new __webctrl;
		$zApp->sql($sql);
		$vApp = $zApp->row();
		$RecordCountApp = $zApp->num();
		$arrapprove = array();
		$arrapprove[0] = "No";
		if($RecordCountApp>0){
			foreach($vApp as $RowApp){
				$arrapprove[$RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_GroupID"]] = $RowApp[_TABLE_ADMIN_USERGROUPAPPROVE_."_Permission"];
			}
		}
		$Marray->approve = $arrapprove;
	}
	return $Marray;
}
function userPmaApprove(){

}
function generate_password($length = 20){
    //$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';
	/*
	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789-=!@#$%^&*()_+,./<>?:[]{}\|';
	  $str = '';
	  $max = strlen($chars) - 1;
	  for ($i=0; $i <= $length; $i++)
		$str .= $chars[mt_rand(0, $max)];
	*/
	$UpperChar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$LowerChar = 'abcdefghijklmnopqrstuvwxyz';
	$Number = '0123456789';
	$SpChar = '-=!@#$%^&*()_+,./<>?:[]{}|';

	$countst01 = round((20*$length)/100);
	$countst02 = round((40*$length)/100);
	$countst03 = round((30*$length)/100);
	$countst04 = round((10*$length)/100);

	$randomString01 = substr(str_shuffle($UpperChar), 0, $countst01);
	$randomString02 = substr(str_shuffle($LowerChar), 0, $countst02);
	$randomString03 = substr(str_shuffle($Number), 0, $countst03);
	$randomString04 = substr(str_shuffle($SpChar), 0, $countst04);

	$str = $randomString01.$randomString02.$randomString03.$randomString04;
	$str = str_shuffle($str);
	return $str;
}
function emoticons($text) {
	$text = nl2br($text);
	$icons = array(
				  '(:01:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/01.png" class="emo1"/>',
				  '(:02:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/02.png" class="emo1"/>',
				  '(:03:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/03.png" class="emo3"/>',
				  '(:04:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/04.png" class="emo3"/>',
				  '(:05:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/05.png" class="emo3"/>',
				  '(:06:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/06.png" class="emo3"/>',
				  '(:07:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/07.png" class="emo3"/>',
				  '(:08:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/08.png" class="emo3"/>',
				  '(:09:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/09.png" class="emo3"/>',
				  '(:10:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/10.png" class="emo3"/>',
				  '(:11:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/11.png" class="emo3"/>',
				  '(:12:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/12.png" class="emo3"/>',
				  '(:13:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/ball/13.png" class="emo3"/>',

				  '(:w001:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-001.gif" class="emo1"/>',
				  '(:w002:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-002.gif" class="emo1"/>',
				  '(:w003:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-003.gif" class="emo3"/>',
				  '(:w004:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-004.gif" class="emo3"/>',
				  '(:w005:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-005.gif" class="emo3"/>',
				  '(:w006:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-006.gif" class="emo3"/>',
				  '(:w007:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-007.gif" class="emo3"/>',
				  '(:w008:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-008.gif" class="emo3"/>',
				  '(:w009:)'   =>  '<img src="'._HTTP_PATH_.'/images/admin_images/emo/whitehead/white-head-emoticon-009.gif" class="emo3"/>'

			 );
	$text = " ".$text." ";
	foreach ($icons as $search => $replace){
		$text = str_replace(" ".$search." ", " ".$replace." ", $text);
	}
   return trim($text);
}
function generate_code($option){
	$txt = $option["prefix"];
	$txttable = $option["table"];
	$txtfield = $option["table"]."_".$option["field"];
	if(!empty($option["flag"])){
		$txtflag = $option["table"]."_".$option["flag"];
	}
	//--
	$prelen = strlen($txt)+$option["numberlength"];
	//--
	$sql = "SELECT * FROM ";
	$sql .= " (";
		$sql .= "SELECT ".$txtfield.",CONCAT(REPLACE(LEFT(".$txtfield.", 1), '_', ''),SUBSTRING(".$txtfield.", 2)) AS NewSeNo FROM ".$txttable;
		if(is_array($option["where"])){
			$num = count($option["where"]);
			$sql .= " WHERE ";
			if($num>0){
				$i = 0;
				foreach($option["where"] as $key=>$val){
					if($i>0){$sql .= ' AND ';}
					$sql .= $key.$val;
					$i++;
				}
			}
		}else{
			$sql .= " WHERE 1";
		}
		if(!empty($option["flag"])){
			$sql .= " AND ".$txtflag." = 0";
		}
	$sql .= ") base WHERE 1 ";
	//$sql .= " AND CHAR_LENGTH(base.NewSeNo) = ".$prelen;
	$sql .= " ORDER BY NewSeNo DESC";
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	if($RecordCount>0){
		$Row = $v[0];
		$strtxt = str_replace($txt,'',$Row["NewSeNo"]);
	}else{
		$strtxt = 0;
	}
	$strtxt = intval($strtxt)+1;
	$stroutput = $txt.formatStringtoZero($strtxt,$option["numberlength"]);
	return $stroutput;
}
function generate_codewithym($option){
	$txt = $option["prefix"];
	$txttable = $option["table"];
	$txtfield = $option["table"]."_".$option["field"];
	$txtorder = $option["table"]."_".$option["order"];
	$txtdad = (empty($option["opdad"])?"":$option["opdad"]);
	$txtformatym = (empty($option["formatym"])?"Y-m":$option["formatym"]);
	$txtreset = (empty($option["resetcount"])?"Y":$option["resetcount"]);// Y , YM
	$txtnowymd = date($txtformatym);
	//--
	$prelen = strlen($txt)+strlen($txtnowymd)+$option["numberlength"]+strlen($txtdad);
	//--
	$sql = "SELECT * FROM";
	$sql .= " (";
		$sql .= "SELECT ".$txtfield.",CONCAT(REPLACE(LEFT(".$txtfield.", 1), '_', ''),SUBSTRING(".$txtfield.", 2)) AS NewSeNo FROM ".$txttable;
		if(is_array($option["where"])){
			$num = count($option["where"]);
			$sql .= " WHERE ";
			if($num>0){
				$i = 0;
				foreach($option["where"] as $key=>$val){
					if($i>0){$sql .= ' AND ';}
					$sql .= $key.$val;
					$i++;
				}
			}
		}else{
			$sql .= " WHERE 1";
		}
		if(!empty($option["flag"])){
			$sql .= " AND ".$txtflag." = 0";
		}
	$sql .= ") base WHERE 1 ";
	//$sql .= " AND CHAR_LENGTH(base.NewSeNo) = ".$prelen;
	$sql .= " ORDER BY NewSeNo DESC";
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	$Row = $v[0];
	$txtnewprefix = $txt.date($txtformatym).$txtdad;
	$arrtxtdbprefix = substr($Row["NewSeNo"],-$option["numberlength"]);
	//$arrtxtdbprefix = explode($txtdad,$Row["NewSeNo"]);

	$txtym = substr($Row["NewSeNo"],strlen($txt),strlen($txtnowymd));

	$txtnowy = date("Y");
	$txtnowm = date("n");
	$txtnowym = date("Yn");

	$txtiny = date("Y", strtotime($txtym));
	$txtinm = date("n", strtotime($txtym));
	$txtinym = date("Yn", strtotime($txtym));
	$txtinformat = date($txtformatym, strtotime($txtym));

	if($txtreset=="Y"){
		if($txtnowy>$txtiny){
			$txtprefix = $txt.$txtnowymd.$txtdad;
			$strtxt = 0;
		}else{
			$txtprefix = $txt.$txtnowymd.$txtdad;
			//$strtxt = $arrtxtdbprefix[count($arrtxtdbprefix)-1];
			$strtxt = $arrtxtdbprefix;
		}
	}else{
		if($txtnowym>$txtinym){
			$txtprefix = $txt.$txtnowymd.$txtdad;
			$strtxt = 0;
		}else{
			$txtprefix = $txt.$txtnowymd.$txtdad;
			//$strtxt = $arrtxtdbprefix[count($arrtxtdbprefix)-1];
			$strtxt = $arrtxtdbprefix;
		}
	}

	$strtxt = intval($strtxt)+1;
	$stroutput = $txtprefix.formatStringtoZero($strtxt,$option["numberlength"]);

	return $stroutput;
}
function generate_codeguarantee($option){
	$txt = $option["prefix"];
	$txttable = $option["table"];
	$txtfield = $option["field"];
	$txtdad = (empty($option["opdad"])?"":$option["opdad"]);
	$txtformatym = (empty($option["formatym"])?"YYYYMM":$option["formatym"]);
	$txtreset = (empty($option["resetcount"])?"Y":$option["resetcount"]);// Y , Y-m
	$txtlang = (empty($option["formatlang"])?"English":$option["formatlang"]);// Y , YM
	$txtcheckfield = (empty($option["checkfield"])?"":$option["checkfield"]);
	//--
	$prelen = strlen($txt)+strlen($txtformatym)+strlen($txtdad);
	$numberlen = intval($option["numberlength"])-$prelen;
	//--
	$sql = "SELECT * FROM";
	$sql .= " (";
		$sql .= "SELECT ".$txtfield.",CONCAT(REPLACE(LEFT(".$txtfield.", 1), '_', ''),SUBSTRING(".$txtfield.", 2)) AS NewSeNo FROM ".$txttable;
		if(is_array($option["where"])){
			$num = count($option["where"]);
			$sql .= " WHERE ";
			if($num>0){
				$i = 0;
				foreach($option["where"] as $key=>$val){
					if($i>0){$sql .= ' AND ';}
					$sql .= $key.$val;
					$i++;
				}
			}
		}else{
			$sql .= " WHERE 1";
		}
		if(!empty($txtcheckfield)){
			if($txtreset=='Y'){
				$sql .= " AND SUBSTRING(".$txtcheckfield.",1,4) = '".date($txtreset)."'";
			}else if($txtreset=='Y-m'){
				$sql .= " AND SUBSTRING(".$txtcheckfield.",1,7) = '".date($txtreset)."'";
			}else if($txtreset=='Y-m-d'){
				$sql .= " AND SUBSTRING(".$txtcheckfield.",1,10) = '".date($txtreset)."'";
			}else{
				$sql .= " AND SUBSTRING(".$txtcheckfield.",1,4) = '".date($txtreset)."'";
			}
		}
	$sql .= ") Base WHERE 1 ";
	//$sql .= " AND CHAR_LENGTH(base.NewSeNo) = ".$prelen;
	$sql .= " ORDER BY NewSeNo DESC";
	$z = new __webctrl;
	$z->sql($sql,'1','1');
	$v = $z->row();
	$RecordCount = $z->num();
	if($RecordCount>0){
		$Row = $v[0];
		$NewSeNo = $Row["NewSeNo"];
		$inlistnumber = substr($NewSeNo,$prelen,strlen($NewSeNo));
	}else{
		$NewSeNo = "";
		$inlistnumber = 0;
	}
	$txtnowd = date("d");
	$txtnowm = date("m");
	$txtnowy = ($txtlang=='Thai'?date("Y")+543:date("Y"));
	switch($txtformatym){
		case 'YYMM':
			$txtnowy = substr($txtnowy,-2);
			$txtinformatdate = $txtnowy.$txtnowm;
		break;case 'YYYYMM':
			$txtinformatdate = $txtnowy.$txtnowm;
		break; default:
	}
	$txtprefix = $txt.$txtinformatdate.$txtdad;
	$strtxt = intval($inlistnumber)+1;
	$stroutput = $txtprefix.formatStringtoZero($strtxt,$numberlen);
	return $stroutput;
}

function convert($number){
	$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
	$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
	$number = str_replace(",","",$number);
	$number = str_replace(" ","",$number);
	$number = str_replace("บาท","",$number);
	$number = explode(".",$number);
	if(sizeof($number)>2){
		return 'ทศนิยมหลายตัวนะจ๊ะ';
		exit;
	}
	$strlen = strlen($number[0]);
	$convert = '';
	for($i=0;$i<$strlen;$i++){
		$n = substr($number[0], $i,1);
		if($n!=0){
			if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
			elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; }
			elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
			else{ $convert .= $txtnum1[$n]; }
			$convert .= $txtnum2[$strlen-$i-1];
		}
	}
	$convert .= 'บาท';
	if($number[1]=='0' OR $number[1]=='00' OR
		$number[1]==''){
		$convert .= 'ถ้วน';
	}else{
		$strlen = strlen($number[1]);
		for($i=0;$i<$strlen;$i++){
		$n = substr($number[1], $i,1);
			if($n!=0){
				if($i==($strlen-1) AND $n==1){$convert
				.= 'เอ็ด';}
				elseif($i==($strlen-2) AND
				$n==2){$convert .= 'ยี่';}
				elseif($i==($strlen-2) AND
				$n==1){$convert .= '';}
				else{ $convert .= $txtnum1[$n];}
				$convert .= $txtnum2[$strlen-$i-1];
			}
		}
		$convert .= 'สตางค์';
	}
	return $convert;
}
class Currency {
  public function bahtEng($thb) {
   list($thb, $ths) = explode('.', $thb);
   $ths = substr($ths.'00', 0, 2);
   $thb = Currency::engFormat(intval($thb)).' Baht';
   if (intval($ths) > 0) {
    $thb .= ' and '.Currency::engFormat(intval($ths)).' Satang';
   }
   return $thb;
  }
  // ตัวเลขเป็นตัวหนังสือ (ไทย)
  public function bahtThai($thb) {
   list($thb, $ths) = explode('.', $thb);
   $ths = substr($ths.'00', 0, 2);
   $thaiNum = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
   $unitBaht = array('บาท', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
   $unitSatang = array('สตางค์', 'สิบ');
   $THB = '';
   $j = 0;
   for ($i = strlen($thb) - 1; $i >= 0; $i--, $j++) {
    $num = $thb[$i];
    $tnum = $thaiNum[$num];
    $unit = $unitBaht[$j];
    switch (true) {
     case $j == 0 && $num == 1 && strlen($thb) > 1:
      $tnum = 'เอ็ด';
      break;
     case $j == 1 && $num == 1:
      $tnum = '';
      break;
     case $j == 1 && $num == 2:
      $tnum = 'ยี่';
      break;
     case $j == 6 && $num == 1 && strlen($thb) > 7:
      $tnum = 'เอ็ด';
      break;
     case $j == 7 && $num == 1:
      $tnum = '';
      break;
     case $j == 7 && $num == 2:
      $tnum = 'ยี่';
      break;
     case $j != 0 && $j != 6 && $num == 0:
      $unit = '';
      break;
    }
    $S = $tnum.$unit;
    $THB = $S.$THB;
   }
   if ($ths == '00') {
    $THS = 'ถ้วน';
   } else {
    $j = 0;
    $THS = '';
    for ($i = strlen($ths) - 1; $i >= 0; $i--, $j++) {
     $num = $ths[$i];
     $tnum = $thaiNum[$num];
     $unit = $unitSatang[$j];
     switch (true) {
      case $j == 0 && $num == 1 && strlen($ths) > 1:
       $tnum = 'เอ็ด';
       break;
      case $j == 1 && $num == 1:
       $tnum = '';
       break;
      case $j == 1 && $num == 2:
       $tnum = 'ยี่';
       break;
      case $j != 0 && $j != 6 && $num == 0:
       $unit = '';
       break;
     }
     $S = $tnum.$unit;
     $THS = $S.$THS;
    }
   }
   return $THB.$THS;
  }
  // ตัวเลขเป็นตัวหนังสือ (eng)
  private function engFormat($number) {
   list($thb, $ths) = explode('.', $thb);
   $ths = substr($ths.'00', 0, 2);
   $max_size = pow(10, 18);
   if (!$number)
    return "zero";
   if (is_int($number) && $number < abs($max_size)) {
    switch ($number) {
     case $number < 0:
      $prefix = "negative";
      $suffix = Currency::engFormat(-1 * $number);
      $string = $prefix." ".$suffix;
      break;
     case 1:
      $string = "one";
      break;
     case 2:
      $string = "two";
      break;
     case 3:
      $string = "three";
      break;
     case 4:
      $string = "four";
      break;
     case 5:
      $string = "five";
      break;
     case 6:
      $string = "six";
      break;
     case 7:
      $string = "seven";
      break;
     case 8:
      $string = "eight";
      break;
     case 9:
      $string = "nine";
      break;
     case 10:
      $string = "ten";
      break;
     case 11:
      $string = "eleven";
      break;
     case 12:
      $string = "twelve";
      break;
     case 13:
      $string = "thirteen";
      break;
     case 15:
      $string = "fifteen";
      break;
     case $number < 20:
      $string = Currency::engFormat($number % 10);
      if ($number == 18) {
       $suffix = "een";
      } else {
       $suffix = "teen";
      }
      $string .= $suffix;
      break;
     case 20:
      $string = "twenty";
      break;
     case 30:
      $string = "thirty";
      break;
     case 40:
      $string = "forty";
      break;
     case 50:
      $string = "fifty";
      break;
     case 60:
      $string = "sixty";
      break;
     case 70:
      $string = "seventy";
      break;
     case 80:
      $string = "eighty";

      break;
     case 90:
      $string = "ninety";
      break;
     case $number < 100:
      $prefix = Currency::engFormat($number - $number % 10);
      $suffix = Currency::engFormat($number % 10);
      $string = $prefix."-".$suffix;
      break;
     case $number < pow(10, 3):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 2))))." hundred";
      if ($number % pow(10, 2))
       $suffix = " and ".Currency::engFormat($number % pow(10, 2));
      $string = $prefix.$suffix;
      break;
     case $number < pow(10, 6):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 3))))." thousand";
      if ($number % pow(10, 3))
       $suffix = Currency::engFormat($number % pow(10, 3));
      $string = $prefix." ".$suffix;
      break;
     case $number < pow(10, 9):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 6))))." million";
      if ($number % pow(10, 6))
       $suffix = Currency::engFormat($number % pow(10, 6));
      $string = $prefix." ".$suffix;
      break;
     case $number < pow(10, 12):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 9))))." billion";
      if ($number % pow(10, 9))
       $suffix = Currency::engFormat($number % pow(10, 9));
      $string = $prefix." ".$suffix;
      break;
     case $number < pow(10, 15):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 12))))." trillion";
      if ($number % pow(10, 12))
       $suffix = Currency::engFormat($number % pow(10, 12));
      $string = $prefix." ".$suffix;
      break;
     case $number < pow(10, 18):
      $prefix = Currency::engFormat(intval(floor($number / pow(10, 15))))." quadrillion";
      if ($number % pow(10, 15))
       $suffix = Currency::engFormat($number % pow(10, 15));
      $string = $prefix." ".$suffix;
      break;
    }
   }
   return $string;
  }
}
function checkIDCard($id) {
	if(strlen($id) != 13) return false;
	for($i=0, $sum=0; $i<12;$i++)
	$sum += (int)($id{$i})*(13-$i);
	if((11-($sum%11))%10 == (int)($id{12}))return true;
	return false;
}
function formatstringinpattern($str,$pattern='idcard'){
	if($pattern=='idcard'){
		$pattern = "_ ____ _____ __ _";
		$pattern_ex = " ";
	}else{
		$pattern = "_-____-_____-__-_";
		$pattern_ex = "-";
	}
	$patternlength = strlen($pattern);
	$arpattern = array();
	for($i=0;$i<$patternlength;$i++){
		if($pattern{$i}==$pattern_ex){
			$arpattern[$i-1] = $pattern_ex;
		}
	}
	$obj_l = strlen($str);
	$strreturn = "";
	for($i=0;$i<$obj_l;$i++){
		$countstr_r = strlen($strreturn);
		if($arpattern[$countstr_r]){
			$strreturn .= $str{$i}.$pattern_ex;
		}else{
			$strreturn .= $str{$i};
		}
	}
	return $strreturn;
}

function zipFilesAndDownload($file_names,$archive_file_name,$file_path){
  //create the object
	$archivwithpath = _RELATIVE_PATH_UPLOAD_."/".$archive_file_name;
	$zip = new ZipArchive();
	//create the file and throw the error if unsuccessful
	if ($zip->open($archivwithpath, ZIPARCHIVE::CREATE )!==TRUE) {
		exit("cannot open <$archive_file_name>\n");
	}

	//add each files of $file_name array to archive
	foreach($file_names as $files){
		$zip->addFile($file_path.$files,$files);
	}
	$zip->close();
	//then send the headers to foce download the zip file
	// header("Content-type: application/zip");
	/*
	header("Content-Disposition: attachment; filename=$archive_file_name");
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($archive_file_name)) . ' GMT');
	header("Pragma: no-cache");
	header("Expires: 0");
	*/
	header("Content-type: application/zip");
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($archivwithpath)) . ' GMT');
	header('Content-Type: application/force-download');
	header('Content-Disposition: inline; filename="'.$archive_file_name.'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($archivwithpath));
	header('Connection: close');

	readfile($archivwithpath);
	recursiveDelete($file_path);
	unlink($archivwithpath);
	exit;
}
function zipFilesAndFile($file_names,$archive_file_name,$file_path){
  //create the object
	$archivwithpath = $archive_file_name;
	$zip = new ZipArchive();
	//create the file and throw the error if unsuccessful
	if ($zip->open($archivwithpath, ZIPARCHIVE::CREATE )!==TRUE) {
		exit("cannot open <$archive_file_name>\n");
	}
	//add each files of $file_name array to archive
	foreach($file_names as $files){
		$zip->addFile($file_path.$files,$files);
	}
	$zip->close();
	recursiveDelete($file_path);
}
function recursiveDelete($str) {
    if (is_file($str)) {
        return @unlink($str);
    }
    elseif (is_dir($str)) {
        $scan = glob(rtrim($str,'/').'/*');
        foreach($scan as $index=>$path) {
            recursiveDelete($path);
        }
        return @rmdir($str);
    }
}
function getBrowser(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
function is_image($path){
    $a = getimagesize($path);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}
function videoType($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
	} elseif (strpos($url, 'youtu.be') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}
function save_base64_image($base64_image_string, $output_file_without_extentnion, $path_with_end_slash="" ) {
    //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }
    //
    //data is like:    data:image/png;base64,asdfasdfasdf
    $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
    $mime=$splited[0];
    $data=$splited[1];

    $mime_split_without_base64=explode(';', $mime,2);
    $mime_split=explode('/', $mime_split_without_base64[0],2);
    if(count($mime_split)==2)
    {
        $extension=$mime_split[1];
        if($extension=='jpeg')$extension='jpg';
        //if($extension=='javascript')$extension='js';
        //if($extension=='text')$extension='txt';
        $output_file_with_extentnion = $output_file_without_extentnion.'.'.$extension;
    }
    file_put_contents( $path_with_end_slash . $output_file_with_extentnion, base64_decode($data) );
    return $output_file_with_extentnion;
}
function save_image_tojpg($file,$output_file_without_extentnion){
	$fileoutputjpg = $output_file_without_extentnion;
	$fileoutputjpg = strtolower($fileoutputjpg);
	$vowels = array(".jpg", ".jpeg");
	$fileoutputjpg = str_replace($vowels, "",$fileoutputjpg);
	$fileoutputjpg = $output_file_without_extentnion.".jpg";
	$image = imagecreatefrompng($file);
	imagejpeg($image, $fileoutputjpg, 100);
	imagedestroy($image);
	return $fileoutputjpg;
}
function getListCountry($flag="TH",$arrlang = array()){
	$Marray = new StdClass;
	$sql = "";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrf = array();
		$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryID AS CountryID";
		$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryCode AS CountryCode";
		if(count($arrlang)>0){

		}else{
			$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryNameEN AS CountryName";
		}
		$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRCOUNTRIES_." WHERE 1";
		unset($arrf);
	$sql .= ") TB";
	$sql .= " ORDER BY TB.CountryName ASC";
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["countryid"] = $Row["CountryID"];
			$ar["code"] = $Row["CountryCode"];
			$ar["name"] = $Row["CountryName"];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getInfoCountry($country=0){
	$Marray = new StdClass;
	$arrf = array();
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryID AS CountryID";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryCode AS CountryCode";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryLongCode AS CountryLongCode";
	$arrf[] = _TABLE_ADDRCOUNTRIES_."_CountryNameEN AS CountryName";
	$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRCOUNTRIES_." WHERE "._TABLE_ADDRCOUNTRIES_."_CountryID = ".intval($country);
	unset($arrf);
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["CountryID"] = $Row["CountryID"];
			$ar["CountryCode"] = $Row["CountryCode"];
			$ar["CountryLongCode"] = $Row["CountryLongCode"];
			$ar["CountryName"] = $Row["CountryName"];
			$Marray->data = $ar;
		}
	}
	return $Marray;
}
function getListProvince($country=0,$flag="TH",$arrlang = array()){
	$Marray = new StdClass;
	$sql = "";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrf = array();
		$arrf[] = _TABLE_ADDRSTATE_."_CountryID AS CountryID";
		$arrf[] = _TABLE_ADDRSTATE_."_StateID AS StateID";
		if(count($arrlang)>0){

		}else{
			$arrf[] = _TABLE_ADDRSTATE_."_NameEN AS StateName";
		}
		$arrf[] = _TABLE_ADDRSTATE_."_Code AS StateCode";
		$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSTATE_." WHERE 1";
		$sql .= " AND "._TABLE_ADDRSTATE_."_CountryID = ".(int)$country;
		unset($arrf);
	$sql .= ") TB";
	$sql .= " ORDER BY TB.StateName ASC";
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["id"] = $Row["StateID"];
			$ar["code"] = $Row["StateCode"];
			$ar["name"] = $Row["StateName"];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getInfoState($state=0){
	$Marray = new StdClass;
	$sql = "";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrf = array();
		$arrf[] = _TABLE_ADDRSTATE_."_CountryID AS CountryID";
		$arrf[] = _TABLE_ADDRSTATE_."_StateID AS StateID";
		$arrf[] = _TABLE_ADDRSTATE_."_NameEN AS StateName";
		$arrf[] = _TABLE_ADDRSTATE_."_Code AS StateCode";
		$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSTATE_." WHERE 1";
		$sql .= " AND "._TABLE_ADDRSTATE_."_StateID = ".(int)$state;
		unset($arrf);
	$sql .= ") TB";
	$sql .= " ORDER BY TB.StateName ASC";
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["StateID"] = $Row["StateID"];
			$ar["StateCode"] = $Row["StateCode"];
			$ar["StateName"] = $Row["StateName"];
			$Marray->data = $ar;
		}
	}
	return $Marray;
}
function getListCity($state=0,$country=0,$flag="TH",$arrlang = array()){
	$Marray = new StdClass;
	// _TABLE_ADDRDISTRICT_
	$sql = "";
	$sql .= "SELECT * FROM ";
	$sql .= "(";
		$arrf = array();
		$arrf[] = _TABLE_ADDRDISTRICT_."_CountryID AS CountryID";
		$arrf[] = _TABLE_ADDRDISTRICT_."_StatesID AS StateID";
		$arrf[] = _TABLE_ADDRDISTRICT_."_DistrictID AS DistrictID";
		if(count($arrlang)>0){

		}else{
			$arrf[] = _TABLE_ADDRDISTRICT_."_NameEN AS DistrictName";
		}
		$arrf[] = _TABLE_ADDRDISTRICT_."_Code AS DistrictCode";
		$sql .= "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRDISTRICT_." WHERE 1";
		$sql .= " AND "._TABLE_ADDRDISTRICT_."_CountryID = ".(int)$country;
		if($state>0){
			$sql .= " AND "._TABLE_ADDRDISTRICT_."_StatesID = ".(int)$state;
		}
		unset($arrf);
	$sql .= ") TB";
	$sql .= " ORDER BY TB.DistrictName ASC";
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["DistrictID"] = $Row["DistrictID"];
			$ar["CountryID"] = $Row["CountryID"];
			$ar["StateID"] = $Row["StateID"];
			$ar["Code"] = $Row["DistrictCode"];
			$ar["Name"] = $Row["DistrictName"];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getInfoCity($city=0){
	$Marray = new StdClass;
	// _TABLE_ADDRDISTRICT_
	$arrf = array();
	$arrf[] = _TABLE_ADDRDISTRICT_."_CountryID AS CountryID";
	$arrf[] = _TABLE_ADDRDISTRICT_."_StatesID AS StateID";
	$arrf[] = _TABLE_ADDRDISTRICT_."_DistrictID AS DistrictID";
	$arrf[] = _TABLE_ADDRDISTRICT_."_NameEN AS DistrictName";
	$arrf[] = _TABLE_ADDRDISTRICT_."_Code AS DistrictCode";
	$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRDISTRICT_." WHERE 1";
	$sql .= " AND "._TABLE_ADDRDISTRICT_."_DistrictID = ".(int)$city;
	unset($arrf);
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["DistrictID"] = $Row["DistrictID"];
			$ar["CountryID"] = $Row["CountryID"];
			$ar["StateID"] = $Row["StateID"];
			$ar["Code"] = $Row["DistrictCode"];
			$ar["Name"] = $Row["DistrictName"];
			$Marray->data = $ar;
		}
	}
	return $Marray;
}
function getListSubDistrict($district=0,$state=0,$country=0,$flag="TH",$arrlang = array()){
	$Marray = new StdClass;
	// _TABLE_ADDRSUBDISTRICT_
	$arrf = array();
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_ID AS ID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_CountryID AS CountryID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_StatesID AS StateID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_DistrictID AS DistrictID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_Zipcode AS ZipCode";
	if(count($arrlang)>0){

	}else{
		$arrf[] = _TABLE_ADDRSUBDISTRICT_."_NameEN AS SubDistrictName";
	}
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_Code AS SubDistrictCode";
	$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSUBDISTRICT_." WHERE 1";
	$sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_CountryID = ".(int)$country;
	if($state>0){
		$sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_StatesID = ".(int)$state;
	}
	if($district>0){
		$sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_DistrictID = ".(int)$district;
	}
	unset($arrf);
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["SubDistrictID"] = $Row["ID"];
			$ar["DistrictID"] = $Row["DistrictID"];
			$ar["CountryID"] = $Row["CountryID"];
			$ar["StateID"] = $Row["StateID"];
			$ar["Code"] = $Row["SubDistrictCode"];
			$ar["Name"] = $Row["SubDistrictName"];
			$ar["ZipCode"] = $Row["ZipCode"];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getInfoSubDistrict($subdistrict=0){
	$Marray = new StdClass;
	// _TABLE_ADDRSUBDISTRICT_
	$arrf = array();
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_ID AS _ID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_CountryID AS CountryID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_StatesID AS StateID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_DistrictID AS DistrictID";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_NameEN AS SubDistrictName";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_Code AS SubDistrictCode";
	$arrf[] = _TABLE_ADDRSUBDISTRICT_."_Zipcode AS ZipCode";
	$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_ADDRSUBDISTRICT_." WHERE 1";
	// $sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_ID = ".(int)$subdistrict;
	$sql .= " AND "._TABLE_ADDRSUBDISTRICT_."_Code = ".(int)$subdistrict;
	unset($arrf);
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["SubDistrictID"] = $Row["_ID"];
			$ar["DistrictID"] = $Row["DistrictID"];
			$ar["CountryID"] = $Row["CountryID"];
			$ar["StateID"] = $Row["StateID"];
			$ar["Code"] = $Row["SubDistrictCode"];
			$ar["Name"] = $Row["SubDistrictName"];
			$ar["ZipCode"] = $Row["ZipCode"];
			$Marray->data = $ar;
		}
	}
	return $Marray;
}
function getListAmphur($provincecode='',$flag="Thai"){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADDRAMPHUR_."_NameThai AS AmphurNameThai,"._TABLE_ADDRAMPHUR_."_NameEnglish AS AmphurNameEnglish,"._TABLE_ADDRAMPHUR_."_Code AS AmphurCode FROM "._TABLE_ADDRAMPHUR_." WHERE 1";
	if(!empty($provincecode)){
		$sql .= " AND "._TABLE_ADDRAMPHUR_."_ProvinceCode = ".(int)$provincecode;
	}
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["code"] = $Row["AmphurCode"];
			$ar["name"] = $Row["AmphurName".$flag];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getListDistrice($amphurcode='',$flag="Thai"){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADDRDISTRICTS_."_NameThai AS DistriceNameThai,"._TABLE_ADDRDISTRICTS_."_NameEnglish AS DistriceNameEnglish,"._TABLE_ADDRDISTRICTS_."_Code AS DistriceCode FROM "._TABLE_ADDRDISTRICTS_." WHERE 1";
	if(!empty($amphurcode)){
		$sql .= " AND "._TABLE_ADDRDISTRICTS_."_AmphuresCode = ".(int)$amphurcode;
	}
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$Marray->datacount = $RecordCount;
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$ar = array();
			$ar["code"] = $Row["DistriceCode"];
			$ar["name"] = $Row["DistriceName".$flag];
			$Marray->data[] = $ar;
		}
	}
	return $Marray;
}
function getInfoProvince($id,$flag="Thai"){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADDRPROVINCE_."_NameThai AS ProvinceNameThai,"._TABLE_ADDRPROVINCE_."_NameEnglish AS ProvinceNameEnglish,"._TABLE_ADDRPROVINCE_."_Code AS ProvinceCode FROM "._TABLE_ADDRPROVINCE_." WHERE "._TABLE_ADDRPROVINCE_."_Code = '".$id."'";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$Row = $v[0];
	$Marray->name = $Row["ProvinceName".$flag];
	$Marray->code = $Row["ProvinceCode"];
	return $Marray;
}
function getInfoAmphur($id,$flag="Thai"){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADDRAMPHUR_."_NameThai AS AmphurNameThai,"._TABLE_ADDRAMPHUR_."_NameEnglish AS AmphurNameEng,"._TABLE_ADDRAMPHUR_."_Code AS AmphurCode FROM "._TABLE_ADDRAMPHUR_." WHERE "._TABLE_ADDRAMPHUR_."_Code = '".$id."'";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$Row = $v[0];
	$Marray->name = $Row["AmphurName".$flag];
	$Marray->code = $Row["AmphurCode"];
	return $Marray;
}
function getInfoDistrice($id,$flag="Thai"){
	$Marray = new StdClass;
	$sql = "SELECT "._TABLE_ADDRDISTRICTS_."_NameThai AS DistriceNameThai,"._TABLE_ADDRDISTRICTS_."_NameEnglish AS DistriceNameEng,"._TABLE_ADDRDISTRICTS_."_Code AS DistriceCode,"._TABLE_ADDRDISTRICTS_."_ZIPCode AS ZIPCode FROM "._TABLE_ADDRDISTRICTS_." WHERE "._TABLE_ADDRDISTRICTS_."_Code = '".$id."'";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$Row = $v[0];
	$Marray->name = $Row["DistriceName".$flag];
	$Marray->code = $Row["DistriceCode"];
	$Marray->zipcode = $Row["ZIPCode"];
	return $Marray;
}
function get_remote_data($url, $post_paramtrs=false)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    if($post_paramtrs)
    {
        curl_setopt($c, CURLOPT_POST,TRUE);
        curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );
    }
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
    curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
    curl_setopt($c, CURLOPT_MAXREDIRS, 10);
    $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;
    if ($follow_allowed)
    {
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
    }
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
    curl_setopt($c, CURLOPT_REFERER, $url);
    curl_setopt($c, CURLOPT_TIMEOUT, 60);
    curl_setopt($c, CURLOPT_AUTOREFERER, true);
    curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
    $data=curl_exec($c);
    $status=curl_getinfo($c);
    curl_close($c);
    preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link); $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);   $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);
    if($status['http_code']==200)
    {
        return $data;
    }
    elseif($status['http_code']==301 || $status['http_code']==302)
    {
        if (!$follow_allowed)
        {
            if (!empty($status['redirect_url']))
            {
                $redirURL=$status['redirect_url'];
            }
            else
            {
                preg_match('/href\=\"(.*?)\"/si',$data,$m);
                if (!empty($m[1]))
                {
                    $redirURL=$m[1];
                }
            }
            if(!empty($redirURL))
            {
                return  call_user_func( __FUNCTION__, $redirURL, $post_paramtrs);
            }
        }
    }
    return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:".json_encode($status)."<br/><br/>Last data got<br/>:$data";
}
function generate_token($length = 10){
	$UpperChar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$LowerChar = 'abcdefghijklmnopqrstuvwxyz';
	$Number = '0123456789';

	$countst01 = round((20*$length)/100);
	$countst02 = round((40*$length)/100);
	$countst03 = round((30*$length)/100);

	$randomString01 = substr(str_shuffle($UpperChar), 0, $countst01);
	$randomString02 = substr(str_shuffle($LowerChar), 0, $countst02);
	$randomString03 = substr(str_shuffle($Number), 0, $countst03);

	$str = $randomString01.$randomString02.$randomString03;
	$str = str_shuffle($str);
	return $str;
}
function getuserToken($id){
	$sql = "SELECT "._TABLE_ADMIN_USERTOKEN_."_TokenID FROM "._TABLE_ADMIN_USERTOKEN_." WHERE "._TABLE_ADMIN_USERTOKEN_."_UserID = ".(int)$id." AND "._TABLE_ADMIN_USERTOKEN_."_Status = 'Active'";
	$sql .= " ORDER BY "._TABLE_ADMIN_USERTOKEN_."_CreateDate DESC";
	$z = new __webctrl;
	$z->sql($sql,1,1);
	$v = $z->row();
	$num = $z->num();
	$Row = $v[0];
	return $Row[_TABLE_ADMIN_USERTOKEN_."_TokenID"];
}
function savetxt($filename,$content,$chmod=0777){
	// In our example we're opening $filename in append mode.
	// The file pointer is at the bottom of the file hence
	// that's where $somecontent will go when we fwrite() it.
	if(!$handle=fopen($filename,'a')){
		die("Cannot open file ($filename)");
	}
	// Write $somecontent to our opened file.
	if(fwrite($handle,$content) === false){
		die("Cannot write to file ($filename)");
	}
	fclose($handle);
	chmod($filename,$chmod);
	return "Success, wrote ($content) to file ($filename)";
}
if(!function_exists("array_column")){
    function array_column($array,$column_name)    {
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }
}
function getOption($option){
	$Marray = new StdClass;
	$xtable = $option["table"];
	$xorderby = $option["orderby"];
	$xascdesc = $option["ascdesc"];
	$arrf = array();
	foreach($option["field"] as $val){
		$arrf[] = 'a.'.$xtable.'_'.$val.' AS '.$val;
	}
	$sql = "SELECT ".implode(',',$arrf)." FROM ".$xtable." a";
	$sql .= " WHERE 1";
	$sql .= " ORDER BY a.".$xtable."_".$xorderby." ".$xascdesc;
	unset($arrf);
	$z = new __webctrl;
	$z->sql($sql);
	$n = $z->num();
	$v = $z->row();
	$Marray->num = $n;
	$Marray->data = $v;
	return $Marray;
}
function getOptionInfo($option){
	$Marray = new StdClass;
	$xtable = $option["table"];
	$xwhere = $option["where"];
	$xdata = $option["data"];
	$arrf = array();
	foreach($option["field"] as $val){
		$arrf[] = 'a.'.$xtable.'_'.$val.' AS '.$val;
	}
	$sql = "SELECT ".implode(',',$arrf)." FROM ".$xtable." a";
	$sql .= " WHERE 1";
	if(!empty($xwhere)){
		$sql .= " AND ".$xtable."_".$xwhere." = '".$xdata."'";
	}
	$z = new __webctrl;
	$z->sql($sql);
	$n = $z->num();
	$v = $z->row();
	$Marray->num = $n;
	if($n>0){
		$Marray->data = $v[0];
	}else{
		$Marray->data = array();
	}
	return $Marray;
}
function getGroup($option){
	//print_r($option);
	$Marray = new StdClass;
	$systemLang = $option["lang"];
	$key = $option["modkey"];
	$xtable = $option["table"];
	$xtabledetail = $xtable."_detail";
	$modtextselect = $option["modtextselect"];
	$selectid = $option["selectid"];

	$sql = "";
	$sqlsub = "";
	foreach($systemLang as $lkey=>$lval){
		$sqlsub .= ",".$lkey.".".$xtabledetail."_Subject AS Subject".$lkey;
		$sqlsub .= ",".$lkey.".".$xtabledetail."_Status AS Status".$lkey;
	}
	$sql = "SELECT  a.*".$sqlsub." FROM ".$xtable." a";
	foreach($systemLang as $lkey=>$lval){
		$sql .= " LEFT JOIN ".$xtabledetail." ".$lkey." ON (a.".$xtable."_ID = ".$lkey.".".$xtabledetail."_ContentID AND ".$lkey.".".$xtabledetail."_Lang = '".$lkey."')";
	}
	$sql .= " WHERE a.".$xtable."_Key='".$key."'";
	$sql .= " AND a.".$xtable."_Status = 'On'";
	$sql .= " ORDER BY a.".$xtable."_Order DESC,a.".$xtable."_ID DESC";
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$n = $z->num();
	$found = array();
	$arr["id"] = 0;
	$arr["selected"] = ($selectid==0?true:false);
	foreach($systemLang as $lkey=>$lval){
		$arr["Subject".$lkey] = $modtextselect[$lkey];
	}
	$found[] = $arr;
	if($n>0){
		foreach($v as $row){
			$arr["id"] = $row[$xtable."_ID"];
			$arr["selected"] = ($selectid==$row[$xtable."_ID"]?true:false);
			foreach($systemLang as $lkey=>$lval){
				$arr["Subject".$lkey] = $row["Subject".$lkey];
			}
			$found[] = $arr;
		}
	}
	$Marray->num = $n+1;
	$Marray->data = $found;
	return $Marray;
}
function CallAPI($method, $url, $data = false , $auth_mode='basic' , $custom_header=NULL){
    $header = array();
    $executionStartTime = microtime(true);
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            $data["_METHOD"] = "PUT";
            curl_setopt($curl, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    if ($auth_mode=='basic') {
      curl_setopt($curl, CURLOPT_USERPWD, "pgvim:QaZwSxEdCrFv");
    } else if ($auth_mode=='jwt') {
      $header[] = "Authorization: Bearer ".$_SESSION['jwt'];
    }

    if (!empty($custom_header)) {
      $header = array_merge($header,$custom_header);
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

		// echo '<pre>';
		// print_r($result);
		// echo '</pre>';

    $executionEndTime = microtime(true);
    $seconds = $executionEndTime - $executionStartTime;

    return json_decode($result,true);
}
function characterToHTMLEntity($str){
	$search = array('&', '<', '>', '€', '‘', '’', '“', '”', '–', '—', '¡', '¢','£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã','ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ','Œ', 'œ', '‚', '„', '…', '™', '•', '˜');

	$replace  = array('&amp;', '&lt;', '&gt;', '&euro;', '&lsquo;', '&rsquo;', '&ldquo;','&rdquo;', '&ndash;', '&mdash;', '&iexcl;','&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;','&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;','&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&OElig;', '&oelig;', '&sbquo;', '&bdquo;', '&hellip;', '&trade;', '&bull;', '&asymp;');

	//REPLACE VALUES
	$str = str_replace($search, $replace, $str);

	//RETURN FORMATED STRING
	return $str;
}
function HTMLEntityTocharacter($str){
	$search  = array('&#39;','&#039;','&amp;', '&lt;', '&gt;', '&euro;', '&lsquo;', '&rsquo;', '&ldquo;','&rdquo;', '&ndash;', '&mdash;', '&iexcl;','&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;','&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;','&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&OElig;', '&oelig;', '&sbquo;', '&bdquo;', '&hellip;', '&trade;', '&bull;', '&asymp;');

	$replace = array('’','’','&', '<', '>', '€', '‘', '’', '“', '”', '–', '—', '¡', '¢','£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã','ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ','Œ', 'œ', '‚', '„', '…', '™', '•', '˜');


	//REPLACE VALUES
	$str = str_replace($search, $replace, $str);

	//RETURN FORMATED STRING
	return $str;
}
class MultiToSingle{
	//public $result=[];
	public $result=array();
	public function __construct($array){
	    if(!is_array($array)){
	        echo "Give a array";
	    }
	    foreach($array as $key => $value){
	        if(is_array($value)){
	            for($i=0;$i<count($value);$i++){
	                $this->result[]=$value[$i];
	            }
	        }else{
	            $this->result[]=$value;
	        }
	    }
	}
}
function insertArrayAtPosition( $array, $insert, $position ) {
    /*
    $array : The initial array i want to modify
    $insert : the new array i want to add, eg array('key' => 'value') or array('value')
    $position : the position where the new array will be inserted into. Please mind that arrays start at 0
    */
    return array_slice($array, 0, $position, TRUE) + $insert + array_slice($array, $position, NULL, TRUE);
}
function getNextKey($k, $array){
	 $keys = array_keys($array);
	 $key  = array_search($k, $keys);
	 if(count($array)-1==$key){
		 return $keys[0];
	 }else{
		 return $keys[$key+1];
	 }
	 return 0; 									//else return nothing ( leaving the final answer unaffected
}
function garbagereplace($string) {
  $garbagearray = array('@','#','$','%','^','&','*','?');
  $garbagecount = count($garbagearray);
  for ($i=0; $i<$garbagecount; $i++) {
    $string = str_replace($garbagearray[$i], '-', $string);
  }
  $string = str_replace(" ","+",$string);
  return $string;
}
function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}
function strlimitUrlEncode($s,$n){
	if(iconv_strlen($s,'UTF-8')>$n){
		$tmptext = iconv_substr($s, 0, $n, "UTF-8");
		return myUrlEncode($tmptext);
	}else{
		return $s;
	}
}
function getDateRangeForAllWeeks($start, $end){
    $fweek = getDateRangeForWeek($start);
    $lweek = getDateRangeForWeek($end);
    $week_dates = [];
    while($fweek['sunday']!=$lweek['sunday']){
        $week_dates [] = $fweek;
        $date = new DateTime($fweek['sunday']);
        $date->modify('next day');

        $fweek = getDateRangeForWeek($date->format("Y-m-d"));
    }
    $week_dates [] = $lweek;

    return $week_dates;
}

function getDateRangeForWeek($date){
    $dateTime = new DateTime($date);
    $monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
    $sunday = clone $dateTime->modify('Sunday this week');
    return ['monday'=>$monday->format("Y-m-d"), 'sunday'=>$sunday->format("Y-m-d")];
}
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) {
        $array[] = $date->format($format);
    }

    return $array;
}
function sortBySubArrayValue(&$array, $key, $dir='asc') {

	$sorter=array();
	$rebuilt=array();

	//make sure we start at the beginning of $array
	reset($array);

	//loop through the $array and store the $key's value
	foreach($array as $ii => $value) {
		$sorter[$ii]=$value[$key];
	}

	//sort the built array of key values
	if ($dir == 'asc') asort($sorter);
	if ($dir == 'desc') arsort($sorter);

	//build the returning array and add the other values associated with the key
	foreach($sorter as $ii => $value) {
		$rebuilt[$ii]=$array[$ii];
	}

	//assign the rebuilt array to $array
	$array=$rebuilt;
}
function addSearch($option){
	// echo '<pre>';
	// print_r($option);
	// echo '</pre>';
	$DataID = $option["dataid"];
	$DataType = $option["datatype"];
	$DataKey = $option["datakey"];
	$systemLang = (isset($option["datalang"])?$option["datalang"]:'');
	$DataCreatID = $option["datacreateid"];
	$DataCreatName = $option["datacreatename"];
	if (!function_exists('ArraySearch')) {
		include(_DIRROOTPATH_SYSTEM_."/assets/lib/phpclass/ArraySearch.php");
	}
	// delete search
	$sql = "DELETE FROM "._TABLE_SEARCH_." WHERE "._TABLE_SEARCH_."_Type = '".$DataType."'";
	$sql .= " AND "._TABLE_SEARCH_."_Key = '".$DataKey."'";
	$sql .= " AND "._TABLE_SEARCH_."_ContentID = ".intval($DataID);
	$z = new __webctrl;
	$z->query($sql);
	// delete search
	include(_DIRROOTPATH_SYSTEM_."/assets/lib/include_menu.php");
	if($DataType=='cms'){
		include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontent.php");
		$PathImg = _RELATIVE_CONTENT_UPLOAD_."b-";
		$arrf = array();
		$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
		$arrf[] = "a."._TABLE_CONTENT_."_Key AS ModKey";
		$arrf[] = "a."._TABLE_CONTENT_."_GID AS GroupID";
		$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
		$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
		$arrf[] = "a."._TABLE_CONTENT_."_End AS ExpireDate";
		$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
		$arrf[] = "a."._TABLE_CONTENT_."_Public AS ContentPublic";
		foreach($systemLang as $lkey=>$lval){
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Title AS Title".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$lkey;
		}
		$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
		foreach($systemLang as $lkey=>$lval){
			$sql .= " LEFT JOIN "._TABLE_CONTENT_DETAIL_." ".$lkey." ON (a."._TABLE_CONTENT_."_ID = ".$lkey."."._TABLE_CONTENT_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTENT_DETAIL_."_Lang = '".$lkey."')";
		}
		$sql .= " WHERE "._TABLE_CONTENT_."_ID = ".(int)$DataID;
		unset($arrf);
	}else if($DataType=='download'){
		include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontentdownload.php");
		$PathImg = _RELATIVE_DOWNLOAD_UPLOAD_;
		$arrf = array();
		$arrf[] = "a."._TABLE_DOWNLOAD_."_ID AS ID";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_Key AS ModKey";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_GID AS GroupID";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_Status AS ListStatus";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_Start AS StartDate";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_End AS ExpireDate";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_Picture AS Picture";
		$arrf[] = "a."._TABLE_DOWNLOAD_."_Public AS ContentPublic";
		foreach($systemLang as $lkey=>$lval){
			$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_ID AS SubjectID".$lkey;
			$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Subject AS Subject".$lkey;
			$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Title AS Title".$lkey;
			$arrf[] = $lkey."."._TABLE_DOWNLOAD_DETAIL_."_Status AS Status".$lkey;
		}
		$sql = "SELECT  ".implode(',',$arrf)." FROM "._TABLE_DOWNLOAD_." a";
		foreach($systemLang as $lkey=>$lval){
			$sql .= " LEFT JOIN "._TABLE_DOWNLOAD_DETAIL_." ".$lkey." ON (a."._TABLE_DOWNLOAD_."_ID = ".$lkey."."._TABLE_DOWNLOAD_DETAIL_."_ContentID AND ".$lkey."."._TABLE_DOWNLOAD_DETAIL_."_Lang = '".$lkey."')";
		}
		$sql .= " WHERE a."._TABLE_DOWNLOAD_."_ID = ".(int)$DataID;
		unset($arrf);
	}else if($DataType=='vdo'){
		include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontentvdo.php");
		$PathImg = _RELATIVE_VDO_UPLOAD_;
		$arrf = array();
		$arrf[] = "a."._TABLE_VDO_."_ID AS ID";
		$arrf[] = "a."._TABLE_VDO_."_Key AS ModKey";
		$arrf[] = "a."._TABLE_VDO_."_GID AS GroupID";
		$arrf[] = "a."._TABLE_VDO_."_Status AS ListStatus";
		$arrf[] = "a."._TABLE_VDO_."_Start AS StartDate";
		$arrf[] = "a."._TABLE_VDO_."_End AS ExpireDate";
		$arrf[] = "a."._TABLE_VDO_."_Picture AS Picture";
		$arrf[] = "a."._TABLE_VDO_."_Public AS ContentPublic";
		foreach($systemLang as $lkey=>$lval){
			$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_ID AS SubjectID".$lkey;
			$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Subject AS Subject".$lkey;
			$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Title AS Title".$lkey;
			$arrf[] = $lkey."."._TABLE_VDO_DETAIL_."_Status AS Status".$lkey;
		}
		$sql = "SELECT  ".implode(',',$arrf)." FROM "._TABLE_VDO_." a";
		foreach($systemLang as $lkey=>$lval){
			$sql .= " LEFT JOIN "._TABLE_VDO_DETAIL_." ".$lkey." ON (a."._TABLE_VDO_."_ID = ".$lkey."."._TABLE_VDO_DETAIL_."_ContentID AND ".$lkey."."._TABLE_VDO_DETAIL_."_Lang = '".$lkey."')";
		}
		$sql .= " WHERE a."._TABLE_VDO_."_ID = ".(int)$DataID;
		unset($arrf);
	}else if($DataType=='calendar'){
		include(_DIRROOTPATH_SYSTEM_."/dataarray/datacalendar.php");
		$PathImg = _RELATIVE_CALENDAR_IMG_UPLOAD_;
		$sql = "";
		$arrfmain = array();
		$arrfmain[] = "TBmain.ID";
		$arrfmain[] = "TBmain.ModKey";
		$arrfmain[] = "TBmain.Subject";
		$arrfmain[] = "TBmain.GroupID";
		$arrfmain[] = "TBGroup.SubjectThai AS GroupName";
		$arrfmain[] = "TBmain.ListStatus";
		$arrfmain[] = "TBmain.StartDate";
		$arrfmain[] = "TBmain.ExpireDate";
		$arrfmain[] = "TBmain.Picture";
		$arrfmain[] = "TBmain.ContentPublic";
		$sql .= "SELECT ".implode(',',$arrfmain)." FROM ";
		$sql .= "("	;
			$arrf = array();
			$arrf[] = "a."._TABLE_CALENDAR_."_ID AS ID";
			$arrf[] = "a."._TABLE_CALENDAR_."_Key AS ModKey";
		  $arrf[] = "a."._TABLE_CALENDAR_."_GroupID AS GroupID";
		  $arrf[] = "a."._TABLE_CALENDAR_."_Name AS Subject";
			$arrf[] = "a."._TABLE_CALENDAR_."_Location AS Location";
			$arrf[] = "a."._TABLE_CALENDAR_."_Status AS ListStatus";
		  $arrf[] = "a."._TABLE_CALENDAR_."_Order AS ListOrder";
		  $arrf[] = "a."._TABLE_CALENDAR_."_DateBegin AS DateBegin";
		  $arrf[] = "a."._TABLE_CALENDAR_."_DateEnd AS DateEnd";
			$arrf[] = "a."._TABLE_CALENDAR_."_Start AS StartDate";
			$arrf[] = "a."._TABLE_CALENDAR_."_End AS ExpireDate";
			$arrf[] = "a."._TABLE_CALENDAR_."_PictureFile AS Picture";
			$arrf[] = "a."._TABLE_CALENDAR_."_Public AS ContentPublic";
			$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CALENDAR_." a";
			$sql .= " WHERE "._TABLE_CALENDAR_."_ID = ".(int)$DataID;
			unset($arrf);
		$sql .= ") TBmain";
		$sql .= " LEFT JOIN (";
		  $arrf = array();
		  $arrf[] = "a."._TABLE_CALENDAR_GROUP_.'_ID AS JoinGroupID';
		  $arrf[] = "a."._TABLE_CALENDAR_GROUP_.'_Color AS GroupColor';
		  foreach($systemLang as $lkey=>$lval){
		    $arrf[] = $lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_ID AS SubjectID".$lkey;
		    $arrf[] = $lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_Subject AS Subject".$lkey;
		    $arrf[] = $lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_Title AS Title".$lkey;
		    $arrf[] = $lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_Status AS Status".$lkey;
		  }
		  $sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_CALENDAR_GROUP_." a";
		  foreach($systemLang as $lkey=>$lval){
		    $sql .= " LEFT JOIN "._TABLE_CALENDAR_GROUP_DETAIL_." ".$lkey." ON (a."._TABLE_CALENDAR_GROUP_."_ID = ".$lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CALENDAR_GROUP_DETAIL_."_Lang = '".$lkey."')";
		  }
		  $sql .= " WHERE a."._TABLE_CALENDAR_GROUP_."_Key='".$DataKey."'";
		  unset($arrf);
		$sql .= ") TBGroup ON (TBmain.GroupID = TBGroup.JoinGroupID)";
		$sql .= " WHERE 1";
		unset($arrfmain);
	}else if($DataType=='questionnaire'){
		include(_DIRROOTPATH_SYSTEM_."/dataarray/dataquestionnaire.php");
		$PathImg = _RELATIVE_QUESTIONNAIRE_IMG_UPLOAD_."b-";
		$arrf = array();
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_ID AS ID";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_Key AS ModKey";
		$arrf[] = "(SELECT '0') AS GroupID";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_Status AS ListStatus";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_Start AS StartDate";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_End AS ExpireDate";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_Picture AS Picture";
		$arrf[] = "a."._TABLE_QUESTIONAIRE_."_Public AS ContentPublic";
		foreach($systemLang as $lkey=>$lval){
			$arrf[] = $lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_ID AS SubjectID".$lkey;
			$arrf[] = $lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_Subject AS Subject".$lkey;
			$arrf[] = $lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_Title AS Title".$lkey;
			$arrf[] = $lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_Status AS Status".$lkey;
		}
		$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_QUESTIONAIRE_." a";
		foreach($systemLang as $lkey=>$lval){
			$sql .= " LEFT JOIN "._TABLE_QUESTIONAIRE_DETAIL_." ".$lkey." ON (a."._TABLE_QUESTIONAIRE_."_ID = ".$lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_ContentID AND ".$lkey."."._TABLE_QUESTIONAIRE_DETAIL_."_Lang = '".$lkey."')";
		}
		$sql .= " WHERE "._TABLE_QUESTIONAIRE_."_ID = ".(int)$DataID;
		unset($arrf);
	}else{
		include(_DIRROOTPATH_SYSTEM_."/dataarray/datacontent.php");
		$PathImg = _RELATIVE_CONTENT_IMG_UPLOAD_."b-";
		$arrf = array();
		$arrf[] = "a."._TABLE_CONTENT_."_ID AS ID";
		$arrf[] = "a."._TABLE_CONTENT_."_Key AS ModKey";
		$arrf[] = "a."._TABLE_CONTENT_."_GID AS GroupID";
		$arrf[] = "a."._TABLE_CONTENT_."_Status AS ListStatus";
		$arrf[] = "a."._TABLE_CONTENT_."_Start AS StartDate";
		$arrf[] = "a."._TABLE_CONTENT_."_End AS ExpireDate";
		$arrf[] = "a."._TABLE_CONTENT_."_Picture AS Picture";
		$arrf[] = "a."._TABLE_CONTENT_."_Public AS ContentPublic";
		foreach($systemLang as $lkey=>$lval){
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_ID AS SubjectID".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Subject AS Subject".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Title AS Title".$lkey;
			$arrf[] = $lkey."."._TABLE_CONTENT_DETAIL_."_Status AS Status".$lkey;
		}
		$sql = "SELECT ".implode(',',$arrf)." FROM "._TABLE_CONTENT_." a";
		foreach($systemLang as $lkey=>$lval){
			$sql .= " LEFT JOIN "._TABLE_CONTENT_DETAIL_." ".$lkey." ON (a."._TABLE_CONTENT_."_ID = ".$lkey."."._TABLE_CONTENT_DETAIL_."_ContentID AND ".$lkey."."._TABLE_CONTENT_DETAIL_."_Lang = '".$lkey."')";
		}
		$sql .= " WHERE "._TABLE_CONTENT_."_ID = ".(int)$DataID;
		unset($arrf);
	}
	$z->sql($sql);
	$RecordCount = $z->num();
	if($RecordCount>0){
		$v = $z->row();
		$Row = $v[0];
		$ID = $Row["ID"];
		$ModKey = $Row["ModKey"];
		$pos = strpos($ModKey, "Admin");
		if($pos === false){
			$LMenuID = array_keys($menuModuleKey, $ModKey);
			$InKey = "Admin".$LMenuID[0];
		}else{
			$InKey = $ModKey;
		}
		$GroupID = $Row["GroupID"];
		$ListStatus = $Row["ListStatus"];
		$StartDate = $Row["StartDate"];
		$ExpireDate = $Row["ExpireDate"];
		$ContentPublic = $Row["ContentPublic"];
		$PathImg = str_replace(_RELATIVE_PATH_UPLOAD_,_HTTP_ROOTPATH_UPLOAD_,$PathImg);
		$Thumbnail = $PathImg.$Row["Picture"];
		if($DataType=='calendar'){
			$Groupname = $Row["GroupName"];
			$Subject = $Row["Subject"];
			$Title = $Row["Subject"];
			$Defaultmylang = "Thai";
			$insert = array();
			$insert[_TABLE_SEARCH_."_Type"] = "'".sql_safe($DataType)."'";
			$insert[_TABLE_SEARCH_."_Key"] = "'".sql_safe($ModKey)."'";
			$insert[_TABLE_SEARCH_."_Lang"] = "'".sql_safe($Defaultmylang)."'";
			$insert[_TABLE_SEARCH_."_CreateDate"] = "NOW()";
			$insert[_TABLE_SEARCH_."_CreateByID"] = sql_safe($DataCreatID,false,true);
			$insert[_TABLE_SEARCH_."_CreateBy"] = "'".sql_safe($DataCreatName)."'";
			$insert[_TABLE_SEARCH_."_ContentID"] = sql_safe($ID,false,true);
			$insert[_TABLE_SEARCH_."_ContentSubject"] = "'".sql_safe($Subject)."'";
			$insert[_TABLE_SEARCH_."_ContentTitle"] = "'".sql_safe($Title)."'";
			$insert[_TABLE_SEARCH_."_GroupID"] = "'".sql_safe($GroupID)."'";
			$insert[_TABLE_SEARCH_."_GroupName"] = "'".sql_safe($Groupname)."'";
			$insert[_TABLE_SEARCH_."_Status"] = "'".sql_safe($ListStatus)."'";
			$insert[_TABLE_SEARCH_."_Public"] = "'".sql_safe($ContentPublic)."'";
			$insert[_TABLE_SEARCH_."_Start"] = "'".sql_safe($StartDate)."'";
			$insert[_TABLE_SEARCH_."_End"] = "'".sql_safe($ExpireDate)."'";
			$insert[_TABLE_SEARCH_."_Picture"] = "'".sql_safe($Thumbnail)."'";
			$z->insert(_TABLE_SEARCH_,$insert);
			unset($insert);
		}else{
			$dataArrGroup = $defaultdata[$InKey]["group"];
			if(!empty($GroupID)){
				$query = "ID='".$GroupID."'";
				$mydata = @ArraySearch($dataArrGroup,$query,1);
				$Groupname = $dataArrGroup[array_key_first($mydata)]["Name"];
			}else{
				$Groupname = "-";
			}
			foreach($systemLang as $lkey=>$lval){
				$Subject = $Row["Subject".$lkey];
				$Title = $Row["Title".$lkey];
				$insert = array();
				$insert[_TABLE_SEARCH_."_Type"] = "'".sql_safe($DataType)."'";
				$insert[_TABLE_SEARCH_."_Key"] = "'".sql_safe($ModKey)."'";
				$insert[_TABLE_SEARCH_."_Lang"] = "'".sql_safe($lkey)."'";
				$insert[_TABLE_SEARCH_."_CreateDate"] = "NOW()";
				$insert[_TABLE_SEARCH_."_CreateByID"] = sql_safe($DataCreatID,false,true);
				$insert[_TABLE_SEARCH_."_CreateBy"] = "'".sql_safe($DataCreatName)."'";
				$insert[_TABLE_SEARCH_."_ContentID"] = sql_safe($ID,false,true);
				$insert[_TABLE_SEARCH_."_ContentSubject"] = "'".sql_safe($Subject)."'";
				$insert[_TABLE_SEARCH_."_ContentTitle"] = "'".sql_safe($Title)."'";
				$insert[_TABLE_SEARCH_."_GroupID"] = "'".sql_safe($GroupID)."'";
				$insert[_TABLE_SEARCH_."_GroupName"] = "'".sql_safe($Groupname)."'";
				$insert[_TABLE_SEARCH_."_Status"] = "'".sql_safe($ListStatus)."'";
				$insert[_TABLE_SEARCH_."_Public"] = "'".sql_safe($ContentPublic)."'";
				$insert[_TABLE_SEARCH_."_Start"] = "'".sql_safe($StartDate)."'";
				$insert[_TABLE_SEARCH_."_End"] = "'".sql_safe($ExpireDate)."'";
				$insert[_TABLE_SEARCH_."_Picture"] = "'".sql_safe($Thumbnail)."'";
				$z->insert(_TABLE_SEARCH_,$insert);
				unset($insert);
			}
		}
	}
}
function addNotification($option){
	// $option => array
	// $option["dataid"]
	// $option["datatype"] => A,B,C,D,E
	//print_r($option);
	if(intval($option["dataid"])>0){
		$insert = array();
		$insert[_TABLE_NOTIFICATION_."_Type"] = "'".sql_safe($option["datatype"])."'";
		if(isset($option["datasubtype"])){
			$insert[_TABLE_NOTIFICATION_."_SubType"] = "'".sql_safe($option["datasubtype"])."'";
		}
		$insert[_TABLE_NOTIFICATION_."_CreateByID"] = sql_safe($_SESSION['Session_Admin_ID'],false,true);
		$insert[_TABLE_NOTIFICATION_."_CreateBy"] = "'".sql_safe($_SESSION['Session_Admin_Name'])."'";
		$insert[_TABLE_NOTIFICATION_."_PostFromID"] = sql_safe($option["datafromid"],false,true);
		$insert[_TABLE_NOTIFICATION_."_PostFromName"] = "'".sql_safe($option["datafromname"])."'";
		$insert[_TABLE_NOTIFICATION_."_PostToID"] = sql_safe($option["datatoid"],false,true);
		$insert[_TABLE_NOTIFICATION_."_PostToName"] = "'".sql_safe($option["datatoname"])."'";
		$insert[_TABLE_NOTIFICATION_."_ContentID"] = sql_safe($option["dataid"],false,true);
		$insert[_TABLE_NOTIFICATION_."_ContentText"] = "'".sql_safe($option["datacontentname"])."'";
		$insert[_TABLE_NOTIFICATION_."_CreateDate"] = "NOW()";
		$insert[_TABLE_NOTIFICATION_."_IP"] = "'".sql_safe(get_real_ip())."'";
		$z = new __webctrl;
		$z->insert(_TABLE_NOTIFICATION_,$insert);
		unset($insert);
	}
}
function productInfo($pid,$type="ID"){
	$Marray = new StdClass;
	$ArrField = array();
	$ArrField[] = _TABLE_PRODUCT_."_ID AS ID";
	$ArrField[] = _TABLE_PRODUCT_."_Material AS Material";
	$ArrField[] = _TABLE_PRODUCT_."_No AS No";
	$ArrField[] = _TABLE_PRODUCT_."_NoDetail AS NoDetail";
	if($type=="ID"){
		$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_PRODUCT_." WHERE "._TABLE_PRODUCT_."_ID = ".intval($pid);
	}else if($type=="MatCode"){
		$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_PRODUCT_." WHERE "._TABLE_PRODUCT_."_Material = '".$pid."'";
	}else{
		$sql = "SELECT ".implode(",",$ArrField)." FROM "._TABLE_PRODUCT_." WHERE "._TABLE_PRODUCT_."_ID = ".intval($pid);
	}
	unset($ArrField);
	$z = new __webctrl;
	$z->sql($sql);
	$v = $z->row();
	$Row = $v[0];
	$ID = $Row["ID"];
	$Material = $Row["Material"];
	$No = $Row["No"];
	$NoDetail = $Row["NoDetail"];
	$found["ID"] = $ID;
	$found["Material"] = $Material;
	$found["No"] = $No;
	$found["NoDetail"] = $NoDetail;

	$Marray->status = "OK";
	$Marray->data = $found;
	return $Marray;
}
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
if (! function_exists("array_key_last")) {
    function array_key_last($array) {
        if (!is_array($array) || empty($array)) {
            return NULL;
        }

        return array_keys($array)[count($array)-1];
    }
}
function MemberInfo($mid){
	$Marray = new StdClass;
	$sql = "";
	$sql .= "SELECT * FROM ";
	$sql .= "("	;
		$arrf = array();
		$arrf[] = "a."._TABLE_MEMBER_."_ID AS ID";
	  $arrf[] = "a."._TABLE_MEMBER_."_Username AS Username";
	  $arrf[] = "a."._TABLE_MEMBER_."_Orgpass AS Orgpass";
	  $arrf[] = "a."._TABLE_MEMBER_."_Name AS FName";
	  $arrf[] = "a."._TABLE_MEMBER_."_LName AS LName";
	  $arrf[] = "CONCAT(TRIM(a."._TABLE_MEMBER_."_AName),TRIM(a."._TABLE_MEMBER_."_Name), ' ', TRIM(a."._TABLE_MEMBER_."_LName)) AS FullName";
	  $arrf[] = "a."._TABLE_MEMBER_."_IDCard AS IDCard";
	  $arrf[] = "IF(a."._TABLE_MEMBER_."_Email IS NULL or a."._TABLE_MEMBER_."_Email = '', '', a."._TABLE_MEMBER_."_Email) as Email";
	  $arrf[] = "IF(a."._TABLE_MEMBER_."_Telephone IS NULL or a."._TABLE_MEMBER_."_Telephone = '', '', a."._TABLE_MEMBER_."_Telephone) as Tel";
	  $arrf[] = "a."._TABLE_MEMBER_."_Status AS ListStatus";
	  $arrf[] = "a."._TABLE_MEMBER_."_CreateDate AS CreateDate";
	  $arrf[] = "IF(a."._TABLE_MEMBER_."_Member IS NULL or a."._TABLE_MEMBER_."_Member = '', '0', a."._TABLE_MEMBER_."_Member) as MLevel";
	  $arrf[] = "a."._TABLE_MEMBER_."_Membertxt AS MLevelTxt";
	  $arrf[] = "a."._TABLE_MEMBER_."_ID AS ListOrder";
		$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_MEMBER_." a";
		$sql .= " WHERE "._TABLE_MEMBER_."_ID = ".intval($mid);
		unset($arrf);
	$sql .= ") TBmain";
	$sql .= " WHERE 1";
	unset($ArrField);
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	$v = $z->row();
	if($RecordCount>0){
		$Row = $v[0];
		$ID = $Row["ID"];
		$Name = $Row["FullName"];
		$Email = $Row["Email"];
		$Tel = $Row["Tel"];
		$found["Name"] = $Name;
		$found["Email"] = $Email;
		$found["Tel"] = $Tel;
	}
	$Marray->status = "OK";
	$Marray->countdata = $RecordCount;
	$Marray->data = $found;
	return $Marray;
}

function ListTimeZone($tid=0){
	// _TABLE_TIMEZONE_
	$found = array();
	$Marray = new StdClass;
	$sql = "";
	$arrf = array();
	$arrf[] = "a."._TABLE_TIMEZONE_."_ID AS ID";
	$arrf[] = "a."._TABLE_TIMEZONE_."_Name AS Name";
	$arrf[] = "a."._TABLE_TIMEZONE_."_gmt_offset AS gmt_offset";
	$arrf[] = "a."._TABLE_TIMEZONE_."_Timezone AS Timezone";
	$sql .= "SELECT  ".implode(',',$arrf)." FROM "._TABLE_TIMEZONE_." a";
	if(intval($tid)>0){
		$sql .= " WHERE "._TABLE_TIMEZONE_."_ID = ".intval($mid);
	}else{
		$sql .= " WHERE 1";
	}
	$z = new __webctrl;
	$z->sql($sql);
	$RecordCount = $z->num();
	if($RecordCount>0){
		$v = $z->row();
		foreach($v as $Row){
			$arr = array();
			$arr["ID"] = $Row["ID"];
			$arr["Name"] = $Row["Name"];
			$arr["gmt_offset"] = $Row["gmt_offset"];
			$arr["Timezone"] = $Row["Timezone"];
			$found[] = $arr;
		}
	}
	$Marray->num = $RecordCount;
	$Marray->data = $found;
	return $Marray;
}
?>
