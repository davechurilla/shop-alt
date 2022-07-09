<?php
/*
  $Id: product_listing.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');

  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
<div id="content_space">
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
  </tr>
</table>
</div>

<?php
  }




  $list_box_contents = array();

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
      case 'PRODUCT_LIST_BUY_NOW':
        $lc_text = TABLE_HEADING_BUY_NOW;
        $lc_align = 'center';
        break;
    }




    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
    }

	/*
    $list_box_contents[0][] = array('align' => $lc_align,
                                    'params' => 'class="productListing-heading"',
                                    'text' => '&nbsp;' . $lc_text . '&nbsp;');
  	*/
  }

/*
if (isset($HTTP_GET_VARS['keywords'])) {
	$keywords = $HTTP_GET_VARS['keywords'];
} else {
$keywords = 'NULL';
}
*/

//echo $keywords;
//echo $HTTP_GET_VARS['keywords'];
//if ( (!isset($HTTP_GET_VARS['keywords']) && empty($HTTP_GET_VARS['keywords'])) ||
//     (!isset($listing['manufacturers_id']) && isset($HTTP_GET_VARS['keywords']) && !empty($HTTP_GET_VARS['keywords'])) ) {



  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
    while ($listing = tep_db_fetch_array($listing_query)) {
    
	//if statement below will suppress all products tied to a manufacturer from the 'Quick Search' listing
	if ( (!isset($HTTP_GET_VARS['keywords']) && empty($HTTP_GET_VARS['keywords'])) ||
		 (!isset($listing['manufacturers_id']) && isset($HTTP_GET_VARS['keywords']) && !empty($HTTP_GET_VARS['keywords'])) ) {
		 
      $rows++;

	  $products_id= $listing['products_id'];

      if (($rows/2) == floor($rows/2)) {
        $list_box_contents[] = array('params' => 'id="productid_' . $products_id . '" class="productListing-even" valign="top"');
      } else {
        $list_box_contents[] = array('params' => 'id="productid_' . $products_id . '" class="productListing-odd" valign="top"');
      }

      $cur_row = sizeof($list_box_contents) - 1;

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        $lc_align = '';

            if (tep_not_null($listing['specials_new_products_price'])) {
              $prod_price = '<s>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
            } else {
              $prod_price = $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            }

        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $lc_align = '';
            $lc_text = '&nbsp;' . $listing['products_model'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_NAME':
// find option names and prepare string
			$optval = "";
           $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . $listing['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . $languages_id . "'"); 
            $products_attributes = tep_db_fetch_array($products_attributes_query); 
            if ($products_attributes['total'] > 0) { 
            $products_options_name_query = tep_db_query("select distinct popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . $listing['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . $languages_id . "'"); 
            while ($products_options_name = tep_db_fetch_array($products_options_name_query)) { 
            $products_options_array = array(); 
         foreach ($products_options_name as $abc) {   
			$optval = "<small>" . $optval . " [" . $abc . "]</small>";
		} 
        } 
			$optval = "<small><i>&nbsp;options</small></i>" . $optval;
        }

// add something before price if one or more attributes are priced
        $products_id= $listing['products_id'];
		$queryval = "SELECT options_values_price FROM products_attributes  WHERE products_id = $products_id";
		$resultval = MYSQL_QUERY($queryval);
		$numberval = MYSQL_NUM_ROWS($resultval);
		$t = 0;
		$totalval = 0;
		$val = "";
		WHILE ($t < $numberval) {
		IF ($numberval != 0){
                	$totalvalt = mysql_result($resultval,$t,"options_values_price");
		}
		$totalval = $totalvalt + $totalval;
		$t++;
        }
		IF ($totalval != 0){
		$from = "";
		}
// end


    // START: Add products extra fields to order email -- MUST EDIT WITH CONDITIONAL FOR RESTRICTING TO CREDIT CARD AND VOUCHER PAYMENTS
    $products_ordered_extra_fields = '';
    $extra_fields_query = tep_db_query("
                    SELECT pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                    FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
                    LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
                    ON ptf.products_extra_fields_id = pef.products_extra_fields_id
                    WHERE ptf.products_id = " . $listing['products_id'] . " AND ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
                    ORDER BY products_extra_fields_order");

    while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
       if ($extra_fields['name'] == 'Product Summary') { 
        $products_ordered_extra_fields .= $extra_fields['value'];
       } 
    }
    // END: Add products extra fields to order email  
    
            $lc_align = '';
            if (isset($HTTP_GET_VARS['manufacturers_id'])) {
              $lc_text = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '"><span style="font-size:16px;"><strong>' . $listing['products_name'] . '</strong></span><br />MORE INFO &raquo;</a><div class="prod_price"><strong>Price:' . $from . '&nbsp;' . $prod_price . '</strong></div>'  . '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '">' . tep_image_button('button_buy_now.gif', IMAGE_BUTTON_BUY_NOW) . '</a><br />' . $products_ordered_extra_fields;
            } else {  
    
              $lc_text = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '"><span style="font-size:16px;"><strong>' . $listing['products_name'] . '</strong></span><br />MORE INFO &raquo;</a><div class="prod_price"><strong>Price:' . $from . '&nbsp;' . $prod_price . '</strong></div><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '">' . tep_image_button('button_buy_now.gif', IMAGE_BUTTON_BUY_NOW) . '</a><br />' . $products_ordered_extra_fields;
            }
            $from="";
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
            $lc_align = '';
            $lc_text = '&nbsp;<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a>&nbsp;';
            break;
          case 'PRODUCT_LIST_PRICE':
            $lc_align = '';
            if (tep_not_null($listing['specials_new_products_price'])) {
              $lc_text = '';
            } else {
              $lc_text = '';
            }
            break;
          case 'PRODUCT_LIST_QUANTITY':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_quantity'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_weight'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_IMAGE':
            $lc_align = 'center';
            if (isset($HTTP_GET_VARS['manufacturers_id'])) {
              $lc_text = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name']) . '</a>';
              
            } else {
              $lc_text = '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name']) . '</a>';
            }
            break;
          case 'PRODUCT_LIST_BUY_NOW':
            $lc_align = 'center';
            $lc_text = '';
            break;
        }

	if (! $list_box_contents[$cur_row][0]) {
                                               
                                               
        $list_box_contents[$cur_row][] = array('align' => 'left',
                                               'params' => 'class="productListing-data" width="165"',
                                               'text'  => $lc_text);                                       
                                               
		} else {
		
        $list_box_contents[$cur_row][] = array('align' => 'left',
                                               'params' => 'class="productListing-data" width="435"',
                                               'text'  => $lc_text);		
		
		}
		
		
		
      	$list_box_contents[$cur_row + 1][0] = array('params' => 'colspan="2"',
      												'text'  => '<div class="Product_Separator"></div>');		

      }
      
     // EOF custom if statement to suppress manufacturer product listings 
     } 

    }
	
    new productListingBox($list_box_contents);
    
  } else {
    $list_box_contents = array();

    $list_box_contents[0] = array('params' => 'class="productListing-odd"');
    $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                   'text' => TEXT_NO_PRODUCTS);

    new productListingBox($list_box_contents);
  }

//}

  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

<div id="content_space">
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
  </tr>
</table>
</div>
<?php
  }
?>
