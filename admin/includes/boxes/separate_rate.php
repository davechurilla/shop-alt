<?php
/*
  $Id: separate_rate.php 1710 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  
  Copyright (c) 2013 rpetet of r-pdesigns.com and webdev22 of wolfftanning.com
  Based on the tools.php file in includes/boxes/ Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- separate_shipping //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_SEPARATE_SHIPPING,
                     'link'  => tep_href_link(FILENAME_SEPARATE_RATE, 'selected_box=separate_rate'));

  if ($selected_box == 'separate_rate') {
    $contents[] = array('text'  => '<a href="' . tep_href_link(FILENAME_SEPARATE_RATE) . '" class="menuBoxContentLink">' . BOX_SEPARATE_SHIPPING_RATE . '</a>');
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- separate_shipping_eof //-->
