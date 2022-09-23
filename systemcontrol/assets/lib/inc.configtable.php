<?php
## Database Table ######################################################
define ("_TABLE_PREFIX_", "thaiselect_");
define ("_TABLE_ADMIN_STAFF_", _TABLE_PREFIX_."administrator_staff");
define ("_TABLE_ADMIN_STAFFLOGIN_", _TABLE_PREFIX_."administrator_stafflogin");
define ("_TABLE_ADMIN_HISTORYPASS_", _TABLE_PREFIX_."administrator_passhistory");
define ("_TABLE_ADMIN_USERGROUP_", _TABLE_PREFIX_."administrator_usergroup");
define ("_TABLE_ADMIN_USERGROUPPMA_", _TABLE_PREFIX_."administrator_usergrouppma");
define ("_TABLE_ADMIN_USERGROUPAPPROVE_", _TABLE_PREFIX_."administrator_usergroupapprove");
define ("_TABLE_ADMIN_USER_", _TABLE_PREFIX_."administrator_user");
define ("_TABLE_ADMIN_USERLOGIN_", _TABLE_PREFIX_."administrator_userlogin");
define ("_TABLE_ADMIN_USERHISTORYPASS_", _TABLE_PREFIX_."administrator_userpasshistory");
define ("_TABLE_ADMIN_USERTOKEN_", _TABLE_PREFIX_."administrator_usertoken");
define ("_TABLE_ADMIN_WDAY_", _TABLE_PREFIX_."administrator_working_day");
define ("_TABLE_ADMIN_TERRITORY_", _TABLE_PREFIX_."territory");
define ("_TABLE_ADMIN_ESTIMATEDPRICE_", _TABLE_PREFIX_."administrator_estimated_price");

define('_TABLE_BANNER_',_TABLE_PREFIX_.'banner');
define("_TABLE_BANNER_DETAIL_",_TABLE_PREFIX_.'bannerdetail');
define("_TABLE_BANNER_GROUP_",_TABLE_PREFIX_.'bannergroup');
define("_TABLE_BANNER_GROUP_DETAIL_",_TABLE_PREFIX_.'bannergroupdetail');
define('_TABLE_BANNER_LOGS_',_TABLE_PREFIX_.'banner_logs');
define('_TABLE_BANNER_SEEONLY_',_TABLE_PREFIX_.'banner_seeonly');

define("_TABLE_STOCKFILE_",_TABLE_PREFIX_.'stockfile');

define("_TABLE_ADDRCOUNTRIES_",_TABLE_PREFIX_.'address_countries');
define("_TABLE_ADDRSTATE_",_TABLE_PREFIX_.'address_countries_states');
define("_TABLE_ADDRDISTRICT_",_TABLE_PREFIX_.'address_countries_district');
define("_TABLE_ADDRSUBDISTRICT_",_TABLE_PREFIX_.'address_countries_sub_district');
define("_TABLE_ADDRPROVINCE_",_TABLE_PREFIX_.'address_provinces');
define("_TABLE_ADDRAMPHUR_",_TABLE_PREFIX_.'address_amphures');
define("_TABLE_ADDRDISTRICTS_",_TABLE_PREFIX_.'address_districts');

define("_TABLE_TIMEZONE_",_TABLE_PREFIX_.'timezones');

define("_TABLE_CONTACT_",_TABLE_PREFIX_.'contact');
define("_TABLE_CONTACT_GROUP_",_TABLE_PREFIX_.'contact_group');
define("_TABLE_CONTACT_GROUP_DETAIL_",_TABLE_PREFIX_.'contact_group_detail');
define("_TABLE_CONTACT_REPLY_",_TABLE_PREFIX_.'contact_reply');

define("_TABLE_CONTENT_",_TABLE_PREFIX_.'content');
define("_TABLE_CONTENT_DETAIL_",_TABLE_PREFIX_.'contentdetail');
define("_TABLE_CONTENT_PIC_",_TABLE_PREFIX_.'contentphoto');
define("_TABLE_CONTENT_PHOTO_",_TABLE_PREFIX_.'contentphoto');
define("_TABLE_CONTENT_VIEW_",_TABLE_PREFIX_.'content_view');
define("_TABLE_CONTENT_GROUP_",_TABLE_PREFIX_.'content_group');
define("_TABLE_CONTENT_FILE_",_TABLE_PREFIX_.'contentfile');
define("_TABLE_CONTENT_LINK_",_TABLE_PREFIX_.'contentlink');
define("_TABLE_CONTENT_RATING_",_TABLE_PREFIX_.'content_rating');
define("_TABLE_CONTENT_COMMENT_",_TABLE_PREFIX_.'content_comment');
define('_TABLE_CONTENT_SEEONLY_',_TABLE_PREFIX_.'content_seeonly');
define('_TABLE_CONTENT_FILE_LOGS_',_TABLE_PREFIX_.'contentfile_logs');

