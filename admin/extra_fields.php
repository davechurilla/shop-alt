<?php
/*
  $Id: manufacturers.php, v1.2 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($HTTP_GET_VARS['fID'])) $fields_id = tep_db_prepare_input($HTTP_GET_VARS['fID']);
        //$fields_name = tep_db_prepare_input($HTTP_POST_VARS['fields_name']);
        $fields_input_type = tep_db_prepare_input($HTTP_POST_VARS['fields_input_type']);
        $fields_input_value = tep_db_prepare_input($HTTP_POST_VARS['fields_input_value']);
        $fields_required_status =  tep_db_prepare_input($HTTP_POST_VARS['fields_required_status']);
        $fields_size = tep_db_prepare_input($HTTP_POST_VARS['fields_size']);
				$fields_required_email = tep_db_prepare_input($HTTP_POST_VARS['fields_required_email']);
        $sql_data_array = array('fields_status' => 1,
                                'fields_input_type' => $fields_input_type,
                                'fields_input_value' => $fields_input_value,
                                'fields_required_status' => $fields_required_status,
                                'fields_size' => $fields_size,
								'fields_required_email' => $fields_required_email);

        if ($action == 'insert') {
          tep_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array);
          $fields_id = tep_db_insert_id();
        } elseif ($action == 'save') {
          tep_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "'");
        }

        $languages = tep_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $fields_name_array = $HTTP_POST_VARS['fields_name'];
          $language_id = $languages[$i]['id'];

          $sql_data_array = array('fields_name' => tep_db_prepare_input($fields_name_array[$language_id]));

          if ($action == 'insert') {
            $insert_sql_data = array('fields_id' => $fields_id,
                                     'languages_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_EXTRA_FIELDS_INFO, $sql_data_array);
          } elseif ($action == 'save') {
            tep_db_perform(TABLE_EXTRA_FIELDS_INFO, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "' and languages_id = '" . (int)$language_id . "'");
          }
        }
        tep_redirect(tep_href_link(FILENAME_EXTRA_FIELDS, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'fID=' . $fields_id));
        break;
      case 'deleteconfirm':
        $fields_id = tep_db_prepare_input($HTTP_GET_VARS['fID']);

        tep_db_query("delete from " . TABLE_EXTRA_FIELDS . " where fields_id = '" . (int)$fields_id . "'");
        tep_db_query("delete from " . TABLE_EXTRA_FIELDS_INFO . " where fields_id = '" . (int)$fields_id . "'");
		tep_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where fields_id = '" . (int)$fields_id . "'");

        tep_redirect(tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page']));
        break;
      case 'setflag':
        $fields_id = tep_db_prepare_input($HTTP_GET_VARS['fID']);
        $flag = tep_db_prepare_input($HTTP_GET_VARS['flag']);

        $sql_data_array = array('fields_status' => $flag);
        tep_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "'");

        tep_redirect(tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page']));
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIELDS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $fields_query_raw = "select ce.fields_id, ce.fields_size, ce.fields_input_type, ce.fields_input_value, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_required_email from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where cei.fields_id=ce.fields_id and cei.languages_id =" . (int)$languages_id;
  $fields_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $fields_query_raw, $manufacturers_query_numrows);
  $fields_query = tep_db_query($fields_query_raw);
  while ($fields = tep_db_fetch_array($fields_query)) {
  if ((!isset($HTTP_GET_VARS['fID']) || (isset($HTTP_GET_VARS['fID']) && ($HTTP_GET_VARS['fID'] == $fields['fields_id']))) && !isset($fInfo) && (substr($action, 0, 3) != 'new')) {
      $fInfo = new objectInfo($fields);
  }

    if (isset($fInfo) && is_object($fInfo) && ($fields['fields_id'] == $fInfo->fields_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fields['fields_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fields['fields_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $fields['fields_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($fields['fields_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'action=setflag&flag=0&fID=' . $fields['fields_id'] . '&page=' . $HTTP_GET_VARS['page']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'action=setflag&flag=1&fID=' . $fields['fields_id'] . '&page=' . $HTTP_GET_VARS['page']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>              </td>
                <td class="dataTableContent" align="right"><?php if (isset($fInfo) && is_object($fInfo) && ($fields['fields_id'] == $fInfo->fields_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fields['fields_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $fields_split->display_count($manufacturers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_FIELDS); ?></td>
                    <td class="smallText" align="right"><?php echo $fields_split->display_links($manufacturers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="3" class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_FIELD . '</b>');

      $contents = array('form' => tep_draw_form('fields', FILENAME_EXTRA_FIELDS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $field_inputs_string = '';
      $languages = tep_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $field_inputs_string .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('fields_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME . $field_inputs_string);      
	  	$contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . '<br>' . tep_draw_radio_field('fields_input_type', 0, ($fInfo->fields_input_type==0) ? true : false) . TEXT_INPUT_FIELD . '<br>' .
																																							tep_draw_radio_field('fields_input_type', 1, ($fInfo->fields_input_type==1) ? true : false) . TEXT_TEXTAREA_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 2, ($fInfo->fields_input_type==2) ? true : false) . TEXT_RADIO_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 3, ($fInfo->fields_input_type==3) ? true : false) . TEXT_CHECK_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 4, ($fInfo->fields_input_type==4) ? true : false) . TEXT_DOWN_FIELD);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_VALUE . '<br>' . tep_draw_textarea_field('fields_input_value', 'nowrap', /*$width*/ 30, /*$height*/ 8, $fInfo->fields_input_value /*, $parameters = '', $reinsert_value = true*/));
			$contents[] = array('text' => '<br>' . TEXT_FIELD_REQUIRED_STATUS . '<br>' . tep_draw_radio_field('fields_required_status', 0, ($fInfo->fields_required_status==0) ? true : false) . 'false<br>' . tep_draw_radio_field('fields_required_status', 1, ($fInfo->fields_required_status==1) ? true : false) . 'true');
      $contents[] = array('text' =>  TEXT_FIELD_SIZE . '<br>' . tep_draw_input_field('fields_size',$fInfo->fields_size));
	  	$contents[] = array('text' => '<br>' . TEXT_FIELD_STATUS_EMAIL . '<br>' . tep_draw_radio_field('fields_required_email', 0, ($fInfo->fields_required_email==0) ? true : false) . 'false<br>' . tep_draw_radio_field('fields_required_email', 1, ($fInfo->fields_required_email==1) ? true : false) . 'true');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $HTTP_GET_VARS['fID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_FIELD . '</b>');

      $contents = array('form' => tep_draw_form('fields', FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $field_inputs_string = '';
      $languages = tep_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $field_inputs_string .= '<br>'. tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('fields_name[' . $languages[$i]['id'] . ']',tep_get_customers_extra_fields_name($fInfo->fields_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME . $field_inputs_string);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . '<br>' . tep_draw_radio_field('fields_input_type', 0, ($fInfo->fields_input_type==0) ? true : false) . TEXT_INPUT_FIELD . '<br>' .
																																							tep_draw_radio_field('fields_input_type', 1, ($fInfo->fields_input_type==1) ? true : false) . TEXT_TEXTAREA_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 2, ($fInfo->fields_input_type==2) ? true : false) . TEXT_RADIO_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 3, ($fInfo->fields_input_type==3) ? true : false) . TEXT_CHECK_FIELD . '<br>' .
                                                                              tep_draw_radio_field('fields_input_type', 4, ($fInfo->fields_input_type==4) ? true : false) . TEXT_DOWN_FIELD);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_VALUE . '<br>' . tep_draw_textarea_field('fields_input_value', 'nowrap', /*$width*/ 30, /*$height*/ 8, $fInfo->fields_input_value /*, $parameters = '', $reinsert_value = true*/));
			$contents[] = array('text' => '<br>' . TEXT_FIELD_REQUIRED_STATUS . '<br>' . tep_draw_radio_field('fields_required_status', 0, ($fInfo->fields_required_status==0) ? true : false) . 'false<br>' . tep_draw_radio_field('fields_required_status', 1, ($fInfo->fields_required_status==1) ? true : false) . 'true');
      $contents[] = array('text' =>  TEXT_FIELD_SIZE . '<br>' . tep_draw_input_field('fields_size', $fInfo->fields_size));
	  $contents[] = array('text' => '<br>' . TEXT_FIELD_STATUS_EMAIL . '<br>' . tep_draw_radio_field('fields_required_email',0,($fInfo->fields_required_email==0)?true:false) . 'false<br>' . tep_draw_radio_field('fields_required_email',1,($fInfo->fields_required_email==1)?true:false) . 'true');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_FIELD . '</b>');
      $contents = array('form' => tep_draw_form('manufacturers', FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $fInfo->fields_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($fInfo) && is_object($fInfo)) {
        $heading[] = array('text' => '<b>' . $fInfo->fields_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $HTTP_GET_VARS['page'] . '&fID=' . $fInfo->fields_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME .  $fInfo->fields_name);
				switch($fInfo->fields_input_type)
				{
				  case  0: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_INPUT_FIELD ); break;
				  case  1: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_TEXTAREA_FIELD ); break;
				  case  2: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_RADIO_FIELD ); break;
				  case  3: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_CHECK_FIELD ); break;
				  case  4: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_DOWN_FIELD ); break;
				  default: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_INPUT_FIELD );
				}
				$contents[] = array('text' => TEXT_FIELD_REQUIRED_STATUS . (($fInfo->fields_required_status==1) ? 'true' : 'false'));
        $contents[] = array('text' => TEXT_FIELD_SIZE .  $fInfo->fields_size);
		$contents[] = array('text' => TEXT_FIELD_REQUIRED_EMAIL . (($fInfo->fields_required_email==1) ? 'true' : 'false'));
        $contents[] = array('text' => '<br>');
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
