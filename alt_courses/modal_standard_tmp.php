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

            $user_type_selected=trim($_POST["drpUserType"]);
            $user_type_text=$USER_TITLE[$user_type_selected];
            $arr_columns["customers_title"]=$user_type_text;

            if($user_type_selected != 0)
            {
                orm::Update("v_imported_users", $arr_columns, array("UserID"=>$user_id));
                orm::Update("customers", $arr_columns, array("customers_email_address"=>$user_email));
                $_SESSION['customers_title'] = $user_type_text; 

            } else {
                echo 'Please select a title from the drop-down menu';
            }
        }
    }

?>
<HTML>
    <HEAD>
		<META http-equiv="content-type" content="text/html; charset=utf-8">
                <title>Online Courses and Exams - Advanced Laser Training</title>     
                <script language ="javascript" src="extgrid.js"></script>

                <!-- Add jQuery library -->
                <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>          
                <script src="cms.js" type="text/javascript"></script>

                 <script language="javascript">

                 window.onscroll = function()
                 {
                    MoveLoadingMessage("loadingDiv");
                 }

                 jQuery.ajaxSetup({
                    beforeSend: function() {            
                    $('#loadingDiv').show()
                 },
                    complete: function(){
                    $('#loadingDiv').hide()
                 },
                    success: function() {}
                 });
                 
                </script>  
  
                <style type="text/css">
                    #menu, .c_menu_td, .right, .buttons-logout {display: none !important;}    
                    .lightwindow_title_bar_close_link {visibility: hidden !important;}
                    #header {min-width:0 !important;}
                    .module_row {height:auto !important;}
                </style>                

    </HEAD>
    <link href="style/index.css" type="text/css" rel="stylesheet" />
    <link href="style/grid.css" type="text/css" rel="stylesheet" />
    <BODY bgcolor="#ffffff" id="standard">

              <table style="display:none" id="loadingDiv" style="position: absolute; left: 10px; top: 10px">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td bgcolor="red">
                                        <font color="white" size="3"><b>&nbsp;<?php echo PLEASE_WAIT ?>&nbsp;</b></font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>

        <script language="javascript">
        </script>

         <table width="100%" cellpadding="0" cellspacing="0" border="0">
           <tr valign="middle">
                <td colspan="3">
                <div id="header">
                <img src="/images/main_header_logo_left.gif" class="left">
                <img src="/images/main_header_logo_right.gif" class="right">
                </div>                    
                </td>
            </tr>
            <tr>
                <td class="c_menu_td" bgcolor="white" valign="top" style="width:170px">
					
					<br>
                                        <table width="100%" >
                                            
                                                    <?php
					if($expand == true) {
                                                        for($z=0;$z<sizeof($main_modules);$z++)
                                                        {
                                                            ?>
                                                            <tr>                                                                
                                                                <td>                                                                                                                                       
                                                                      <label id="ctlmenuname" class="menu_header_name"><?php echo $MODULES[$main_modules[$z]['module_name']] ?></label>
                                                                      <table cellpadding="0" cellspacing="0" border="0" style="background: url('i/ln.gif') repeat-x;
                                                                       height: 1px; width: 75%; margin-top: 10px; margin-bottom: 5px;">
                                                                            <tr>
                                                                            <td>
                                                                            </td>
                                                                            </tr>
                                                                      </table>                           
                                                                     
                                                                            <table class="class1" cellspacing="0" cellpadding="3" Border="0" border="0" style="width:100%;border-collapse:collapse;">
                                                                                <?php for($y=0;$y<sizeof($child_modules[$main_modules[$z]['id']]);$y++) {  ?>
                                                                                <tr>
                                                                                    <td>
                                                                                         <?php 
                                                                                            $file_name = $child_modules[$main_modules[$z]['id']][$y]["file_name"];
                                                                                            echo "<a class=\"menu_child_name\" href='index.php?module=$file_name'>".$MODULES[$child_modules[$main_modules[$z]['id']][$y]["module_name"]]."</a>";
                                                                                         ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php } ?>
                                                                            </table>
                                                                      <br>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
							}
                                                    ?>
                                                
                                        </table>
					
                </td>
                <td width="15px"></td>
                <td  align="center" valign="top" bgcolor="#F4F5F7" >
                          <table width="95%" cellpadding="0" cellspacing="0" border="0" style="margin-top:10px;">
				<tr>
					<td>
						<table>	
							<tr>	
								
								<td></td>
							</tr>	
						</table>

						<div id="menu">
						<?php 

                        if(SHOW_MENU=="all" || (SHOW_MENU=="registered" && $autorized==true)) {
                        echo "<p class='headingName'><span class='titleName'>Courses:</span></p><ul>"; 
						while($row = db::fetch($menus)) {
						
                            if ($user_type == "2" && in_array($row['priority'], $asg_ids)) {
    						echo "<li><a href='?module=show_page&id=".$row['id']."'><font color='#18A0FF'>".$row['page_name']."</font></a></li>";
                            }

                            if ($user_type == "1") {
                            echo "<li><a href='?module=show_page&id=".$row['id']."'><font color='#18A0FF'>".$row['page_name']."</font></a></li>";
                            }                            
						} 
                        echo "</ul>";
                        } 
                        ?>
						</div>
					</td>
				</tr>
                                <tr>
                                    <td align="right">
                                        <a href="logout.php" border="0"><div class="buttons-logout" style="display:inline-block;"></div><!-- <img border=0 src="<?php //echo LOGOUT_BUTTON_FILE ?>" /> --></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>

                                <tr>                                    
                                        <td valign="top" bgcolor="#F4F5F7">
                                         
                                                    
                                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="main_table_desc_text">
                                                                          <p class="headingName">
                                                                            <span class="titleName">
                                                                                Add your title
                                                                            </span>
                                                                          </p>
                                                                        </td>                                                                       
                                                                    </tr>
                                                                    <tr>
                                                                        <td><br><hr><br></td>
                                                                    </tr>
                                                                </table>
                                                          
                                                    </td>
                                                                                                    
                                    </tr>

                                    <tr class="module_row">
                                        <td valign="top">
                                            <div id="user_title_modal">
                                            <form method="post" name="form1" id="user_title_add">    

                                            <table width="90%">    
                                                <tr>
                                                    <td class="c_list_item"><p>We do not have a record of your designated title in our database. Please choose the appropriate title, or no title below. Your title will be displayed after your name on your certificate after you pass your exam!</p></td>
                                                </tr>
                                                <tr><td height="20"></td></tr>
                                                <tr><td><table>
                                                <tr>
                                                    <td class="c_list_item">Title: </td>
                                                    <td align="left">
                                                        <select id="drpUserType" name="drpUserType">
                                                            <?php echo $user_type_options ?>
                                                        </select>
                                                    </td>
                                                </tr>

                                                    <td colspan="2">
                                                        
                                                        <input class="st_button" type="submit" name="btnSave" value="<?php echo SAVE ?>" id="btnSave" />

                                                    </td>
                                                </tr>
                                                <tr><td height="20"></td></tr>
                                                </table></td></tr>
                                            </table>
                                                <input type="hidden" id="hdnMode" value="<?php echo $mode ?>">            

                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                            </table>
                </td>
            </tr>
         </table>
        <div style="display:<?php echo DEBUG_SQL=="yes" ? "" : "none" ?>">
        <table style="width:100%" style="display:<?php echo DEBUG_SQL=="yes" ? "" : "none" ?>">
            <tr>
                <td bgcolor="white">
                    <table style="width:100%" cellpadding="0" cellspacing="0">
                        <?php
                        for($i=0;$i<count($queries);$i++)
                        {
                            ?>
                                <tr>
                                    <td bgcolor="moccasing" class="query_head">
                                      <b>Query <?php echo $i+1 ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="query">
                                        <?php echo util::getFormattedSQL($queries[$i]) ?>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                    </td>
                                </tr>
                            <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        </div>
        <script type="text/javascript">
                  $( "#user_title_add" ).submit(function( event ) {
                    console.log("submitted");
                      try{
                          parent.jQuery.fancybox.close();
                      }catch(err){
                          parent.$("#fancybox-overlay").hide();
                          parent.$("#fancybox-wrap").hide();
                      }     
                  }); 
        </script>  
   </BODY>

</HTML>
