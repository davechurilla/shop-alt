<?php if(!isset($RUN)) { exit(); } ?>
<?php

 access::allow("2");

 require "grid.php";
 require "db/users_db.php";
 //require_once "db/asg_db.php";

    $hedaers = array(QUIZ_NAME,"&nbsp;");
    $columns = array("quiz_name"=>"text");

    $grd = new grid($hedaers,$columns, "index.php?module=active_assignments");

    $grd->process_html_command="process_quiz_status";

    function process_quiz_status($row)
    {
    $html ="";      
	$status = intval($row['user_quiz_status']);  
    // $success = intval($row['success']);

    $added_date = $row[5];

    $expired_date = date(strtotime("+6 months", strtotime($added_date)));
    $date = new DateTime();
    $newdate = $date->format('Y-m-d H:i:s');
    $newdate = strtotime($newdate);

    $diff = round($expired_date - $newdate);

    if($diff <= 0) {
        $html.="<td align=center>".ALREADY_FINISHED."</td>";
    }

	elseif(intval($row['limited'])<=intval($row['uq_count']))
	{
        	if($status<2)
        	{
			$status == 0 ? $text = START : $text = CCONTINUE;
            		$html.="<td width='50%' align=center><a href='?module=show_intro&id=".$row['asg_id']."'>".$text."</a></td>";
       		}
        	else
        	{
            		$html.="<td align=center>".ALREADY_FINISHED."</td>";
        	}
	}
	else 
	{
		if($status<2)
        	{
			$status == 0 ? $text = START : $text = CCONTINUE;
            		$html.="<td width='50%' align=center><a href='?module=show_intro&id=".$row['asg_id']."'>".$text."</a></td>";
       		}
        	else
        	{
            		$html.="<td width='50%' align=center><a href='?module=show_intro&id=".$row['asg_id']."'>".TAKE_AGAIN."</a></td>";
        	}
	}
        return $html;
    }

    //$grd->edit_link="index.php?module=add_edit_quiz";

    //$grd->id_links=(array("Start"=>"?module=show_intro"));
    //$grd->id_link_checks = array("");
    $grd->id_column="asg_id";

    $grd->edit=false;
    $grd->delete=false;
    $grd->empty_data_text=NO_ACTIVE_ASG;

    $user_id = $_SESSION['user_id'];
    $query = asgDB::GetActAsgByUserIDQuery($user_id);
    
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return ACTIVE_ASSIGNMENTS;
    }

?>
