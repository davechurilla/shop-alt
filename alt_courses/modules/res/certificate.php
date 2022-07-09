<?php
session_start(); 

$fname = $_SESSION['name'];
$lname = $_SESSION['surname'];
$title = $_SESSION['customers_title'];

if($title != '' && $title != 'No title') {
    $title = $title;
} else {
    $title = '';
}

$fullName = $fname . ' ' . $lname;
$courseLevel = $_REQUEST['intro_text'];
$courseTitle = $_REQUEST['quiz_name'];

?>
<style type="text/css">
<!--

p {
    margin: 3mm 0; 
    padding: 0;
}

strong {
    margin: 0; 
    padding: 0;
}


-->
</style>
<page backimg="./res/cert_bg.jpg" backtop="7mm" backbottom="7mm" backleft="7mm" backright="7mm">

    <page_header>

    </page_header>
    <page_footer>

    </page_footer>

<table class="cert_copy" style="width:30%; margin-top:60mm;" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center" style="border-bottom: 1px solid #000;" valign="top">
    <p style="font-size: 32pt; font-family: times, serif;"><?php echo str_replace('XXX', '20', $fullName); ?><?php if($title != '') echo ', ' .  str_replace('XXX', '20', $title); ?></p>
    </td>
    </tr>   
    <tr>
    <td style="text-align: center; font-family: times, serif; height: 70mm;" align="center" valign="top">     
    <p style="font-family: times, serif;font-size: 13pt; margin: 4mm 0 1mm 0;">has completed the</p>
    <p style="font-family: times, serif;font-size: 20pt; margin-top:0;"><?php echo str_replace('XXX', '20', $courseLevel); ?></p>

    <p style="font-family: times, serif;font-size: 24pt;"><em><?php echo str_replace('XXX', '20', $courseTitle); ?></em></p>
  
    <p style="font-family: times, serif;font-size: 20pt;margin:1mm !important;"><strong><?php echo date("Y"); ?></strong></p>
    <p style="font-family: times, serif;font-size: 14pt;margin:1mm !important;"><strong>World Clinical Laser Institute</strong></p>
    </td>
    </tr>

    <tr>
    <td align="center" style="border-bottom: 1px solid #000;">
    <img src="./res/signature.png" style="width: 350px; height: 81px; margin-bottom: -5mm;" />
    </td>
    </tr>
    <tr>
    <td align="center">    
    <p style="font-family: times, serif;font-size: 10pt;"><strong>William E. Brown, Jr., Executive Director</strong><br />World Clinical Laser Institute</p>
    </td>
    </tr>
</table>


</page>