<?php if(!isset($RUN)) { exit(); } ?>
<?php 

 if(REGISTRATION_ENABLED!="yes") exit();

require_once "db/asg_db.php";

if(!isset($_GET['g']))
{
	header("location:login.php");
}

$guid = trim($_GET['g']);

$results = orm::Select("users",array(), array("random_str"=>$guid), "");
$count = db::num_rows($results);
if($count >0 ) 
{
	$row = db::fetch($results);
	if($row['approved']=="0")
	{
		orm::Update("users", array("approved"=>1), array("random_str"=>$guid));
		asgDB::AcceptNewUser($row["UserID"]);
		$msg = R_REG_APPROVED." ".R_GO_TO." <a href='login.php'>".R_LOGIN_PAGE."</a>";
	} else $msg = R_REG_ALREADY_APPROVED." ".R_GO_TO." <a href='login.php'>".R_LOGIN_PAGE."</a>";
}
else $msg = R_URL_WRONG;


function desc_func () { return R_APPROVE_REG; }

?>
