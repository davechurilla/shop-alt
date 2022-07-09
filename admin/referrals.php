<?php
/*
  $Id: referrals.php,v 1.00 2004/06/07 22:50:52 rmh Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2004 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['sID'])) $sources_id = tep_db_prepare_input($_GET['sID']);
        $sources_name = tep_db_prepare_input($_POST['sources_name']);

        $sql_data_array = array('sources_name' => $sources_name);

        if ($action == 'insert') {
          tep_db_perform(TABLE_SOURCES, $sql_data_array);
          $sources_id = tep_db_insert_id();
        } elseif ($action == 'save') {
          tep_db_perform(TABLE_SOURCES, $sql_data_array, 'update', "sources_id = '" . (int)$sources_id . "'");
        }

        tep_redirect(tep_href_link(FILENAME_REFERRALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $sources_id));
        break;
      case 'deleteconfirm':
        $sources_id = tep_db_prepare_input($_GET['sID']);

        tep_db_query("delete from " . TABLE_SOURCES . " where sources_id = '" . (int)$sources_id . "'");

        tep_redirect(tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page']));
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

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">

<?php //require(DIR_WS_INCLUDES . 'template_top.php'); ?>

<!-- header //-->
<?php
  require(DIR_WS_INCLUDES . 'header.php');
?>
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
 
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_REFERRALS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $sources_query_raw = "select sources_id, sources_name from " . TABLE_SOURCES . " order by sources_name";
  $sources_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $sources_query_raw, $sources_query_numrows);
  $sources_query = tep_db_query($sources_query_raw);
  while ($sources = tep_db_fetch_array($sources_query)) {
    if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $sources['sources_id']))) && !isset($sInfo) && (substr($action, 0, 3) != 'new')) {

      $sInfo = new objectInfo($sources);
    }

    if (isset($sInfo) && is_object($sInfo) && ($sources['sources_id'] == $sInfo->sources_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sources['sources_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sources['sources_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $sources['sources_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($sInfo) && is_object($sInfo) && ($sources['sources_id'] == $sInfo->sources_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sources['sources_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $sources_split->display_count($sources_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_REFERRALS); ?></td>
                    <td class="smallText" align="right"><?php echo $sources_split->display_links($sources_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_REFERRAL . '</b>');

      $contents = array('form' => tep_draw_form('sources', FILENAME_REFERRALS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_REFERRALS_NAME . '<br>' . tep_draw_input_field('sources_name'));

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $_GET['sID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_REFERRAL . '</b>');

      $contents = array('form' => tep_draw_form('sources', FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_REFERRALS_NAME . '<br>' . tep_draw_input_field('sources_name', $sInfo->sources_name));

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_REFERRAL . '</b>');

      $contents = array('form' => tep_draw_form('sources', FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $sInfo->sources_name . '</b>');

      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($sInfo) && is_object($sInfo)) {
        $heading[] = array('text' => '<b>' . $sInfo->sources_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_REFERRALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sources_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
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