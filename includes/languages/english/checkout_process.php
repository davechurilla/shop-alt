<?php
/*
  $Id: checkout_process.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('EMAIL_TEXT_LETTER_INTRO', '<p>Dear Advanced Laser Training Customer,</p><p><strong>Thank you</strong> for your order. We appreciate your business and look forward to providing you with exceptional customer service. Below is the receipt for your order.</p>');
define('EMAIL_TEXT_LETTER_BODY', '<p>If you have ordered one of our online courses you will receive a separate e-mail from AdvancedLaserTraining which will provide you with a link to access the course. After you click on the link in the e-mail, you will type in your email address and password to access the online course. The password you will use will be the same as the password you registered and use to login on the Advanced Laser Training website. If you registered over the phone, your password is your last name with the first letter capitalized. If you have lost or forgotten your password, you can <a href="https://shop.advancedlasertraining.com/password_forgotten.php" target="_blank">reset it here</a>. If you do not receive this e-mail within one business day of placing the order please check your SPAM folder and if you cannot locate it call <strong>877-LASER66 (527-3766).</strong></p> <p>Advanced Laser Training also offers the following resources and products:</p> <ul> <li>A Laser Surgical Training DVD. This DVD includes 22 chapters on the most commonly performed soft tissue laser procedures with narration, power settings and type of anesthesia used.</li> <li>A Patient Education Brochure series. These unique brochures help you explain laser dentistry procedures in an easy to understand format and are designed for patients.</li> </ul> <p>If you would like to register for one of our courses or purchase any of our products please call us at <strong>877-LASER66 (527-3766)</strong> or visit our web site at <strong><a href="http://www.advancedlasertraining.com" target="_blank">AdvancedLaserTraining.com</a>.</strong></p><p>We look forward to working with you to meet all your laser needs.</p> <p>All the best,</p> <p><strong>Malia Owens</strong><br /> <strong>Advanced Laser Training, Inc.</strong><br /> <strong>Vice President Sales and Marketing</strong><br /> 2651 Quarry Lane<br /> Fayetteville, AR 72704<br /> 877-527-3766 Toll Free<br /> 479-361-8853 Local/ Canada Callers<br />949-945-3938 Cell<br /> <a href="mailto:MOwens@AdvancedLaserTraining.com" target="_blank">MOwens@AdvancedLaserTraining.com</a></p> <p> ATTENTION: This email address was given to us by someone who visited our online store. If this was not done by you please email us at <a href="mailto:mowens@advancedlasertraining.com" target="_blank">mowens@advancedlasertraining.com</a></p>');

define('EMAIL_TEXT_SUBJECT_SOL', 'Your Denmat SOL Webinar is ready to view');
define('EMAIL_TEXT_LETTER_SOL', '<p>Dear Advanced Laser Training Customer,</p> <p><strong>Thank you</strong> for registering for the DenMat SOL Webinar.  This is a FREE Webinar. To access the content, please visit the DenMat SOL link provided to you below. </p> <p><a href="http://www.denmat.com/Product_-_STM_-_SOL" target="_blank">http://www.denmat.com/Product_-_STM_-_SOL</a></p> <p>Participants completing and passing the 15 question electronic multiple choice test at the end of the webinar will receive 1 AGD/PACE Approved CE credit.  Advanced Laser Training, INC. is designated as an Approved AGD / PACE Program Provider by the Academy of General Dentistry. The formal continuing education programs at Advanced Laser Training are accepted by AGD for Fellowship, Mastership, and Membership Maintenance Credit. The current term of approval extends from 3/1/2013 - 2/29/2016. Provider ID: # 351393.</p> <p>Call us at <strong>(877) 527-3766</strong> to receive a trifold brochure regarding Advanced Laser Training s 2013 live training courses as well as information on our online courses. This brochure includes descriptions of each of our four course types along with registration information for Live and Online versions.  </p> <p>Advanced Laser Training also offers substantial discounts on the following items for DenMat customers:</p> <ul> <li>A Laser Surgical Training DVD special offer. This DVD includes 22 chapters on the most commonly performed soft tissue procedures with narration, power settings and type of anesthesia used.</li> <li>A Patient Education Brochure special offer. These informative brochures help you explain laser dentistry procedures in an easy to understand format designed for patients. Buy 4 sets and receive 5th set free.</li> <li>Laser Loupe Filters that fit all major loupe brands.  These filters allow you to use your loupes while performing laser procedures. They are the most comfortable, least expensive eye protection we ve found on the market. No fogging, lightweight and easy to use. </li> </ul> <p>Thank you for your business. We look forward to working with you to meet all your laser needs.</p> <p><strong>Malia Owens</strong><br /> <strong>Advanced Laser Training, Inc.</strong><br /> <strong>Vice President Sales and Marketing</strong><br /> 2651 Quarry Lane<br /> Fayetteville, AR 72704<br /> 877-527-3766 Toll Free<br /> 479-361-8853 Local/ Canada Callers<br /> 479-419-5598 Fax<br /> 949-945-3938 Cell<br /> <a href="mailto:MOwens@AdvancedLaserTraining.com" target="_blank">MOwens@AdvancedLaserTraining.com</a></p> <p>ATTENTION: This email address was given to us by someone who visited our online store. If this was not done by you please email us at <a href="mailto:mowens@advancedlasertraining.com" target="_blank">mowens@advancedlasertraining.com</a></p>');

define('EMAIL_TEXT_SUBJECT_ONLINE_COURSE', 'Your online course is ready');

// PWA BOF
define('EMAIL_WARNING', 'ATTENTION: This email address was given to us by someone who visited our online store. If this was not done by you please email us at  ' . STORE_OWNER_EMAIL_ADDRESS . ' Thank you for shopping with us and have a great day.');
// PWA EOF
define('EMAIL_TEXT_SUBJECT', 'Order Process');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_PRODUCTS', 'Products');
define('EMAIL_TEXT_SUBTOTAL', 'Sub-Total:');
define('EMAIL_TEXT_TAX', 'Tax:        ');
define('EMAIL_TEXT_SHIPPING', 'Shipping: ');
define('EMAIL_TEXT_TOTAL', 'Total:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');

define('EMAIL_ONLINECOURSE_PAID_TEXT', "\n\n" . 'Thank you for registering for our online course.' . "\n" . 'If you need further training after taking this course you are invited to attend the same class live within 12 months at no additional cost. This offer valid only for customers that sign up and pay Advanced Laser Training directly not valid for laser company covered courses, not combinable with any other discount or special offers.' . "\n" . 'You can access the site and view the content from any high speed computer.  Watch the videos, download the materials and work at your own pace.' . "\n" . 'Remember you can watch the segments as many times as you like and the course will be open to you indefinitely.' . "\n" . 'Please login to the online course using the link, username and password provided.' . "\n");

define('EMAIL_ONLINECOURSE_UNPAID_TEXT', "\n\n" . 'Thank you for registering for our online course.' . "\n" . 'If you need further training after taking this course you are invited to attend the same class live within 12 months at no additional cost. This offer valid only for customers that sign up and pay Advanced Laser Training directly not valid for laser company covered courses, not combinable with any other discount or special offers.' . "\n" . 'You can access the site and view the content from any high speed computer.  Watch the videos, download the materials and work at your own pace.' . "\n" . 'Remember you can watch the segments as many times as you like and the course will be open to you indefinitely.' . "\n" . 'Upon receipt of payment, or serial number for manufacturer credit, for the online course(s) you have ordered, we will personally send you an email with information on how to access this restricted area.' . "\n");

?>



 



 



 



 