define("_TABLE_VDO_",_TABLE_PREFIX_.'vdo');
define("_TABLE_VDO_DETAIL_",_TABLE_PREFIX_.'vdodetail');
define("_TABLE_VDO_VIEW_",_TABLE_PREFIX_.'vdo_view');
define("_TABLE_VDO_GROUP_",_TABLE_PREFIX_.'vdo_group');

define("_TABLE_DOWNLOAD_",_TABLE_PREFIX_.'download');
define("_TABLE_DOWNLOAD_DETAIL_",_TABLE_PREFIX_.'downloaddetail');
define("_TABLE_DOWNLOAD_VIEW_",_TABLE_PREFIX_.'download_view');
define("_TABLE_DOWNLOAD_LOGS_",_TABLE_PREFIX_.'download_logs');
define("_TABLE_DOWNLOAD_GROUP_",_TABLE_PREFIX_.'download_group');
define("_TABLE_DOWNLOAD_FILE_",_TABLE_PREFIX_.'downloadfile');
define('_TABLE_DOWNLOAD_SEEONLY_',_TABLE_PREFIX_.'download_seeonly');

define("_TABLE_ABOUT_",_TABLE_PREFIX_.'about');
define("_TABLE_ABOUT_DETAIL_",_TABLE_PREFIX_.'aboutdetail');

define("_TABLE_SEARCH_LOGS_",_TABLE_PREFIX_.'search_logs');

define('_TABLE_INTRO_',_TABLE_PREFIX_.'intro');
define('_TABLE_INTRO_DETAIL_',_TABLE_PREFIX_.'introdetail');

define('_TABLE_ADS_',_TABLE_PREFIX_.'ads');
define('_TABLE_ADS_DETAIL_',_TABLE_PREFIX_.'adsdetail');

define("_TABLE_MEMBER_",_TABLE_PREFIX_.'member');
define("_TABLE_MEMBER_USAGE_",_TABLE_PREFIX_.'member_usage');
define("_TABLE_MEMBER_MEDAL_",_TABLE_PREFIX_."member_medal");
define("_TABLE_MEMBER_SALARY_",_TABLE_PREFIX_."member_salary");
define("_TABLE_MEMBER_FILE_",_TABLE_PREFIX_."member_file");

define("_TABLE_THAIEMBASSY_",_TABLE_PREFIX_.'thaiembassy');
define("_TABLE_THAIEMBASSY_CITY_",_TABLE_PREFIX_.'thaiembassy_city');

define('_TABLE_WEBLINK_',_TABLE_PREFIX_.'weblink');
define("_TABLE_WEBLINK_DETAIL_",_TABLE_PREFIX_.'weblinkdetail');
define('_TABLE_WEBLINK_LOGS_',_TABLE_PREFIX_.'weblink_logs');
define('_TABLE_WEBLINK_GROUP_',_TABLE_PREFIX_.'weblink_group');

define('_TABLE_CALENDAR_',_TABLE_PREFIX_.'calendar');
define("_TABLE_CALENDAR_GROUP_",_TABLE_PREFIX_.'calendar_group');
define("_TABLE_CALENDAR_GROUP_DETAIL_",_TABLE_PREFIX_.'calendar_group_detail');

define("_TABLE_NOTIFICATION_",_TABLE_PREFIX_.'notifications');
define("_TABLE_SEARCH_",_TABLE_PREFIX_.'search');

define("_TABLE_FRONTMENU_",_TABLE_PREFIX_."frontmenu");
define("_TABLE_FRONTMENU_DETAIL_",_TABLE_PREFIX_.'frontmenu_detail');

define("_TABLE_FRONTMENUCONTENT_",_TABLE_PREFIX_."fronthomecontent");

define("_TABLE_COUNTPAGE_",_TABLE_PREFIX_."countmap");

define("_TABLE_MAIL_DOCUMENT_",_TABLE_PREFIX_."mlt_document");
define("_TABLE_MAIL_DOCUMENT_FILE_",_TABLE_PREFIX_."mlt_documentfile");
define("_TABLE_MAIL_GROUP_",_TABLE_PREFIX_."mlt_group");
define("_TABLE_MAIL_GROUP_DETAIL_",_TABLE_PREFIX_.'mlt_group_detail');
define("_TABLE_MAIL_MAILLIST_",_TABLE_PREFIX_."mlt_maillist");
define("_TABLE_MAIL_MAILLISTINGROUP_",_TABLE_PREFIX_."mlt_maillistingroup");
define("_TABLE_MAIL_TASK_",_TABLE_PREFIX_."mlt_task");
define("_TABLE_MAIL_TASKPROGRESS_",_TABLE_PREFIX_."mlt_task_progress");
define("_TABLE_MAIL_TASKREPORT_",_TABLE_PREFIX_."mlt_task_report");

