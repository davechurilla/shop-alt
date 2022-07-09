<?php if(!isset($RUN)) { exit(); } ?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script language="javascript">
var chklocal = new Array();
var chktype = new Array();
var uqids = new Array();
var msg_type = 0;
var labelid = 'lbl';
function send_message(mtype)
{
		EnableButtons(true);
		if(mtype==2) labelid='lblres' ;
		else labelid='lbl';
	
		msg_type = mtype;
		chklocal = new Array();
		chktype = new Array();
		uqids = new Array();
		var cName="chklcl";
		var cNameI = "chkimp";
		var theForm = document.getElementById("form1");
		for (v=0,z=0,y=0,i=0,n=theForm.elements.length;i<n;i++)
		{
		  var lclind = theForm.elements[i].className.indexOf(cName);
		  var impind = theForm.elements[i].className.indexOf(cNameI);
		  if ( lclind!=-1 || impind !=-1) {
		  
		    	if(theForm.elements[i].checked) 
			{
				var hdnID = lclind!=-1 ? "hdn"+y : "hdnI"+v;
				var hdnuqID = lclind!=-1 ? "hdnuq"+y : "hdnuqi"+v;
				var user_id=document.getElementById(hdnID).value;
				var uq_id=document.getElementById(hdnuqID).value;
				chklocal[z] = user_id;
				chktype[z] = lclind!=-1 ? 1 : 2 ;
				uqids[z] = uq_id;
				z++;
			}
			lclind!=-1 ? y++ : v++ ;
		  }
	       }
	       c = 0;
	       SendMails();
}

function SendMails()
{
		if(sent==true)
		{
			if(chklocal[c]==null) 
			{
				EnableButtons(false);
				return ;
			}
			sent = false;
			SendMail(chklocal[c],chktype[c],uqids[c])
			c++;
		}
		
		setTimeout(function(){SendMails()},2000);
		
	
} 

var sent = true;
var c = 0;

function SendMail(user_id, user_type,user_quiz_id)
{
	var lblID = "";
	msg_type == 1 ? lblID  = labelid+user_id : lblID  = labelid+user_id+user_quiz_id;
	document.getElementById(lblID).innerHTML="<img src='style/i/ajax_loader2.gif'>";
	  $.post(document.location.href, {  send_mail : "yes", user_id : user_id , user_type : user_type,user_quiz_id:user_quiz_id, msgtype :msg_type, ajax: "yes" },
         function(data){          
//alert(data);   
             sent = true;
            msg_type == 1 ? lblID  = labelid+user_id : labelid+user_id+user_quiz_id;
	    document.getElementById(lblID).innerHTML='<?php echo $SENT['yes'] ?>';
        });
}
function EnableButtons(enable)
{	
	document.form1.btnStart.disabled=enable;
	document.form1.btnRes.disabled=enable;
}

</script>
<form name=form1 id=form1 >
<table class="desc_text_bg">
    <tr>
        <td width="280px">
            <?php echo CAT ?> :
        </td>
        <td>
            <?php echo $cat_name ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo TEST ?> :
        </td>
        <td>
            <?php echo $test_name ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo TYPE ?> :
        </td>
        <td>
            <?php echo $quiz_type ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo QUESTIONS_ORDER ?> :
        </td>
        <td>
            <?php echo $questions_order ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo ANSWERS_ORDER ?> :
        </td>
        <td>
            <?php echo $answer_order ?>
        </td>
    </tr>
    
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo REVIEW_ANSWERS ?> :
        </td>
        <td>
            <?php echo $review_answers ?>
        </td>
    </tr>
    
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo SHOW_RESULTS ?> :
        </td>
        <td>
            <?php echo $show_results ?>
        </td>
    </tr>
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo RESULTS_BY ?> :
        </td>
        <td>
            <?php echo $results_by ?>
        </td>
    </tr>
   <tr >
        <td>
            <?php echo ASG_HOW_MANY ?> :
        </td>
        <td>
            <?php echo $asg_how_many ?>
        </td>
    </tr>
   <tr>
  <tr >
        <td>
            <?php echo ASG_AFFECT_CHANGE ?> :
        </td>
        <td>
            <?php echo $asg_affect_change ?>
        </td>
    </tr>
   <tr>

  <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo ASG_SEND_RESULTS ?> :
        </td>
        <td>
            <?php echo $asg_send_results ?>
        </td>
    </tr>
   <tr>	

  <tr >
        <td>
            <?php echo ENABLE_FOR_NEW ?> :
        </td>
        <td>
            <?php echo $accept_new ?>
        </td>
    </tr>
   <tr>	
   

    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo SUCCESS_POINT_PERC ?> :
        </td>
        <td>
            <?php echo $pass_score ?>
        </td>
    </tr>
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo TEST_TIME ?> :
        </td>
        <td>
            <?php echo $test_time ?>
        </td>
    </tr>   
</table>

<br>
<table width="98%">
    <tr>
        <td><br></td>
    </tr>
    <tr>
       <td class="desc_text_bg2"><?php echo LOCAL_USERS ?></td>
    </tr>
    <tr>
        <td>
<div id="divLU">
    <?php echo $grid_lu_html ?>
</div>
        </td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="desc_text_bg2"><?php echo IMPORTED_USERS ?></td>
    </tr>
    <tr>
        <td>
<div id="divIU">
    <?php echo $grid_iu_html ?>
</div>
        </td>
    </tr>
 <tr>
        <td><br></td>
    </tr
    <tr>
	<td>
		<input type=button id=btnStart onclick='send_message(1)' value="Send start mail" /> 
		<input type=button id=btnRes onclick='send_message(2)' value="Send results mail" /> 
	</td>
    </tr>
</table>
</form>
<br>

<a href="#" onclick="javascript:window.location.href='?module=assignments'"><?php echo BACK ?></a>

<br>
<br>
<br>
<br>
<br>


