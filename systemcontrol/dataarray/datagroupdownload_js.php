<?php
$Array_Mod_Lang["txtinput:inputMainType"]["Thai"] = "Group Management";
$Array_Mod_Lang["txtinput:inputMainType"]["English"] = "Detail Head";
header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";

?>
