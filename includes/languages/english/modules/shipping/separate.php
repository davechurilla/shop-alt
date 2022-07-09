<?php
/*
  $Id: separate.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 Robert Petet [rpetet] of r-pdesigns.com and Brett Gowler [WebDev22] of wolfftanning.com 

  Released under the GNU General Public License
*/
$status_query = tep_db_query("select distinct `configuration_value` from " . TABLE_CONFIGURATION ." where configuration_key = 'MODULE_SHIPPING_SEPARATE_VERSION' ");
 while($row = mysql_fetch_assoc($status_query)){
 $ver = $row['configuration_value'];
 }

// define('MODULE_SHIPPING_SEPARATE_TEXT_TITLE', 'Separate Shipping ver:' . $ver );
define('MODULE_SHIPPING_SEPARATE_TEXT_TITLE', 'Shipping by weight');
define('MODULE_SHIPPING_SEPARATE_TEXT_DESCRIPTION', 'Seperate Shipping Per Product/Category ver:' . $ver );
define('MODULE_SHIPPING_SEPARATE_TEXT_WAY', 'Total Shipping Cost');
define('MODULE_SHIPPING_SEPARATE_TEXT_QTY', 'Qty');
define('MODULE_SHIPPING_SEPARATE_TEXT_AMOUNT', 'Amount');

?>