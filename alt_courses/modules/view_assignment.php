<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

 require "grid.php";
 require_once "db/asg_db.php";
 require "lib/cmail.php";
 require "lib/libmail.php";

 $asg_id=util::GetKeyID("asg_id", "?module=assignments");

 $asg_res = asgDB::GetAsgById($asg_id);

 if(db::num_rows($asg_res)==0)
 {
     die(ASG_CANNOT_BE_FOUND);
 }

 $row=db::fetch($asg_res);

 $cat_name=$row['cat_name'];
 $test_name=$row['quiz_name'];
 $quiz_type=$row['quiz_type']=="1" ? O_QUIZ : O_SURVEY;
 
 $questions_order=$row['qst_order']=="1" ? BY_PRIORITY : RANDOM;
 $answer_order=$row['answer_order']=="1" ? BY_PRIORITY : RANDOM;
 $review_answers=$row['allow_review']=="1" ? O_YES : O_NO;
 
 $show_results=$row['show_results']=="1" ? O_YES : O_NO;
 $results_by=$row['results_mode'] == "1" ? O_POINT : O_PERCENT;
 $asg_how_many=$row['limited'];
 $asg_affect_change=$row['affect_changes'] == "1" ? AFFECT : DONT_AFFECT;
 $asg_send_results=$row['send_results'] == "2" ? ASG_SEND_MAN : ASG_SEND_AUTO;
 $accept_new=$row['accept_new_users'] == "2" ? O_NO : O_YES;
 $pass_score=$row['pass_score'];
 $test_time=$row['quiz_time'];

 $srv_display = "";
 if($row['quiz_type']=="2") $srv_display ="none";


 $chk_all_html = "<input type=checkbox name=chkAll2 onclick='grd_select_all(document.getElementById(\"form1\"),\"chklcl\",\"this.checked\")'>";
 $hedaers = array($chk_all_html,USER_ID, LOGIN, USER_NAME, USER_SURNAME ,STATUS, START_SENT,RESULTS_SENT ,SUCCESS, TOTAL_POINT,"&nbsp;");
 $columns = array("user_id"=>"text","UserName"=>"text", "Name"=>"text","Surname"=>"text","status_name"=>"text","start_sent"=>"text","results_sent"=>"text","is_success"=>"text","total_point"=>"text");

 $grd = new grid($hedaers,$columns, "index.php?module=view_assginments");
 $grd->edit=false;
 $grd->delete=false;

 $grd->id_links=(array(DETAILS=>"?module=view_details"));
 $grd->id_link_key="user_quiz_id";
 $grd->id_column="user_quiz_id";
 $grd->checkbox=true;
