<?php if(!isset($RUN)) { exit(); } ?>
<?php 

 if(REGISTRATION_ENABLED!="yes") exit();


include "lib/libmail.php";
include "lib/cmail.php";

$val = new validations("btnRegister");
$val->AddValidator("txtName", "empty", R_NAME_VAL,"");
$val->AddValidator("txtSurname", "empty", R_SURNAME_VAL,"");
$val->AddValidator("txtLogin", "an", R_LOGIN_VAL , "");
$val->AddValidator("txtPass", "an", R_PASSWORD_VAL , "");
$val->AddValidator("txtEmail", "email", R_EMAIL_VAL , "");


if(isset($_POST["txtName"]) && $val->Isvalid())
{
	$guid = md5(util::Guid());
	orm::Insert("users" , array("UserName"=>$_POST['txtLogin'],
						"Password"=>md5(trim($_POST['txtPass'])),					
						"Name"=>$_POST['txtName'],
						"Surname"=>$_POST['txtSurname'],
						"added_date"=>util::Now(),
						"user_type"=>2,
						"email"=>$_POST['txtEmail'],
						"address"=>$_POST['txtAddr'],
						"phone"=>$_POST['txtPhone'],	
						"approved"=>0,
						"disabled"=>0,
						"random_str"=>$guid
					));

	$url = WEB_SITE_URL."?module=approve_registration&g=".$guid;	

	$results = orm::Select("users", array(),array("UserName"=>$_POST['txtLogin']), "");
	$row = db::fetch($results);
	$cmail = new cmail("register_user",$row);

	$m= new Mail; 
	$m->From(MAIL_FROM ); 
	$m->To( trim($_POST['txtEmail']) );
	$m->Subject( $cmail->subject );
	$m->Body( str_replace("[url]", $url , $cmail->body) );    	
	$m->Priority(3) ;    
	//$m->Attach( "asd.gif","", "image/gif" ) ;
	
	if(MAIL_USE_SMTP=="yes")
	{
		$m->smtp_on(MAIL_SERVER, MAIL_USER_NAME, MAIL_PASSWORD ) ;    
	}
	$m->Send(); 


	header("location:?module=register_step2");
}

if(isset($_POST["ajax"]))
{
         $results = orm::Select("users", array(), array("UserName"=>$_POST["login_to_check"]) , "");
         $count = db::num_rows($results);
	 $msg = 0;
         if($count > 0)
	 {
		$msg= LOGIN_ALREADY_EXISTS ;
         }

 	 $results = orm::Select("users", array(), array("email"=>$_POST["email"]) , "");
         $count = db::num_rows($results);
         if($count > 0)
	 {
		$msg= EMAIL_ALREADY_EXISTS ;
         }

	 echo $msg;
}



function desc_func () { return R_REG_FORM; }

?>
