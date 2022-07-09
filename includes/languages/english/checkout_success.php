<?php
/*
  $Id: checkout_success.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Success'); 

define('HEADING_TITLE', 'Your Order Has Been Processed!');

define('TEXT_CHECK_SPAM', 'IMPORTANT NOTE:<br />Be sure to check your Spam folder if you do not see emails(s) in your inbox from Advanced Laser Training. An email with your order details, and if you registered for one of our courses, a separate email with details about how to access the course, should have been immediately sent to you. Please contact the <a href="' . tep_href_link(FILENAME_CONTACT_US) . '">store owner</a> for assistance if you did not receive an email from us.');
define('TEXT_SUCCESS', 'If you ordered a live or online course and paid with a credit card your registration will be immediately processed and made available to you. If you ordered a live or online course with a manufacturer credit your registration will take 24 hours to be approved. If you ordered from our accessories or brochures your products will arrive at their destination within 2-5 working days.');
define('TEXT_NOTIFY_PRODUCTS', 'Please notify me of updates to the products I have selected below:');
define('TEXT_SEE_ORDERS', 'You can view your order history by going to the <a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">\'My Account\'</a> page and by clicking on <a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">\'History\'</a>.');
define('TEXT_CONTACT_STORE_OWNER', 'Please direct any questions you have to the <a href="' . tep_href_link(FILENAME_CONTACT_US) . '">store owner</a>.');
define('TEXT_THANKS_FOR_SHOPPING', 'Thanks for shopping with us online!');

define('TABLE_HEADING_COMMENTS', 'Enter a comment for the order processed');

define('TABLE_HEADING_DOWNLOAD_DATE', 'Expiry date: ');
define('TABLE_HEADING_DOWNLOAD_COUNT', ' downloads remaining');
define('HEADING_DOWNLOAD', 'Download your products here:');
define('FOOTER_DOWNLOAD', 'You can also download your products at a later time at \'%s\'');
?>