<?php if(!isset($RUN)) { exit(); } ?>
<HTML>
    <HEAD>
		<META http-equiv="content-type" content="text/html; charset=utf-8">
                <title>Online Courses and Exams - Advanced Laser Training</title>     
                <script language ="javascript" src="extgrid.js"></script>

                <!-- Add jQuery library -->
                <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>          
                <script src="cms.js" type="text/javascript"></script>

                <!-- Add fancyBox -->
                <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
                <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>


                <link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
                <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>     

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

   

    </HEAD>
    <link href="style/index.css" type="text/css" rel="stylesheet" />
    <link href="style/grid.css" type="text/css" rel="stylesheet" />
    <BODY bgcolor="#ffffff" id="standard">
<?php
// $arr = get_defined_vars();
// print_r($arr);
// echo $_SESSION['user_type'];
?>
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
            MoveLoadingMessage("loadingDiv");
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
                                <?php
                                if($module_name!="show_page") 
                                   {
                                ?>
                                <tr>                                    
                                        <td valign="top" bgcolor="#F4F5F7">
                                         
                                                    
                                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="main_table_desc_text">
                                                                          <p class="headingName">
                                                                            <span class="titleName">
                                                                                <?php
                                                                                    echo desc_func();
                                                                                ?>
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
                                <?php
                                   }
                                ?>                                    
                                    <tr height="550px" class="module_row">
                                        <td valign="top">
                                             <?php
						include "modules/".$module_name."_tmp.php";
                                             ?>
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
            $(document).ready(function() {
                $("#fancybox").fancybox( {maxWidth : 720, maxHeight: 400, type: 'iframe', modal: true} );
            });
            function modalOpen() {
              $.fancybox( {href: "modal.php", maxWidth : 720, maxHeight: 400, type: "iframe", modal: true} ); 
            }  
          
        </script>         
        <?php 
            $customers_title = $_SESSION['customers_title'];   

            if ( empty($customers_title) && $_SESSION['user_type'] == 2 ) {      
                echo '<script type="text/javascript">$(document).ready(function() {modalOpen();});</script>';
                $_SESSION['modal_state'] = 'open';
            } 
        ?>     
                           
   </BODY>

</HTML>
