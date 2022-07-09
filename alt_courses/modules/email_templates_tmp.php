<?php if(!isset($RUN)) { exit(); } ?>
<script language="javascript">
function load_template()
{
	var table_display = "none";
	var temp_id = document.getElementById('drpTemps').options[document.getElementById('drpTemps').selectedIndex].value;
	if(temp_id!="-1") table_display = "";
	
	document.getElementById('tblBody').style.display = table_display;

	if(temp_id=="-1") return ;

	 $.post("?module=email_templates", { load_temp:"yes",tempid: temp_id, ajax: "yes" },
             function(data){
		if(data=="-1") { alert('<?php echo CANNOT_FIND_TEMP ?>') ; }
		else {
			 var data_arr = data.split('[{sep}]');
			document.getElementById('txtSubject').value = data_arr[0];
			document.getElementById('txtBody').value = data_arr[1];
			document.getElementById('txtVars').value = data_arr[2];
		}

            });
}

function save_template()
{
	var temp_id = document.getElementById('drpTemps').options[document.getElementById('drpTemps').selectedIndex].value;
	var subject = document.getElementById('txtSubject').value;
	var body = document.getElementById('txtBody').value;

	 $.post("?module=email_templates", { save_temp:"yes",tempid: temp_id, body:body,subject:subject, ajax: "yes" },
             function(data){
             	
		alert(data);

            });
}

</script>
<form method="post" name="form1" >
<table class="desc_text" border="0" align=center>
    <tr>
        <td>
            <?php echo SELECT_TEMP ?> :
        </td>
        <td>
            <select id="drpTemps" name="drpTemps" class="st_txtbox" onchange = "load_template()">
                <?php echo $name_options ?>
            </select>
        </td>
    </tr>

</table>
<table align=center style="display:none" id=tblBody>
    <tr>
	<td>
	<table>
		<tr>
			<td class=c_list_head><?php echo E_SUBJECT ?> : </td>	
		</tr>
		<tr>
			<td><input type=text id=txtSubject name=txtSubject style="width:700px" /> </td>	
		</tr>
		<tr>
			<td class=c_list_head><?php echo E_BODY ?> : </td>	
		</tr>
		<tr>
			<td align=center>
				<textarea id=txtBody name=txtBody style="width:700px;height:300px" ></textarea>
			</td>
		</tr>	
		<tr>
			<td class=c_list_head><?php echo E_VARS ?> : </td>	
		</tr>
		<tr>
			<td align=center>
				<input disabled type=text id=txtVars name=txtVars style="width:700px" />
			</td>
		</tr>		
		<tr>	
			<td align=center>
				<input onclick="save_template()" style="width:135px" type=button id=btnSave name=btnSave value="<?php echo SAVE ?>" />
				<input style="width:135px" type=button id=btnCancel name=btnCancel value="<?php echo CANCEL ?>" />
			</td>
		</tr>	
	</table>
	</td>
    </tr>
</table>
</form>

