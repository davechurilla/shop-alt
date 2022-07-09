<?php
  class ot_cat_qvb_discount {
    var $title, $output, $discounts, $deduction, $tax_amount;

    function ot_cat_qvb_discount() {
      $this->code = 'ot_cat_qvb_discount';
      $this->title = MODULE_CAT_QVB_DISCOUNT_TITLE;
      $this->description = MODULE_CAT_QVB_DISCOUNT_DESCRIPTION;
      $this->enabled = ((MODULE_CAT_QVB_DISCOUNT_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_CAT_QVB_DISCOUNT_SORT_ORDER;
      $this->output = array();
      $this->discounts = array();
    }
    
    function process() {
      global $order, $ot_subtotal;

      $this->deduction = 0;                  // no deductions yet
      $this->tax_amount = 0;                 // no deductions yet
      $this->fill_category_discount_array(); // fill the discount definitions
      $this->add_cart_info();                // add the cart information
      $this->set_breaks();                   // determine the break index
      $this->process_discounts();            // set the discounts
      $order->info['total'] -= $this->deduction;
      $order->info['tax'] -= $this->tax_amount;
      if ($this->sort_order < $ot_subtotal->sort_order) $order->info['subtotal'] -= $this->deduction;
    }

// fill the discount information table
function fill_category_discount_array () {
  global $cart;

  $category_discount_definitions = split(',',MODULE_CAT_QVB_DISCOUNT_RATES);
  $n = sizeof($category_discount_definitions);
  for ($c = 0; $c < $n; $c++) {
    $category_discount_parts = split(':',$category_discount_definitions[$c]);
    $this->discounts[$c]['category'] = $category_discount_parts[0];
    $this->discounts[$c]['dc_type']  = $category_discount_parts[1];
    $this->discounts[$c]['th_type']  = $category_discount_parts[2];
    $this->discounts[$c]['cart']     = 0;
    $this->discounts[$c]['value']    = 0;
    $this->discounts[$c]['tax']      = 0;
    $this->discounts[$c]['index']    = -1;
    $breaks = split(';', $category_discount_parts[3]);
    $m = sizeof($breaks);
    $index = 0;
    for ($b = 0; $b < $m; $b+=2) {
      $this->discounts[$c]['breaks'][$index]['threshold'] = $breaks[$b];
      $this->discounts[$c]['breaks'][$index]['amount']    = $breaks[$b+1];
      $index++;
    }
  }
}

// add the cart information
function add_cart_info () {
  global $cart;

  $products = $cart->get_products();
  $pn = sizeof($products);
  for ($p=0; $p<$pn; $p++) {
    $t_prid = tep_get_prid($products[$p]['id']);
    $products_tax = tep_get_tax_rate($products[$p]['tax_class_id']);
    $cat_query = tep_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $t_prid . "'");
    $cat_result = tep_db_fetch_array($cat_query); 
    $n = sizeof($this->discounts);
    for ($i=0; $i<$n; $i++) {
      if ($this->cat_under_cat($this->discounts[$i]['category'],$cat_result['categories_id'])) {
        $this->discounts[$i]['cart'] = $this->discounts[$i]['cart'] + $cart->get_quantity($products[$p]['id']);
        $this->discounts[$i]['value'] = $this->discounts[$i]['value'] + ($products[$p]['price']+$products_tax)*$cart->get_quantity($products[$p]['id']);
        $this->discounts[$i]['tax'] = $this->discounts[$i]['tax'] + ($products[$p]['price']*$products_tax/100);
        $this->tax_amount = $this->tax_amount + $this->discounts[$i]['tax'];
      }
    }
  }
}

// determine the break index based on category quantity or value
function set_breaks () {

  $n = sizeof($this->discounts);
  for ($x=0; $x<$n; $x++) {
    if ($this->discounts[$x]['th_type']  == 'Q') { // quantity or value
      $this->discounts[$x]['index'] = $this->determine_break_index($this->discounts[$x]['cart'], $this->discounts[$x]['breaks']); // break on quantity
    } else {
      $this->discounts[$x]['index'] = $this->determine_break_index($this->discounts[$x]['value'], $this->discounts[$x]['breaks']); // break on value
    }
  }
}

function determine_break_index ($amount, $breaks) {
 $break_index = -1;
 $n = sizeof($breaks);
  for ($b=0; $b<$n; $b++) {
      if ($amount >= $breaks[$b]['threshold']) $break_index = $b;
  }
  return $break_index;
}


function process_discounts () {

  $n = sizeof($this->discounts);
  for ($x=0; $x<$n; $x++) {
    if ($this->discounts[$x]['index'] > -1) { // break found
        $this->set_discounts($this->discounts[$x]['category'], $this->discounts[$x]['dc_type'], $this->discounts[$x]['th_type'], $this->discounts[$x]['cart'], $this->discounts[$x]['value'], $this->discounts[$x]['breaks'][$this->discounts[$x]['index']]['threshold'], $this->discounts[$x]['breaks'][$this->discounts[$x]['index']]['amount']);
    }
  }
}

// set the discount output based on type
function set_discounts ($category, $dc_type, $th_type, $cart_amount, $value, $threshold, $discount_amount) {
  global $currencies;
  
  if ($th_type != 'Q') $cart_amount = $currencies->format($value);
  $this->output[] = array('title' => $this->discount_message($category, $dc_type, $th_type, $threshold, $discount_amount).' ['.$cart_amount.']:',
                          'text' =>  sprintf(MODULE_CAT_QVB_DISCOUNT_FORMATED_TEXT, $currencies->format($this->discount_amount($dc_type, $th_type, $cart_amount, $value, $threshold, $discount_amount))),
                          'value' => $discount_amount);
  $this->deduction = $this->deduction + $this->discount_amount($dc_type, $th_type, $cart_amount, $value, $threshold, $discount_amount);
}

function discount_message ($category, $dc_type, $th_type, $threshold, $discount_amount) {
  global $currencies;

  if ($th_type != 'Q') $threshold = 'for ' . $currencies->format($threshold);
  switch($dc_type) {
    case 'MS' : $message = sprintf(CAT_QVB_DISC_MSG_MS,$threshold,$this->cat_name($category),$currencies->format($discount_amount));break;
    case 'MM' : $message = sprintf(CAT_QVB_DISC_MSG_MM,$threshold,$this->cat_name($category),$currencies->format($discount_amount));break;
    case 'ME' : $message = sprintf(CAT_QVB_DISC_MSG_ME,$threshold,$this->cat_name($category),$currencies->format($discount_amount));break;
    case 'IM' : $message = sprintf(CAT_QVB_DISC_MSG_IM,$threshold,$this->cat_name($category),$discount_amount);break;
    case 'PE' : $message = sprintf(CAT_QVB_DISC_MSG_PE,$threshold,$this->cat_name($category),$discount_amount);break;
  }
  return $message;
}

function discount_amount ($dc_type, $th_type, $cart_amount, $value, $threshold, $discount_amount) {

  if ($th_type != 'Q') $cart_amount = $value;
  switch($dc_type) {
    case 'MS' : $od_amount = $discount_amount;break;
    case 'MM' : $od_amount = $discount = floor(($cart_amount / $threshold)) *  $discount_amount;break;
    case 'ME' : $od_amount = $cart_amount * $discount_amount;break;
    case 'IM' : $od_amount = floor(($cart_amount / $threshold)) * ($value/$cart_amount) * $discount_amount;break;
    case 'PE' : $od_amount = ($value * $discount_amount / 100);break;
  }
  return $od_amount;
}


function cat_name ($cat_id) {
  global $languages_id;

  $cat_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . "  
                             where categories_id = '".$cat_id."' 
                               and language_id = '" . (int)$languages_id . "'");
  $cat = tep_db_fetch_array($cat_query);
  return $cat['categories_name'];
}

function cat_under_cat ($cat1, $cat2) {
 $cat_path = tep_get_cat_path($cat2);
 $cat_path_array = split("_" , $cat_path);
 if (in_array ($cat1,$cat_path_array)) {
   return true;
 } else {
   return false;
 }
}


// returns all breaks for the category if present
function breaks ($catid) {

  $this->fill_category_discount_array();
  $n = sizeof($this->discounts);
  for ($c=0; $c<$n; $c++) {
    if ($this->cat_under_cat($this->discounts[$c]['category'],$catid)) {
      return $this->discounts[$c]['breaks'];
    }
  }
}

function teaser ($catid, $multiple = true, $all = true) {

  $teaser = '';
  $this->fill_category_discount_array();
  $this->add_cart_info();
  $this->set_breaks();
  $n = sizeof($this->discounts);
  for ($c=0; $c<$n; $c++) {
    if ($this->cat_under_cat($this->discounts[$c]['category'],$catid)) {
      $bn = sizeof($this->discounts[$c]['breaks']);
      // what teasers to show, all (including already qualified) or just all next or just 1 next
      if ($all) { // show all breaks
         $bg = 0;
      } else { // start by showing the next
         $bg = $this->discounts[$c]['index']+1;
      }
      if ($multiple) { // show all breaks
        $bl = $bn;
      } else {  // show only the next break
        $bl = $this->discounts[$c]['index']+2;
      }
      for ($b=$bg; $b<$bl; $b++) {
        $teaser .= $this->discount_message($catid, $this->discounts[$c]['dc_type'],$this->discounts[$c]['th_type'],$this->discounts[$c]['breaks'][$b]['threshold'],$this->discounts[$c]['breaks'][$b]['amount']).'<br>';
      }
    }
  }
  if ($teaser !='') {
  return 
  '<tr>
    <td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td>
   </tr>
   <tr>
    <td>
     <table width=100% class="borderGray" cellpadding="4">
      <tr>
       <td class="discountHead" nowrap>'.$this->cat_name($catid).' Offer</td>
       <td align="center" width="100%" class="discountMain" bgcolor="#ffffe0">'.$teaser.'</td>
      </tr>
     </table>
    </td>
   </tr>
   <tr>
    <td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td>
   </tr>';
   } else {
     return '';
   }
}

// display the discounts in the cart
function display_discounts () {

  $this->fill_category_discount_array(); // fill the discount definitions
  $this->add_cart_info();                // add the cart information
  $this->set_breaks();                   // determine the break index
  $this->process_discounts();            // set the discounts
  $n = sizeof($this->output);
  for ($x=0; $x<$n; $x++) {
    echo '<tr><td align="right">'.$this->output[$x]['title'].'</td><td align="right">'.$this->output[$x]['text'].'</td></tr>';
  }
  return $this->deduction;
}


    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value 
                                     from " . TABLE_CONFIGURATION . " 
                                     where configuration_key = 'MODULE_CAT_QVB_DISCOUNT_STATUS'");
        $this->check = mysql_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_CAT_QVB_DISCOUNT_STATUS', 'MODULE_CAT_QVB_DISCOUNT_SORT_ORDER', 'MODULE_CAT_QVB_DISCOUNT_RATES');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values 
    ('Activate Category Quantity Discount', 'MODULE_CAT_QVB_DISCOUNT_STATUS', 'true', 'Do you want to enable the category quantity discount module?', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values 
    ('Sort Order', 'MODULE_CAT_QVB_DISCOUNT_SORT_ORDER', '2', 'Sort order of display.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values 
    ('Discount Rates', 'MODULE_CAT_QVB_DISCOUNT_RATES', '21:MS:Q:1;200;2;400;3;500,28:MM:Q:1;10;3;20,206:MS:Q:1;200;2;400;3;500;4;600;5;700;5;800,93:IM:Q:10;1,102:IM:Q:10;2,207:MS:V:1400;100;2800;200', 'The discount is based on the number of items in the same category tree or their value.', '6', '5', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }

?>