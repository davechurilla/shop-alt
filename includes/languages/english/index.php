<?php
/*
  $Id: index.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

define('TEXT_MAIN', '<div class="intro"><img src="images/title_intro.gif" width="351" height="25" border="0" /><br />We invite you to browse through our store and shop with confidence. We invite you to create an account with us if you like, or shop as a guest. Either way, your shopping cart will be active until you leave the store.<br />Thank you for visiting.</div>');
define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

if ( isset($HTTP_GET_VARS['manufacturers_id']) ) {
  define('IMAGE_TITLE', '<img src="images/title_cat_1.gif" border="0" />');
}

if ( ($category_depth == 'products') || (isset($HTTP_GET_VARS['manufacturers_id'])) ) {
  define('IMAGE_TITLE', '<img src="images/title_cat_' . substr($cPath, 0, 1) . '.gif" border="0" />');
  
  define('CAT_INTRO_1', '<p>Discover the potential benefits of the exciting world of laser dentistry and receive 8 CE credits upon successful completion of each course - live or online.</p>');
  define('CAT_INTRO_2', '<p>We offer fibers and hand pieces as well as strippers, cleavers, disposable cannulas and initiating film. If you own a disposable tip laser you owe it to yourself to purchase a cleaver to save money on tips.</p>');  
  define('CAT_INTRO_3', '<img src="images/prod_broch_intro_img.jpg" width="211" height="211" align="right" border="0" /><p>This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.</p><p>Sold in packages of 50. <!--<br /> <span class="blue"><strong>Buy any 4 brochures and receive your 5th set free.</strong></span></p>/-->');
  define('CAT_INTRO_4', '<p><a href="http://www.advancedLaserLearning.com"><strong>AdvancedLaserLearning.com.</strong></a> All your laser learning needs. Only a click away.</p><p>Advanced Laser Training is committed to giving you an unparalleled dental laser educational experience. To that end, we are offering our students the opportunity to experience continuous Laser Training and support with AdvancedLaserLearning.com.</p><p>Sign up with AdvancedLaserLearning.com and enjoy access to our laser education subscription site. We are so sure you will be pleased with our service your first month is absolutely free. If for any reason, you feel it is not a good fit for you at this time, simply cancel via email, fax, or phone. If weire correct, and itis everything you had hoped for, do nothing and continue enjoying its benefits.</p><p>3 ways to subscribe. AdvancedLaserLearning.com is an annual subscription service that is offered for as low as $79.00 per month. It will renew monthly (or annually if paid in advance) and you are welcome to continue your membership as long as you enjoy laser dentistry and are committed to an exciting continuing education experience.</p>');
  define('HEADING_TITLE', 'Let\'s See What We Have Here');
  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Model');
  define('TABLE_HEADING_PRODUCTS', 'Product Name');
  define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
  define('TABLE_HEADING_QUANTITY', 'Quantity');
  define('TABLE_HEADING_PRICE', 'Price');
  define('TABLE_HEADING_WEIGHT', 'Weight');
  define('TABLE_HEADING_BUY_NOW', 'Buy Now');
  define('TEXT_NO_PRODUCTS', 'There are no products to list in this category.');
  define('TEXT_NO_PRODUCTS2', 'There is no product available from this manufacturer.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Number of Products: ');
  define('TEXT_SHOW', '<b>Show:</b>');
  define('TEXT_BUY', 'Buy 1 \'');
  define('TEXT_NOW', '\' now');
  define('TEXT_ALL_CATEGORIES', 'All Categories');
  define('TEXT_ALL_MANUFACTURERS', 'All Manufacturers');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'What\'s New Here?');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Categories');
}
?>
