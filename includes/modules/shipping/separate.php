<?php
/*
  $Id: separate.php 1850 2014-01-11 00:52:16Z hpdl $
  Ver: 1.85
  
  ======================== Made for osCommerce 2.2 rc2=============
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
 
  Copyright (c) 2013 Robert Petet [rpetet] of http://r-pdesign.com and Brett Gowler [WebDev22] of http://wolfftanning.com 
   
  Loosely based  on tables.php  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
 
 

*/


// need to check that we are on the right page to use the following if then statement
$page = htmlentities($_SERVER['PHP_SELF']);




// if statement added so "can't redeclare objectInfo" conflict  doesn't arise in admin area
//thanks goes out to burt for his suggestion in the following line

if ( $page == DIR_WS_HTTP_CATALOG . FILENAME_CHECKOUT_SHIPPING  ){

// used so module can use function objectInfo in  checkout_shipping.php 
 class objectInfo {

// added from admin
    function objectInfo($object_array) {
      reset($object_array);
      while (list($key, $value) = each($object_array)) {
        $this->$key = tep_db_prepare_input($value);
      }
    }
  }
}
  class separate {
    var $code, $title, $description, $icon, $enabled;
	
// class constructor
   
	
    function separate() {
      global $order, $products, $cart;

      $this->code = 'separate';
      $this->title = MODULE_SHIPPING_SEPARATE_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_SEPARATE_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_SEPARATE_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_SEPARATE_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_SEPARATE_STATUS == 'True' ? true : false));
      $this->api_version = '1.81';
      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_SEPARATE_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_SEPARATE_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
	  while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }
}		
     

	//ship by product
	 elseif(MODULE_SHIPPING_SEPARATE_SETTING != ''){

	$check_flag = true;          
	
}
elseif(MODULE_SHIPPING_SEPARATE_STATUS_FLAT != ''){
	$check_flag = true; 
}
     

        if ($check_flag == false) {
          $this->enabled = false;
        }
      
 } 
  
	
