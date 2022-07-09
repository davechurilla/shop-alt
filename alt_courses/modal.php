<?php
 
  require "lib/util.php";
  require 'config.php';
  require 'db/mysql2.php';
  require 'db/access_db.php';  
  require "lib/access.php";
  require "db/orm.php";
  require_once "db/asg_db.php";
  require "lib/validations.php";
  require "lib/webcontrols.php";

  if(!isset($LANGUAGES)) header("location:install/index.php");

  if(USE_MATH=="yes") include("mathpublisher/mathpublisher.php") ;
   
  $RUN = 1;

  $module_name = GetModuleName();
  $expand =false;
  $autorized = false;
  $check = true;
  if($module_name=="register" || $module_name=="forgot_password" ||
    $module_name=="register_step2" || $module_name=="approve_registration"
  ) 
  {
	$check = false;
  }
  else if ($module_name=="show_page")
  {
	if(!isset($_SESSION['txtLogin']) && SHOW_MENU=="all") $check = false;
  }

  if($check==true) 
  {
	$modules = access_db::GetModules($_SESSION['txtLogin'], $_SESSION['txtPass'],$_SESSION['txtPassImp'],true);
  	$has_result = db::num_rows($modules);
  

  	if($has_result==0)
  	{ 
        	header("location:login.php");
        	exit;
  	}

  	if($has_result!=0) {
  		$_SESSION['KCFINDER'] = array();
  		$_SESSION['KCFINDER']['disabled'] = false;
 	}
  	$autorized = true;
	$expand  = true;
  	ExpandModules($modules);
  }
    
  function ExpandModules($modules)
  {
      global $child_modules,$main_modules;
      while($row=db::fetch($modules))
      {	  
          if($row['parent_id']=="0")
          {		  
              $main_modules[] = $row;
          }
          else
          {        
              $child_modules[$row['parent_id']][]=$row;
          }
      }
  }   

  $user_type = $_SESSION['user_type'];
  $user_id = $_SESSION['user_id'];

  $menus = orm::Select("pages", array("page_name","id","priority"), array(), "priority");

  $query = asgDB::GetActAsgByUserIDQuery($user_id);
  $results = db::exec_sql($query);
  $asg_ids = array();
  while($row = db::fetch($results)) {array_push($asg_ids, $row['org_quiz_id']);} 

  // ShowModule();

  function ShowModule()
  {
        global $module_name,$module_t_name,$Util;

        if(!file_exists("modules/$module_name".".php") || $module_name=="" || strpos($module_name,"../")!=0)
            $module_name="default";

        $module_t_name=$module_name."_tmp";

  }

  function GetModuleName()
  {
	return isset($_GET["module"]) ? $_GET["module"] : "default" ;
  }

  include "modules/".$module_name.".php";
  
  if(!isset($_POST["ajax"]))
  {
        $queries = debug::GetSQLs();
        include "modal_".SITE_TEMPLATE."_tmp.php";
  }  


?>
