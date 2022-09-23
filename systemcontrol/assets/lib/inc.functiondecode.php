<?php
function decodeAPPData($option){
  $Marray = new StdClass;
  $txt = $option["TEXT"];
  $text = base64_decode(strrev($txt));
  $arrAdd = explode("|",$text);
  if(count($arrAdd)>1){
    $data1 = strrev(base64_decode($arrAdd[0]));
    $data2 = strrev(base64_decode($arrAdd[1]));
    $data3 = strrev(base64_decode($arrAdd[2]));
    $data4 = strrev(base64_decode($arrAdd[3]));
    $data5 = strrev(base64_decode($arrAdd[4]));
    $data6 = strrev(base64_decode($arrAdd[5]));
    $data7 = strrev(base64_decode($arrAdd[6]));
    $data8 = strrev(base64_decode($arrAdd[7]));
    $arr = array();
    if($option["APIKEY"]==$data1){
      $arr["HOST"] = $data2;
      $arr["PORT"] = $data3;
      $arr["DBNAME"] = $data4;
      $arr["DBUSER"] = $data5;
      $arr["DBPASS"] = $data6;
      $arr["ROOTUSER"] = $data7;
      $arr["ROOTPASS"] = $data8;
    }else{
      $arr["HOST"] = "-";
      $arr["PORT"] = "-";
      $arr["DBNAME"] = "-";
      $arr["DBUSER"] = "-";
      $arr["DBPASS"] = "-";
      $arr["ROOTUSER"] = "-";
      $arr["ROOTPASS"] = "-";
    }
  }else{
    $arr["HOST"] = "-";
    $arr["PORT"] = "-";
    $arr["DBNAME"] = "-";
    $arr["DBUSER"] = "-";
    $arr["DBPASS"] = "-";
    $arr["ROOTUSER"] = "-";
    $arr["ROOTPASS"] = "-";
  }
  $Marray->option = $arr;
  return $Marray;
}
function endcodeAPPData($option){
  $Marray = new StdClass;
  //print_r($option);
  $indata = "";
  $data1 = $option["APIKEY"];
  $data1 = strrev($data1);
  $data1 = base64_encode($data1);
  $indata .= $data1;

  $data2 = $option["HOST"];
  $data2 = strrev($data2);
  $data2 = base64_encode($data2);
  $indata .= "|".$data2;

  $data3 = $option["PORT"];
  $data3 = strrev($data3);
  $data3 = base64_encode($data3);
  $indata .= "|".$data3;

  $data4 = $option["DBNAME"];
  $data4 = strrev($data4);
  $data4 = base64_encode($data4);
  $indata .= "|".$data4;

  $data5 = $option["DBUSER"];
  $data5 = strrev($data5);
  $data5 = base64_encode($data5);
  $indata .= "|".$data5;

  $data6 = $option["DBPASS"];
  $data6 = strrev($data6);
  $data6 = base64_encode($data6);
  $indata .= "|".$data6;

  $data7 = $option["ROOTUSER"];
  $data7 = strrev($data7);
  $data7 = base64_encode($data7);
  $indata .= "|".$data7;

  $data8 = $option["ROOTPASS"];
  $data8 = strrev($data8);
  $data8 = base64_encode($data8);
  $indata .= "|".$data8;

  $indata = strrev(base64_encode($indata));
  //$indata = (base64_encode($indata));
  $Marray->data = $indata;
  $Marray->option = $option;
	return $Marray;
}
?>