// class methods
    function quote($method = '') {
      global $order, $cart, $shipping_weight, $shipping_num_boxes, $customer_id, $products_id;
	  $ind_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_IND'");
	  $mode_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_DEFAULT_MODE'"       );
	  $inh_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_INHERIT'");
	  if ($mode_query !=''){
	  $mode = tep_db_fetch_array($mode_query);
	  }
	  if ($ind_query !=''){
		$ind = tep_db_fetch_array($ind_query);
		}
	  if ($inh_query !=''){
		$inh = tep_db_fetch_array($inh_query);
		}

/* user logic so that ONLY if a default rate is set AND ind rates is set to yes results are given for only those products that are individual otherwise
  use default rates OR use individual rates */ 
  
	if ($mode['configuration_value'] != 'No' and $ind['configuration_value'] == 'Yes'){
		
	  //separate querys for flat or tbl 
	  //independent flat query for products/categories $status_query
	  $status_query = tep_db_query("select distinct sr.p_id, `p_rate`, p_free, p_status, p_per, (p_rate * cb.customers_basket_quantity) as p_qty, sr.c_id, `c_rate`, c_free, c_status, c_per,(c_rate * cb.customers_basket_quantity ) as c_qty, cb.customers_basket_quantity as quantity, sm.p_sep, sm.c_sep from " . TABLE_SHIPPING_RATES . " sr, (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id) inner join ". TABLE_SHIPPING_MODE ." sm where (p_status = '1' or  c_status = '1' ) and (cb.products_id = sr.p_id or ptc.categories_id = sr.c_id) and (p_free = '0' and c_free = '0') and (sm.p_id = sr.p_id and sr.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '1' or sm.c_mode = '2') or (sm.p_mode = '1' or sm.p_mode = '2')) ");
	  
	  // independent tbl query for products'/ category's[qty]  $status_query2
	  
	   $status_query2 = tep_db_query("select distinct str.p_id, `p_tbl`, p_stat, p_ind,(p_tbl * cb.customers_basket_quantity) as p_qty_tbl, str.c_id, `c_tbl`, c_stat, c_ind, (c_tbl * cb.customers_basket_quantity ) as c_qty_tbl, cb.customers_basket_quantity as quantity, cb.customers_basket_id from " . TABLE_SHIPPING_TABLE_RATES . " str, (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id) inner join ". TABLE_SHIPPING_MODE ." sm where (p_stat = '1' or c_stat = '1') and cb.products_id = str.p_id or ptc.categories_id = str.c_id and (cb.customers_basket_quantity <= p_qty xor cb.customers_basket_quantity <= c_qty) and (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by str.p_id, str.c_id");
	   
	   // independent tbl query for products'/ category's [weight] $status_query2a
	   $status_query2a = tep_db_query("select distinct str.p_id, `p_tbl`, p_stat, p_ind,  min(round(p.products_weight,0) * p_tbl) as pound_p, (min(round(p.products_weight,0) * p_tbl)*cb.customers_basket_quantity) as pound_per_p, str.c_id, `c_tbl`, c_stat, c_ind,  min(round(p.products_weight,0) * c_tbl) as pound_c, (min(round(p.products_weight,0) * c_tbl)*cb.customers_basket_quantity) as pound_per_c, round(p.products_weight,0) as pound  from " . TABLE_SHIPPING_TABLE_RATES . " str, (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id) inner join ". TABLE_PRODUCTS . " p on (p.products_id = cb.products_id) inner join ". TABLE_SHIPPING_MODE ." sm where (p_stat = '1' or c_stat = '1') and cb.products_id = str.p_id or ptc.categories_id = str.c_id and (round(p.products_weight,0) <= p_qty xor round(p.products_weight,0) <= c_qty) and (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by str.p_id, str.c_id");
	   
	   // independent tbl query for products'/categories'[price] $status_query3
	  $status_query3 = tep_db_query("select distinct p.products_id, str.p_id, `p_qty`, `p_tbl`, p_ind, (p_tbl * cb.customers_basket_quantity) as tbl_price_p, str.c_id, `c_qty`, `c_tbl`, c_ind, (c_tbl * cb.customers_basket_quantity) as tbl_price_c, cb.customers_basket_quantity from " . TABLE_SHIPPING_TABLE_RATES . " str inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.customers_id='" . $customer_id ."' ) inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on ( ptc.products_id = cb.products_id) inner join  ". TABLE_PRODUCTS . " p on (p.products_id = str.p_id or str.p_id = '0') and (p.products_price <= p_qty or p.products_price <= c_qty) and (p_stat = '1' or c_stat = '1') inner join ". TABLE_SHIPPING_MODE ." sm where cb.products_id = str.p_id or ptc.categories_id = str.c_id and (p.products_id = ptc.products_id and ptc.categories_id = str.c_id)and (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by str.p_id, str.c_id");
      	  
	 
	 } else {
	 //flat query for products/categories $status_query
	 $status_query = tep_db_query("select distinct p_id, `p_rate`, p_free, p_status, p_per, (p_rate * cb.customers_basket_quantity) as p_qty, c_id, `c_rate`, c_free, c_status, c_per,(c_rate * cb.customers_basket_quantity ) as c_qty, cb.customers_basket_quantity from " . TABLE_SHIPPING_RATES . " , (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id) where (p_status = '1' or  c_status = '1' ) and (cb.products_id = p_id or ptc.categories_id = c_id) and (p_free = '0' and c_free = '0')");
	 
	 
	 // need to separate table querys for products/categories & [qty] vs [weight] vs [price]
	 // tbl query for products'/ category's[qty]  $status_query2
	  
	   $status_query2 = tep_db_query("select distinct p_id, `p_tbl`, p_stat, p_ind,(p_tbl * cb.customers_basket_quantity) as p_qty_tbl, c_id, `c_tbl`, c_stat, c_ind, (c_tbl * cb.customers_basket_quantity ) as c_qty_tbl, cb.customers_basket_quantity from " . TABLE_SHIPPING_TABLE_RATES . " , (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id)where (p_stat = '1' or c_stat = '1') and cb.products_id = p_id or ptc.categories_id = c_id and (cb.customers_basket_quantity <= p_qty xor cb.customers_basket_quantity <= c_qty) group by p_id, c_id");
	   
	   // tbl query for products'/ category's [weight] $status_query2a
	   $status_query2a = tep_db_query("select distinct p_id, `p_tbl`, p_stat, p_ind,  min(round(p.products_weight,0) * p_tbl) as pound_p, (min(round(p.products_weight,0) * p_tbl)*cb.customers_basket_quantity) as pound_per_p, c_id, `c_tbl`, c_stat, c_ind,  min(round(p.products_weight,0) * c_tbl) as pound_c, (min(round(p.products_weight,0) * c_tbl)*cb.customers_basket_quantity) as pound_per_c, round(p.products_weight,0) as pound, cb.customers_basket_quantity from " . TABLE_SHIPPING_TABLE_RATES . " str, (select * from ". TABLE_CUSTOMERS_BASKET . " where customers_id='" . $customer_id ."' ) cb inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.products_id = cb.products_id) inner join ". TABLE_PRODUCTS . " p on (p.products_id = cb.products_id)where (p_stat = '1' or c_stat = '1') and cb.products_id = p_id or ptc.categories_id = c_id and (round(p.products_weight,0) <= p_qty xor round(p.products_weight,0) <= c_qty) group by p_id, c_id");
	 
	  // tbl query for products'/categories'[price] $status_query3
	  
	  $status_query3 = tep_db_query("select distinct p.products_id, str.p_id, `p_qty`, `p_tbl`, p_ind, (p_tbl * cb.customers_basket_quantity) as tbl_price_p, str.c_id, `c_qty`, `c_tbl`, c_ind, (c_tbl * cb.customers_basket_quantity) as tbl_price_c, p.products_price as price from " . TABLE_SHIPPING_TABLE_RATES . " str inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.customers_id='" . $customer_id ."' ) inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on ( ptc.products_id = cb.products_id) inner join  ". TABLE_PRODUCTS . " p on (p.products_id = str.p_id or str.p_id = '0') and (p.products_price <= p_qty or p.products_price <= c_qty) and (p_stat = '1' or c_stat = '1') where cb.products_id = p_id or ptc.categories_id = c_id and (p.products_id = ptc.products_id and ptc.categories_id = str.c_id)group by str.p_id, str.c_id");
	}   
	 // arrays for calculations 
	 // cycle through the querys and put values into an array
	
	//Flat results
	if ($status_query != ''){
	while($row = tep_db_fetch_array($status_query)){
     
	 //products
	 if($row["p_sep"] == '1'){
	 $qty_p[] = $row["quantity"];
	 } 
	 if($row["p_per"] == '1'){
	 $p_qty[] = $row["p_qty"] ; 
	 }else{
	 $p_rate[] = $row["p_rate"];
	 }
	 
	 
     //category
	 if($row["c_per"] == '1'){
	 $c_qty[] = $row["c_qty"] ;
	 } else{
	 $c_rate[] = $row["c_rate"];
	 }
	 if($row["c_sep"] == '1'){
	  $qty[] = $row["quantity"];
	 }
	 
	
	}
	}
	if ($status_query2 != ''){
	
	//Table results [qty]
	 while($row = tep_db_fetch_array($status_query2)){
	 
     
	 if($row["p_ind"] == '1'){//product tbl per item 
	 //product
	 $p_qty2[] = $row["p_qty_tbl"];//tbl per item qty
	} else{
	 $p_rate2[] = $row["p_tbl"]; //product tbl qty
	}
	//needed for correct qty
	if ($row["p_sep"] == '1'){
	
	 $tbl_qty_p[] = $row["quantity"];
	 }
	 
	//category
	
	 if($row["c_ind"] == '1'){//category tbl per item qty
	 $c_qty2[] = $row["tbl_qty_c"] ;//tbl per item qty
	} else{
	$c_rate2[] = $row["c_tbl"]; //category tbl qty
	}
	}
	//needed for correct qty
	if ($row["c_sep"] == '1'){
	
	 $tbl_qty[] = $row["quantity"];
	
	}
}
if ($status_query2a != ''){	
	//Table results [weight]
	 while($row = tep_db_fetch_array($status_query2a)){
	 
	 //product	 
	 if($row["p_ind"] == '1'){
	 $p_qty3[] = $row["pound_per_p"];//tbl per item pound
	 } else {
	 $p_pound[] = $row["pound_p"]; //product tbl pound
	 }
	 if($row["p_sep"] != '0'){
	 
	$tbl_pound_p[] = $row["pound"];
	
	}
	 //category
	 if($row["c_ind"] == '1'){
	 $c_qty3[] = $row["pound_per_c"] ;//tbl per item pound
	 } else {
	 $c_pound[] = $row["pound_c"]; //category tbl pound
	 }
	 if($row["c_sep"] != '0'){
	 
	$tbl_pound[] = $row["pound"];
	
	}
	
}
 }
 if ($status_query3 != ''){
     //Table results [price]
     while($row = tep_db_fetch_array($status_query3)){
	 
     //products
	 if($row["p_ind"] == '1'){
	 $p_qty4[] = $row["tbl_price_p"] - ( 1 * $row["p_tbl"]);//tbl per item product[price]
     } else {
	 $p_rate3[] = $row["p_tbl"]; //product tbl [price]
	 }
	 if($row["p_sep"] != '0'){
	 
	 $tbl_price_p[] = $row["price"];
	 
	 }
    //categories
	 if($row["c_ind"] == '1'){
	 $c_qty4[] = $row["tbl_price_c"] - ( 1 * $row["c_tbl"]);//tbl per item category[price]
     } else {
	 $c_rate3[] = $row["c_tbl"]; //category tbl [price]
	 }
	  if($row["c_sep"] != '0'){
	 
	 $tbl_price[] = $row["price"];
 } 
 
 }
}
/*================== INHERIT QUERYS ======================*/
/* user logic so that ONLY if a default rate is set AND ind rates is set to yes results are given for only those products that are individual otherwise
  use default rates OR use individual inherit rates */
if ($inh['configuration_value'] == 'Yes') { 
if ($mode['configuration_value'] != 'No' and $ind['configuration_value'] == 'Yes' ){
		
		//flat query for sub categories inherit $status_query4
$status_query4= tep_db_query("select distinct ptc.products_id, sr.c_id, c_rate, c_per, (c_rate * cb.customers_basket_quantity) as qty from " . TABLE_SHIPPING_RATES ." sr inner join ". TABLE_CUSTOMERS_BASKET . " cb inner join ". TABLE_CATEGORIES . " c on (c.parent_id = sr.c_id ) inner join ". TABLE_PRODUCTS . " p inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id and ptc.products_id = cb.products_id) inner join " . TABLE_SHIPPING_MODE . " sm where cb.customers_id='" . $customer_id ."' and sr.c_status = '1' and (sm.p_id = sr.p_id and sr.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '1' or sm.c_mode = '2') or (sm.p_mode = '1' or sm.p_mode = '2')) group by ptc.products_id");

//flat query for main categories products $status_query5
$status_query5= tep_db_query("select  ptc.products_id,cb.products_id, sr.c_id, sr.c_rate, sr.c_per, (sr.c_rate * cb.customers_basket_quantity) as qty from ". TABLE_CATEGORIES . " c inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc. products_id and cb.customers_id = '" . $customer_id ."') inner join " . TABLE_SHIPPING_RATES ." sr on (c.parent_id= '0' and c.categories_id = sr.c_id) inner join " . TABLE_SHIPPING_MODE . " sm where sr.c_status = '1' and (sm.p_id = sr.p_id and sr.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by ptc.products_id ");
 
 //inherit for table [qty] sub/main $status_query6
$status_query6= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, str.c_qty, str.c_tbl, str.c_ind, (cb.customers_basket_quantity * str.c_tbl) as tbl_per_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on ((cb.customers_basket_quantity <= str.c_qty and str.c_id = c.parent_id) or (cb.customers_basket_quantity <= str.c_qty and c.parent_id = '0' and str.c_id = c.categories_id)) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) inner join " . TABLE_SHIPPING_MODE . " sm where (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by ptc.products_id");


//inherit for table [weight] sub/main $status_query7
$status_query7= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, str.c_qty, str.c_tbl, str.c_ind, (round(p.products_weight,0) * str.c_tbl) as pound_c, ((round(p.products_weight,0) * str.c_tbl) * cb.customers_basket_quantity) as pound_per_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on ((cb.customers_basket_quantity <= str.c_qty and str.c_id = c.parent_id) or (cb.customers_basket_quantity <= str.c_qty and c.parent_id = '0' and str.c_id = c.categories_id)) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) inner join " . TABLE_SHIPPING_MODE . " sm where (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by ptc.products_id");

//tbl query for [price] sub/main $status_query8
$status_query8= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, min(str.c_qty), str.c_tbl, str.c_ind, (cb.customers_basket_quantity * str.c_tbl) as tbl_price_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on (((p.products_price <= str.c_qty and str.c_id = c.parent_id) or (p.products_price <= str.c_qty and ptc.categories_id = str.c_id and c.parent_id = '0' ))) inner join " . TABLE_SHIPPING_MODE . " sm where (sm.p_id = str.p_id and str.c_id = sm.c_id) and (sm.c_sep = '1' or sm.p_sep = '1') and ((sm.c_mode= '3' or sm.c_mode = '4') or (sm.p_mode = '3' or sm.p_mode = '4')) group by ptc.products_id having min(str.c_qty)");
		}
		else{
//flat query for sub categories inherit $status_query4
$status_query4= tep_db_query("select distinct ptc.products_id, sr.c_id, c_rate, c_per, (c_rate * cb.customers_basket_quantity) as qty from " . TABLE_SHIPPING_RATES ." sr inner join ". TABLE_CUSTOMERS_BASKET . " cb inner join ". TABLE_CATEGORIES . " c on (c.parent_id = sr.c_id ) inner join ". TABLE_PRODUCTS . " p inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id and ptc.products_id = cb.products_id) where cb.customers_id='" . $customer_id ."' and sr.c_status = '1' group by ptc.products_id");

//flat query for main categories products $status_query5
$status_query5= tep_db_query("select c.categories_id, c.parent_id, ptc.categories_id, ptc.products_id,cb.products_id, sr.c_id, sr.c_rate, sr.c_per, (sr.c_rate * cb.customers_basket_quantity) as qty from ". TABLE_CATEGORIES . " c inner join " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc. products_id and cb.customers_id = '" . $customer_id ."') inner join " . TABLE_SHIPPING_RATES ." sr on (c.parent_id= '0' and c.categories_id = sr.c_id) where sr.c_status = '1' group by ptc.products_id ");
 
 //inherit for table [qty] sub/main $status_query6
$status_query6= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, str.c_qty, str.c_tbl, str.c_ind, (cb.customers_basket_quantity * str.c_tbl) as tbl_per_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on ((cb.customers_basket_quantity <= str.c_qty and str.c_id = c.parent_id) or (cb.customers_basket_quantity <= str.c_qty and c.parent_id = '0' and str.c_id = c.categories_id)) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) group by ptc.products_id");


//inherit for table [weight] sub/main $status_query7
$status_query7= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, str.c_qty, str.c_tbl, str.c_ind, (round(p.products_weight,0) * str.c_tbl) as pound_c, ((round(p.products_weight,0) * str.c_tbl) * cb.customers_basket_quantity) as pound_per_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on ((cb.customers_basket_quantity <= str.c_qty and str.c_id = c.parent_id) or (cb.customers_basket_quantity <= str.c_qty and c.parent_id = '0' and str.c_id = c.categories_id)) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) group by ptc.products_id");

//tbl query for [price] sub/main $status_query8
$status_query8= tep_db_query("select c.categories_id, c.parent_id, ptc.products_id as ptc_p, ptc.categories_id as ptc_c, cb.products_id, str.c_id, min(str.c_qty), str.c_tbl, str.c_ind, (cb.customers_basket_quantity * str.c_tbl) as tbl_price_c from ". TABLE_CATEGORIES . " c inner join ". TABLE_PRODUCTS_TO_CATEGORIES . " ptc on (ptc.categories_id = c.categories_id) inner join ". TABLE_CUSTOMERS_BASKET . " cb on (cb.products_id = ptc.products_id and cb.customers_id = '" . $customer_id ."' ) inner join ". TABLE_PRODUCTS . " p on (p.products_id = ptc.products_id) inner join " . TABLE_SHIPPING_TABLE_RATES ." str on (((p.products_price <= str.c_qty and str.c_id = c.parent_id) or (p.products_price <= str.c_qty and ptc.categories_id = str.c_id and c.parent_id = '0' ))) group by ptc.products_id having min(str.c_qty)");

}
}
    //Inherit Flat rates Sub-Categories' products
	if ($status_query4 != ''){
	while($row = tep_db_fetch_array($status_query4)){
	
	 if($row["c_per"] == '1'){ //flat per item
	 $c_qty5[] = $row["qty"] - ( 1 * $row["c_rate"]); //added for extra shipping rate showing up in quote.
	 } else {
	 $c_rate4[] = $row["c_rate"];//flat
	 }
	 if($row["c_sep"] != '0'){
	
	 $qty_i[] = $row["quantity"];
	 }
	 
	} 
    }
	 //Inherit Flat rates Main-Categories' products
	 if ($status_query5 != ''){
	 while($row = tep_db_fetch_array($status_query5)){
     
	 if($row["c_per"] == '1'){ //flat per item
	 $c_qty6[] = $row["qty"] - ( 1 * $row["c_rate"]); //added for extra shipping rate showing up in quote.
	 } else {
	 $c_rate5[] = $row["c_rate"];//flat
	 }
	  if($row["c_sep"] != '0'){
	
	 $qty_i[] = $row["quantity"];
	 }
	 
	}
}	
	 //Inherit Table rates sub/main [qty]
	 if ($status_query6 != ''){
	 while($row = tep_db_fetch_array($status_query6)){
	 
	 //sub category rates
	 if ($row["c_id"] == $row["parent_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty7[] = $row["tbl_per_c"] ;//tbl per item qty
	 } else {
	 $c_rate6[] = $row["c_tbl"];//tbl qty sub
	 }
	 if ($row["c_sep"] != '0'){
	 
	 $tbl_qty_i[] = $row["quantity"];
	}
	
	 }
	 }
	 //main category rates
	 if ($row["c_id"] == $row["categories_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty8[] = $row["tbl_per_c"] - ( 1 * $row["c_tbl"]);//tbl per item qty
	 } else {
	 $c_rate7[] = $row["c_tbl"];//tbl qty sub
	 }
	 if ($row["c_sep"] != '0'){
	 
	 $tbl_qty_i[] = $row["quantity"];
	}
	
	 }
	  
	 }
	 if ($status_query7 != ''){
     //Inherit Table rates sub/main  [weight]
     while($row = tep_db_fetch_array($status_query7)){
	 
	 //sub category rates
	 if ($row["c_id"] == $row["parent_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty9[] = $row["pound_per_c"];//tbl per item pound
	 } else {
	 $inh_pound[] = $row["pound_c"];//tbl pound sub
	 }
	 if($row["c_per"] != '0'){
	
	$tbl_pound_i[] = $row["pound"];
	}
	
	 }
	 
	 //main category rates
	 if ($row["c_id"] == $row["categories_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty10[] = $row["pound_per_c"];//tbl per item pound
	 } else {
	 $inh_pound2[] = $row["pound_c"];//tbl pound sub
	 }
	 if($row["c_sep"] != '0'){
	
	$tbl_pound_i[] = $row["pound"];
	}
	 
      	 
    }
	}
	}
	if ($status_query8 != ''){
    //Inherit Table rates [price]
    while($row = tep_db_fetch_array($status_query8)){
	 
	 //sub category rates
	 if ($row["c_id"] == $row["parent_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty11[] = $row["tbl_price_c"] ;//tbl per item price
	 } else {
	 $c_rate8[] = $row["c_tbl"];//tbl qty sub
	 }
	 if($row["c_sep"] == '1'){
	  
	 $tbl_price_i[] = $row["price"];
 } 
 
	 }
	 
	 //main category rates
	 if ($row["c_id"] == $row["categories_id"]){
     
	 if($row["c_ind"] == '1'){//tbl per item
	 $c_qty12[] = $row["tbl_price_c"];//tbl per item price
	 } else {
	 $c_rate9[] = $row["c_tbl"];//tbl qty sub
	 }
	 if($row["c_sep"] == '1'){
	  
	 $tbl_price_i[] = $row["price"];
 } 
 
	 }
    
 } 
     }


	 /* add values from new result columns to display when calculating shipping [Regular]*/
	 
	 // Flat Rates [Default]
	 if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE != 'No' and MODULE_SHIPPING_SEPARATE_IND == 'No' ){
	   
	   if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Flat'){
      $shipping = MODULE_SHIPPING_SEPARATE_FLAT;//use flat instead of table rate
	  } elseif(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Flat per item'){
	  $shipping = MODULE_SHIPPING_SEPARATE_FLAT * $cart->count_contents();
	 } 
	 // Table Rates [Default]
	 elseif( MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table' xor MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table per item'){
       if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
        $order_total = $cart->show_total();
      } elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty') {
        $order_total = $cart->count_contents();
      } else {
	    $order_total = $cart->show_weight();  
	  }

      $table_cost = preg_split("^[:,]^" , MODULE_SHIPPING_SEPARATE_COST);
      $size = sizeof($table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($order_total <= $table_cost[$i]) {
          $shipping = $table_cost[$i+1];
          break;
        }
      }

      if (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
        $shipping = $shipping * ($order_total / SHIPPING_MAX_WEIGHT);
      }
	  
	  if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table per item'){
	   $shipping = $shipping * $cart->count_contents() ;
	  }
	}
	//Check if The total shipping is more than Max shipping rate 
	  //if it is, apply max shipping rate 
 if ( $shipping > MODULE_SHIPPING_SEPARATE_MAX){
 $shipping = MODULE_SHIPPING_SEPARATE_MAX;
 }
	}
	 
	else {
	
 //for individual products
 //flat rates
if (MODULE_SHIPPING_SEPARATE_SETTING == 'product'){
      if ($p_rate != ''){ //reg flat
	  $rate = array_sum($p_rate);
	  }
	  if ($p_qty != ''){ //reg flat per
	  $rate2 = array_sum($p_qty);
	  }
	  //tbl rates
       if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
	  
	
	
	// table rates regular
	 if($p_rate3 != '')	 {
	  $tbl = array_sum($p_rate3);
	}
	//per item tbl
	  if($p_qty4 != ''){
	 $tbl2 = array_sum($p_qty4);
	 }
	 $shipping = $rate + $tbl + $rate2 + $tbl2;  
	 
	 
	  
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	  
	 
	 //table rate regular
     if($p_rate2 != ''){ 
      $tbl = array_sum($p_rate2);
	}
	 //per item
	 if($p_qty2 != ''){
	 $tbl2 = array_sum($p_qty2);
	 }
	  
	 $shipping = $rate + $rate2 + $tbl + $tbl2;  
	 
	 
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
	     
	
	 //regular table rate
      if($p_pound != ''){
	  $weight = array_sum($p_pound);
	  }
	  //per item table rate
      if($p_qty3 != ''){
	  $weight2 = array_sum($p_qty3);
	  }
        
	   $shipping = $weight + $rate + $rate2 + $weight2;
	   
	   
	  }
	 //Check if The total shipping is more than Max shipping rate 
	  //if it is, apply max shipping rate 
 if ( $shipping > MODULE_SHIPPING_SEPARATE_MAX){
 $shipping = MODULE_SHIPPING_SEPARATE_MAX;
 } 
}	  
 //for individual categories
 if (MODULE_SHIPPING_SEPARATE_SETTING == 'category'){
  
     if (MODULE_SHIPPING_SEPARATE_INHERIT == 'Yes'){
	 if (MODULE_SHIPPING_SEPARATE_MODE == 'price'){
	 
	 //====== flat rates for products in the sub-categories======//
     //reg flat rate [price]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [price]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [price]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [price]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [price]
	 if($c_rate8 !=''){
	 $tbl = array_sum($c_rate8);
	 }
	 //per item table rate per item [price]
	 if($c_qty11 !=''){
	 $tbl2 = array_sum($c_qty11);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [price]
	  if($c_rate9 !=''){
	 $tbl3 = array_sum($c_rate9);
	 }
	 //per item table rate [price]
	 if($c_qty12 !=''){
	 $tbl4 = array_sum($c_qty12);
	 }
	 $shipping = $rate1 + $rate2 + $rate3 + $rate4 + $tbl1 + $tbl2 + $tbl3 + $tbl4;
	 }
	  elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	 
	 //====== flat rates for products in the sub-categories======//
     //reg flat rate [qty]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [qty]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [qty]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [qty]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [qty]
	 if($c_rate6 !=''){
	 $tbl = array_sum($c_rate6);
	 }
	 //per item table rate per item [qty]
	 if($c_qty7 !=''){
	 $tbl2 = array_sum($c_qty7);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [qty]
	  if($c_rate7 !=''){
	 $tbl3 = array_sum($c_rate7);
	 }
	 //per item table rate [qty]
	 if($c_qty9 !=''){
	 $tbl4 = array_sum($c_qty9);
	 }
	 $shipping = $rate + $rate2 + $rate3 + $rate4 + $tbl + $tbl2 + $tbl3 + $tbl4;
	 
	 } 
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight'){
	  //====== flat rates for products in the sub-categories======//
     //reg flat rate [weight]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [weight]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [weight]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [weight]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [pound]
	 if($inh_pound !=''){
	 $tbl = array_sum($inh_pound);
	 }
	 //per item table rate per item [pound]
	 if($c_qty8 !=''){
	 $tbl2 = array_sum($c_qty8);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [pound]
	  if($inh_pound2 !=''){
	 $tbl3 = array_sum($inh_pound2);
	 }
	 //per item table rate [pound]
	 if($c_qty10 !=''){
	 $tbl4 = array_sum($c_qty10);
	 }
	 $shipping = $rate + $rate2 + $rate3 + $rate4 + $tbl + $tbl2 + $tbl3 + $tbl4;
	 
	 }
	} 
	else{
	//================Reg category rates=============//
	  if ($c_rate != ''){ //reg flat
	  $rate = array_sum($c_rate);
	  }
	  if ($c_qty != ''){ //reg flat per
	  $rate2 = array_sum($c_qty);
	  }
	  
	  if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
	  
	  
	  if ( $c_rate3 != ''){ //reg tbl
     
      $tbl = array_sum($c_rate3);
	  }
	  if ( $c_qty4 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty4);
	  }
      
	  
	 $shipping = $rate + $tbl + $rate2 + $tbl2;  
	 
	 
	  
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	   
	
	  
	  if ( $c_rate2 != ''){ //reg tbl
     
      $tbl = array_sum($c_rate2);
	  }
	  if ( $c_qty2 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty2);
	  }
      
	  
	 $shipping = $rate + $tbl + $rate2 + $tbl2;
	 
	 
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
	     
	  
	  if ( $c_pound != ''){ //reg tbl
     
      $tbl = array_sum($c_pound);
	  }
	  if ( $c_qty3 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty3);
	  }
      
	  
	 $shipping = $rate + $tbl + $rate2 + $tbl2;
	 
	   
	   
	  }
	  
	  //Check if The total shipping is more than Max shipping rate 
	  //if it is, apply max shipping rate 
 if ( $shipping > MODULE_SHIPPING_SEPARATE_MAX){
 $shipping = MODULE_SHIPPING_SEPARATE_MAX;
 }
}
}
}
/* add values from new result columns to display when calculating shipping [With Independent need to subtract independent rates ]*/
 if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE != 'No' and  MODULE_SHIPPING_SEPARATE_IND == 'Yes'){
	  if ($qty != ''){
	  $qty = array_sum($qty);
	  }
	  if ($qty_p != ''){
	  $qty_p = array_sum($qty_p);
	  }
	  if ($pound != ''){
	  $pound = array_sum($pound);
	  }
	  if ($pound_p != ''){
	  $pound_p = array_sum($pound_p);
	  }
	  if ($price != ''){
	  $price = array_sum($price);
	  }
	  if ($price_p != ''){
	  $price_p = array_sum($price_p);
	  }
	  //table
	  if ($tbl_qty != ''){
	  $tbl_qty = array_sum($tbl_qty);
	  }
	  if ($tbl_qty_p != ''){
	  $tbl_qty_p = array_sum($tbl_qty_p);
	  }
	  if ($tbl_pound != ''){
	  $tbl_pound = array_sum($tbl_pound);
	  }
	  if ($tbl_pound_p != ''){
	  $tbl_pound_p = array_sum($tbl_pound_p);
	  }
	  if ($tbl_price != ''){
	  $tbl_price = array_sum($tbl_price);
	  }
	  if ($price_p != ''){
	  $tbl_price_p = array_sum($tbl_price_p);
	  }
	   // Flat Rates [With independent]
	   if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Flat'){
      $shipping1 = MODULE_SHIPPING_SEPARATE_FLAT;//use flat instead of table rate
	  } elseif(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Flat per item'){
	  $qty = $cart->count_contents() - ($qty + $qty_p);
	  $shipping1 = MODULE_SHIPPING_SEPARATE_FLAT * ($qty);
	 } 
	 // Table Rates [With independent ]
	 elseif( MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table' xor MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table per item'){
       if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
        $order_total = $cart->show_total() - ($tbl_price + $tbl_price_p);
      } elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty') {
        $order_total = $cart->count_contents() - ($tbl_qty + $tbl_qty_p);
      } else {
	    $order_total = $cart->show_weight() - ($tbl_pound + $tbl_pound_p);  
	  }

      $table_cost = preg_split("^[:,]^" , MODULE_SHIPPING_SEPARATE_COST);
      $size = sizeof($table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($order_total <= $table_cost[$i]) {
          $shipping1 = $table_cost[$i+1];
          break;
        }
      }

      if (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
        $shipping1 = $shipping * ($order_total / SHIPPING_MAX_WEIGHT);
      }
	  //Table per item
	  if(MODULE_SHIPPING_SEPARATE_DEFAULT_MODE == 'Table per item'){
	   $shipping1 = $shipping * $cart->count_contents() ;
	  }
	}
	
	
