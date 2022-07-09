<?php
/*
  $Id: customers.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- customers //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CUSTOMERS,
                     'link'  => tep_href_link(FILENAME_CUSTOMERS, 'selected_box=customers'));

  if ($selected_box == 'customers') {
// BOE Access with Level Account (v. 2.2a) for the Admin Area of osCommerce (MS2) 1 of 1
		$contents[] = array('text'  => tep_admin_files_boxes(FILENAME_CUSTOMERS, BOX_CUSTOMERS_CUSTOMERS) .
									tep_admin_files_boxes(FILENAME_REFERRALS, BOX_CUSTOMERS_REFERRALS) .
									tep_admin_files_boxes(FILENAME_LABEL_PRINT, BOX_CUSTOMERS_PRINTLABELS) . 
									tep_admin_files_boxes(FILENAME_CHANGE_PASSWORD, BOX_CUSTOMERS_CHANGE_PASSWORD) . 
									tep_admin_files_boxes(FILENAME_ORDERLIST, BOX_CUSTOMERS_ORDERLIST) . 
									tep_admin_files_boxes(FILENAME_BIRTHDAY, BOX_CUSTOMERS_BIRTHDAY) . 									 
                                   tep_admin_files_boxes(FILENAME_ORDERS, BOX_CUSTOMERS_ORDERS));
                                  
// EOE Access with Level Account (v. 2.2a) for the Admin Area of osCommerce (MS2) 1 of 1								   
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- customers_eof //-->
