<?php
$Array_Mod_Lang["txtinput:firstname"]["EN"] = "First Name";
$Array_Mod_Lang["txtinput:firstname"]["TH"] = "ชื่อ";
$Array_Mod_Lang["txtinput:lastname"]["EN"] = "Last Name";
$Array_Mod_Lang["txtinput:lastname"]["TH"] = "นามสกุล";
$Array_Mod_Lang["txtinput:useremail"]["EN"] = "Employee Email Address";
$Array_Mod_Lang["txtinput:useremail"]["TH"] = "อีเมล์";
$Array_Mod_Lang["txtinput:telephone"]["EN"] = "Employee Telephone";
$Array_Mod_Lang["txtinput:telephone"]["TH"] = "หมายเลขโทรศัพท์";
$Array_Mod_Lang["txtinput:Emp_note"]["EN"] = "Employee Notes";
$Array_Mod_Lang["txtinput:Emp_note"]["TH"] = "รายละเอียดเพิ่มเติม";
$Array_Mod_Lang["txtinput:Employee ID"]["EN"] = "Employee ID";
$Array_Mod_Lang["txtinput:Employee ID"]["TH"] = "รหัสผู้ใช้งาน";
$Array_Mod_Lang["txtinput:fullname"]["EN"] = "Fullname";
$Array_Mod_Lang["txtinput:fullname"]["TH"] = "ชื่อ - นามสกุล";
$Array_Mod_Lang["txtrequired:firstname"]["EN"] = "Enter First Name";
$Array_Mod_Lang["txtrequired:firstname"]["TH"] = "กรุณากรอกชื่อ";
$Array_Mod_Lang["txtrequired:lastname"]["EN"] = "Enter Last Name";
$Array_Mod_Lang["txtrequired:lastname"]["TH"] = "กรุณากรอกนามสกุล";
$Array_Mod_Lang["txtrequired:email"]["EN"] = "Employee Email Address";
$Array_Mod_Lang["txtrequired:email"]["TH"] = "กรุณากรอกอีเมล์";
$Array_Mod_Lang["txtrequired:email VALID"]["EN"] = "Enter a VALID email address";
$Array_Mod_Lang["txtrequired:email VALID"]["TH"] = "กรุณากรอกรูปแบบอีเมล์ให้ถูกต้อง";
$Array_Mod_Lang["txtinput:Emp_Type"]["EN"] = "Employee Type";
$Array_Mod_Lang["txtinput:Emp_Type"]["TH"] = "ประเภท";
$Array_Mod_Lang["txtinput:Emp_Country"]["EN"] = "Country";
$Array_Mod_Lang["txtinput:Emp_Country"]["TH"] = "Country";


header('Content-type: application/javascript');
$js_array = json_encode($Array_Mod_Lang);
echo "var Array_Mod_Lang = ". $js_array . ";\n";
?>
