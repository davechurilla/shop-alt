<?php if(!isset($RUN)) { exit(); } ?>
<?php
require "lib/libmail.php";

access::allow("1");

if(isset($_POST['ajax']))
{
		$m= new Mail; 
		$m->From(MAIL_FROM); 
		$m->To( trim($_POST["email"]) );
		$m->Subject("test");
		$m->Body("test from ".WEB_SITE_URL);    	 	
		$m->Priority(3) ;   	
		if(MAIL_USE_SMTP=="yes")
		{
			$m->smtp_on(MAIL_SERVER, MAIL_USER_NAME, MAIL_PASSWORD ) ;    
		}
		$m->Send(); 
}

function desc_func() 
{
	return TEST_MAIL;
}

?>
