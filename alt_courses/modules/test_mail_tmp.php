<?php if(!isset($RUN)) { exit(); } ?>
<script language="javascript">
	function send_mail()
	{
	     document.form1.btnSend.disabled=true;
 	     var email = document.getElementById('txtMail').value;
	     $.post("?module=test_mail", { email: email, ajax: "yes" },
             function(data){
                    alert('<?php echo CHECK_MAIL ?>');
                     document.form1.btnSend.disabled=false;
                 

            });
	}
</script>
<form id=form1 name=form1>
<table align=center>
<tr>
	<td> <?php echo MAIL_ADDRESS ?> : 
	</td>
	<td><input type=text id=txtMail name=txtMail />
	</td>
	<td><input type=button name=btnSend id=btnSend value="<?php echo SEND ?>" onclick="send_mail()" style="width:90px" />
	</td>
</tr>
</table>
</form>
