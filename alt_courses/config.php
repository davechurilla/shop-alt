<?php

  /*  This code has been developed by Els . Els11@yandex.ru    
		In God I trust 				*/

  define("SQL_IP", "mysql.advancedlasertraining.com"); // ip address of mysql database 
  define("SQL_USER", "advlaser");  // username for connecting to mysql
  define("SQL_PWD","I^uI3JJC"); // password for connecting to mysql
  define("SQL_DATABASE","shop_advlaser"); // database where you have executed sql scripts

  define("WEB_SITE_URL","https://shop.advancedlasertraining.com/alt_courses/"); // the url where you installed this script . do not delete last slash  
  define("USE_MATH", "no"); // yes , no . if you want to use math symbols , you have to enable it
  define("DEBUG_SQL","no"); // enable it , if you want to view sql queries .
  define("PAGING","100");  // paging for all grids
  define("SHOW_MENU","registered"); // all = all users , registered = registered users  , nobody = menu will be disabled
  define("SHOW_MENU_ON_LOGIN_PAGE", "no"); // yes , no

  define("MAIL_FROM", "mowens@advancedlasertraining.com"); // 
  define("MAIL_CHARSET", "UTF-8");
  define("MAIL_USE_SMTP", "yes");
  define("MAIL_SERVER", "mail.advancedlasertraining.com"); // only if smtp enabled
  define("MAIL_USER_NAME", "mowens@advancedlasertraining.com"); // only if smtp enabled
  define("MAIL_PASSWORD", "quarrylane"); // only if smtp enabled

  define("REGISTRATION_ENABLED", "yes");
  define("SITE_TEMPLATE", "standard"); // gold  , standard

  $PAGE_HEADER_TEXT= "Advanced Laser Training Online Course Exam"; //only in gold and green templates
  define("HEADER_TEXT_LINK", "https://shop.advancedlasertraining.com/");
  $PAGE_SUB_HEADER_TEXT=""; //only in gold and green templates
  $PAGE_FOOTER_TEXT="Contact mail : info@advancedlasertraining.com"; //only in gold and green templates

  // function Imported_Users_Password_Hash($entered_password,$password_from_db)
  // {
  //     return md5($entered_password);
  // }

 
function Imported_Users_Password_Hash($entered_password,$password_from_db)
{
// to say , we have some hashed password in database , something like this 0Ajsdfuy847jdshjdh:02
// our $password_from_db variable will be that password . $password_from_db = "0Ajsdfuy847jdshjdh:02";
// and $entered_password is the plain text entered by our user
// we need to generate that password from plain text. 
// first we need to explode our password that came from database 
 
$password_details = explode(":", $password_from_db); // this function will explode the password
$password_hash = $password_details[0]; // this will take hashed password from exploded array
$password_salt = $password_details[1]; // this will take salt 
 
// and now , we need to generate password in same way 
$password_for_check = md5($password_salt . $entered_password) . ":" .$password_salt ;
 
    return $password_for_check;
}

  @session_start();

  // LANGUAGE CONFIGURATION
  $LANGUAGES = array("english.php"=>"English","russian.php"=>"Russian");
  $DEFAULT_LANGUAGE_FILE="english.php";

  //----------------------------do not touch the code below--------------------------------
  
  if(isset($_SESSION['lang_file']))
  {
      $DEFAULT_LANGUAGE_FILE = $_SESSION['lang_file'];
  }
  
  if(isset($_GET['lang']))
  {
      $lang_arr = util::translate_array($LANGUAGES);
      if(isset($lang_arr[$_GET['lang']])) $DEFAULT_LANGUAGE_FILE = $lang_arr[$_GET['lang']];
  }

  require "lang/".$DEFAULT_LANGUAGE_FILE;

  ini_set ('magic_quotes_gpc', 0);
  ini_set ('magic_quotes_runtime', 0);
  ini_set ('magic_quotes_sybase', 0);
  ini_set('session.bug_compat_42',0);
  ini_set('session.bug_compat_warn',0);  
  
  //----------------------------------------------------------------------
  
?>
