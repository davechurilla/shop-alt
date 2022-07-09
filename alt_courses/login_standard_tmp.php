<?php if(!isset($RUN)) { exit(); } ?>
<html>
    <head><META http-equiv="content-type" content="text/html; charset=utf-8">
            <link href="style/index.css" type="text/css" rel="stylesheet" />
            <title>Login - Online Courses and Exams - Advanced Laser Training</title>

    </head>
    <body bgcolor="#ffffff">
        <form method="post" action="login.php">

    <table align="center" border="0" style="width:100%">
        <tr>
            <td>
                <div id="header">
                <img src="/images/main_header_logo_left.gif" class="left">
                <img src="/images/main_header_logo_right.gif" class="right">
                </div>
                <table align=center  style="width:100%;height:433px;">
                    <tr>
                        <td>
                            <table cellpadding=0 cellspacing=0 align="center" width="410px">
                                <tr>
                                     <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td bgcolor="#FFFFFF">

                                    </td>
                                    <td bgcolor="#FFFFFF" colspan=2>
                                        <table bgcolor="#FFFFFF" align="center">
                                            <tr>
                                                <td colspan="2" valign="middle">
                                                    <p class="headingName">
                                                        <span class="titleName">
                                                            Online Courses and Exams
                                                        </span>
                                                    </p>                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" valign="middle" height="10">                                                  
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo LOGIN ?> :
                                                </td>
                                                <td>
                                                   <input type="text" name="txtLogin" class="login_box"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo PASSWORD ?> :
                                                </td>
                                                <td>
                                                    <input type="password" class="login_box" name="txtPass"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo LANGUAGE ?> :
                                                </td>
                                                <td>
                                                    <select name="drpLang" class="login_box">
                                                        <?php echo $language_options ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 align=center><input type="submit" value="<?php echo LOG_IN ?>" name="btnSubmit" style="width:100px" /></td>
                                            </tr>
                                             <tr>
                                    <td colspan=3 align=center class="main_txt_lt"><br>
                                         <?php echo $msg ?>
                                    </td>
					
                                </tr>				
                                        </table>
                                    </td>
                                </tr>
				<tr style="display:<?php echo $register_display ?>">
					<td colspan=3 align=center><a href="https://shop.advancedlasertraining.com/password_forgotten.php" target="_blank"><font color="#18A0FF"><?php echo REG_FORGOT_PASS ?></font></a><!-- &nbsp;&nbsp;<a href="index.php?module=register"><font color="#18A0FF"><?php //echo REG_NEW_USER ?> </font></a> --></td>
				</tr>
                                <tr>
                                    <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        </form>
    </body>
</html>