//for individual products
 
if (MODULE_SHIPPING_SEPARATE_SETTING == 'product'){
      if ($p_rate != ''){ //reg flat
	  $rate = array_sum($p_rate);
	  }
	  if ($p_qty != ''){ //reg flat per
	  $rate2 = array_sum($p_qty);
	  }
       if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
	  
	
	
	// table rates regular
	 if($p_rate3 != '')	 {
	  $tbl = array_sum($p_rate3);
	}
	//per item tbl
	  if($p_qty4 != ''){
	 $tbl2 = array_sum($p_qty4);
	 }
	 $shipping2 = $rate + $tbl + $rate2 + $tbl2;  
	 
	 
	  
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	  
	 
	 //table rate regular
     if($p_rate2 != ''){ 
      $tbl = array_sum($p_rate2);
	}
	 //per item
	 if($p_qty2 != ''){
	 $tbl2 = array_sum($p_qty2);
	 }
	  
	 $shipping2 = $rate + $rate2 + $tbl + $tbl2;  
	 
	 
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
	     
	
	 //regular table rate
      if($p_pound != ''){
	  $weight = array_sum($p_pound);
	  }
	  //per item table rate
      if($p_qty3 != ''){
	  $weight2 = array_sum($p_qty3);
	  }
        
	   $shipping2 = $weight + $rate + $rate2 + $weight2;
	   
	   
	  }
 }
	  
 //for individual categories
