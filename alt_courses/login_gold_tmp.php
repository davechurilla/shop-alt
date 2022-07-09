<?php if(!isset($RUN)) { exit(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Quizzes and Surveys</title>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language ="javascript" src="jquery.js"></script>
<script language ="javascript" src="extgrid.js"></script>
<script src="cms.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="style/login_gold.css" media="screen" />
</head>
<body>

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


<div id="wrap" >

<div id="header">
<h1><a href="#">Quizzes and Surveys</a></h1>
<h2>Web based quiz software allowing to create quizzes and surveys</h2>
</div>

<div id="menu">
<ul>
<?php 
if(SHOW_MENU_ON_LOGIN_PAGE=="yes" && (SHOW_MENU=="all" || (SHOW_MENU=="registered" && $autorized==true))) {
while($row = db::fetch($menus)) {

echo "<li><a href='index.php?module=show_page&id=".$row['id']."'>".$row['page_name']."</a></li>";
} } ?>
</ul>
</div>

<div id="content">
<div  align=center> <br /><br />
   <form method="post" action="login.php">
     <table border=0 cellspacing=5 cellpadding=5>
	 	<tr>
			<td class=stext>
				<?php echo LOGIN ?> :
			</td>
			<td>
				 <input type="text" name="txtLogin" class="login_box"  />
			</td>
		</tr>
		<tr>
			<td class=stext>
				<?php echo PASSWORD ?> :
			</td>
			<td>
				 <input type="password" class="login_box" name="txtPass"  />
			</td>
		</tr>
		 <tr>
			<td  align=right class=stext>
                                                    <?php echo LANGUAGE ?> :
                                                </td>
                                                <td>
                                                    <select name="drpLang" style="width:300px">
                                                        <?php echo $language_options ?>
                                                    </select>
                                                </td>
                                            </tr>
  		<tr>
                                                <td colspan=2 align=center><input class=loginbtn type="submit" value="<?php echo LOG_IN ?>" name="btnSubmit" /></td>
                                            </tr>
                                             <tr>
                                    <td colspan=2 align=center class=loginmsg><br>
                                         <?php echo $msg ?>
                                    </td>
					
                                </tr>				
                                        </table>
<br />
<table style="display:<?php echo $register_display ?>">
<tr>
					<td ><a class=new_users href="index.php?module=forgot_password"><?php echo REG_FORGOT_PASS ?></a>&nbsp;&nbsp;&nbsp;<a href="index.php?module=register" class=new_users><?php echo REG_NEW_USER ?> </a></td>
				</tr>
</table>

     </form>
</div>

<div class="left"> 



</div>

<div style="clear: both;"> </div>

</div>

<div id="bottom"> </div>
<div id="footer">
<?php echo $PAGE_FOOTER_TEXT ?>
</div>

</div>

</body>
</html>
