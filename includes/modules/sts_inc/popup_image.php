<?php
/*
  $Id: popup_image.php,v MoPics 6 2003/06/05 23:26:23 Rigadin $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $products_query = tep_db_query("select pd.products_name, p.products_model, p.products_image from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and pd.language_id = '" . (int)$languages_id . "'");
  $products = tep_db_fetch_array($products_query);
	
	$sts->template['productname'] = $products['products_name'];
	$sts->template['productmodel'] =  $products['products_model'];
	$sts->template['popupimage'] = tep_image(DIR_WS_IMAGES . $products['products_image'],'','','', 'name="prodimage"');
	
// Empty placeholders, to be used in case you build something for several product images
  $sts->template['back']=''; // Back button, in case there are several product images
	$sts->template['next']= ''; // Next button
	$sts->template['count']=''; // For the text 1/7 (first picture on seven, ...)
	
?>