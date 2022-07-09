<?php if(!isset($RUN)) { exit(); } ?>
<?php

 access::allow("2");

 // require "grid.php";
 require "db/users_db.php";
 // require_once "db/asg_db.php";

    $val = new validations("btnSave");
    $val->AddValidator("drpUserType", "notequal", USER_TYPE_VAL , "-1");

    $selected="-1";
    $mode="edit";
    $user_id=$_SESSION["user_id"];
    $user_email=$_SESSION["email"];

    $user_type_options = webcontrols::BuildOptions($USER_TITLE, $selected);

    if(isset($_POST["btnSave"]) /*&& $val->IsValid()*/)
    {
        if($_SESSION["user_id"])  {
        // {
            $user_type_selected=trim($_POST["drpUserType"]);
            $user_type_text=$USER_TITLE[$user_type_selected];
            $arr_columns["customers_title"]=$user_type_text;

            if($user_type_selected != 0)
            {
                orm::Update("v_imported_users", $arr_columns, array("UserID"=>$user_id));
                orm::Update("customers", $arr_columns, array("customers_email_address"=>$user_email));
            } else {
                echo 'Please select a title from the drop-down menu';
            }
        }

        header("location:?module=active_assignments");
    }

?>