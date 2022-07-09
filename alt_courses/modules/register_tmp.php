<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>
<?php echo $val->DrowJsArrays(); ?>

<script language="javascript">

function checkform()
{
	document.form1.btnRegister.disabled=true;
	var user_name= document.getElementById('txtLogin').value;
	var email= document.getElementById('txtEmail').value;
        var status=validate();
        if(status)
        {
             $.post("?module=register", { login_to_check: user_name,email: email, ajax: "yes" },
             function(data){
                 if(data=="0")
                 {
                     document.forms["form1"].submit();
                 }
                 else
                 {
                    alert(data);
                    document.form1.btnRegister.disabled=false;
                 }

            });
        }
        else
        {
            document.form1.btnRegister.disabled=false;
        } 
}

</script>

<form method="post" name="form1" id="form1">

<table >
	<tr>
		<td align=right><?php echo R_NAME ?> <font color=red>*</font> : </td>
		<td><input maxlength=25 type=text name=txtName id=txtName style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_SURNAME ?> <font color=red>*</font> : </td>
		<td><input maxlength=25 type=text name=txtSurname id=txtSurname style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_LOGIN ?> <font color=red>*</font> : </td>
		<td><input maxlength=20 type=text name=txtLogin id=txtLogin style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_PASSWORD ?> <font color=red>*</font> : </td>
		<td><input maxlength=20 type=text name=txtPass id=txtPass style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_EMAIL ?> <font color=red>*</font> : </td>
		<td><input maxlength=35 type=text name=txtEmail id=txtEmail style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_ADDRESS ?> : </td>
		<td><input maxlength=50 type=text name=txtAddr style="width:230px"></td>
	</tr>
	<tr>
		<td align=right><?php echo R_PHONE ?> : </td>
		<td><input maxlength=15 type=text name=txtPhone style="width:230px"></td>
	</tr>	
	<tr>
		<td align=center colspan=2><br><input style="width:125px" name=btnRegister id=btnRegister type=button value="Register" onclick="checkform();" />&nbsp;<input type=button value="Cancel" style="width:125px" onclick="javascript:window.location.href='login.php'"></td>
	</tr>

</table>


</form>