if (MODULE_SHIPPING_SEPARATE_SETTING == 'category'){
  
     if (MODULE_SHIPPING_SEPARATE_INHERIT == 'Yes'){
	 if (MODULE_SHIPPING_SEPARATE_MODE == 'price'){
	 
	 //====== flat rates for products in the sub-categories======//
     //reg flat rate [price]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [price]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [price]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [price]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [price]
	 if($c_rate8 !=''){
	 $tbl = array_sum($c_rate8);
	 }
	 //per item table rate per item [price]
	 if($c_qty11 !=''){
	 $tbl2 = array_sum($c_qty11);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [price]
	  if($c_rate9 !=''){
	 $tbl3 = array_sum($c_rate9);
	 }
	 //per item table rate [price]
	 if($c_qty12 !=''){
	 $tbl4 = array_sum($c_qty12);
	 }
	 $shipping2 = $rate1 + $rate2 + $rate3 + $rate4 + $tbl1 + $tbl2 + $tbl3 + $tbl4;
	 }
	  elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	 
	 //====== flat rates for products in the sub-categories======//
     //reg flat rate [qty]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [qty]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [qty]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [qty]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [qty]
	 if($c_rate6 !=''){
	 $tbl = array_sum($c_rate6);
	 }
	 //per item table rate per item [qty]
	 if($c_qty7 !=''){
	 $tbl2 = array_sum($c_qty7);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [qty]
	  if($c_rate7 !=''){
	 $tbl3 = array_sum($c_rate7);
	 }
	 //per item table rate [qty]
	 if($c_qty9 !=''){
	 $tbl4 = array_sum($c_qty9);
	 }
	 $shipping2 = $rate + $rate2 + $rate3 + $rate4 + $tbl + $tbl2 + $tbl3 + $tbl4;
	 
	 } 
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight'){
	  //====== flat rates for products in the sub-categories======//
     //reg flat rate [weight]
	 if($c_rate4 !=''){
	 $rate = array_sum($c_rate4);
	 }
	 //reg flat rate per item [weight]
	 if($c_qty5 !=''){
	 $rate2 = array_sum($c_qty5);
	 }
	 
	 //====== flat rates for products in the main-categories======//
     //reg flat rate [weight]
	 if($c_rate5 !=''){
	 $rate3 = array_sum($c_rate5);
	 }
	 //reg flat rate per item [weight]
	 if($c_qty6 !=''){
	 $rate4 = array_sum($c_qty6);
	 }
	 
	 //====== table rates for products in the sub-categories====//
	 //regular table rate [pound]
	 if($inh_pound !=''){
	 $tbl = array_sum($inh_pound);
	 }
	 //per item table rate per item [pound]
	 if($c_qty8 !=''){
	 $tbl2 = array_sum($c_qty8);
	 }
	 
	 //=======table rates for products in the main categories=====//
	 //reg table rate [pound]
	  if($inh_pound2 !=''){
	 $tbl3 = array_sum($inh_pound2);
	 }
	 //per item table rate [pound]
	 if($c_qty10 !=''){
	 $tbl4 = array_sum($c_qty10);
	 }
	 $shipping2 = $rate + $rate2 + $rate3 + $rate4 + $tbl + $tbl2 + $tbl3 + $tbl4;
	 
	 }
	} 
	else{
	//================Reg category rates=============//
	  if ($c_rate != ''){ //reg flat
	  $rate = array_sum($c_rate);
	  }
	  
	  if ($c_qty != ''){ //reg flat per
	  $rate2 = array_sum($c_qty);
	  }
	  
	  if (MODULE_SHIPPING_SEPARATE_MODE == 'price') {
	  
	  
	  if ( $c_rate3 != ''){ //reg tbl
     
      $tbl = array_sum($c_rate3);
	  }
	  if ( $c_qty4 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty4);
	  }
      
	  
	 $shipping2 = $rate + $tbl + $rate2 + $tbl2;  
	 
	 
	  
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'qty'){
	   
	
	  
	  if ( $c_rate2 != ''){ //reg tbl
     
      $tbl = array_sum($c_rate2);
	  }
	  if ( $c_qty2 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty2);
	  }
      
	  
	 $shipping2 = $rate + $tbl + $rate2 + $tbl2;
	 
	 
	 }
	 elseif (MODULE_SHIPPING_SEPARATE_MODE == 'weight') {
	     
	  
	  if ( $c_pound != ''){ //reg tbl
     
      $tbl = array_sum($c_pound);
	  }
	  if ( $c_qty3 != ''){ //reg tbl per
     
      $tbl2 = array_sum($c_qty3);
	  }
      
	  
	 $shipping2 = $rate + $tbl + $rate2 + $tbl2;
	 
	   
	   
	  }
	  }
	  
	  }
	  $shipping = $shipping1 + $shipping2;
	  //Check if The total shipping is more than Max shipping rate 
	  //if it is, apply max shipping rate 
 if ( $shipping > MODULE_SHIPPING_SEPARATE_MAX){
 $shipping = MODULE_SHIPPING_SEPARATE_MAX;
 }	  

}





      


      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_SEPARATE_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_SEPARATE_TEXT_WAY, 
													 //'title' => MODULE_SHIPPING_SEPARATE_DEFAULT_MODE . "&nbsp; &nbsp;" . MODULE_SHIPPING_SEPARATE_SETTING . "&nbsp; &nbsp;" . MODULE_SHIPPING_SEPARATE_MODE,
                                                     'cost' => $shipping + MODULE_SHIPPING_SEPARATE_HANDLING)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
     
      return $this->quotes;
  }
  
  
   
  

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SEPARATE_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

	
	//add new tables and default configuration values for admin area 
    function install() {
	
	//MODULE_SHIPPING_SEPARATE_STATUS [enable module]
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable  Seperate Shipping Method', 'MODULE_SHIPPING_SEPARATE_STATUS', 'True', 'Do you want to offer separate shipping per Product/Category?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
	 
	 //MODULE_SHIPPING_SEPARATE_VERSION [version of SSPP]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order,  date_added) VALUES ('Version:', 'MODULE_SHIPPING_SEPARATE_VERSION', '1.85', 'Version', '6', '0',  now())");
	  
	  //MODULE_SHIPPING_SEPARATE_COST [default table rate]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Default Table Rate', 'MODULE_SHIPPING_SEPARATE_COST', '25:8.50,50:5.50,10000:0.00', 'The shipping table is based on the total qty, cost, or weight of items. Example: 25:8.50,50:5.50,etc.. Up to 25 charge 8.50, from there to 50 charge 5.50, etc', '6', '0', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_DEFAULT_MODE [Set Default Mode]
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function,  date_added) values ('Use Default Rates?', 'MODULE_SHIPPING_SEPARATE_DEFAULT_MODE', 'No', 'Using 10 products  and Flat rate $1 and the Default Table rate  and max shipping $50, The following calculations are performed.<br>Flat shipping = $1<br>Flat per item shipping = $10<br>Table shipping= $8.50<br>Table per item shipping = $50.00 ', '6', '0', 'tep_cfg_select_option(array(\'No\',\'Flat\',\'Flat per item\', \'Table\', \'Table per item\'), ', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_SETTING [ per category, per product setting]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Individual Product/Category Setting', 'MODULE_SHIPPING_SEPARATE_SETTING', 'product', 'Set per individual category, or per product', '6', '0', 'tep_cfg_select_option(array(\'category\', \'product\'), ', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_MODE [qty,price,weight selection for table rates] 
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Shipping Method for Table Rates', 'MODULE_SHIPPING_SEPARATE_MODE', 'qty', 'The shipping table rate is based on the  qty, order total, or weight of the items ordered.', '6', '0', 'tep_cfg_select_option(array(\'qty\', \'price\', \'weight\'), ', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_HANDLING [Handling Charge]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Handling Fee', 'MODULE_SHIPPING_SEPARATE_HANDLING', '0', 'Handling fee for this shipping method.', '6', '0', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_TAX_CLASS [use a tax class]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_SHIPPING_SEPARATE_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_ZONE [set up zone shipping for one zone] 
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Shipping Zone', 'MODULE_SHIPPING_SEPARATE_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
	  
	  //MODULE_SHIPPING_SEPARATE_SORT_ORDER [sort order]
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_SHIPPING_SEPARATE_SORT_ORDER', '0', 'Sort order of display.', '6', '0', now())");
	 
	 //MODULE_SHIPPING_SEPARATE_STATUS_FLAT [Type of flat shipping] replaced with MODULE_SHIPPING_SEPARATE_DEFAULT_MODE as of v1.81
	 
    /* tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Enable Default Flat Rate?', 'MODULE_SHIPPING_SEPARATE_STATUS_FLAT', 'Flat', 'When this is enabled along with the all setting, The  flat rate will be applied to all products in the shopping cart otherwise the default table rate will be used.', '6', 'No','', 'tep_cfg_select_option(array(\'Flat\', \'Flat per item\'), ', now())");*/
	 
	 
	 //MODULE_SHIPPING_SEPARATE_FLAT [Default Flat Rate]
	 tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order,  date_added) values ('Default Flat Rate', 'MODULE_SHIPPING_SEPARATE_FLAT', '1.00', 'Place a rate here for global flat rate or leave as 0.00 for free shipping.', '6', '0', now())");
	 
	 //MODULE_SHIPPING_SEPARATE_DEFAULT_STATUS [ enable default status] replaced with MODULE_SHIPPING_SEPARATE_DEFAULT_MODE as of v1.81
	 
	 /*tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function,  date_added) values ('Use Default Rates?', 'MODULE_SHIPPING_SEPARATE_DEFAULT_STATUS', 'No', 'Enable the default Rates below.', '6', '0', 'tep_cfg_select_option(array(\'Yes\', \'No\'), ', now())");*/
	 
	 //MODULE_SHIPPING_SEPARATE_MAX [set a max shipping rate]
	 tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order,  date_added) values ('Max Shipping Rate', 'MODULE_SHIPPING_SEPARATE_MAX', '50.00', 'Place a max shipping rate here.', '6', '0', now())");
	 
	 //MODULE_SHIPPING_SEPARATE_INHERIT [ enable inherit status]
	 tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function,  date_added) values ('Inherit Rates from Main Categories?', 'MODULE_SHIPPING_SEPARATE_INHERIT', 'No', 'Allow sub-categories to inherit rates from main categories?.', '6', '0', 'tep_cfg_select_option(array(\'Yes\', \'No\'), ', now())");
	 
	  //MODULE_SHIPPING_SEPARATE_IND [use individual rates with default rates]
	 tep_db_query("insert into " . TABLE_CONFIGURATION . " (`configuration_id`, `configuration_title`, `configuration_key`, `configuration_value`, `configuration_description`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES (NULL, 'Use Individual rates with the default rates?', 'MODULE_SHIPPING_SEPARATE_IND', 'Yes', 'When this is set to Yes you can use individual rates along with the default rates.', '6', '0', '2014-01-05 00:00:00', '2014-01-05 00:00:00', NULL, 'tep_cfg_select_option(array(\'Yes\', \'No\'),')");
	 
	 //MODULE_SHIPPING_SEPARATE_MAX_PER [ enable max shipping per]
	/* tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function,  date_added) values ('Apply Max Shipping Rate per item?', 'MODULE_SHIPPING_SEPARATE_MAX_PER', 'No', 'Enable max shipping per item?.', '6', '0', 'tep_cfg_select_option(array(\'Yes\', \'No\'), ', now())");*/
	 
	 // create new tables shipping_rates and shipping_table_rates
	 tep_db_query("CREATE TABLE IF NOT EXISTS `shipping_rates` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_status` int(2) NOT NULL DEFAULT '0',
  `p_status` int(2) NOT NULL DEFAULT '0',
  `c_free` int(11) NOT NULL DEFAULT '0',
  `p_free` int(11) NOT NULL DEFAULT '0',
  `c_per` int(2) NOT NULL DEFAULT '0',
  `p_per` int(2) NOT NULL DEFAULT '0',
  `c_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `c_rate` decimal(20,2) NOT NULL DEFAULT '0.00',
  `p_rate` decimal(20,2) NOT NULL DEFAULT '0.00',
  `c_mode` int(11) NOT NULL,
  `p_mode` int(11) NOT NULL,
  PRIMARY KEY (`rate_id`)
)");
   
   tep_db_query("CREATE TABLE IF NOT EXISTS `shipping_table_rates` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `c_stat` int(2) NOT NULL DEFAULT '0',
  `p_stat` int(2) NOT NULL DEFAULT '0',
  `c_ind` int(2) NOT NULL DEFAULT '0',
  `p_ind` int(2) NOT NULL DEFAULT '0',
  `c_tbl` decimal(20,2) NOT NULL DEFAULT '0.00',
  `p_tbl` decimal(20,2) NOT NULL DEFAULT '0.00',
  `p_qty` int(11) NOT NULL,
  `c_qty` int(11) NOT NULL,
  PRIMARY KEY (`rate_id`,`c_id`,`p_id`)
)");
//create table shipping_mode
tep_db_query("CREATE TABLE IF NOT EXISTS `shipping_mode` (
  `mode_id` int(255) NOT NULL AUTO_INCREMENT,
  `c_id` int(255) NOT NULL DEFAULT '0',
  `p_id` int(255) NOT NULL DEFAULT '0',
  `c_mode` int(2) NOT NULL DEFAULT '0',
  `p_mode` int(2) NOT NULL DEFAULT '0',
  `c_sep` int(2) NOT NULL DEFAULT '0',
  `p_sep` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mode_id`)
)");
}
    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	  tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . MODULE_SHIPPING_SEPARATE_VERSION ."')");
	  
	  tep_db_query("drop table `shipping_rates`");
	  tep_db_query("drop table `shipping_table_rates`");
	  tep_db_query("drop table `shipping_mode`");
    }
    
    function keys() {
      return array('MODULE_SHIPPING_SEPARATE_STATUS', 'MODULE_SHIPPING_SEPARATE_SETTING', 'MODULE_SHIPPING_SEPARATE_INHERIT', 'MODULE_SHIPPING_SEPARATE_DEFAULT_MODE', 'MODULE_SHIPPING_SEPARATE_IND', 'MODULE_SHIPPING_SEPARATE_FLAT', 'MODULE_SHIPPING_SEPARATE_COST', 'MODULE_SHIPPING_SEPARATE_MODE', 'MODULE_SHIPPING_SEPARATE_MAX',    'MODULE_SHIPPING_SEPARATE_HANDLING', 'MODULE_SHIPPING_SEPARATE_TAX_CLASS', 'MODULE_SHIPPING_SEPARATE_ZONE', 'MODULE_SHIPPING_SEPARATE_SORT_ORDER');
    }
 

}

?>