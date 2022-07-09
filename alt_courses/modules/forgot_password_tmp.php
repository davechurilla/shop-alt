<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>
<?php echo $val->DrowJsArrays(); ?>
<script language = "javascript">
function restore_password()
{

	document.form1.btnSend.disabled=true;
	var email= document.getElementById('txtEmail').value;

        var status=validate();

        if(status)
        {
             $.post("?module=forgot_password", { email_for_restoring: email, ajax: "yes" },
             function(data){
             
                    alert(data);
                     document.form1.btnSend.disabled=false;
                 

            });
        }
        else
        {
            document.form1.btnSend.disabled=false;
        } 	
		
}
</script>
<form id=form1 name=form1 method=post>
<table>
	<tr>
		<td>
			Enter you email address :
		</td>
		<td>
			<input type=text id=txtEmail name=txtEmail  />
		</td>
		<td><input type=button id=btnSend name=btnSend value = "Send password" onclick="restore_password()" />
		</td>
	</tr>
	<tr>	<td colspan=3 align=center><br>
			<a href="login.php">Return to the login page</a>
		</td>
	<tr>
</table>
</form>
