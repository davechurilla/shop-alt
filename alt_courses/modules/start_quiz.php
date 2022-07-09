<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("2");

 require "grid.php";
 require "db/questions_db.php";
 require_once "db/asg_db.php";
 include "lib/libmail.php";
 require "lib/cmail.php";
 require "qst_viewer.php";

 $app_display = "";
 $msg_display = "none";
 $timer_display ="";
 $msg_text = "";
 $qst_html ="";
 $timer_script = "";
 $timer_display = "none";
 $pager_html="";
 $pager_display="";

 $emulate_goto=true;
 while($emulate_goto==true) { // emulating goto operator 

 $user_id = $_SESSION['user_id'];
 $asg_id = util::GetID("?module=active_assignments");
 $_SESSION['asg_id']=$asg_id;

 $active_asg = asgDB::GetActAsgByUserID($user_id, $asg_id);
 $asg_num = db::num_rows($active_asg);
 if($asg_num==0)
 {
     DisplayMsg("error",QUIZ_NO_ACCESS,false);
     break;
 }

 $asg_row = db::fetch($active_asg);
 $status = intval($asg_row['user_quiz_status']);
 $user_quiz_id = $asg_row['user_quiz_id'];
 $allow_review = $asg_row['allow_review'];
 $send_results = $asg_row['send_results'];
 $_SESSION['user_quiz_id']=$user_quiz_id;
 $quiz_type = $asg_row['quiz_type'];

 if($status==0)
 {
     $date = util::Now();
     $user_quiz_id=db::exec_insert(orm::GetInsertQuery("user_quizzes", array("assignment_id"=>$asg_id,
                                                            "user_id"=>$user_id,
                                                            "status"=>"1",
                                                            "added_date"=>$date,
                                                            "success"=>"0"
                                                       )));     
 }
 else if($status>=2)
 {     
    DisplayMsg("error",ALREADY_FINISHED,false);
    break;
 }

 if($quiz_type=="1") // if survey
 {
    $timer_display= "";
    $ended=ShowTimer($status,$asg_row);
    if($ended==true) break;
 }

 $page = "?module=start_quiz&id=".$asg_id ;
 $qst_viewer = new qst_viewer($page);
 $qst_viewer->user_quiz_id=$user_quiz_id;
 $priority = $qst_viewer->GetPriority(); 

 if(isset($_POST['btnNext']))
 {
     UpdateValues();
     if($_POST['finish_quiz']=="1") break;
     $priority =$qst_viewer->GetNextPriority();     
 }
 if(isset($_POST['btnPrev']))
 {
    $priority =$qst_viewer->GetPrevPriority();
 }

 if(isset($_POST['load_question']))
 {
    $priority = $_POST['load_priority'];    
 }

 $qst_query = questions_db::GetQuestionsByPriority($priority, $asg_id, $user_id , $asg_row['qst_order'],$asg_row['quiz_id']);

 $row_qst = db::fetch(db::exec_sql($qst_query));

 //echo $qst_query;

 if($priority==1)
 {
     $qst_viewer->show_prev=false;
 }
 else if($row_qst['next_priority']==-1)
 {
     $qst_viewer->show_next=false;
     $qst_viewer->show_finish=true;
 }
 //echo $qst_query; 
 $qst_viewer->ans_priority=$asg_row['answer_order'];
 $qst_viewer->BuildQuestionWithResultset($row_qst);
 $qst_html = $qst_viewer->html;
 

// $row_num = db::num_rows($qst_results);

// if($row_num==0)
 //{
//    DisplayError("You don't have access to this quiz/survey");
 //}
 
 $pager_html = GetPager();

 if(isset($_POST['data_post']))
 {
    echo $qst_html."[{sep}]".$pager_html;
 }

 $emulate_goto =false;

 }


 function UpdateValues()
 {
    global $user_quiz_id, $success;
    
    $db = new db();
    $db->connect();
    $db->begin();

    try
    {
     $db->query(orm::GetDeleteQuery("user_answers", array("user_quiz_id"=>$user_quiz_id , "question_id"=>intval($_POST['qstID']))));
     $date = date('Y-m-d H:i:s');
     switch ($_POST['qst_type']) {

         case 0 : // if checkbox
             $chks = explode(";|",$_POST['post_data']);
             for($i=0;$i<sizeof($chks);$i++)
             {
                 $chk_value=trim($chks[$i]);
                 if($chk_value=="") continue;

                 $chk_value = intval($chk_value);
                 $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$chk_value,
                                                                    "user_answer_id"=>$chk_value,
                                                                    "added_date"=>$date
                                                              ));
                 $db->query($query);
             }
         break;
         case 1 : //if radio button
                 $chk_value=trim($_POST['post_data']);
                 if($chk_value!="")
                 {
                    $chk_value = intval($chk_value);
                    $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$chk_value,
                                                                    "user_answer_id"=>$chk_value,
                                                                    "added_date"=>$date
                                                             ));
                    $db->query($query);
                 }
         break ;
         case 3 : // if free text area
                 $free_vals = explode(";|",$_POST['post_data']);
                 $answer_id=$free_vals[0];
                 $answer_text=$free_vals[1];
                 //if($chk_value!="")
                 //{                    
                    $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$answer_id,
                                                                    "user_answer_text"=>$answer_text,
                                                                    "added_date"=>$date
                                                             ));
                    $db->query($query);
                // }
        break ;
        case 4 : // if muti text
             $txts = explode(";|",$_POST['post_data']);
             for($i=0;$i<sizeof($txts);$i++)
             {
                 $txt_key_value=trim($txts[$i]);                 
                 if($txt_key_value=="") continue;

                 $txt_exp=explode(":|",$txt_key_value);
                 $txt_key = intval($txt_exp[0]);
                 $txt_value = $txt_exp[1];
                 
                 if(trim($txt_key)=="" || trim($txt_value)=="") continue ;

                 $query = orm::GetInsertQuery("user_answers", array("user_quiz_id"=>$user_quiz_id,
                                                                    "question_id"=>intval($_POST["qstID"]),
                                                                    "answer_id"=>$txt_key,
                                                                    "user_answer_text"=>$txt_value,
                                                                    "added_date"=>$date
                                                              ));
                 $db->query($query);
             }
         
         break;

     }

     $db->commit();

     if($_POST['finish_quiz']=="1")
     {                  
      global $fdate,$send_results;
      $fdate = util::Now();
          $row=asgDB::UpdateUserQuiz($user_quiz_id,2,$fdate);
          $msg = GetQuizResults($row);
          DisplayMsg("warning",$msg,true);
      if($send_results == "1" && $success) SendMail($row);
     }     

     $db->commit();

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
        $db->rollback();
    }
    $db->close_connection();
    
 }



 function GetQuizResults($row)
 {
    global $quiz_type,$user_quiz_id,$allow_review,$success,$asg_row;
    
    $msg = QUIZ_FINISHED.". <br>";
    // if($row['show_results']=="1" && $quiz_type=="1")
    // {
        //$total = $row['total_point'];
        $total = round($row['total_perc'])." %";        

        $msg.=YOUR_TOTAL_POINT.": $total. ";
        //.SUCCESS_POINT.": ".$row['pass_score']." ."
        $msg.="<br>";           

        if($row['quiz_success']=="1")
        {
            $msg.=EXAM_SUCCESS;     
        $success = true;
        }
        else
        {
            $msg.=EXAM_UNSUCCESS;
            $msg.="<br><br><a href='?module=active_assignments' target='_blank'><div class='buttons-take-exam-again' style='display:inline-block;''></div></a>";
        $success =false;
        }
    // }    
    if($allow_review=="1")
    {
        $msg.="<br><br><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\"><tr><td><a href='?module=view_details&user_quiz_id=".$user_quiz_id."' target='_blank'><div class='buttons-view-details' style='display:inline-block;''></div></a></td>";
    }
        if($success)
    {
        $_SESSION['quiz_name'] = $asg_row['quiz_name'];
        $_SESSION['intro_text'] = $asg_row['intro_text'];
        
        $quiz_name = $asg_row['quiz_name'];
        $intro_text = $asg_row['intro_text'];   
        //$finish_date = strtotime($fdate)->format('F j, Y');
        //$finish_date = $fdate);
        $df = new DateTime($fdate);
        $finish_date = $df->format('F j, Y');
        //$finish_date = date("F j, Y", $fdate);
        $msg.="<td><a href='modules/certificate.php?quiz_name=".$quiz_name."&intro_text=".$intro_text."' target='_blank'><div class='buttons-print-cert' style='display:inline-block;''></div></a></td>";
        $msg.="<td><a href='modules/ce_letter.php?quiz_name=".$quiz_name."&finish_date=".$finish_date."' target='_blank'><div class='buttons-print-letter' style='display:inline-block;''></div></a></td></tr></table>";
        $msg.="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"1000\" style=\"padding-top: 35px;\"> <tbody> <tr> <td align=\"left\" height=\"30\" valign=\"top\" colspan=\"5\"><span class=\"titleName\">RECOMMENDED PRODUCTS</span></td> </tr> <tr> <td align=\"left\" valign=\"top\" width=\"200\"><div style=\"padding-top: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/index.php?cPath=3\" target=\"_blank\"><img src=\"http://shop.advancedlasertraining.com/images/Patient_Brochures_Set_sm.jpg\" alt=\"Six Brochure Set Package\" width=\"165\" height=\"110\"></a></div> <div style=\"padding-top: 15px;padding-bottom: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/index.php?cPath=3\" target=\"_blank\">Laser Patient Brochures<br> Pkgs of 50 — Buy 4 sets get the 5th one free<br> <span class=\"small\">MORE INFO &gt;&gt;</span></a></div> </td> <td align=\"left\" valign=\"top\" width=\"200\"><div style=\"padding-top: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?products_id=107\" target=\"_blank\"><img alt=\"Diode Soft Tissue Laser DVD\" src=\"http://shop.advancedlasertraining.com/images/prod_acc_diodeDVD.jpg\"></a></div> <div style=\"padding-top: 15px;padding-bottom: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?products_id=107\" target=\"_blank\">Diode Soft Tissue Laser DVD<br> Special Offer<br> <span class=\"small\">MORE INFO &gt;&gt;</span></a></div> </td> <td align=\"left\" valign=\"top\" width=\"200\"><div style=\"padding-top: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=108\" target=\"_blank\"><img src=\"http://shop.advancedlasertraining.com/images/prod_loupe_filters.jpg\" alt=\"Laser Loupe Filters\"></a></div> <div style=\"padding-top: 15px;padding-bottom: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=108\" target=\"_blank\">Laser Loupe Filters<br> <span class=\"small\">MORE INFO &gt;&gt;</span></a></div> </td> <td align=\"left\" valign=\"top\" width=\"200\"><div style=\"padding-top: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=114\" target=\"_blank\"><img alt=\"Fiber Stripper\" src=\"http://shop.advancedlasertraining.com/images/cleaver_square_sm.jpg\"></a></div> <div style=\"padding-top: 15px;padding-bottom: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=114\" target=\"_blank\">Laser Fiber Cleaver<br> <span class=\"small\">MORE INFO &gt;&gt;</span></a></div> </td> <td align=\"left\" valign=\"top\" width=\"200\"><div style=\"padding-top: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=115\" target=\"_blank\"><img alt=\"Fiber Stripper\" src=\"http://shop.advancedlasertraining.com/images/initiation_stripe_sm.jpg\"></a></div> <div style=\"padding-top: 15px;padding-bottom: 10px;\"> <a href=\"http://shop.advancedlasertraining.com/product_info.php?cPath=2&amp;products_id=115\" target=\"_blank\">Laser Initiation Film<br><span class=\"small\">MORE INFO &gt;&gt;</span></a></div> </td> </tr> </tbody> </table>";        
        $msg.="<br><br><a href='http://www.advancedlasertraining.com' target='_blank'>Learn more about additional training</a>";
        
        $asg_id = $_SESSION['asg_id'];
        asgDB::ChangeLimited("0", $asg_id); 
    }
    return $msg;
 }

 function SendMail($row)
 {
    global $success,$user_id,$asg_row,$user_quiz_id;

//  $results = orm::Select("user_quizzes", array() , array("id"=>$user_quiz_id), "");
//  $row = db::fetch($results);
    
    $temp = "quiz_results_success";
    if(!$success) $temp = "quiz_results_not_success";
    $cmail = new cmail($temp,"");

    $subject = $cmail->subject;
    $body = $cmail->body;

    $subject = ReplaceVars($subject, $asg_row , $row);
    $body = ReplaceVars($body, $asg_row , $row);

    try
    {
    $m= new Mail; 
    $m->From(MAIL_FROM ); 
    $m->To( trim($_SESSION['email']) );
    $m->Subject( $subject);
    $m->Body( $body);  
    $m->Cc( 'mowens@advancedlasertraining.com' );     
    $m->Priority(3) ;    
    //$m->Attach( "asd.gif","", "image/gif" ) ;

    if(MAIL_USE_SMTP=="yes")
    {
        $m->smtp_on(MAIL_SERVER, MAIL_USER_NAME, MAIL_PASSWORD ) ;    
    }
    $m->Send(); 

    }
    catch(Exception $e)
    {
    //    echo $e->getMessage();
    //    $db->rollback();
    }
    
 }

 function ReplaceVars($var,$asg_row,$row)
 {
    global $fdate;
    $var = str_replace("[quiz_name]", $asg_row['quiz_name'],$var);
    $var = str_replace("[start_date]", $asg_row['uq_added_date'],$var);
    $var = str_replace("[finish_date]", $fdate,$var);
    $var = str_replace("[pass_score]", $row['pass_score'],$var);
    $var = str_replace("[user_score]", $row['results_mode']=="1" ? $row['total_point'] : $row['total_point']." %" ,$var);
    $var = str_replace("[UserName]", $_SESSION['txtLogin'],$var);
    $var = str_replace("[Name]", $_SESSION['name'],$var);
    $var = str_replace("[Surname]", $_SESSION['surname'],$var);
    $var = str_replace("[email]", $_SESSION['email'],$var);
    $var = str_replace("[url]", WEB_SITE_URL,$var);
    return $var;
 }

 function DisplayMsg($type,$msg,$isajax)
 {
     if(isset($_POST['ajax'])) $isajax=true;
     
     if($isajax==true)
     {
        if($type=="error")
        {
            echo "error:".$msg;
        }
        else if($type=="warning")
        {
             echo "warni:".$msg;
        }
        else
        {
             echo $msg;
        }
     }
     else
     {
        global $app_display,$msg_display,$msg_text,$timer_display,$pager_display;
        $app_display="none";
        $msg_display = "";
        $msg_text=$msg;
        $timer_display="none";
        $pager_display="none";
     }

    // echo $msg;

 }

 function ShowTimer($status,$row)
 {
     $ended = false;
     $start_date =$row['uq_added_date'];
     if($status=="0") $start_date = util::Now();

     $diff = abs(strtotime(util::Now()) - strtotime($start_date));

     $total_minutes = intval($diff/60);

     $minuets = intval($row['quiz_time']) - $total_minutes -1;
     $seconds = 60-($diff%60);

     // if($total_minutes>=intval($row['quiz_time']))
     // {
     //    global $user_quiz_id;
     //    $row_results=asgDB::UpdateUserQuiz($user_quiz_id,3,util::Now());
     //    $msg=TIME_ENDED." <br>";
     //    $msg.=GetQuizResults($row_results);        
     //    DisplayMsg("message",$msg,false);
     //    $ended=true;
     // }
     // else
     // {      
     //     global $timer_script;
     //     $timer_script="<script language=javascript>Init_Timer($minuets,$seconds)</script>";
     // }
     // return $ended;

 }

 function GetPager()
 {
      global $priority,$asg_id,$page,$asg_row,$user_id;
      $res_qst=db::exec_sql(questions_db::GetQuestionsByAsgIdQuery($asg_id,$asg_row['quiz_id'], $user_id,$asg_row['qst_order']));
      if(db::num_rows($res_qst)==0) return "";
      $i=0;
      $pager_html = "";
      $finish = 0;
      while($row=db::fetch($res_qst))
      {          
                  $i++;
                  $bgcolor="white";
                  if($priority==$row['priority'])
                  {
                     $bgcolor = "silver";
                  }
                 $pager_html.= "<u><a style='cursor:pointer;background-color:$bgcolor' onmouseout='HideObject(\"tblTip\")' ".
                               " onmouseover='ShowQst(event.pageX, event.pageY ,".$row['priority'].", ".$asg_row['qst_order'].", ".$asg_row['quiz_id'].", ".$asg_row['answer_order'].")' onclick='LoadQst(\"$page\",$row[question_type_id],$row[priority],$row[id],$finish)'>".$i."</a></u>&nbsp;";
      }

      return $pager_html."&nbsp;&nbsp;";
 }

 function desc_func()
 {
        return QUIZ_SURV;
 }

?>