$grd->chk_class="chklcl";
 $grd->column_override=array("is_success"=>"success_override","status_name"=>"status_override","start_sent"=>"start_override", "results_sent"=>"results_override");

 $i = -1;
 function success_override($row)
 {
     global $YES_NO,$i;
     $i++; 
     return $YES_NO[$row['is_success']]."<input type=hidden id=hdnuq$i value='".$row['user_quiz_id']."'><input type=hidden id=hdn$i value=".$row['user_id']." />";
 }


 function status_override($row)
 {
     global $ASG_STATUS;
     return $ASG_STATUS[$row['status_id']];
 }

 function start_override($row)
 {
	global $SENT;
 	$key = $row['start_sent'] == "" ? "no" : "yes";
	return "<span id=lbl".$row['user_id'].">".$SENT[$key]."</span>";
 }

 function results_override($row)
 {
	global $SENT;
 	$key = $row['results_sent'] == "" ? "no" : "yes";
	return "<span id=lblres".$row['user_id'].$row['user_quiz_id'].">".$SENT[$key]."</span>";
 }


 $query = asgDB::GetUserResultsQuery($asg_id, 1);
 $grd->DrowTable($query);
 $grid_lu_html = $grd->table;

 $chk_all_html = "<input type=checkbox name=chkAll2 onclick='grd_select_all(document.getElementById(\"form1\"),\"chkimp\",\"this.checked\")'>";
 $hedaers = array($chk_all_html,USER_ID, LOGIN, USER_NAME, USER_SURNAME ,STATUS, START_SENT,RESULTS_SENT ,SUCCESS, TOTAL_POINT,"&nbsp;");
  
 $grd_iu = new grid($hedaers,$columns, "index.php?module=view_assginments");
 $grd_iu->edit=false;
 $grd_iu->delete=false;

 $grd_iu->id_links=(array(DETAILS=>"?module=view_details"));
 $grd_iu->id_link_key="user_quiz_id";
 $grd_iu->id_column="user_quiz_id";
 $grd_iu->checkbox=true;
 $grd_iu->chk_class="chkimp";
 $grd_iu->column_override=array("is_success"=>"iu_success_override","status_name"=>"iu_status_override","start_sent"=>"start_override", "results_sent"=>"results_override");


 $y = -1;
 function iu_success_override($row)
 {
     global $YES_NO,$y;
     $y++;
     return $YES_NO[$row['is_success']]."<input type=hidden id=hdnuqi$y value='".$row['user_quiz_id']."'><input type=hidden id=hdnI$y value=".$row['user_id']." />";;
 }
  

 function iu_status_override($row)
 {
     global $ASG_STATUS;
     return $ASG_STATUS[$row['status_id']];
 }

 $query = asgDB::GetUserResultsQuery($asg_id, 2);
 $grd_iu->DrowTable($query);
 $grid_iu_html = $grd_iu->table;


 if(isset($_POST['ajax']))
 {
	if(isset($_POST['send_mail']))
	{
		global  $asg_id;
		$user_id = $_POST['user_id'];
		$msg_type = $_POST['msgtype'] ;
		$user_type = $_POST['user_type'] ;
		$user_quiz_id = $_POST['user_quiz_id'] ;
		$array_where =  array("user_id"=>$user_id,"assignment_id"=>$asg_id,"user_type"=>$user_type , "mail_type"=>$msg_type) ;
		if($msg_type=="2") 
		$array_where =  array("user_id"=>$user_id,"assignment_id"=>$asg_id,"user_type"=>$user_type , "mail_type"=>$msg_type,"user_quiz_id"=>$user_quiz_id) ;

		$results = orm::Select("mailed_users", array() ,$array_where, "");
		$count = db::num_rows($results);	
		if($count == 0 )
		{			
			SendMail($user_id);
		}
	}
	
	
 }

 function SendMail($user_id)
 {
	global  $asg_id,$msg_type,$user_type,$user_quiz_id;
	$results = asgDB::GetUserInfoByAsgId($asg_id,$user_id,$user_type,$user_quiz_id);
	$row = db::fetch($results);

	if($msg_type=="1") $temp = "quiz_start_message";
	else 
	{
		if($row['success']==1)  $temp = 'quiz_results_success'; 
		else if($row['success']==0) $temp = 'quiz_results_not_success';
		else return ;
	}

	$cmail = new cmail($temp, $row);

	$subject = str_replace("[url]", WEB_SITE_URL, $cmail->subject);	
	$subject = str_replace("[quiz_name]", $row['quiz_name'], $subject);

	$body = str_replace("[url]", WEB_SITE_URL, $cmail->body);	
	$body = str_replace("[quiz_name]", $row['quiz_name'], $body);

	if($msg_type==2)
	{
		$subject = str_replace("[start_date]", $row['added_date'], $subject);	
		$subject = str_replace("[finish_date]", $row['finish_date'], $subject);
		$subject = str_replace("[user_score]", $row['results_mode']==1 ? $row['pass_score_point'] : $row['pass_score_perc']."%" , $subject);
		$subject = str_replace("[pass_scpre]", $row['pass_score'], $subject);

		$body = str_replace("[start_date]", $row['added_date'], $body);	
		$body = str_replace("[finish_date]", $row['finish_date'], $body);
		$body = str_replace("[user_score]", $row['results_mode']==1 ? $row['pass_score_point'] : $row['pass_score_perc']."%" , $body);
		$body = str_replace("[pass_scpre]", $row['pass_score'], $body);
	}

	$m= new Mail; 
	$m->From(MAIL_FROM ); 

	$m->To( trim($row['email']));
	$m->Subject( $subject );
	$m->Body( $body);    	
	$m->Priority(3) ;    
	//$m->Attach( "asd.gif","", "image/gif" ) ;
	
	if(MAIL_USE_SMTP=="yes")
	{
		$m->smtp_on(MAIL_SERVER, MAIL_USER_NAME, MAIL_PASSWORD ) ;    
	}
	$m->Send(); 


	$array_insert = array("user_id"=>$user_id, "user_type"=>$user_type , "assignment_id"=>$asg_id, "mail_type"=>$msg_type);

	if($msg_type=="2")
	{
	$array_insert = array("user_id"=>$user_id, "user_type"=>$user_type , "assignment_id"=>$asg_id, "mail_type"=>$msg_type,"user_quiz_id"=>$user_quiz_id);
	}

	orm::Insert("mailed_users", $array_insert);
	
	//echo $temp;
 }


 function desc_func()
 {
        return VIEW_ASSIGNMENT;
 }

?>
