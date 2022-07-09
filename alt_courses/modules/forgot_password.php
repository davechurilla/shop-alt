<?php if(!isset($RUN)) { exit(); } ?>
<?php 

 if(REGISTRATION_ENABLED!="yes") exit();

include "lib/libmail.php";
include "lib/cmail.php";

$val = new validations("btnSend");
$val->AddValidator("txtEmail", "email", "Please, enter email in a correct format","");

if(isset($_POST["ajax"]))
{
   	 $random_pass=rand(10000, 90000);
	 $random_pass_hash = md5($random_pass);
         $results = orm::Select("users", array(), array("email"=>trim($_POST["email_for_restoring"])) , "");
         $count = db::num_rows($results);
	 if($count < 1)
	 {
		echo "This email doesn't exist in our database";
	 }
	 else
	 {
		orm::Update("users", array ("password"=>$random_pass_hash),array("email"=>trim($_POST["email_for_restoring"])));

		$row = db::fetch($results);
		$cmail = new cmail("forgot_password", $row);	
		$body =str_replace("[url]", WEB_SITE_URL , $cmail->body);
		$body =str_replace("[random_password]", $random_pass, $body);
		$m= new Mail; 
		$m->From(MAIL_FROM ); 
		$m->To( trim($_POST["email_for_restoring"]) );
		$m->Subject( $cmail->subject );
		$m->Body($body);    	 	
		$m->Priority(3) ;   	
		if(MAIL_USE_SMTP=="yes")
		{
			$m->smtp_on(MAIL_SERVER, MAIL_USER_NAME, MAIL_PASSWORD ) ;    
		}
		$m->Send(); 				
	 	echo "You password has been reseted and sent to your email ";
	 }

}

function desc_func () { return "Restoring password"; }

?>