define("_TABLE_INGREDIENTS_GROUP_",_TABLE_PREFIX_.'ingredients_group');
define("_TABLE_INGREDIENTS_GROUP_DETAIL_",_TABLE_PREFIX_.'ingredients_group_detail');
define("_TABLE_INGREDIENTS_",_TABLE_PREFIX_.'ingredients');
define("_TABLE_INGREDIENTS_DETAIL_",_TABLE_PREFIX_.'ingredients_detail');
define("_TABLE_INGREDIENTS_PHOTO_",_TABLE_PREFIX_.'ingredients_photo');
define("_TABLE_INGREDIENTS_FILE_",_TABLE_PREFIX_.'ingredients_file');

define("_TABLE_SUPERMARKET_",_TABLE_PREFIX_.'supermarket');
define("_TABLE_SUPERMARKET_DETAIL_",_TABLE_PREFIX_.'supermarket_detail');
define("_TABLE_SUPERMARKET_PHOTO_",_TABLE_PREFIX_.'supermarket_photo');
define("_TABLE_SUPERMARKET_FILE_",_TABLE_PREFIX_.'supermarket_file');
define("_TABLE_SUPERMARKET_GROUP_",_TABLE_PREFIX_.'supermarket_ingroup');
define("_TABLE_SUPERMARKET_WTIME_",_TABLE_PREFIX_.'supermarket_intime');

define("_TABLE_BLOG_GROUP_",_TABLE_PREFIX_.'blog_group');
define("_TABLE_BLOG_GROUP_DETAIL_",_TABLE_PREFIX_.'blog_group_detail');
define("_TABLE_BLOG_",_TABLE_PREFIX_.'blog');
define("_TABLE_BLOG_DETAIL_",_TABLE_PREFIX_.'blog_detail');
define("_TABLE_BLOG_PHOTO_",_TABLE_PREFIX_.'blog_photo');
define("_TABLE_BLOG_FILE_",_TABLE_PREFIX_.'blog_file');

define("_TABLE_FAQ_",_TABLE_PREFIX_.'faq');
define("_TABLE_FAQ_DETAIL_",_TABLE_PREFIX_.'faq_detail');

define("_TABLE_RECIPES_GROUP_",_TABLE_PREFIX_.'recipes_group');
define("_TABLE_RECIPES_GROUP_DETAIL_",_TABLE_PREFIX_.'recipes_group_detail');
define("_TABLE_RECIPES_",_TABLE_PREFIX_.'recipes');
define("_TABLE_RECIPES_DETAIL_",_TABLE_PREFIX_.'recipes_detail');
define("_TABLE_RECIPES_DETAILRELATE_",_TABLE_PREFIX_.'recipes_detailrelate');
define("_TABLE_RECIPES_PHOTO_",_TABLE_PREFIX_.'recipes_photo');
define("_TABLE_RECIPES_FILE_",_TABLE_PREFIX_.'recipes_file');

define("_TABLE_RESTAURANT_",_TABLE_PREFIX_.'restaurant');
define("_TABLE_RESTAURANT_DETAIL_",_TABLE_PREFIX_.'restaurant_detail');
define("_TABLE_RESTAURANT_FILE_",_TABLE_PREFIX_.'restaurant_file');
define("_TABLE_RESTAURANT_WORK_",_TABLE_PREFIX_.'restaurant_work');
define("_TABLE_RESTAURANT_SCORE_",_TABLE_PREFIX_.'restaurant_score');
define("_TABLE_RESTAURANT_SCORE_DETAIL_",_TABLE_PREFIX_.'restaurant_scoredetail');
define("_TABLE_RESTAURANT_RATING_",_TABLE_PREFIX_.'restaurant_rating');
define("_TABLE_RESTAURANT_STATUSLOGS_",_TABLE_PREFIX_.'restaurant_statuslogs');

define("_TABLE_PRODUCTS_TYPE_",_TABLE_PREFIX_.'member_product_type');
define("_TABLE_PRODUCTS_",_TABLE_PREFIX_.'member_product');
define("_TABLE_PRODUCTS_DETAIL_",_TABLE_PREFIX_.'member_product_detail');
define("_TABLE_PRODUCTS_FILE_",_TABLE_PREFIX_.'member_product_file');

?>
