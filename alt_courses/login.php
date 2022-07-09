<?php

  require "lib/util.php";
  require 'config.php';
  require 'db/mysql2.php';  
  require "db/orm.php";
  require "db/access_db.php";
  require "lib/validations.php";
  require "lib/webcontrols.php";

  $RUN = 1;


  $msg = "";
  $autorized =false;

  if(isset($_POST['btnSubmit']))
  {      
      $txtLogin = db::esp(trim($_POST['txtLogin']));
      $txtPass = md5(trim($_POST['txtPass']));
      $password="";
      //$txtPassImp= Imported_Users_Password_Hash(trim($_POST['txtPass']));
      $results = access_db::GetModules($txtLogin, "", "", false);
      $has_result = db::num_rows($results);      
      if($has_result!=0 && isset($LANGUAGES[$_POST['drpLang']]))
      {
          $row = db::fetch($results);

          if($row['imported']=="0") $password = $txtPass ;
          else $password = Imported_Users_Password_Hash(trim($_POST['txtPass']), $row['password']);

          if($password==$row['password'])
          {

            $_SESSION['lang_file']=$_POST['drpLang'];
            $_SESSION['txtLogin'] = $txtLogin;
            $_SESSION['txtPass'] = $password;
            $_SESSION['txtPassImp'] = $password;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];
      	    $_SESSION['imported'] = $row['imported'];
      	    $_SESSION['name'] = $row['Name'];
      	    $_SESSION['surname'] = $row['Surname'];
            $_SESSION['customers_title'] = $row['customers_title'];
      	    $_SESSION['email'] = $row['email'];
            if($row['user_type']=="1")
            header("location:index.php?module=quizzes");
            else
            header("location:index.php?module=active_assignments");
          }
      }
      $msg = LOGIN_INCORRECT;
  }

  $language_options = webcontrols::BuildOptions($LANGUAGES, $DEFAULT_LANGUAGE_FILE);

  $menus = orm::Select("pages", array("page_name","id"), array(), "priority");

  if(REGISTRATION_ENABLED=="yes") $register_display = "";
  else $register_display="none";

  include "login_".SITE_TEMPLATE."_tmp.php";


?>
