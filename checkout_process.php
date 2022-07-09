<?php
/*
  $Id: checkout_process.php 1750 2007-12-21 05:20:28Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/classes/http_client.php');
  require('alt_courses/db/mysql2.php');
  require('alt_courses/lib/util.php');

// BOF: WebMakers.com Added: Downloads Controller - Free Shipping
// Reset $shipping if free shipping is on and weight is not 0
if (tep_get_configuration_key_value('MODULE_SHIPPING_FREESHIPPER_STATUS') and $cart->show_weight()!=0) {
  tep_session_unregister('shipping');
}
// EOF: WebMakers.com Added: Downloads Controller - Free Shipping


// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!tep_session_is_registered('shipping') || !tep_session_is_registered('sendto')) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

  if ( (tep_not_null(MODULE_PAYMENT_INSTALLED)) && (!tep_session_is_registered('payment')) ) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
 }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);

// load selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
    }
  }

  $payment_modules->update_status();

  if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;

  $order_totals = $order_total_modules->process();

// load the before_process function from the payment modules
  $payment_modules->before_process();

  $sql_data_array = array('customers_id' => $customer_id,
                          'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
                          'customers_title' => $order->customer['customers_title'],
                          'customers_company' => $order->customer['company'],
                          'customers_street_address' => $order->customer['street_address'],
                          'customers_suburb' => $order->customer['suburb'],
                          'customers_city' => $order->customer['city'],
                          'customers_postcode' => $order->customer['postcode'],
                          'customers_state' => $order->customer['state'],
                          'customers_country' => $order->customer['country']['title'],
                          'customers_telephone' => $order->customer['telephone'],
                          'customers_email_address' => $order->customer['email_address'],
                          'customers_address_format_id' => $order->customer['format_id'],
 // PWA BOF
                          'customers_dummy_account' => $order->customer['is_dummy_account'],
 // PWA EOF
                          'delivery_name' => trim($order->delivery['firstname'] . ' ' . $order->delivery['lastname']),
                          'delivery_company' => $order->delivery['company'],
                          'delivery_street_address' => $order->delivery['street_address'],
                          'delivery_suburb' => $order->delivery['suburb'],
                          'delivery_city' => $order->delivery['city'],
                          'delivery_postcode' => $order->delivery['postcode'],
                          'delivery_state' => $order->delivery['state'],
                          'delivery_country' => $order->delivery['country']['title'],
                          'delivery_address_format_id' => $order->delivery['format_id'],
                          'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
                          'billing_company' => $order->billing['company'],
                          'billing_street_address' => $order->billing['street_address'],
                          'billing_suburb' => $order->billing['suburb'],
                          'billing_city' => $order->billing['city'],
                          'billing_postcode' => $order->billing['postcode'],
                          'billing_state' => $order->billing['state'],
                          'billing_country' => $order->billing['country']['title'],
                          'billing_address_format_id' => $order->billing['format_id'],
                          'payment_method' => $order->info['payment_method'],
                          'cc_type' => $order->info['cc_type'],
                          'cc_owner' => $order->info['cc_owner'],
                          'cc_number' => $order->info['cc_number'],
                          'cc_expires' => $order->info['cc_expires'],
                          'date_purchased' => 'now()',
                          'orders_status' => $order->info['order_status'],
                          'currency' => $order->info['currency'],
                          'currency_value' => $order->info['currency_value']);
  tep_db_perform(TABLE_ORDERS, $sql_data_array);
  $insert_id = tep_db_insert_id();
  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
    $sql_data_array = array('orders_id' => $insert_id,
                            'title' => $order_totals[$i]['title'],
                            'text' => $order_totals[$i]['text'],
                            'value' => $order_totals[$i]['value'],
                            'class' => $order_totals[$i]['code'],
                            'sort_order' => $order_totals[$i]['sort_order']);
    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
  }

  $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
  $sql_data_array = array('orders_id' => $insert_id,
                          'orders_status_id' => $order->info['order_status'],
                          'date_added' => 'now()',
                          'customer_notified' => $customer_notification,
                          'comments' => $order->info['comments']);
  tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

$onlineCourse = array();
$onlineCourseName = array();

// initialized for the email confirmation
  $products_ordered = '';
  $subtotal = 0;
  $total_tax = 0;

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
// Stock Update - Joao Correia
    if (STOCK_LIMITED == 'true') {
      if (DOWNLOAD_ENABLED == 'true') {
        $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                            FROM " . TABLE_PRODUCTS . " p
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                             ON p.products_id=pa.products_id
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                             ON pa.products_attributes_id=pad.products_attributes_id
                            WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
        $products_attributes = $order->products[$i]['attributes'];
        if (is_array($products_attributes)) {
          $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
        }
        $stock_query = tep_db_query($stock_query_raw);
      } else {
        $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
      }
      if (tep_db_num_rows($stock_query) > 0) {
        $stock_values = tep_db_fetch_array($stock_query);
// do not decrement quantities if products_attributes_filename exists
        if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
          $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
        } else {
          $stock_left = $stock_values['products_quantity'];
        }
        tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
        if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
          tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
        }
      }
    }

// Update products_ordered (for bestsellers list)
    tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");

    $sql_data_array = array('orders_id' => $insert_id,
                            'products_id' => tep_get_prid($order->products[$i]['id']),
                            'products_model' => $order->products[$i]['model'],
                            'products_name' => $order->products[$i]['name'],
                            'products_price' => $order->products[$i]['price'],
                            'final_price' => $order->products[$i]['final_price'],
                            'products_tax' => $order->products[$i]['tax'],
                            'products_quantity' => $order->products[$i]['qty']);
    tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
    $order_products_id = tep_db_insert_id();

//------insert customer choosen option to order--------
    $attributes_exist = '0';
    $products_ordered_attributes = '';
    if (isset($order->products[$i]['attributes'])) {
      $attributes_exist = '1';
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        if (DOWNLOAD_ENABLED == 'true') {
          $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                on pa.products_attributes_id=pad.products_attributes_id
                               where pa.products_id = '" . $order->products[$i]['id'] . "'
                                and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                and pa.options_id = popt.products_options_id
                                and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                and pa.options_values_id = poval.products_options_values_id
                                and popt.language_id = '" . $languages_id . "'
                                and poval.language_id = '" . $languages_id . "'";
          $attributes = tep_db_query($attributes_query);
        } else {
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
        }
        $attributes_values = tep_db_fetch_array($attributes);
// BOF Option Type Feature
$attr_name = $attributes_values['products_options_name'];

        if ($attributes_values['products_options_id'] == PRODUCTS_OPTIONS_VALUE_TEXT_ID) {
          $attr_name_sql_raw = 'SELECT po.products_options_name FROM ' .
            TABLE_PRODUCTS_OPTIONS . ' po, ' .
            TABLE_PRODUCTS_ATTRIBUTES . ' pa WHERE ' .
            ' pa.products_id="' . tep_get_prid($order->products[$i]['id']) . '" AND ' .
            ' pa.options_id="' . $order->products[$i]['attributes'][$j]['option_id'] . '" AND ' .
            ' pa.options_id=po.products_options_id AND ' .
            ' po.language_id="' . $languages_id . '" ';
          $attr_name_sql = tep_db_query($attr_name_sql_raw);
          if ($arr = tep_db_fetch_array($attr_name_sql)) {
            $attr_name  = $arr['products_options_name'];
          }
        }
//EOF Option Type Feature
        $sql_data_array = array('orders_id' => $insert_id,
                                'orders_products_id' => $order_products_id,
                                // BOF Option Type Feature
                                //'products_options' => $attributes_values['products_options_name'],
                                //'products_options_values' => $attributes_values['products_options_values_name'],
                                'products_options' => $attr_name,
                                'products_options_values' => $order->products[$i]['attributes'][$j]['value'],
                                // EOF Option Type Feature
                                'options_values_price' => $attributes_values['options_values_price'],
                                'price_prefix' => $attributes_values['price_prefix']);
        tep_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

        if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
          $sql_data_array = array('orders_id' => $insert_id,
                                  'orders_products_id' => $order_products_id,
                                  'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                  'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                  'download_count' => $attributes_values['products_attributes_maxcount']);
          tep_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
        }
        $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
      }
    }

    // START: Add products extra fields to order email -- MUST EDIT WITH CONDITIONAL FOR RESTRICTING TO CREDIT CARD AND VOUCHER PAYMENTS
    $products_ordered_extra_fields = '';
    $extra_fields_query = tep_db_query("
                    SELECT pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                    FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
                    LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
                    ON ptf.products_extra_fields_id = pef.products_extra_fields_id
                    WHERE ptf.products_id = " . tep_get_prid($order->products[$i]['id']) . " AND ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
                    ORDER BY products_extra_fields_order");

    while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {

    	if ($extra_fields['name'] != 'Product Summary') {

          $products_ordered_extra_fields .= "\n\t" . $extra_fields['name'] . ': ' . $extra_fields['value'];
        }
    }
    // END: Add products extra fields to order email

//------insert customer choosen option eof ----
    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
    $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
    $total_cost += $total_products_price;

$solWebinarPurchased = false;
// $onlineCourse = array();

// START: Add products extra fields to order email
// if ($products_ordered_extra_fields != '') {

//    if ($order->info['payment_method'] == 'Credit Card' || ($order->info['payment_method'] == 'Manufacturer Credit <font style="font-weight:normal"> - required information must be supplied</font>' && $order->info['comments'])) {


// 	   // START: Add products extra fields to order email
// 				  $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . $products_ordered_extra_fields . EMAIL_ONLINECOURSE_PAID_TEXT . "\n";
// 	   // END: Add products extra fields to order email

// 	   //if($order->products[$i]['id'] == '113') { $solWebinarPurchased = true; }
//      //if($order->products[$i]['model'] != '') { $onlineCourse = true; }
//    }

//    else {

// 	   $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . EMAIL_ONLINECOURSE_UNPAID_TEXT . "\n";

// 	   //if($order->products[$i]['id'] == '113') { $solWebinarPurchased = true; }
//      //if($order->products[$i]['model'] != '') { $onlineCourse = true; }
//    }

// }

// else {

    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";

    //if($order->products[$i]['id'] == '113') { $solWebinarPurchased = true; }
    //if($order->products[$i]['model'] != '') { $onlineCourse = true; }
// }
// END: Add products extra fields to order email

if($order->products[$i]['id'] == '113') { $solWebinarPurchased = true; }
if($order->products[$i]['model'] != '') {  $onlineCourseAddId = $order->products[$i]['model']; $onlineCourseAddName = strip_tags($order->products[$i]['name']); array_push( $onlineCourse, $onlineCourseAddId ); array_push( $onlineCourseName, $onlineCourseAddName );  }


$check_customer_password_query = tep_db_query("select customers_password from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
$check_customer_password = tep_db_fetch_array($check_customer_password_query);

          //if (tep_validate_password($password_current, $check_customer['customers_password']))




// Get 1 free
    // If this product qualifies for free product(s) add the free products
    if (is_array ($free_product = $cart->get1free ($products_id))) {
      // Update products_ordered (for bestsellers list)
      //   comment out the next line if you don't want free products in the bestseller list
      tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $free_product['quantity']) . " where products_id = '" . tep_get_prid($free_product['id']) . "'");

      $sql_data_array = array('orders_id' => $insert_id,
                              'products_id' => $free_product['id'],
                              'products_model' => $free_product['model'],
                              'products_name' => $free_product['name'],
                              'products_price' => 0,
                              'final_price' => 0,
                              'products_tax' => '',
                              'products_quantity' => $free_product['quantity']
                             );
      tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

      $total_weight += ($free_product['quantity'] * $free_product['weight']);
    }
// end Get 1 free



  }


//add a els user and an online course/exam
if(count($onlineCourse>0)) {

      // if ($order->info['payment_method'] == 'Credit Card') {
      //   $quiz_status="1";
      // } else {
      //   $quiz_status="0";
      // }

  $UserID_query = tep_db_query("select * from v_imported_users where UserID = '" . $customer_id . "'");

  if (!tep_db_num_rows($UserID_query)) {

    $sql_data_array = array('UserID' => $customer_id,
                            'Name' => $order->customer['firstname'],
                            'Surname' => $order->customer['lastname'],
                            'customers_title' => $order->customer['customers_title'],
                            'email' => $order->customer['email_address'],
                            'UserName' => $order->customer['email_address'],
                            'Password' => $check_customer_password['customers_password'],
                            );

    tep_db_perform('v_imported_users', $sql_data_array);

  }

foreach ($onlineCourse as $key => $value) {
  // echo $key.":<br>";
  // echo $value;

      if ($value == "109") {
        $pass_score="21";
      } else {
        $pass_score="35";
      }

      // if ($value === "111") { $value="106"; }

  $query = array(
      "quiz_id"=>$value,
      "results_mode"=>"1",
      "added_date"=>util::Now(),
      //"quiz_time"=>trim($_POST["txtTestTime"]),
      "show_results"=>"1",
      "org_quiz_id"=>$value,
      "pass_score"=>$pass_score,
      "quiz_type"=>"1",
      //"quiz_type"=>$_POST["drpType"],
      "status"=>"1",
      "qst_order"=>"1",
      "answer_order"=>"1",
      "allow_review"=>"1",
      "limited"=>"3",
      "affect_changes"=>"2",
      "send_results"=>"1",
      "accept_new_users"=>"2"
     );
    tep_db_perform('assignments', $query);
    $asg_id = mysql_insert_id();

    $sql_data_array = array("assignment_id"=>$asg_id,
       "user_type"=>"2",
       "user_id"=>$customer_id
    );

    tep_db_perform('assignment_users', $sql_data_array);
  }


}

// lets start with the email confirmation
  $email_order = EMAIL_TEXT_LETTER_INTRO .

  				 //STORE_NAME . "\n" .
                 EMAIL_SEPARATOR . "\n" .
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
                 EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false) . "\n" .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
 // PWA BOF
  if ($order->customer['is_dummy_account']) {
    $email_order .= EMAIL_WARNING . "\n\n";
  }
  // PWA EOF
  if ($order->info['comments']) {
    $email_order .= "Comments: " . tep_db_output($order->info['comments']) . "\n\n";
  }
    if ($order->info['how_referred']) {
    $email_order .= "How you heard about us: " . tep_db_output($order->info['how_referred']) . "\n\n";
  }

  $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  $products_ordered .
                  EMAIL_SEPARATOR . "\n";

  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
    $email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
  }

  if ($order->content_type != 'virtual') {
    $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .
                    EMAIL_SEPARATOR . "\n" .
                    tep_address_label($customer_id, $sendto, 0, '', "\n") . "\n";
  }


  //if (count($onlineCourse) > 0) { $courseOutput = print_r($onlineCourse, true); $email_order .= $courseOutput; } else { $email_order .= "\nNope.\n"; }

  $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                  EMAIL_SEPARATOR . "\n" .
                  tep_address_label($customer_id, $billto, 0, '', "\n") . "\n\n";

  $email_order .= "Email Address\n" .
                  EMAIL_SEPARATOR . "\n" .
                  $order->customer['email_address'] . "\n\n";

  //if ($order->customer['telephone'] != '') {
  $email_order .= "Phone Number\n" .
                  EMAIL_SEPARATOR . "\n" .
                  $order->customer['telephone'] . "\n\n";
                  count($onlineCourse) . "\n\n";
  //}

  if (is_object($$payment)) {
    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
                    EMAIL_SEPARATOR . "\n";
    $payment_class = $$payment;
    $email_order .= $order->info['payment_method'] . "\n\n";
    if ($payment_class->email_footer) {
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }

  $email_order .= EMAIL_TEXT_LETTER_BODY;

  tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

//send online course purchase email
array_filter($onlineCourse);
  if ( !empty($onlineCourse) ) {
      $email_onlineCourse_order = "<div style=\"text-align:center;width:auto;\"><img src=\"http://shop.advancedlasertraining.com/images/alt_letter_logo.png\" /></div>";
      $email_onlineCourse_order .= "<p>Dear " . $order->customer['firstname'] . " " . $order->customer['lastname'].",</p> <p><strong>Thank you</strong> for choosing Advanced Laser Training. You have registered for the following online course(s):</p> ";
      $email_onlineCourse_order .= "<p><strong>Course Name(s): </strong>" . implode(",", $onlineCourseName) . " <br /> <strong>Continuing Education Credits:</strong> 8 AGD/PACE Approved CE creditsCertification: World Clinical Laser Institute (WCLI) Associate Fellowship Certification <br /> <strong>Full Name: </strong>".$order->customer['firstname'] . " " . $order->customer['lastname']."<br /> <strong>Login:</strong> ". $order->customer['email_address'] ."<br /> <strong>Password:</strong> same password used to login at shop.advancedlasertraining.com </p>";
      $email_onlineCourse_order .= "<p>To join the course please click on the link below and enter your password:<br /> <a href=\"http://shop.advancedlasertraining.com/alt_courses/\" target=\"_blank\">http://shop.advancedlasertraining.com/alt_courses/</a></p> <p>You can access the course and view the materials from any high speed computer. You can watch the videos at your own pace as well as pause, rewind or fast forward the videos.  The course handouts have been scanned and are available as a color PDF document that can be viewed on your computer or printed out. You can watch the segments as many times as you like and the course will be open to you until you submit and pass the exam or six months from the original date of purchase. After viewing all of the materials you take the test online. Once you have successfully passed the test you will be able to print your CE Letter and WCLI Certificate.</p><p>If you have any other staff members you would like to register, we can offer you special one-time pricing of $100 per registrant.  Just give us a call or visit our website and we can help you get them registered. You have up to 3 months from today to take advantage of this great one time offer. Normal price for this course is $795 per person.</p> <p>If you refer a colleague who registers for one or more of our online or live courses we will send you a $50 Visa Gift Card for each registration as our thank you for the referral.</p> <p>If you have any questions or need support please call 877-LASER 66 (527-3766) or email <a href=\"mailto:MOwens@AdvancedLaserTraining.com\" target=\"_blank\">MOwens@AdvancedLaserTraining.com</a>. Thank you for your business please enjoy the course,</p> <p><strong>Malia Owens</strong><br /> <strong>Advanced Laser Training, Inc.</strong><br /> <strong>Vice President Sales and Marketing</strong><br /> 2651 Quarry Lane<br /> Fayetteville, AR 72704<br /> 877-527-3766 Toll Free<br /> 479-361-8853 Local/ Canada Callers<br /> 479-419-5598 Fax<br /> 949-945-3938 Cell<br /> <a href=\"mailto:MOwens@AdvancedLaserTraining.com\ target=\"_blank\">MOwens@AdvancedLaserTraining.com</a></p> <p>ATTENTION: This email address was given to us by someone who visited our online store. If this was not done by you please email us at <a href=\"mailto:mowens@advancedlasertraining.com\" target=\"_blank\">mowens@advancedlasertraining.com</a></p>";
      tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT_ONLINE_COURSE, $email_onlineCourse_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }



// send SOL Webinar purchase email
  if ($solWebinarPurchased) {
  	tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT_SOL, EMAIL_TEXT_LETTER_SOL, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }

// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
    tep_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }

// load the after_process function from the payment modules
  $payment_modules->after_process();

  $cart->reset(true);

// unregister session variables used during checkout
  tep_session_unregister('sendto');
  tep_session_unregister('billto');
  tep_session_unregister('shipping');
  tep_session_unregister('payment');
  tep_session_unregister('comments');
  tep_session_unregister('how_referred');

  // PWA BOF 2b
  if (tep_session_is_registered('customer_is_guest')){
    //delete the temporary account
    tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  }
  // PWA EOF 2b

  tep_redirect(tep_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
