<?php
header('Content-Type: text/css');
echo '.barprograss { width: 100%; height: 16px; background: #CCCCCC; position: relative; border: 0px solid #000; padding: 1px; border-radius: 10px;}';
echo '.barprograss .pg01 { background: #026596; }';
echo '.barprograss .pg02 { background: #F00;}';
for($i=1;$i<=100;$i++){
  echo '.barprograss .inbarprograss'.$i.' { width: '.$i.'%; height: 14px; border-radius: 10px;}';
}
?>
