<?php
/*
  $Id: get_1_free.php,v 1.1 2007/03/27 jck Exp $
  $From: specials.php,v 1.41 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        tep_db_query("update " . TABLE_GET_1_FREE . "
                      set status = '" . (int)$_GET['flag'] . "',
                          date_status_change = now()
                      where get_1_free_id = '" . (int)$_GET['fID'] . "'"
                    );

        tep_redirect(tep_href_link(FILENAME_GET_1_FREE, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'fID=' . $_GET['fID'], 'NONSSL'));
        break;
        
      case 'insert':
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $products_free_id = tep_db_prepare_input($_POST['products_free_id']);  
        $products_free_quantity = tep_db_prepare_input($_POST['products_free_quantity']);
        $products_qualify_quantity = tep_db_prepare_input($_POST['products_qualify_quantity']);
        $products_multiple = tep_db_prepare_input($_POST['products_multiple']);
        $day = tep_db_prepare_input($_POST['day']);
        $month = tep_db_prepare_input($_POST['month']);
        $year = tep_db_prepare_input($_POST['year']);

        $expires_date = '';
        if (tep_not_null($day) && tep_not_null($month) && tep_not_null($year)) {
          $expires_date = $year;
          $expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
          $expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
        }

        tep_db_query("insert into " . TABLE_GET_1_FREE . "
                                  (products_id,
                                   products_free_id,
                                   products_free_quantity,
                                   products_qualify_quantity,
                                   products_multiple,
                                   get_1_free_date_added,
                                   get_1_free_expires_date,
                                   status)
                      values ('" . (int)$products_id . "',
                              '" . tep_db_input($products_free_id) . "',
                              '" . tep_db_input($products_free_quantity) . "',
                              '" . tep_db_input($products_qualify_quantity) . "',
                              '" . tep_db_input($products_multiple) . "',
                              now(),
                              '" . tep_db_input($expires_date) . "',
                              '1')"
                    );
        $get_1_free_id = tep_db_insert_id();
        
        tep_redirect(tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . (int)$get_1_free_id ));
        break;
        
      case 'update':
        $get_1_free_id = tep_db_prepare_input($_POST['get_1_free_id']);
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $products_free_id = tep_db_prepare_input($_POST['products_free_id']);
        $products_free_quantity = tep_db_prepare_input($_POST['products_free_quantity']);
        $products_qualify_quantity = tep_db_prepare_input($_POST['products_qualify_quantity']);
        $products_multiple = tep_db_prepare_input($_POST['products_multiple']);
        $day = (int)tep_db_prepare_input($_POST['day']);
        $month = (int)tep_db_prepare_input($_POST['month']);
        $year = (int)tep_db_prepare_input($_POST['year']);
        $expires_date = '';
        if (tep_not_null($day) && tep_not_null($month) && tep_not_null($year)) {
          $expires_date = $year;
          $expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
          $expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
        }

        tep_db_query("update " . TABLE_GET_1_FREE . "
                      set products_free_id = '" . tep_db_input($products_free_id) . "',
                          products_free_quantity = '" . tep_db_input($products_free_quantity) . "',
                          products_free_quantity = '" . tep_db_input($products_free_quantity) . "',
                          products_qualify_quantity = '" . tep_db_input($products_qualify_quantity) . "',
                          products_multiple = '" . tep_db_input($products_multiple) . "',
                          get_1_free_last_modified = now(),
                          get_1_free_expires_date = '" . $expires_date . "'
                      where get_1_free_id = '" . (int)$get_1_free_id . "'"
                      );

        tep_redirect(tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . (int)$get_1_free_id));
        break;
        
      case 'deleteconfirm':
        $get_1_free_id = tep_db_prepare_input($_GET['fID']);

        tep_db_query("delete from " . TABLE_GET_1_FREE . "
                      where get_1_free_id = '" . (int)$get_1_free_id . "'"
                    );

        tep_redirect(tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
?>
<link rel="stylesheet" type="text/css" href="includes/javascript/calendar.css">
<script language="JavaScript" src="includes/javascript/calendarcode.js"></script>
<?php
  }
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<div id="popupcalendar" class="text"></div>
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
    $form_action = 'insert';
    if ( ($action == 'edit') && isset($_GET['fID']) ) {
      $form_action = 'update';

      $product_qualify_query = tep_db_query("select p.products_id,
                                                    pd.products_name,
                                                    g1f.products_free_id,
                                                    g1f.products_free_quantity,
                                                    g1f.products_qualify_quantity,
                                                    g1f.products_multiple,
                                                    g1f.status,
                                                    g1f.get_1_free_expires_date
                                            from " . TABLE_PRODUCTS . " p,
                                                 " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                                 " . TABLE_GET_1_FREE . " g1f
                                            where p.products_id = pd.products_id
                                              and pd.language_id = '" . (int)$languages_id . "'
                                              and p.products_id = g1f.products_id
                                              and g1f.get_1_free_id = '" . (int)$_GET['fID'] . "'"
                                           );
      $product_qualify = tep_db_fetch_array($product_qualify_query);
      $fInfo = new objectInfo($product_qualify);
    } else {
      $fInfo = new objectInfo(array());

// create an array of products already set for get 1 free, which will be
//   excluded from the pull down menu of products
//   (when creating a new product promotion)
      $get_1_free_array = array();
      $get_1_free_query = tep_db_query("select p.products_id
                                        from " . TABLE_PRODUCTS . " p,
                                             " . TABLE_GET_1_FREE . " g1f
                                        where g1f.products_id = p.products_id"
                                      );
      while ($get_1_free = tep_db_fetch_array($get_1_free_query)) {
        $get_1_free_array[] = $get_1_free['products_id'];
      }
    }
?>
      <tr><form name="new_get_1_free" <?php echo 'action="' . tep_href_link(FILENAME_GET_1_FREE, tep_get_all_get_params(array('action', 'info', 'fID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post">
<?php if ($form_action == 'update') echo tep_draw_hidden_field('get_1_free_id', $_GET['fID']); ?>
        <td><br><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_PRODUCT; ?>&nbsp;</td>
            <td class="main">
<?php
    if ( ($action == 'edit') && isset($_GET['fID']) ) {
      echo '<b>' . $fInfo->products_name . '</b>';
      echo tep_draw_hidden_field('products_id', $fInfo->products_id);
    } else {
      echo tep_draw_products_pull_down('products_id', 'style="font-size:10px"', $get_1_free_array);
    }
?>
            </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_PRODUCTS_QUALIFY_QUANTITY; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('products_qualify_quantity', (isset($fInfo->products_qualify_quantity) ? $fInfo->products_qualify_quantity : '')); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_PRODUCTS_MULTIPLE ; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('products_multiple', (isset($fInfo->products_multiple) ? $fInfo->products_multiple : '')); ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_PRODUCTS_FREE; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_products_pull_down('products_free_id', 'style="font-size:10px"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_PRODUCTS_FREE_QUANTITY; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('products_free_quantity', (isset($fInfo->products_free_quantity) ? $fInfo->products_free_quantity : '')); ?></td>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_GET_1_FREE_EXPIRES_DATE; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('day', (isset($fInfo->expires_date) ? substr($fInfo->expires_date, 8, 2) : ''), 'size="2" maxlength="2" class="cal-TextBox"') . tep_draw_input_field('month', (isset($fInfo->expires_date) ? substr($fInfo->expires_date, 5, 2) : ''), 'size="2" maxlength="2" class="cal-TextBox"') . tep_draw_input_field('year', (isset($fInfo->expires_date) ? substr($fInfo->expires_date, 0, 4) : ''), 'size="4" maxlength="4" class="cal-TextBox"'); ?><a class="so-BtnLink" href="javascript:calClick();return false;" onmouseover="calSwapImg('BTN_date', 'img_Date_OVER',true);" onmouseout="calSwapImg('BTN_date', 'img_Date_UP',true);" onclick="calSwapImg('BTN_date', 'img_Date_DOWN');showCalendar('new_get_1_free','dteWhen','BTN_date');return false;"><?php echo tep_image(DIR_WS_IMAGES . 'cal_date_up.gif', 'Calendar', '22', '17', 'align="absmiddle" name="BTN_date"'); ?></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><br><?php echo TEXT_GET_1_FREE_PRICE_TIP; ?></td>
            <td class="main" align="right" valign="top"><br><?php echo (($form_action == 'insert') ? tep_image_submit('button_insert.gif', IMAGE_INSERT) : tep_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . (isset($_GET['f
            ID']) ? '&fID=' . $_GET['fID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $get_1_free_query_raw = "select p.products_id,
                                    pd.products_name,
                                    p.products_price,
                                    g1f.get_1_free_id,
                                    g1f.products_free_id,
                                    g1f.products_free_quantity,
                                    g1f.products_qualify_quantity,
                                    g1f.products_multiple,
                                    g1f.get_1_free_date_added,
                                    g1f.get_1_free_last_modified,
                                    g1f.get_1_free_expires_date,
                                    g1f.date_status_change,
                                    g1f.status
                             from " . TABLE_PRODUCTS . " p,
                                  " . TABLE_GET_1_FREE . " g1f,
                                  " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             where p.products_id = pd.products_id
                               and pd.language_id = '" . (int)$languages_id . "'
                               and p.products_id = g1f.products_id
                             order by pd.products_name";
    $get_1_free_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $get_1_free_query_raw, $get_1_free_query_numrows);
    $get_1_free_query = tep_db_query($get_1_free_query_raw);
    while ($get_1_free = tep_db_fetch_array($get_1_free_query)) {
      if ((!isset($_GET['fID']) || (isset($_GET['fID']) && ($_GET['fID'] == $get_1_free['get_1_free_id']))) && !isset($fInfo)) {
        $fInfo_array = $get_1_free;
        $fInfo = new objectInfo($get_1_free);
      }

      if (isset($fInfo) && is_object($fInfo) && ($get_1_free['get_1_free_id'] == $fInfo->get_1_free_id)) {
        echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $fInfo->get_1_free_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $get_1_free['get_1_free_id']) . '\'">' . "\n";
      }
?>
                <td  class="dataTableContent"><?php echo $get_1_free['products_name']; ?></td>
                <td  class="dataTableContent" align="right">
<?php
      if ($get_1_free['status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'action=setflag&flag=0&fID=' . $get_1_free['get_1_free_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'action=setflag&flag=1&fID=' . $get_1_free['get_1_free_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($fInfo) && is_object($fInfo) && ($get_1_free['get_1_free_id'] == $fInfo->get_1_free_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $get_1_free['get_1_free_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $get_1_free_split->display_count($get_1_free_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_GET_1_FREE); ?></td>
                    <td class="smallText" align="right"><?php echo $get_1_free_split->display_links($get_1_free_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&action=new') . '">' . tep_image_button('button_new_product.gif', IMAGE_NEW_PRODUCT) . '</a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_get_1_free . '</b>');
      $contents = array('form' => tep_draw_form('get_1_free', FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $fInfo->get_1_free_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $fInfo->products_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $fInfo->get_1_free_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($fInfo)) {
        $product_free_query = tep_db_query("select products_name
                                            from " . TABLE_PRODUCTS_DESCRIPTION . "
                                            where products_id = '" . (int)$fInfo->products_free_id . "'"
                                   );
        $product_free = tep_db_fetch_array($product_free_query);
        
        $heading[] = array('text' => '<b>' . $fInfo->products_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $fInfo->get_1_free_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_GET_1_FREE, 'page=' . $_GET['page'] . '&fID=' . $fInfo->get_1_free_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . tep_date_short($fInfo->get_1_free_date_added));
        $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . tep_date_short($fInfo->get_1_free_last_modified));
        $contents[] = array('text' => '<br>' . TEXT_INFO_PRODUCTS_QUALIFY_QUANTITY . ' ' . $fInfo->products_qualify_quantity);
        $contents[] = array('text' => '' . TEXT_INFO_PRODUCTS_MULTIPLE . ' ' . $fInfo->products_multiple);
        $contents[] = array('text' => '<br>' . TEXT_INFO_PRODUCTS_FREE . ' ' . $product_free['products_name']);
        $contents[] = array('text' => '' . TEXT_INFO_PRODUCTS_FREE_QUANTITY . ' ' . $fInfo->products_free_quantity);
        $contents[] = array('text' => '<br>' . TEXT_INFO_EXPIRES_DATE . ' <b>' . tep_date_short($fInfo->get_1_free_expires_date) . '</b>');
        $contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . ' ' . tep_date_short($fInfo->date_status_change));
      }
      break;
  }
  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
}
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
