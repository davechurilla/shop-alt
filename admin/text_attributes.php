<?php
/*
  denuz, text attributes mod
  denuz@oscommerce-support.co.uk
*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['taID'])) $products_text_attributes_id = tep_db_prepare_input($_GET['taID']);
        $products_text_attributes_name = tep_db_prepare_input($_POST['products_text_attributes_name']);

        $sql_data_array = array('products_text_attributes_name' => $products_text_attributes_name);

        if ($action == 'insert') {
          tep_db_perform(TABLE_TEXT_ATTRIBUTES, $sql_data_array);
          $products_text_attributes_id = tep_db_insert_id();
        } elseif ($action == 'save') {
          tep_db_perform(TABLE_TEXT_ATTRIBUTES, $sql_data_array, 'update', "products_text_attributes_id = '" . (int)$products_text_attributes_id . "'");
        }

        tep_redirect(tep_href_link(FILENAME_TEXT_ATTRIBUTES, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'taID=' . $products_text_attributes_id));
        break;
      case 'deleteconfirm':
        $products_text_attributes_id = tep_db_prepare_input($_GET['taID']);

        tep_db_query("delete from " . TABLE_TEXT_ATTRIBUTES . " where products_text_attributes_id = '" . (int)$products_text_attributes_id . "'");

        tep_redirect(tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page']));
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
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEXT_ATTRIBUTES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $products_text_attributes_query_raw = "select products_text_attributes_id, products_text_attributes_name from " . TABLE_TEXT_ATTRIBUTES . " order by products_text_attributes_name";
  $products_text_attributes_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_text_attributes_query_raw, $products_text_attributes_query_numrows);
  $products_text_attributes_query = tep_db_query($products_text_attributes_query_raw);
  while ($products_text_attributes = tep_db_fetch_array($products_text_attributes_query)) {
    if ((!isset($_GET['taID']) || (isset($_GET['taID']) && ($_GET['taID'] == $products_text_attributes['products_text_attributes_id']))) && !isset($taInfo) && (substr($action, 0, 3) != 'new')) {
      $taInfo = new objectInfo($products_text_attributes);
    }

    if (isset($taInfo) && is_object($taInfo) && ($products_text_attributes['products_text_attributes_id'] == $taInfo->products_text_attributes_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $products_text_attributes['products_text_attributes_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $products_text_attributes['products_text_attributes_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $products_text_attributes['products_text_attributes_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($taInfo) && is_object($taInfo) && ($products_text_attributes['products_text_attributes_id'] == $taInfo->products_text_attributes_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $products_text_attributes['products_text_attributes_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $products_text_attributes_split->display_count($products_text_attributes_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TEXT_ATTRIBUTES); ?></td>
                    <td class="smallText" align="right"><?php echo $products_text_attributes_split->display_links($products_text_attributes_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_TEXT_ATTRIBUTE . '</b>');

      $contents = array('form' => tep_draw_form('products_text_attributes', FILENAME_TEXT_ATTRIBUTES, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_TEXT_ATTRIBUTES_NAME . '<br>' . tep_draw_input_field('products_text_attributes_name'));

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $_GET['taID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_TEXT_ATTRIBUTE . '</b>');

      $contents = array('form' => tep_draw_form('products_text_attributes', FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_TEXT_ATTRIBUTES_NAME . '<br>' . tep_draw_input_field('products_text_attributes_name', $taInfo->products_text_attributes_name));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_TEXT_ATTRIBUTE . '</b>');

      $contents = array('form' => tep_draw_form('products_text_attributes', FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $taInfo->products_text_attributes_name . '</b>');

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($taInfo) && is_object($taInfo)) {
        $heading[] = array('text' => '<b>' . $taInfo->products_text_attributes_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_TEXT_ATTRIBUTES, 'page=' . $_GET['page'] . '&taID=' . $taInfo->products_text_attributes_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
      }
      break;
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
    </table></td>
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
