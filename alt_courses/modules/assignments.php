<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "extgrid.php";
    require_once "db/asg_db.php";
    //require_once "db/users_db.php";

    // $hedaers = array(QUIZ_NAME, ADDED_DATE, "&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
    // $columns = array("quiz_name"=>"text", "added_date"=>"short date");

    $hedaers = array(QUIZ_NAME, ADDED_DATE, "ALT Login Email", "&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
    $columns = array("quiz_name"=>"text", "added_date"=>"short date", "UserName"=>"text");    

    $grd = new extgrid($hedaers,$columns, "index.php?module=assignments");
    $grd->edit_link="index.php?module=add_assignment";

    $grd->column_override=array("UserName"=>"UserName_override");

    $grd->commands=array(START=>"start");
    $grd->process_command_override="grd_process_command_override";
    //$grd->edit_attr_override = "grd_ovverride_edit_attr";
    $grd->edit_link_override = "grd_ovverride_edit_link";
    $grd->retrieve_user_login =  "grd_retrieve_user_login";

    $grd->id_links=(array(INFORMATION=>"?module=view_assignment", REPORTS=>"?module=reports_chart"));
   // $grd->id_links=(array("Information"=>"?module=view_assignment"));
    $grd->id_link_key="asg_id";    


    if($grd->IsClickedBtnDelete())
    {
	asgDB::DeleteRelatedQuiz($grd->process_id);  
        asgDB::DeleteAsgById($grd->process_id);        
    }

    if($grd->IsClickedBtn("start"))
    {
        asgDB::ChangeStat("1", $grd->process_id);
    }

    if($grd->IsClickedBtn("stop"))
    {
        asgDB::ChangeStat("2", $grd->process_id);

        $res_uq = db::exec_sql(orm::GetSelectQuery("user_quizzes", array(), array("assignment_id"=>$grd->process_id, "status"=>"1"), ""));

        while($row_uq=db::fetch($res_uq))
        {
	    $date = date('Y-m-d H:i:s');
            asgDB::UpdateUserQuiz($row_uq['id'], "4", $date);
        }

    }

    function grd_ovverride_edit_link($row)
    {
        //echo $row['id'] ;
        global $grd;
        if(intval($row['status'])>0)
        {
            return "&nbsp;";
        }
        else
        {
            return extgrid::EditCommandTemplate($row, $grd);
        }
    }

        function grd_retrieve_user_login($row)
        {
            global $grd;
            $asgId = $row['id'] ;
            return "<td>" . $asgId . "</td>";
        }    


  
function UserName_override($row)
{
 // here you have all columns in $row[]; do what ever you want . this function will be bind each time when grid will drow the row
    global $grd;
    $asg_id = $row["id"];

        $res=orm::Select("assignment_users", array(), array("assignment_id"=>$asg_id), "");        
            $row_uid = db::fetch($res);
            $uid = $row_uid['user_id'];
            $utype = $row_uid['user_type'];

        if($utype == 2) {
        $res_login=orm::Select("v_imported_users", array(), array("UserID"=>$uid), ""); 
            $row_login = db::fetch($res_login);
            $ulogin = $row_login['UserName'];
        } else {
            $ulogin = "Not an ALT customer";
        }

       return $ulogin;     
}
   
   

  //  function grd_ovverride_edit_attr($row)
  //  {
  //     if(intval($row['status'])>0)
  //      {
  //          return "onclick='return alert(\"Cannot edit assignment , because quiz/survey already started\")';return false;";
  //      }
  //  }

    function grd_process_command_override($row)
    {
        global $grd;
        if($row['status']==0)
        {
            return extgrid::ProcessCommandTemplate($row, "start", START,$grd);
        }
        else if($row['status']==1)
        {
            return extgrid::ProcessCommandTemplate($row, "stop", STOP, $grd);
        }
        else 
        {
            return "<td>&nbsp;</td>";
        }
    }

    $query = asgDB::GetAsgQuery();    

    $grd->DrowTable($query);
    $grid_html = $grd->table;

//    $search_html = $grd->DrowSearch(array(QUIZ_NAME),array("quiz_name"));

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return ASSIGNMENTS;
    }

?>
