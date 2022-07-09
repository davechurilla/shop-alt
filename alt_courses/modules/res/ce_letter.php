<?php
session_start(); 

$fname = $_SESSION['name'];
$lname = $_SESSION['surname'];
$title = $_SESSION['customers_title'];

$fullName = $fname . ' ' . $lname;
//$courseLevel = $_REQUEST['intro_text'];
$courseTitle = $_REQUEST['quiz_name'];
$date = $_REQUEST['finish_date'];

?>
<style type="text/css">
<!--

p {
    margin: 2mm 0; 
    padding: 0;
    line-height: 18px;
}

strong {
    margin: 0; 
    padding: 0;
}


-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">


<div class=Section1>
<div style='border:none;border-bottom:solid windowtext 1.5pt;
padding:0in 0in 1.0pt 0in'>
    <p align=right style='text-align:right;float:right;border:none;
padding:0in;'><span
style='color:black;'><img width=362 height=71
src="./res/image002.gif" v:shapes="_x0000_i1025"></span></p>
</div>
<p align=right style='text-align:right;float:right;'><b><span style='font-size:11.0pt;color:#333333'>Advanced Laser Training, Inc.</span></b><br />
<span style='font-size:
11.0pt;color:#333333'>2651 Quarry Lane</span><br />
<span style='font-size:
11.0pt;color:#333333'>Fayetteville, AR 72704</span><br />
<span style='font-size:
11.0pt;color:#333333'>Phone 877-527-3766</span><br />
<span style='font-size:
11.0pt;color:#333333'>AGD Provider ID # 351393</span><br />
<b><span style='font-size:11.0pt;color:#333333'>www.AdvancedLaserTraining.com</span></b></p>
  <div style='border:none;border-bottom:solid windowtext 1.5pt;
padding:0in 0in 1.0pt 0in'> </div><br /><br />
  <p><span style='font-size:14.0pt;color:#333333;'><?php echo str_replace('XXX', '20', $date); ?></span></p>
  <p><span style='font-size:14.0pt;color:#333333;line-height:16pt;'>Advanced Laser
    Training, Inc. verifies that <strong><?php echo str_replace('XXX', '20', $fullName); ?></strong> successfully completed the online <i><?php echo str_replace('XXX', '20', $courseTitle); ?> Course</i>.&nbsp; This course was presented by Dr. Chris Owens  for 8 AGD / PACE approved continuing education
    credits.<i></i></span></p>
  <p><span style='font-size:14.0pt;color:#333333'>Verified by:</span></p>
  <p><span style='font-size:14.0pt;color:#333333'><img width=164 height=57
src="./res/image004.gif" v:shapes="_x0000_i1026"></span></p>
  <p><span style='font-size:14.0pt;color:#333333'>Chris Owens,
    DDS</span><br />
<span style='font-size:14.0pt;color:#333333'>www.AdvancedLaserTraining.com<br /> AGD Provider ID # 351393</span></p>
  <p><span style='font-size:14.0pt'><img width=78 height=89
src="./res/image006.gif" v:shapes="_x0000_i1027"></span></p>
  <p><span style='font-size:11.0pt;color:#333333'>Continuing
    education credits for participation in this activity may or may not apply
    toward license renewal requirements in your state.&nbsp; It is the responsibility of each participant to verify the
    requirements of his or her state licensing board(s).&nbsp; Please retain a copy of this document for your records.&nbsp; Thank you.</span></p>
</div>

</page>