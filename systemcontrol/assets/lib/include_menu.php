<?php
$indexmaingroup = 1;
$MenuGroupMain[$indexmaingroup] = $indexmaingroup;
$MenuGroupMainName[$indexmaingroup] = "System";

$indexgroupmenu = 1;
$MenuMainGroup[$indexgroupmenu] = $indexmaingroup;
$MenuGroup[$indexgroupmenu] = $indexgroupmenu;
$MenuGroupName[$indexgroupmenu] = "Administrator";
$MenuGroupIcon[$indexgroupmenu] = "fa-laptop";

$indexmenu = 1;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="Employee";
$menuFolder[$indexmenu]="employee";
$menuLink[$indexmenu]="../employee/index.php";
$menuFolderModule[$indexmenu]="employee";
$menuModuleKey[$indexmenu]="employee";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="EmpCode";
$menuDefaultOrder[$indexmenu]="ASC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-user";

$indexmenu = 2;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="User Management";
$menuFolder[$indexmenu]="user_management";
$menuLink[$indexmenu]="../useradmin/index.php";
$menuFolderModule[$indexmenu]="user_management";
$menuModuleKey[$indexmenu]="user_management";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ID";
$menuDefaultOrder[$indexmenu]="ASC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-user-plus";

$indexmenu = 3;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="Group Management";
$menuFolder[$indexmenu]="groupuser";
$menuLink[$indexmenu]="../groupuser/index.php";
$menuFolderModule[$indexmenu]="groupuser";
$menuModuleKey[$indexmenu]="groupuser";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ID";
$menuDefaultOrder[$indexmenu]="ASC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-users";

$indexgroupmenu = 2;
$MenuMainGroup[$indexgroupmenu] = $indexmaingroup;
$MenuGroup[$indexgroupmenu] = $indexgroupmenu;
$MenuGroupName[$indexgroupmenu] = "Management (CMS)";
$MenuGroupIcon[$indexgroupmenu] = "fa-cogs";

$indexmenu = 4;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="Stock Images / File";
$menuFolder[$indexmenu]="managefile";
$menuLink[$indexmenu]="../managefile/imgcard.php";
$menuFolderModule[$indexmenu]="managefile";
$menuModuleKey[$indexmenu]="managefile";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="Code";
$menuDefaultOrder[$indexmenu]="ASC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-picture-o";

$indexmenu = 5;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="????????????????????????????????????";
$menuFolder[$indexmenu]="about";
$menuLink[$indexmenu]="../about/index.php";
$menuFolderModule[$indexmenu]="about";
$menuModuleKey[$indexmenu]="about";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListCount";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-comments";

$indexmenu = 6;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="?????????????????? Banner";
$menuFolder[$indexmenu]="banner";
$menuLink[$indexmenu]="../banner/index.php";
$menuFolderModule[$indexmenu]="banner";
$menuModuleKey[$indexmenu]="banner";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-comments";

$indexmenu = 7;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="?????????????????? Floating Ad.";
$menuFolder[$indexmenu]="ads";
$menuLink[$indexmenu] = "../floating/index.php";
$menuFolderModule[$indexmenu]="floating";
$menuModuleKey[$indexmenu]="floating";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-comments";

$indexmenu = 8;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="????????????????????????????????????";
$menuFolder[$indexmenu]="service";
$menuLink[$indexmenu]="../content/index.php";
$menuFolderModule[$indexmenu]="service";
$menuModuleKey[$indexmenu]="cms";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";

$indexmenu = 9;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="???????????? BS Express";
$menuFolder[$indexmenu]="branch";
$menuLink[$indexmenu]="../branch/index.php";
$menuFolderModule[$indexmenu]="branch";
$menuModuleKey[$indexmenu]="cms";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";

$indexmenu = 10;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="?????????????????????";
$menuFolder[$indexmenu]="content";
$menuLink[$indexmenu]="../content/index.php";
$menuFolderModule[$indexmenu]="content";
$menuModuleKey[$indexmenu]="cms";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";


$indexmenu = 11;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="???????????????????????????";
$menuFolder[$indexmenu]="contactus";
$menuLink[$indexmenu]="../contactus/group.php";
$menuFolderModule[$indexmenu]="contactus";
$menuModuleKey[$indexmenu]="contactus";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";


$indexmenu = 12;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="???????????????????????????????????????";
$menuFolder[$indexmenu]="contactus";
$menuLink[$indexmenu]="../contactus/group.php";
$menuFolderModule[$indexmenu]="contactus";
$menuModuleKey[$indexmenu]="contactus";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";


$indexmenu = 12;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="????????????????????????";
$menuFolder[$indexmenu]="contactus";
$menuLink[$indexmenu]="../contactus/group.php";
$menuFolderModule[$indexmenu]="contactus";
$menuModuleKey[$indexmenu]="contactus";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";


$indexgroupmenu = 3;
$MenuMainGroup[$indexgroupmenu] = $indexmaingroup;
$MenuGroup[$indexgroupmenu] = $indexgroupmenu;
$MenuGroupName[$indexgroupmenu] = "???????????????????????????";
$MenuGroupIcon[$indexgroupmenu] = "fa-cogs";

$indexmenu = 13;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="????????????????????????????????????????????????";
$menuFolder[$indexmenu]="content";
$menuLink[$indexmenu]="../content/index.php";
$menuFolderModule[$indexmenu]="content";
$menuModuleKey[$indexmenu]="cms";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";

$indexmenu = 14;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="?????????????????????????????????????????????????????????";
$menuFolder[$indexmenu]="content";
$menuLink[$indexmenu]="../content/index.php";
$menuFolderModule[$indexmenu]="content";
$menuModuleKey[$indexmenu]="cms";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-gears";


$indexgroupmenu = 4;
$MenuMainGroup[$indexgroupmenu] = $indexmaingroup;
$MenuGroup[$indexgroupmenu] = $indexgroupmenu;
$MenuGroupName[$indexgroupmenu] = "FAQ Management";
$MenuGroupIcon[$indexgroupmenu] = "fa-cogs";

$indexmenu = 15;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="FAQ listing";
$menuFolder[$indexmenu]="faq";
$menuLink[$indexmenu]="../faq/index.php";
$menuFolderModule[$indexmenu]="faq";
$menuModuleKey[$indexmenu]="FAQListing";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-picture-o";


$indexmenu = 26;
$menuIndex[$indexmenu]="Admin".$indexmenu;
$menuName[$indexmenu]="Products";
$menuFolder[$indexmenu]="products";
$menuLink[$indexmenu]="../products/index.php";
$menuFolderModule[$indexmenu]="products";
$menuModuleKey[$indexmenu]="memberProduct";
$menuOption[$indexmenu]="0";
$menuInGroup[$indexmenu]=$indexgroupmenu;
$menuType[$indexmenu]="module";//module,link
$menuTarget[$indexmenu]="_self";
$menuDefaultList[$indexmenu]="ListOrder";
$menuDefaultOrder[$indexmenu]="DESC";
$menuDefaultFilter[$indexmenu]="";
$menuDefaultStatus[$indexmenu]="";
$menuDefaultDetails[$indexmenu]="";
$menuDefaultIcon[$indexmenu]="fa-comments";

?>
