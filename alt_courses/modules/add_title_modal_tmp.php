<?php if(!isset($RUN)) { exit(); } ?>
<div id="user_title_modal">
<form method="post" name="form1">    

<table>    
    <tr>
        <td>Title: </td>
        <td>
            <select id="drpUserType" name="drpUserType">
                <?php echo $user_type_options ?>
            </select>
        </td>
    </tr>

        <td colspan="2" align="center">
            <?php //echo $user_type_selected ?>
            
            
            <input class="st_button" type="submit" name="btnSave" value="<?php echo SAVE ?>" id="btnSave" />
            <!-- <input class="st_button" type="button" name="btnCancel" value="<?php //echo CANCEL ?>" id="btnCancel" onclick="javascript:window.location.href='?module=local_users'" /> -->
        </td>
    </tr>
</table>
    <input type="hidden" id="hdnMode" value="<?php echo $mode ?>">            

</form>
</div>