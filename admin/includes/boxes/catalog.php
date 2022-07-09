<?php
/*
  $Id: catalog.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- catalog //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CATALOG,
                     'link'  => tep_href_link(FILENAME_CATEGORIES, 'selected_box=catalog'));

  if ($selected_box == 'catalog') {
   /* $contents[] = array('text'  => '<a href="' . tep_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_CATEGORIES_PRODUCTS . '</a><br>' . 
//Price editor	
	   '<a href="' . tep_href_link('price_editor.php', '', 'NONSSL') . '" class="menuBoxContentLink">Price Management</a><br>' . 
//Price editor
//Price updater
	
	                               '<a href="' . tep_href_link(FILENAME_PRICE_UPDATER, '', 'NONSSL') . '" class="menuBoxContentLink">' . 
BOX_CATALOG_PRICE_UPDATER . '</a><br>' . 
//Price updater

                                   '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES . '</a><br>' .
                                   '<a href="' . tep_href_link(FILENAME_CATEGORIES_EXTRA, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_CATEGORIES_EXTRA_DESCRIPTION . '</a><br />' . //Added for extra categories information
                                   '<a href="' . tep_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_MANUFACTURERS . '</a><br>' .
                                   '<a href="' . tep_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_REVIEWS . '</a><br>' .
                                   '<a href="' . tep_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_SPECIALS . '</a><br>' .                                   
                                   '<a href="' . tep_href_link(FILENAME_STAR_PRODUCT, '', 'NONSSL') . '" class="menuBoxContentLink">' . STAR_PRODUCT . '</a><br>' .
                                   //'<a href="' . tep_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_PRODUCTS_EXPECTED . '</a>');
                                   		//kgt - discount coupons
    															 '<a href="' . tep_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_PRODUCTS_EXPECTED . '</a><br>'. 
    															 '<a href="' . tep_href_link(FILENAME_DISCOUNT_COUPONS, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_DISCOUNT_COUPONS . '</a>' );
    															 //end kgt - discount coupons*/
																 
// BOE Access with Level Account (v. 2.2a) for the Admin Area of osCommerce (MS2) 1 of 1

    $contents[] = array('text'  =>tep_admin_files_boxes(FILENAME_CATEGORIES, BOX_CATALOG_CATEGORIES_PRODUCTS) .
							       tep_admin_files_boxes(FILENAME_PRICE_UPDATER, BOX_CATALOG_PRICE_UPDATER) . 
                                   tep_admin_files_boxes(FILENAME_PRODUCTS_ATTRIBUTES, BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES) . 
								   tep_admin_files_boxes(FILENAME_CATEGORIES_EXTRA, BOX_CATALOG_CATEGORIES_EXTRA_DESCRIPTION) . 
                                   tep_admin_files_boxes(FILENAME_MANUFACTURERS, BOX_CATALOG_MANUFACTURERS) . 
                                   tep_admin_files_boxes(FILENAME_REVIEWS, BOX_CATALOG_REVIEWS) . 
                                   tep_admin_files_boxes(FILENAME_GET_1_FREE, BOX_CATALOG_GET_1_FREE) . 
								   tep_admin_files_boxes(FILENAME_START_PRODUCT, BOX_CATALOG_START_PRODUCT) . 
                                   tep_admin_files_boxes(FILENAME_SPECIALS, BOX_CATALOG_SPECIALS) . 
								   tep_admin_files_boxes(FILENAME_DISCOUNT_COUPONS, BOX_CATALOG_DISCOUNT_COUPONS) . 
                                   // START: Product Extra Fields
									'<a href="' . tep_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_PRODUCTS_EXPECTED . '</a><br>' .
									 '<a href="' . tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_PRODUCTS_EXTRA_FIELDS . '</a>');
								   // END: Product Extra Fields
// EOE Access with Level Account (v. 2.2a) for the Admin Area of osCommerce (MS2) 1 of 1																 
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- catalog_eof //-->
