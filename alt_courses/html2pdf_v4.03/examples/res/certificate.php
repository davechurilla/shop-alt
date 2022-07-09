<?php
$content = 'David Churilla';
?>
<style type="text/css">
<!--
.cert_bg{
    width: 150mm;
    height: 540px;
    text-align: center;
    /*background:url(cert_bg.png) no-repeat;*/
    position: relative;
}

.cert_copy {
    margin: 0 auto;
    position: relative;
    top: 50mm;
    width: 100mm;
    /*border: 1px solid #333;*/
    font-family: Times, serif;
    text-align: center;
}

.namecontainer {
    width: 100%;
    border: 1px solid #000;
    /*border-bottom: 1px solid #000;*/
    position: relative;
    padding: 5px 0;
    font-size: 35px;
    line-height: 30px;
    font-weight: normal;
    white-space: nowrap;
}

p {
    margin: 10px 0; 
    padding: 0;
}

.cert_copy p.intro {
    font-size: 12px;
    line-height: 12px;
}

.cert_copy p.level, .cert_copy p.course_type {
    font-size: 20px;
    line-height: 22px;
}

.cert_copy p.title {
    font-size: 18px;
    line-height: 20px;
    white-space: nowrap;
}

.cert_copy p.course_type {
    padding: 10px 0;    
}

.cert_copy p.organization {
    font-size: 14px;
    line-height: 14px;
}

.signature {
    margin: 0 185px;
    position: absolute; 
    top: 395px;
    width: 350px;
}

.signature .signature_box {
    position: relative;
    width: auto;
    height: 60px;
    margin: 0;
    border-bottom: 1px solid #000;
}

.signature .signature_box .image {
    /*background: url(signature.png) no-repeat;*/
    width: 258px;
    height: 60px;
    margin: 0 46px;
    position:relative;
    bottom: -10px;
}

.signature p.signature_copy {
    position: relative; 
    font-size: 10px;
    line-height: 10px;
}


-->
</style>
<page backimg="./res/cert_bg.png">
<div class="cert_bg">

<div class="cert_copy">
    <div class="namecontainer"><?php echo str_replace('XXX', '20', $content); ?></div>
    <p class="intro">has completed the</p>
    <p class="level">Level I Laser Certification Course Associate Fellowship Certification</p>
    <p class="title"><em>Soft Tissue Surgical and Periodontal Applications</em></p>
    <p class="course_type"><strong>2013 Online Course</strong></p>
    <p class="organization"><strong>World Clinical Laser Institute</strong></p>
</div>

<div class="signature">
    <div class="signature_box">
    <div class="image"></div>
    </div>
    <p class="signature_copy"><strong>William E. Brown, Jr., Executive Director</strong><br />World Clinical Laser Institute</p>
</div>

</div>
</page>