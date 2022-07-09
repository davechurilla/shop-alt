<?php

/*
  $Id: separate.php 1850 2014-01-11 00:52:16Z hpdl $
  Ver: 1.85
  
======================== Made for osCommerce 2.2 rc2=============  
  osCommerce, Open Source E-Commerce Solutions 
  http://www.oscommerce.com 

  Copyright (c) 2013 rpetet of http://www.r-pdesigns.com & web22 of htpp://www.wolfftanning.com Developed for v 2.2
  
  Based on categories.php Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
 		
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
  ////
// Sets the status of a product
  function tep_set_status($p_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_SHIPPING_RATES . " set status = '1' where p_id = '" . $p_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_SHIPPING_RATES . " set status = '0' where p_id = '" . $p_id . "'");
    } else {
      return -1;
    }
  }
   
  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($HTTP_GET_VARS['flag'] == '0') || ($HTTP_GET_VARS['flag'] == '1') ) {
          if (isset($HTTP_GET_VARS['pID'])) {
		  
            tep_set_status($HTTP_GET_VARS['pID'], $HTTP_GET_VARS['flag']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $HTTP_GET_VARS['cPath'] . '&pID=' . $HTTP_GET_VARS['pID']));
        break;

//insert update category
      case 'insert_category':
      case 'update_category':
        if (isset($HTTP_POST_VARS['c_id'])){
		$categories_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		//SSPP Begin
		$c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_rate = tep_db_prepare_input($HTTP_POST_VARS['c_rate']);
		$c_per = tep_db_prepare_input($HTTP_POST_VARS['c_per']);
		$c_status = tep_db_prepare_input($HTTP_POST_VARS['c_status']); 
		$c_free = tep_db_prepare_input($HTTP_POST_VARS['c_free']);
      $sql_data_array = array('c_id' => $c_id,
	                          'c_rate'=> tep_db_input($c_rate),
							  'c_per'=> tep_db_input($c_per),
							  'c_status'=>tep_db_input($c_status),
							  'c_free'=>tep_db_input($c_free));
	  
		//SSPP End
		}
        if ($action == 'insert_category') {
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
          tep_db_perform(TABLE_SHIPPING_RATES, $sql_data_array);
         
		  
        } elseif ($action == 'update_category') {
          tep_db_perform(TABLE_SHIPPING_RATES, $sql_data_array, 'update', "c_id = '" . (int)$categories_id . "'");
          
        }

		
		
        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $categories_id));
        break;
		
//insert category table
	  case 'insert_category_tbl':
        $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_qty  = tep_db_prepare_input($HTTP_POST_VARS['c_qty']);
		$c_tbl  = tep_db_prepare_input($HTTP_POST_VARS['c_tbl']);
        $c_ind  = tep_db_prepare_input($HTTP_POST_VARS['c_ind']);
	  $sql_data_array = array('c_id' => $c_id,
	                          'c_qty'=> tep_db_input($c_qty),
							  'c_tbl'=> tep_db_input($c_tbl),
							  'c_ind'=> tep_db_input($c_ind));
		//SSPP End
		         
          tep_db_perform(TABLE_SHIPPING_TABLE_RATES, $sql_data_array);
			
        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $c_id));
        break;

//update category table
 case 'update_category_tbl':
       if (isset($HTTP_GET_VARS['rate_id'])) $rates_id = tep_db_prepare_input($HTTP_GET_VARS['rate_id']); 
         
	 $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		$c_qty  = tep_db_prepare_input($HTTP_POST_VARS['c_qty']);
		$c_tbl  = tep_db_prepare_input($HTTP_POST_VARS['c_tbl']);
	  $sql_data_array = array('c_id' => $c_id,
	                          'c_qty'=> tep_db_input($c_qty),
							  'c_tbl'=> tep_db_input($c_tbl));
							  
		//SSPP End
          
        
          
           tep_db_perform(TABLE_SHIPPING_TABLE_RATES, $sql_data_array, 'update', "rate_id = '" . tep_db_input($r_id) . "'");

          

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
         
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $c_id));
        
        break;

//insert category mode
case'insert_category_mode':
case 'update_category_mode':
 if (isset($HTTP_GET_VARS['cID'])) $categories_id = tep_db_prepare_input($HTTP_GET_VARS['cID']); 
	   $c_mode = tep_db_prepare_input($HTTP_POST_VARS['c_mode']);
	   if ($c_mode == '0'){
	   //free
       $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_per = '0';
		$c_status = '0'; 
		$c_free = '1';
		$c_mode = '0';
        $sql_data_array = array('c_id' => $c_id,
							   'c_per'=> tep_db_input($c_per),
							   'c_status'=>tep_db_input($c_status),
							   'c_free'=>tep_db_input($c_free));
		
		 
	    $c_stat = '0';
        $c_ind = '0';
	    $sql_data_array2 = array('c_id' => $c_id,
							  'c_stat' => $c_stat,
	                          'c_ind'=> $c_ind);
	  	   

		   }
		   if ($c_mode == '1'){
	   //flat 
       $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_rate = tep_db_prepare_input($HTTP_POST_VARS['c_rate']);
		$c_per = '0'; //per
		$c_status = '1'; //stat
		$c_free = '0';
        $sql_data_array = array('c_id' => $c_id,
	                          'c_rate'=> tep_db_input($c_rate),
							  'c_per'=> tep_db_input($c_per),
							  'c_status'=>tep_db_input($c_status),
							   'c_free'=>tep_db_input($c_free));
	  	 
        $c_stat = '0';
        $c_ind = '0';
	    $sql_data_array2 = array('c_id' => $c_id,
							  'c_stat' => $c_stat,
	                          'c_ind'=> $c_ind );		 

		   }
		   
		   if ($c_mode == '2'){
	   //flat per
        $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_rate = tep_db_prepare_input($HTTP_POST_VARS['c_rate']);
		$c_per = '1';
		$c_status = '1'; 
		$c_free = '0';
        $sql_data_array = array('c_id' => $c_id,
	                          'c_rate'=> tep_db_input($c_rate),
							  'c_per'=> tep_db_input($c_per),
							  'c_status'=>tep_db_input($c_status),
							   'c_free'=>tep_db_input($c_free));
							  
		$c_stat = '0';
        $c_ind = '0';
	    $sql_data_array2 = array('c_id' => $c_id,
							  'c_stat' => $c_stat,
	                          'c_ind'=> $c_ind );
	  	}
		if ($c_mode == '3'){
	    //tbl
	    $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_rate = tep_db_prepare_input($HTTP_POST_VARS['c_rate']);
		$c_per = '0';
		$c_status = '0'; 
		$c_free = '0';
        $sql_data_array = array('c_id' => $c_id,
	                          'c_rate'=> tep_db_input($c_rate),
							  'c_per'=> tep_db_input($c_per),
							  'c_status'=>tep_db_input($c_status),
							   'c_free'=>tep_db_input($c_free));
		
	    $c_stat = '1';
        $c_ind = '0';
	    $sql_data_array2 = array('c_id' => $c_id,
							  'c_stat' => $c_stat,
	                         'c_ind'=> $c_ind );
		}
		if ($c_mode == '4'){
	    //tbl per
	    $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		$c_rate = tep_db_prepare_input($HTTP_POST_VARS['c_rate']);
		$c_per = '0';
		$c_status = '0'; 
		$c_free = '0';
        $sql_data_array = array('c_id' => $c_id,
							  'c_per'=> tep_db_input($c_per),
							  'c_status'=>tep_db_input($c_status),
							   'c_free'=>tep_db_input($c_free));
	    $c_stat = '1';
        $c_ind = '1';
	    $sql_data_array2 = array('c_id' => $c_id,
							  'c_stat' => tep_db_input($c_stat),
	                          'c_ind'=> $c_ind );
		} 
       $sql_data_array3 = array('c_id' => $c_id,
							   'c_mode'=> tep_db_input($c_mode));
	//insert					   
		if ($action == 'insert_category_mode') {
		//[the following update query's are only  enacted if a flat or table rate is set]
		//flat 
           tep_db_query("update ". TABLE_SHIPPING_RATES ." set c_per = '" . tep_db_input($c_per) ."', c_status = '" . tep_db_input($c_status) ."',  c_free = '" .tep_db_input($c_free)."' where c_id ='" . tep_db_input($c_id) . "'");
        //table 
          tep_db_query("update ". TABLE_SHIPPING_TABLE_RATES ." set c_stat = '" . tep_db_input($c_stat) ."', c_ind = '" . tep_db_input($c_ind) ."' where c_id ='" . tep_db_input($c_id) . "'");
		
		//mode
		tep_db_perform(TABLE_SHIPPING_MODE, $sql_data_array3);
		} 
	//update
		elseif ($action == 'update_category_mode') {
		  //[the following update query's are only  enacted if a flat or table rate is set]
		  //flat 
           tep_db_query("update ". TABLE_SHIPPING_RATES ." set c_per = '" . tep_db_input($c_per) ."', c_status = '" . tep_db_input($c_status) ."',  c_free = '" .tep_db_input($c_free)."' where c_id ='" . tep_db_input($c_id) . "'");
          
		   //table 
          tep_db_query("update ". TABLE_SHIPPING_TABLE_RATES ." set c_stat = '" . tep_db_input($c_stat) ."', c_ind = '" . tep_db_input($c_ind) ."' where c_id ='" . tep_db_input($c_id) . "'");
        
          //mode
		  tep_db_query("update " . TABLE_SHIPPING_MODE . " set c_mode = '" .tep_db_input($c_mode)."' where c_id ='" . tep_db_input($c_id) . "'");
         }
          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
         
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $c_id));
        
        break;
          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
         
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $c_id));
        
        break;
							   


	   
		
		   
		 

//update_category_ind
case 'insert_category_ind':
case 'update_category_ind':
       if (isset($HTTP_GET_VARS['cID'])) $categories_id = tep_db_prepare_input($HTTP_GET_VARS['cID']);
	   $c_id =  tep_db_prepare_input($HTTP_POST_VARS['c_id']);
	   $c_sep = tep_db_prepare_input($HTTP_POST_VARS['c_sep']);
	   $sql_data_array = array('c_id' => $c_id,
	                           'c_sep'=> $c_sep);
		
		if ($action == 'insert_category_ind'){
		tep_db_perform(TABLE_SHIPPING_MODE, $sql_data_array);
		}
		elseif ($action == 'update_category_ind'){
		tep_db_query("update " . TABLE_SHIPPING_MODE . " set c_sep = '" . tep_db_input($c_sep) . "' where c_id=" . $c_id);
	    } 
	  
	   
		if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
    
	 tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $c_id));
        break;
		
//delete_category_confirm
case 'delete_category_confirm':
       if (isset($HTTP_GET_VARS['cID'])) $categories_id = tep_db_prepare_input($HTTP_GET_VARS['cID']); 
          $r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		  $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		  
        tep_db_query("delete  from ". TABLE_SHIPPING_RATES . " where rate_id = '" . tep_db_input($r_id) . "'");
		
		if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
    
	 tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $categories_id));
        break;
// delete category tbl confirm
case 'delete_category_tbl_confirm':
       if (isset($HTTP_GET_VARS['cID'])) $categories_id = tep_db_prepare_input($HTTP_GET_VARS['cID']); 
          $r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		  $c_id = tep_db_prepare_input($HTTP_POST_VARS['c_id']);
		  
        tep_db_query("delete  from ". TABLE_SHIPPING_TABLE_RATES . " where rate_id = '" . tep_db_input($r_id) . "'");
		
		if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
    
	 tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $categories_id));
        break;
 

		
//insert update product
      case 'insert_product':
      case 'update_product':
       
          if (isset($HTTP_POST_VARS['p_id'])){
		 $products_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_rate = tep_db_prepare_input($HTTP_POST_VARS['p_rate']);
		$p_per = tep_db_prepare_input($HTTP_POST_VARS['p_per']);
		$p_free = tep_db_prepare_input($HTTP_POST_VARS['p_free']);
		$p_status = tep_db_prepare_input($HTTP_POST_VARS['p_status']);
      $sql_data_array = array('p_id' => $p_id,
	                          'p_rate'=> tep_db_input($p_rate),
							  'p_per'=> tep_db_input($p_per),
							  'p_free'=>tep_db_input($p_free),
							  'p_status'=>tep_db_input($p_status));
	 
		
          }
          if ($action == 'insert_product') {
           
            tep_db_perform(TABLE_SHIPPING_RATES, $sql_data_array);
          
          } elseif ($action == 'update_product') {
		  
            tep_db_perform(TABLE_SHIPPING_RATES, $sql_data_array, 'update', "p_id = '" . (int)$products_id . "'");
           
          }

          

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }

          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products_id));
        
        break;
	
	//New Product Tbl	
	  case 'insert_product_tbl':
	   if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);
          
		$p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_qty  = tep_db_prepare_input($HTTP_POST_VARS['p_qty']);
		$p_tbl  = tep_db_prepare_input($HTTP_POST_VARS['p_tbl']);
		$p_ind = tep_db_prepare_input($HTTP_POST_VARS['p_ind']);
     
	  $sql_data_array = array('p_id' => $p_id,
	                          'p_qty'=> tep_db_input($p_qty),
							  'p_tbl'=> tep_db_input($p_tbl),
							  'p_ind'=>tep_db_input($p_ind));
	  tep_db_perform(TABLE_SHIPPING_TABLE_RATES, $sql_data_array);
	   if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
          
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $p_id));
        
        break;
		
	//Update Product Tbl
      case 'update_product_tbl':
       if (isset($HTTP_GET_VARS['rate_id'])) $rates_id = tep_db_prepare_input($HTTP_GET_VARS['rate_id']); 
         
	 $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		$p_qty  = tep_db_prepare_input($HTTP_POST_VARS['p_qty']);
		$p_tbl  = tep_db_prepare_input($HTTP_POST_VARS['p_tbl']);
        $p_ind = tep_db_prepare_input($HTTP_POST_VARS['p_ind']);
	  $sql_data_array = array('p_id' => $p_id,
	                          'p_qty'=> tep_db_input($p_qty),
							  'p_tbl'=> tep_db_input($p_tbl),
							  'p_ind'=>tep_db_input($p_ind));
							  
		//SSPP End
          
        
          
           tep_db_perform(TABLE_SHIPPING_TABLE_RATES, $sql_data_array, 'update', "rate_id = '" . tep_db_input($r_id) . "'");

          

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
         
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products_id));
        
        break;
      
  
		

//update product mode
case 'insert_product_mode':	
case 'update_product_mode':
       if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']); 
       $p_id =  tep_db_prepare_input($HTTP_POST_VARS['p_id']);
	   $p_mode = tep_db_prepare_input($HTTP_POST_VARS['p_mode']);
	   if ($p_mode == '0'){
	   //free
        $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_per = '0';
		$p_status = '0'; 
		$p_free = '1';
        $sql_data_array = array('p_id' => $p_id,
							  'p_per'=> tep_db_input($p_per),
							  'p_status'=>tep_db_input($p_status),
							  'p_free'=>tep_db_input($p_free));
		
		 
	    $p_stat = '0';
        $p_ind = '0';
	    $sql_data_array2 = array('p_id' => $p_id,
							  'p_stat' => $p_stat,
	                          'p_ind'=> $p_ind);
	  	   

		   }
		   if ($p_mode == '1'){
	   //flat
        $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_per = '0';
		$p_status = '1'; 
		$p_free = '0';
        $sql_data_array = array('p_id' => $p_id,
							  'p_per'=> tep_db_input($p_per),
							  'p_status'=>tep_db_input($p_status),
							  'p_free'=>tep_db_input($p_free));
		
		 
	    $p_stat = '0';
        $p_ind = '0';
	    $sql_data_array2 = array('p_id' => $p_id,
							  'p_stat' => $p_stat,
	                          'p_ind'=> $p_ind);
	  	   

		   }
		   
		  if ($p_mode == '2'){
	   //flat per
        $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_per = '1';
		$p_status = '1'; 
		$p_free = '0';
        $sql_data_array = array('p_id' => $p_id,
							  'p_per'=> tep_db_input($p_per),
							  'p_status'=>tep_db_input($p_status),
							  'p_free'=>tep_db_input($p_free));
		
		 
	    $p_stat = '0';
        $p_ind = '0';
	    $sql_data_array2 = array('p_id' => $p_id,
							  'p_stat' => $p_stat,
	                          'p_ind'=> $p_ind);
	  	   

		   }
		if ($p_mode == '3'){
	   //tbl
        $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_per = '0';
		$p_status = '0'; 
		$p_free = '0';
        $sql_data_array = array('p_id' => $p_id,
							  'p_per'=> tep_db_input($p_per),
							  'p_status'=>tep_db_input($p_status),
							  'p_free'=>tep_db_input($p_free));
		
		 
	    $p_stat = '1';
        $p_ind = '0';
	    $sql_data_array2 = array('p_id' => $p_id,
							  'p_stat' => $p_stat,
	                          'p_ind'=> $p_ind);
	  	   

		   }
		if ($p_mode == '4'){
	    
		//tbl per
        $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		$p_per = '0';
		$p_status = '0'; 
		$p_free = '0';
        $sql_data_array = array('p_id' => $p_id,
							  'p_per'=> tep_db_input($p_per),
							  'p_status'=>tep_db_input($p_status),
							  'p_free'=>tep_db_input($p_free));
		
		 
	    $p_stat = '1';
        $p_ind = '1';
	    $sql_data_array2 = array('p_id' => $p_id,
							  'p_stat' => $p_stat,
	                          'p_ind'=> $p_ind);
	  	   

		   }
		 $sql_data_array3 = array('p_id' => $p_id,
							   'p_mode'=> tep_db_input($p_mode));
		//insert					   
		if ($action == 'insert_product_mode') {
		//[the following update query's are only  enacted if a flat or table rate is set]
		 //flat 
           tep_db_query("update ". TABLE_SHIPPING_RATES ." set p_per = '" . tep_db_input($p_per) ."', p_status = '" . tep_db_input($p_status) ."',  p_free = '" .tep_db_input($p_free)."' where p_id ='" . tep_db_input($p_id) . "'");
          
		   //table 
          tep_db_query("update ". TABLE_SHIPPING_TABLE_RATES ." set p_stat = '" . tep_db_input($p_stat) ."', p_ind = '" . tep_db_input($p_ind) ."' where p_id ='" . tep_db_input($p_id) . "'");
		
		//mode
		tep_db_perform(TABLE_SHIPPING_MODE, $sql_data_array3);
		} 
	//update
		elseif ($action == 'update_product_mode') {
		   
		   //flat table
           tep_db_query("update ". TABLE_SHIPPING_RATES ." set p_per = '" . tep_db_input($p_per) ."', p_status = '" . tep_db_input($p_status) ."',  p_free = '" .tep_db_input($p_free)."' where p_id ='" . tep_db_input($p_id) . "'");
          
		   //table rates
          tep_db_query("update ". TABLE_SHIPPING_TABLE_RATES ." set p_stat = '" . tep_db_input($p_stat) ."', p_ind = '" . tep_db_input($p_ind) ."' where p_id ='" . tep_db_input($p_id) . "'");
		  
		  //mode
		  tep_db_query("update " . TABLE_SHIPPING_MODE . " set  p_mode = '" .tep_db_input($p_mode)."' where p_id ='" . tep_db_input($p_id) . "'");
        
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
         
          tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $p_id));
        
        break;
		
//update_product_ind
case 'insert_product_ind':
case 'update_product_ind':
        if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']); 
	   $p_id =  tep_db_prepare_input($HTTP_POST_VARS['p_id']);
	   $p_sep = tep_db_prepare_input($HTTP_POST_VARS['p_sep']);
	   $sql_data_array = array('p_id' => $p_id,
	                           'p_sep'=> $p_sep);
		
		if ($action == 'insert_product_ind'){
		tep_db_perform(TABLE_SHIPPING_MODE, $sql_data_array);
		}
		elseif ($action == 'update_product_ind'){
		tep_db_query("update " . TABLE_SHIPPING_MODE . " set p_sep = '" . tep_db_input($p_sep) . "' where p_id=" . $p_id);
	    } 
		if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
    
	 tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $p_id));
        break;
		

     //delete product confirm 
  case 'delete_product_confirm':
        if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']); 
         $r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		 $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		 
         
       
	  tep_db_query("delete  from ". TABLE_SHIPPING_RATES . " where rate_id = '" . tep_db_input($r_id) . "'"); 

	     if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

         tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $p_id));
        break;

//delete product tbl confirm
 case 'delete_product_tbl_confirm':
        if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']); 
         $r_id = tep_db_prepare_input($HTTP_POST_VARS['rate_id']);
		 $p_id = tep_db_prepare_input($HTTP_POST_VARS['p_id']);
		 
         
       
	  tep_db_query("delete  from ". TABLE_SHIPPING_TABLE_RATES . " where rate_id = '" . tep_db_input($r_id) . "'"); 

	     if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

         tep_redirect(tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $p_id));
        break;		     
        
       
      
     
    }
  }
// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top">

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE .'&nbsp; &nbsp;'. HEADING_VER; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo tep_draw_form('search', FILENAME_SEPARATE_RATE, '', 'get');
    echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search');
    echo tep_hide_session_id() . '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo tep_draw_form('goto', FILENAME_SEPARATE_RATE, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
    echo tep_hide_session_id() . '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SEPARATE_SHIPPING; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $categories_count = 0;
    $rows = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $search = tep_db_prepare_input($HTTP_GET_VARS['search']);

      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($search) . "%' order by c.sort_order, cd.categories_name");
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    }
    while ($categories = tep_db_fetch_array($categories_query)) {
      $categories_count++;
      $rows++;

// Get parent_id for subcategories if search
      if (isset($HTTP_GET_VARS['search'])) $cPath= $categories['parent_id'];

      if ((!isset($HTTP_GET_VARS['cID']) && !isset($HTTP_GET_VARS['pID']) || (isset($HTTP_GET_VARS['cID']) && ($HTTP_GET_VARS['cID'] == $categories['categories_id']))) && !isset($cInfo) ) {
        $category_childs = array('childs_count' => tep_childs_in_category_count($categories['categories_id']));
        $category_products = array('products_count' => tep_products_in_category_count($categories['categories_id']));
        
        $cInfo_array = array_merge($categories, $category_childs, $category_products);
        $cInfo = new objectInfo($cInfo_array);
		//category rate query
        $c_rate_query = tep_db_query("select rate_id, c_rate, c_status, c_free, c_per from " . TABLE_SHIPPING_RATES ." where c_id =" . $cInfo->categories_id );
	    if ($c_rate_query !=''){
		$crate = tep_db_fetch_array($c_rate_query);
		}
		//category table query
		$c_tbl_query = tep_db_query("select rate_id, c_qty, c_tbl, c_ind, c_stat from " . TABLE_SHIPPING_TABLE_RATES ." where c_id =" . $cInfo->categories_id );      
		//category mode
		$c_mode_query = tep_db_query("select c_mode, c_sep from " . TABLE_SHIPPING_MODE . "  where c_id =" . $cInfo->categories_id );
		
		if ($c_mode_query != ''){
		$crate2 = tep_db_fetch_array($c_mode_query);
		}
		
		if($crate['c_rate'] >= '0.00'){
		$rInfo2= new objectInfo($crate);
		}
		 
	}
		 
      if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SEPARATE_RATE, tep_get_path($categories['categories_id'])) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, tep_get_path($categories['categories_id'])) . '">' . tep_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $categories['categories_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $products_count = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_name like '%" . tep_db_input($search) . "%' order by pd.products_name");
    } else {
      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name");
    }
    while ($products = tep_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;

// Get categories_id for product if search
      if (isset($HTTP_GET_VARS['search'])) $cPath = $products['categories_id'];

      if ( (!isset($HTTP_GET_VARS['pID']) && !isset($HTTP_GET_VARS['cID']) || (isset($HTTP_GET_VARS['pID']) && ($HTTP_GET_VARS['pID'] == $products['products_id']))) && !isset($pInfo) && !isset($cInfo)  && !isset($rInfo4) ) {
// find out the rating average from customer reviews
        $reviews_query = tep_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$products['products_id'] . "'");
        $reviews = tep_db_fetch_array($reviews_query);
        $pInfo_array = array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
		
		// product rate query		
		$rate_query2 = tep_db_query("select  rate_id, p_rate, p_status, p_free, p_per from " . TABLE_SHIPPING_RATES ." where p_id =" . $pInfo->products_id ." group by rate_id " );
		if ($rate_query2 !=''){
	    $rate = tep_db_fetch_array($rate_query2);
		}
		
		//product table query
		$p_tbl_query = tep_db_query("select  rate_id, p_qty, p_tbl, p_ind, p_stat from " . TABLE_SHIPPING_TABLE_RATES ." where p_id =" . $pInfo->products_id . " group by rate_id");
		
		//product mode
		$p_mode_query = tep_db_query("select p_mode, p_sep from " . TABLE_SHIPPING_MODE . "  where p_id =" . $pInfo->products_id );
		
		if ($p_mode_query != ''){
		$rate2 = tep_db_fetch_array($p_mode_query);
		}
		
		if($rate['p_rate'] >='0.00'){
		$rInfo4= new objectInfo($rate);
		}
      }

      if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview&read=only') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview&read=only') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $products['products_name']; ?></td>
                <td class="dataTableContent" align="center">&nbsp;
<?php
     
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $cPath_back = '';
    if (sizeof($cPath_array) > 0) {
      for ($i=0, $n=sizeof($cPath_array)-1; $i<$n; $i++) {
        if (empty($cPath_back)) {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = (tep_not_null($cPath_back)) ? 'cPath=' . $cPath_back . '&' : '';
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br>' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?></td>
                    <td align="right" class="smallText"><?php if (sizeof($cPath_array) > 0) echo '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, $cPath_back . 'cID=' . $current_category_id) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;';  ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
	//new_category
      case 'new_category':
	  
	 
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('newcategory', FILENAME_SEPARATE_RATE, 'action=insert_category&cPath=' . $cPath , 'post' , 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

       //Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_RATE . '<br>' . tep_draw_input_field('c_rate', '','size ="10"' ));
		
		
        //Separate Shipping per Qty [SSPQ] End
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		
        break;
//new category table		
		 case 'new_category_tbl':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('newcategorytbl', FILENAME_SEPARATE_RATE, 'action=insert_category_tbl&cPath=' . $cPath , 'post' , 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

       //Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br>' . TEXT_SEPARATE_QTY . '&nbsp;' . tep_draw_input_field('c_qty', '','size ="8"' ). '&nbsp;' . TEXT_SEPARATE_TBL . '&nbsp;' . tep_draw_input_field('c_tbl', '','size ="8"' ));
		
        //Separate Shipping per Qty [SSPQ] End
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

//edit category
      case 'edit_category':
	    
	  
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		//Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_RATE . '<br>' . tep_draw_input_field('c_rate', '','size ="20"', $cInfo->c_rate ));
		
        //Separate Shipping per Qty [SSPQ] End
		
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

//edit category table
		case 'edit_category_tbl':
	   
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categoriestbl', FILENAME_SEPARATE_RATE, 'action=update_category_tbl&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		//Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		$contents[] = array('text'=> tep_draw_hidden_field('rate_id', $rInfo->rate_id));
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br>' . TEXT_SEPARATE_QTY . '&nbsp;' . tep_draw_input_field('c_qty', $rInfo->c_qty,'size ="8"' ). '&nbsp;' . TEXT_SEPARATE_TBL . '&nbsp;' . tep_draw_input_field('c_tbl', $rInfo->c_tbl,'size ="8"' ));
		
        //Separate Shipping per Qty [SSPQ] End
		
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&rate_id=' . $rInfo->rate_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
		
//edit category mode for future feel of module
case 'edit_category_mode':
        
	    $category_mode =   array(array('id' => '0', 'text' => ENTRY_FREE),
	                             array('id' => '1', 'text' => ENTRY_FLAT),
                                 array('id' => '2', 'text' => ENTRY_FLAT_PER),
								 array('id' => '3','text' => ENTRY_TABLE),
								 array('id' => '4','text' => ENTRY_TABLE_PER));
		
	   
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        
		if ($crate2['c_mode'] == ''){
		$contents = array('form' => tep_draw_form('categoriesmode', FILENAME_SEPARATE_RATE, 'action=insert_category_mode&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}
		else{
        $contents = array('form' => tep_draw_form('categoriesmode', FILENAME_SEPARATE_RATE, 'action=update_category_mode&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}
		
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_MODE . '<br>These modes are only enacted if a flat or table rate is present. <br>' . tep_draw_pull_down_menu('c_mode', $category_mode,$id));
		
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');		 
        break; 
		
//edit category ind for future feel of module
case 'edit_category_ind':
        
	    $category_ind =   array(array('id' => '0', 'text' => SHIP_ENTRY_NO),
	                             array('id' => '1', 'text' => SHIP_ENTRY_YES));
		
	   
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        
		if ($crate2['c_sep'] == ''){
        $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=insert_category_ind&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}
		else{
		 $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=update_category_ind&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		 }
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		
	    $contents[] = array('text'=> tep_draw_hidden_field('c_id', $cInfo->categories_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_IND . '<br>This only applies if the Use Individual rates with the default rates? is set to yes<br>' . tep_draw_pull_down_menu('c_sep', $category_ind,$id));
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');		 
        break; 
		
		
		
//delete_category
      case 'delete_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=delete_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
		$contents[] = array('text' =>"<br>". tep_draw_hidden_field('rate_id', $rInfo2->rate_id,'size="2"' )); 
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
		$contents[] = array('text' =>"<br>".  $rInfo2->c_rate );
        $contents[] = array('text' => '<br><b>' . $cInfo->categories_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break; 
//delete category tbl	
 case 'delete_category_tbl':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=delete_category_tbl_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
		$contents[] = array('text' =>"<br>". tep_draw_hidden_field('rate_id', $rInfo->rate_id,'size="2"' )); 
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
		$contents[] = array('text' => TEXT_SEPARATE_QTY . $rInfo->c_qty  . '&nbsp;' . TEXT_SEPARATE_TBL . '&nbsp;' . $rInfo->c_tbl );
        $contents[] = array('text' => '<br><b>' . $cInfo->categories_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      
//new product
		 case 'new_product':
	     
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('newproduct', FILENAME_SEPARATE_RATE, 'action=insert_product&cPath=' . $cPath , 'post' , 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_PRODUCT_INTRO);

       //Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		if ($rate['p_rate'] == ''){
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_RATE . '<br>' . tep_draw_input_field('p_rate', '','size ="10"', $pInfo->p_rate ));
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		}
        break;
		
//edit product
      case 'edit_product':
	 
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('editproduct', FILENAME_SEPARATE_RATE, 'action=update_product&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		//Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_RATE . '<br>' . tep_draw_input_field('p_rate', $rInfo2->p_rate,'size ="10"'  ));
		if ($rate['p_status'] == '0'){
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FLAT .'<br>'. tep_draw_selection_field('p_status','radio','1',false) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_status','radio','0',true) . SHIPPING_ENTRY_NO);
		} else {
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FLAT .'<br>'. tep_draw_selection_field('p_status','radio','1',true) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_status','radio','0',false) . SHIPPING_ENTRY_NO);
		}
		if ($rate['p_per'] == '0' ){
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FLAT_PER .'<br>'. tep_draw_selection_field('p_per','radio','1',false) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_per','radio','0',true) . SHIPPING_ENTRY_NO);
		} else {
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FLAT_PER .'<br>'. tep_draw_selection_field('p_per','radio','1',true) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_per','radio','0',false) . SHIPPING_ENTRY_NO);
		}
		if ($rate['p_free'] == '0'){
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FREE .'<br>'. tep_draw_selection_field('p_free','radio','1',false) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_free','radio','0',true) . SHIPPING_ENTRY_NO);
		} else {
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_FREE .'<br>'. tep_draw_selection_field('p_free','radio','1',true) . SHIPPING_ENTRY_YES . "&nbsp; &nbsp;" . tep_draw_selection_field('p_free','radio','0',false) . SHIPPING_ENTRY_NO);
		}
		
        //Separate Shipping per Qty [SSPQ] End
		
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
		
//new product tbl		
		 case 'new_product_tbl':
	 
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('newproducttable', FILENAME_SEPARATE_RATE, 'action=insert_product_tbl&cPath=' . $cPath , 'post' , 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_PRODUCT_INTRO);

       //Separate Shipping per Qty [SSPQ]
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br>' . TEXT_SEPARATE_QTY . '&nbsp;' . tep_draw_input_field('p_qty', '','size ="8"', $pInfo->p_qty ). '&nbsp;' . TEXT_SEPARATE_TBL . '&nbsp;' . tep_draw_input_field('p_tbl', '','size ="8"', $pInfo->p_tbl ));
        //Separate Shipping per Qty [SSPQ] End
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
		
//edit product table
		case 'edit_product_tbl':
	    
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('editproduct', FILENAME_SEPARATE_RATE, 'action=update_product_tbl&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		//Separate Shipping per Qty [SSPQ]
	    
		
		$contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br>' . TEXT_SEPARATE_QTY . '&nbsp;'. TEXT_SEPARATE_TBL);
		
		$contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		$contents[] = array('text' =>"<br>". tep_draw_hidden_field('rate_id', $rInfo->rate_id,'size="2"' )); 
		$contents[] = array('text' => tep_draw_input_field('p_qty', $rInfo->p_qty,'size ="8"').'&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . tep_draw_input_field('p_tbl', $rInfo->p_tbl,'size ="8"' ));
		
        //Separate Shipping per Qty [SSPQ] End
		
        $contents[] = array('align' => 'right', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&rate_id=' . $rInfo->rate_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		
        break;

//edit product mode for future feel of module

case 'edit_product_mode':
        
	    $product_mode =   array(array('id' => '0', 'text' => ENTRY_FREE),
	                             array('id' => '1', 'text' => ENTRY_FLAT),
                                 array('id' => '2', 'text' => ENTRY_FLAT_PER),
								 array('id' => '3','text' => ENTRY_TABLE),
								 array('id' => '4','text' => ENTRY_TABLE_PER));
		
	   
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        
		if ($rate2['p_mode'] == ''){
		$contents = array('form' => tep_draw_form('products_mode', FILENAME_SEPARATE_RATE, 'action=insert_product_mode&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}
		else{
       
        $contents = array('form' => tep_draw_form('products_mode', FILENAME_SEPARATE_RATE, 'action=update_product_mode&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_MODE . '<br>These modes are only enacted if a flat or table rate is present. <br>' . tep_draw_pull_down_menu('p_mode', $product_mode,$id));
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');		 
        break;

//edit product ind for future feel of module
case 'edit_product_ind':
        
	    $product_ind =   array(array('id' => '0', 'text' => SHIP_ENTRY_NO),
	                             array('id' => '1', 'text' => SHIP_ENTRY_YES));
		
	   
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');
        if ($rate2['p_sep'] == ''){
		 $contents = array('form' => tep_draw_form('products_ind', FILENAME_SEPARATE_RATE, 'action=insert_product_ind&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
		}else{
        $contents = array('form' => tep_draw_form('products_ind', FILENAME_SEPARATE_RATE, 'action=update_product_ind&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );}
        $contents[] = array('text' => TEXT_EDIT_INTRO);
        
		
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_MODE . '<br>This only applies if the Use Individual rates with the default rates? is set to yes<br>' . tep_draw_pull_down_menu('p_sep', $product_ind,$id));
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');		 
        break; 		
		
//delete_product
case 'delete_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('products', FILENAME_SEPARATE_RATE, 'action=delete_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('p_id', $pInfo->products_id));
		$contents[] = array('text' => tep_draw_hidden_field('rate_id',$rInfo4->rate_id));
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
		$contents[] = array('text' => $rInfo4->p_rate);
        $contents[] = array('text' => '<br><b>' . $pInfo->products_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

// delete product table
case 'delete_product_tbl':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_SEPARATE_RATE, 'action=delete_product_tbl_confirm&cPath=' . $cPath) . tep_draw_hidden_field('p_id', $pInfo->products_id));
		$contents[] = array('text' =>"<br>". tep_draw_hidden_field('rate_id', $rInfo3->rate_id,'size="2"' )); 
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
		$contents[] = array('text' =>"<br>". $rInfo3->p_qty .'&nbsp; &nbsp;' . $rInfo3->p_tbl );
        $contents[] = array('text' => '<br><b>' . $pInfo->products_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
		

		     
      
		
		
		
		
//default right column text
// category text
      default:
        if ($rows > 0) {
          if (isset($cInfo) && is_object($cInfo)) { // category info box contents
            $category_path_string = '';
            $category_path = tep_generate_category_path($cInfo->categories_id);
            for ($i=(sizeof($category_path[0])-1); $i>0; $i--) {
              $category_path_string .= $category_path[0][$i]['id'] . '_';
            }
            $category_path_string = substr($category_path_string, 0, -1);
            
			
			
			
            $heading[] = array('text' => '<b>' . $cInfo->categories_name . '</b>');

           
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($cInfo->date_added));
            if (tep_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($cInfo->last_modified));
            $contents[] = array('text' => '<br>' . tep_info_image($cInfo->categories_image, $cInfo->categories_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br>' . $cInfo->categories_image);
			$config_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_DEFAULT_MODE'");
			if ($config_query !=''){
	    $config = tep_db_fetch_array($config_query);
		}   
		    $config_query2 = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_IND'");
			
			if ($config_query2 !=''){
	    $config2 = tep_db_fetch_array($config_query2);
		}
			if ($config['configuration_value'] != 'No' and $config2['configuration_value'] == 'Yes'){
			if($crate2['c_sep'] == '' xor $crate2['c_sep'] == '0'){
			$id = '0';
			$text = SHIP_ENTRY_NO;
			}elseif($crate2['c_sep'] == '1'){
			$id = '1';
			$text = SHIP_ENTRY_YES;
			}
		     $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SEPARATE_IND . '<br>' . $text );
			 $contents[] = array('text' => '<br><center><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo2->rate_id . '&id='. $id .'&action=edit_category_ind') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a></center>');
			 }
			 
			if ($crate2['c_mode'] == '0' ){
			$id = '0';
			$text = ENTRY_FREE ;
			}
			if ($crate2['c_mode'] == '1'){
			$id = '1';
			$text = ENTRY_FLAT ;
			}
			if ($crate2['c_mode'] == '2'){
			$id = '2';
			$text = ENTRY_FLAT_PER ;
			}
			if ($crate2['c_mode'] == '3'){
			$id = '3';
			$text = ENTRY_TABLE ;
			}
			if ($crate2['c_mode'] == '4'){
			$id = '4';
			$text = ENTRY_TABLE_PER ;
			}
			
			
			
		     $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SEPARATE_MODE . '<br>' . $text );
			 $contents[] = array('text' => '<br><center><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo2->rate_id . '&id='. $id .'&action=edit_category_mode') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a></center>');
			// flat rate heading text 
			$contents[] = array('text' => '<br>'. TEXT_SEPARATE_RATE  .'<br>' );
			
	       
			if ($crate['c_rate'] == ''){
			$contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=new_category') . '">' . tep_image_button('button_new_rate.gif', IMAGE_NEW_RATE) . '</a>&nbsp; ');
			
			 }
			elseif ($crate['c_rate'] != '') {
			
			  $contents[] = array('text' =>'<br>'. tep_draw_separator('pixel_trans.gif','110px', '20px') . $rInfo2->c_rate . '<br><br><center><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo2->rate_id .'&c_rate=' . $rInfo2->c_rate . '&action=edit_category') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo2->rate_id .'&c_rate=' . $rInfo2->c_rate . '&action=delete_category') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a></center>');
			 
			}
			//table text
             $contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br><b>' . TEXT_SEPARATE_QTY . tep_draw_separator('pixel_trans.gif','20px', '20px') . TEXT_SEPARATE_TBL .'</b><br><br>');
			if ($c_tbl_query !=''){
			while ($tbl = tep_db_fetch_array($c_tbl_query)){
		$rInfo = new objectInfo($tbl);
		   
					
			 $contents[] = array('text' =>tep_draw_separator('pixel_trans.gif','80px', '20px') . $rInfo->c_qty . tep_draw_separator('pixel_trans.gif','20px', '20px') . $rInfo->c_tbl .
		     '&nbsp; <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo->rate_id . '&c_qty=' . $rInfo->c_qty . '&c_tbl=' . $rInfo->c_tbl .'&action=edit_category_tbl') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&rate_id=' . $rInfo->rate_id . '&c_qty=' . $rInfo->c_qty . '&c_tbl=' . $rInfo->c_tbl .'&action=delete_category_tbl') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
			}
			}
			$contents[] = array('align' => 'center', 'text' =>'<br><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=new_category_tbl') . '">' . tep_image_button('button_new_tbl.gif', IMAGE_NEW_TBL_RATE) . '</a><hr>');
			
			
	   
        
			 
            $contents[] = array('text' => '<br>' . TEXT_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br>' . TEXT_PRODUCTS . ' ' . $cInfo->products_count);
	}		
// product info box contents
			
           
		  elseif (isset($pInfo) && is_object($pInfo)) { 
		  
		   
			 
			
		   
            $heading[] = array('text' => '<b>' . tep_get_products_name($pInfo->products_id, $languages_id) . '</b>');
            $contents[] = array('text' => '<br>' . tep_info_image($pInfo->products_image, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . $pInfo->products_image);
			$config_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_DEFAULT_MODE'");
			if ($config_query !=''){
	    $config = tep_db_fetch_array($config_query);
		}   
		    $config_query2 = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='MODULE_SHIPPING_SEPARATE_IND'");
			
			if ($config_query2 !=''){
	    $config2 = tep_db_fetch_array($config_query2);
		}
			
			if ($config['configuration_value'] != 'No' and $config2['configuration_value'] == 'Yes'){
			if($rate2['p_sep'] == '' xor $rate2['p_sep'] == '0'){
			$id = '0';
			$text = SHIP_ENTRY_NO;
			}elseif($rate2['p_sep'] == '1'){
			$id = '1';
			$text = SHIP_ENTRY_YES;
			}
		     $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SEPARATE_IND . '<br>' . $text );
			 $contents[] = array('text' => '<br><center><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo2->rate_id . '&id='. $id .'&action=edit_product_ind') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a></center>');
			 }
			
			if ($rate2['p_mode'] == '0' ){
			$id = '0';
			$text = ENTRY_FREE ;
			}
			if ($rate2['p_mode'] == '1'){
			$id = '1';
			$text = ENTRY_FLAT ;
			}
			if ($rate2['p_mode'] == '2'){
			$id = '2';
			$text = ENTRY_FLAT_PER ;
			}
			if ($rate2['p_mode'] == '3'){
			$id = '3';
			$text = ENTRY_TABLE ;
			}
			if ($rate2['p_mode'] == '4'){
			$id = '4';
			$text = ENTRY_TABLE_PER ;
			}
			
	      $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SEPARATE_MODE . '<br>' . $text );
			 $contents[] = array('text' => '<br><center><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo->rate_id . '&id='. $id .'&action=edit_product_mode') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a></center>');
       
        
		  /* */
			// flat rate heading text 
	        $contents[] = array('text' => '<br>'. TEXT_SEPARATE_RATE . '<br>' );
			
	      
			 
			 if ($rate['p_rate'] == ''){
			 $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . tep_image_button('button_new_rate.gif', IMAGE_NEW_RATE) . '</a><hr>');
			 }
			 elseif ($rate['p_rate'] !=''){
			 $contents[] = array('text' =>'<br>'. tep_draw_separator('pixel_trans.gif','110px', '20px') . $rInfo4->p_rate . tep_draw_separator('pixel_trans.gif','10px', '20px') . '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo4->rate_id .'&p_rate=' . $rInfo4->p_rate . '&action=edit_product') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo4->rate_id . '&action=delete_product') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
			 }
			 
			 
			 
			 $contents[] = array('text' => '<br>'. TEXT_SEPARATE_TBL_HEAD . '<br>' . TEXT_SEPARATE_QTY . '&nbsp;'. TEXT_SEPARATE_TBL);
			
			if ($p_tbl_query !=''){
			while ($tbl2 = tep_db_fetch_array($p_tbl_query)){
		  $rInfo3 = new objectInfo($tbl2);
			 $contents[] = array( 'text' =>$rInfo3->p_qty . tep_draw_separator('pixel_trans.gif','50px', '20px') . $rInfo3->p_tbl . 
		     '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo3->rate_id . '&p_qty=' . $rInfo3->p_qty . '&p_tbl=' . $rInfo3->p_tbl .'&action=edit_product_tbl') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&rate_id=' . $rInfo3->rate_id . '&action=delete_product_tbl') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
			}
			}
			$contents[] = array('align' => 'center', 'text' =>'<br><a href="' . tep_href_link(FILENAME_SEPARATE_RATE, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product_tbl') . '">' . tep_image_button('button_new_tbl.gif', IMAGE_NEW_TBL_RATE) . '</a><hr>');
			
			 // used for select box
			/*if ($rate['p_status'] == '0' and $rate['p_per'] == '0' and $rate['p_free'] == '1' and $rInfo3->p_stat == '0' and $rInfo3->p_ind == '0'){
			$id = '0';
			}
			if ($rate['p_status'] == '1' and $rate['p_per'] == '0' and $rate['p_free'] == '0' and $rInfo3->p_stat == '0' and $rInfo3->p_ind == '0'){
			$id = '1';
			}
			if ($rate['p_status'] == '1' and $rate['p_per'] == '1' and $rate['p_free'] == '0' and $rInfo3->p_stat == '0' and $rInfo3->p_ind == '0'){
			$id = '2';
			}
			if ($rate['p_status'] == '0' and $rate['p_per'] == '0' and $rate['p_free'] == '0' and $rInfo3->p_stat == '1' and $rInfo3->p_ind == '0'){
			$id = '3';
			}
			if ($rate['p_status'] == '0' and $rate['p_per'] == '0' and $rate['p_free'] == '0' and $rInfo3->p_stat == '1' and $rInfo3->p_ind == '1'){
			$id = '4';
			}
		
			$product_mode =   array(array('id' => '0', 'text' => ENTRY_FREE),
	                             array('id' => '1', 'text' => ENTRY_FLAT),
                                 array('id' => '2', 'text' => ENTRY_FLAT_PER),
								 array('id' => '3','text' => ENTRY_TABLE),
								 array('id' => '4','text' => ENTRY_TABLE_PER));
	   
          $contents [] = array('form' => tep_draw_form('product_mode', FILENAME_SEPARATE_RATE, 'action=update_product_mode&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') );
        
		
	    $contents[] = array('text'=> tep_draw_hidden_field('p_id', $pInfo->products_id));
		
		$contents[] = array('text' => '<br>' . TEXT_SEPARATE_MODE . '<br><center>' . tep_draw_pull_down_menu('p_mode', $product_mode, $id). '</center>');
		
		$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . '<hr>');*/
          
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS);
        }
        break;
    }
	}

    if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
	
?>
          </tr>
        </table></td>
      </tr>
    </table>

    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
