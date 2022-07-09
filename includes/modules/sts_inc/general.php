<?php
/*
$Id: general.php,v 4.5.4 2005/11/03 05:57:21 rigadin Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2005 osCommerce

Released under the GNU General Public License

Based on: Simple Template System (STS) - Copyright (c) 2004 Brian Gallagher - brian@diamondsea.com
STS v4.5.4 by Rigadin2 (www.osc-help.net)
*/

//this is used for cat_depth to set the page ID when viewing cats and prods
if($cPath) { 
$page = substr($cPath, 0, 1); 
}
elseif(isset($HTTP_GET_VARS['manufacturers_id'])) {
$page = '1';
}
elseif($category_depth == 'top') {
$page = '0';
}
else {
$page = '';
}

//set the img for the courses page to diplay if page is courses page
if (substr($cPath, 0, 1) == 1 || (isset($HTTP_GET_VARS['manufacturers_id']) && $HTTP_GET_VARS['manufacturers_id'] != 10)) {
	$courses_img = '<img src="images/courses_img.gif" border="0" />';
	//echo $HTTP_GET_VARS['manufacturers_id'];
}

else {
	$courses_img = '';
}


//set the div for the manufacturer logo to diplay if there is a manufacturer ID set in session
if (isset($HTTP_GET_VARS['manufacturers_id'])) {
	$manufacturers_id = $HTTP_GET_VARS['manufacturers_id'];
	$manu_logo = '<div id="manu_logo"><div class="logo"></div></div>';
}

else {
	$manu_logo = '';
}


// Set $templatedir and $templatepath (aliases) to current template path on web server, allowing for HTTP/HTTPS differences, removing the trailing slash

	$sts->template['templatedir'] = substr(((($request_type == 'SSL') ? DIR_WS_HTTPS_CATALOG : DIR_WS_HTTP_CATALOG) . STS_TEMPLATE_DIR),0,-1);
//	$sts->template['templatepath'] = $sts->template['templatedir']; // Deprecated in v4.3, use $templatedir instead
	
	$sts->template['htmlparams'] = HTML_PARAMS; // Added in v4.0.7
	
    $sts->template['date'] = strftime(DATE_FORMAT_LONG);
    $sts->template['langid'] = $languages_id; // used for images in different languages
    
	$sts->template['sid'] =  tep_session_name() . '=' . tep_session_id();
    $sts->template['cataloglogo'] = '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language . '/header_logo.gif', STORE_NAME) . '</a>'; // Modified in v4.3
    $sts->template['urlcataloglogo'] = tep_href_link(FILENAME_DEFAULT);

	$sts->template['greeting'] = tep_customer_greeting(); 

    // Deprecated in v4.3, use $urlmyaccount instead.
    //$sts->template['urlmyaccountlogo'] = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');

    $sts->template['cartlogo'] = '<a href="' . tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language. '/header_cart.gif', HEADER_TITLE_CART_CONTENTS) . '</a>';

			$sts->template['myaccountlogo'] = '<a href=' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . ' class="headerNavigation">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language . '/header_account.gif', HEADER_TITLE_MY_ACCOUNT) . '</a>';
    // Deprecated in v4.3, use $urlcartcontents instead.
//    $sts->template['urlcartlogo'] = tep_href_link(FILENAME_SHOPPING_CART);

    // Get logo from template folder, depending on language. Changed in v4.3
		$sts->template['checkoutlogo'] = '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language.'/header_checkout.gif', HEADER_TITLE_CHECKOUT) . '</a>';
		// Deprecated in v4.3, use $urlcheckout instead
    //$sts->template['urlcheckoutlogo'] = tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');

    $sts->template['breadcrumbs'] = $breadcrumb->trail(' &raquo; ');
    $sts->template['cat_depth'] = $page;
    $sts->template['manu_id'] = $manufacturers_id;
	$sts->template['courses_img'] = $courses_img;
	$sts->template['manu_logo'] = $manu_logo;
	
    if (tep_session_is_registered('customer_id')) {
      $sts->template['myaccount'] = '<a href=' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . ' class="headerNavigation">' . HEADER_TITLE_MY_ACCOUNT . '</a>';
      $sts->template['urlmyaccount'] = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
      $sts->template['logoff'] = '<a href=' . tep_href_link(FILENAME_LOGOFF, '', 'SSL')  . ' class="headerNavigation">' . HEADER_TITLE_LOGOFF . '</a>';
      $sts->template['urllogoff'] = tep_href_link(FILENAME_LOGOFF, '', 'SSL');
      $sts->template['myaccountlogoff'] = $sts->template['myaccount'] . " | " . $sts->template['logoff'];
// Next tags added in v4.3
			$sts->template['loginofflogo'] = '<a href=' . tep_href_link(FILENAME_LOGOFF, '', 'SSL') . ' class="headerNavigation">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language . '/header_logoff.gif', HEADER_TITLE_LOGOFF) . '</a>';
    } else {
      $sts->template['myaccount'] = '<a href=' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . ' class="headerNavigation">' . HEADER_TITLE_MY_ACCOUNT . '</a>';
      $sts->template['urlmyaccount'] = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
      $sts->template['logoff'] = '';
      $sts->template['urllogoff'] = '';
      $sts->template['myaccountlogoff'] = $sts->template['myaccount'];
// Next tags added in v4.3
			$sts->template['loginofflogo'] = '<a href=' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . ' class="headerNavigation">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language . '/header_login.gif', HEADER_TITLE_LOGIN) . '</a>';
    }
// v4.5: use SSL if possible.
    $sts->template['cartcontents']    = '<a href=' . tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . ' class="headerNavigation">' . HEADER_TITLE_CART_CONTENTS . '</a>';
    $sts->template['urlcartcontents'] = tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL');  // A real URL since v4.3, before was same as $cartcontents

    $sts->template['checkout'] = '<a href=' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . ' class="headerNavigation">' . HEADER_TITLE_CHECKOUT . '</a>';
    $sts->template['urlcheckout'] = tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
    $sts->template['headertags']= "<title>" . TITLE ."</title>";
		
// Next tags added in v4.3 to display an image according to language and linking to the contact us page.
		$sts->template['contactlogo'] = '<a href=' . tep_href_link(FILENAME_CONTACT_US) . ' class="headerNavigation">' . tep_image(STS_TEMPLATE_DIR.'images/'.$language . '/header_contact_us.gif', BOX_INFORMATION_CONTACT) . '</a>';

// Tags generally displayed in the footer. =============================================
  // Get the number of requests
  require(DIR_WS_INCLUDES . 'counter.php');
  $sts->template['numrequests'] = $counter_now . ' ' . FOOTER_TEXT_REQUESTS_SINCE . ' ' . $counter_startdate_formatted;
	
	$sts->template['footer_text']= FOOTER_TEXT_BODY;
	
// Get the banner if any
  $sts->start_capture();
  if ($banner = tep_banner_exists('dynamic', '468x50')) {
    echo tep_display_banner('static', $banner);
  }
  $sts->stop_capture ('banner_only');
	
// START STS 4.5.4: error & info messages, created in header.php for osCommerce without STS
  $sts->start_capture();
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(urldecode($HTTP_GET_VARS['error_message'])); ?></td>
  </tr>
</table>
<?php
  }
  $sts->restart_capture ('error_message');
  if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars($HTTP_GET_VARS['info_message']); ?></td>
  </tr>
</table>
<?php
  }
	$sts->stop_capture ('info_message');
// END STS 4.5.4
?>
