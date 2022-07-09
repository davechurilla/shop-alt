<?php
/*
  $Id: mail.php,v 1.31 2003/06/20 00:37:51 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
$action = (isset($_GET['action']) ? $_GET['action'] : '');



switch ($_GET['action']) {
  case 'createSets':
    if (empty($_POST['set_size'])) {
      $messageStack->add(ERROR_NO_SET_SIZE, 'error');
    }elseif (empty($_POST['products_options_id'])) {
      $messageStack->add(ERROR_NO_OPTION_SELECTED, 'error');
    }
    break;

 case 'saveSets':
    if (empty($_POST['products_attributes_sets_name']) ) {
      $messageStack->add(ERROR_NO_ATTRIBUTE_SET_NAME, 'error');
    }elseif (!empty($_POST['products_attributes_sets_name']) ) {
      // Insert new set row to attribute sets table
      $insert_sql="insert into ".TABLE_PRODUCTS_ATTRIBUTES_SETS. " (products_attributes_sets_id, products_attributes_sets_name, products_options_id) values ('','" . $_POST['products_attributes_sets_name'] . "'," . $_POST['products_options_id'] . ")";
      tep_db_query($insert_sql);
      $new_attribute_set_id = tep_db_insert_id();
   
      // Loop to Insert new elements rows to attribute sets table
      for($i=0; $i<$_POST['set_size']; $i++){
        $insert_sql="insert into ".TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " (products_attributes_sets_elements_id, products_attributes_sets_id, options_values_id, options_values_price, price_prefix, sort_order) values (''," . $new_attribute_set_id . "," . (int)$_POST['products_options_values_id_'.$i] . "," . tep_db_input($_POST['options_values_price_'.$i]) . ",'" . tep_db_input($_POST['price_prefix_'.$i]) . "'," . tep_db_input($_POST['sort_order_'.$i]) . ")";
        tep_db_query($insert_sql);
      }
      $messageStack->add(NOTICE_ATTRIBUTE_CREATED, 'success');
      tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS));
    }
    break;
        
  case 'updateSets':
   if (!empty($_POST['products_attributes_sets_name']) ){
      $update_sql = "UPDATE " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " SET products_attributes_sets_name = '" . $_POST['products_attributes_sets_name'] . "', products_options_id = " . (int)$_POST['products_options_id'] . " WHERE products_attributes_sets_id = " . (int)$_POST['products_attributes_sets_id'] ." ";
      tep_db_query($update_sql);
      for($i=0; $i<$_POST['set_size']; $i++){
        if( $_POST['remove_set_element'.$i] == "on" ){
          // INSTEAD OF SKIPPING WE NOW NEED TO DELETE THE ELEMENT TABLE ROW
          $delete_sql = "DELETE FROM " . TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " WHERE products_attributes_sets_elements_id = " . (int)$_POST['products_attributes_sets_elements_id_' . $i] . " "; 
          tep_db_query($delete_sql);
        }else{
          //NOW UPDATE THE SET ELEMENTS
          $update_sql= "UPDATE " . TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " SET options_values_id = " . (int)$_POST['products_options_values_id_'.$i] . ", options_values_price = " . $_POST['options_values_price_' . $i]. ", price_prefix = '" . $_POST['price_prefix_' . $i] . "', sort_order = " . $_POST['sort_order_'.$i] . " WHERE products_attributes_sets_elements_id = " . (int)$_POST['products_attributes_sets_elements_id_' . $i] . " ";
          tep_db_query($update_sql);
        } // end of else
      } // end loop
      if( !empty($_POST['newset_size']) && $_POST['newset_size']!= $_POST['set_size']){
        for($i=$_POST['set_size']+1; $i<($_POST['newset_size']+1); $i++){
          $insert_sql="insert into ".TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " (products_attributes_sets_elements_id, products_attributes_sets_id, options_values_id, options_values_price, price_prefix, sort_order) values ('', ". (int)$_POST['products_attributes_sets_id'].",'','',''," . $i . ")";
          tep_db_query($insert_sql);
        }
      }
	
      $messageStack->add_session(SUCCESS_ATTRIBUTE_SETS_SAVED, 'success');

      $arr_ProductsAttributeSetsIDs = array();
      $arr_ProductsAttributeSetsIDs[0] = $_POST['products_attributes_sets_id'];
      $arr_product_ids = array();
      $product_ids_query_sql = "select products_id from ".TABLE_PRODUCTS_ATTRIBUTES_SETS_TO_PRODUCTS." where  products_attributes_sets_id=".$_POST['products_attributes_sets_id'];
      $product_ids_query = tep_db_query($product_ids_query_sql);

      while($products_ids = tep_db_fetch_array($product_ids_query)) {
        jjg_db_attributeSets( $arr_ProductsAttributeSetsIDs, $products_ids['products_id'], "update_product" );
      }
      $messageStack->add_session(SUCCESS_PRODUCTS_UPDATED, 'success');
      tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS));
    }
   break;
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
      <table border="0" width="100%" cellspacing="0" cellpadding="0"><!-- Outer Table - Begin -->
        <tr>
          <td width="100%">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
              </tr>
            </table>
          </td>
        </tr>
      <tr>
    <td>
<?php
  if ( ($action == 'createSets') && !empty($_POST['products_options_id']) && !empty($_POST['set_size']) ) {
    echo tep_draw_form('attributeSets', FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=saveSets');
?>
             <table border="0"  cellpadding="2" cellspacing="2">
               <tr class="dataTableHeadingRow">
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_OPTION_NAME; ?></td>
				<td class="dataTableHeadingContent" align=center ><?php echo TABLE_HEADING_OPTION_VALUE; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRICE_PREFIX; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_OPTION_PRICE; ?></td>
				<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SORT_ORDER; ?></td>
               </tr>
               
 <?php
    $arr_option_names = array();
    $options_name_query_sql = "select po.products_options_name, po.products_options_id from " . TABLE_PRODUCTS_OPTIONS . " po where po.products_options_id=".$_POST['products_options_id'];
    $options_name_query = tep_db_query($options_name_query_sql);
    while( $options_name = tep_db_fetch_array($options_name_query) ){
      $option_name =  $options_name['products_options_name'];
      $option_id =  $options_name['products_options_id'];
    }

    $arr_option_values = array();
    $options_query_sql = "select pov.products_options_values_name, pov.products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po where pov2po.products_options_id = " . (int)$_POST['products_options_id'] . " and pov.products_options_values_id = pov2po.products_options_values_id order by pov.products_options_values_name";
    $options_query = tep_db_query($options_query_sql);
    while($option_values = tep_db_fetch_array($options_query)) {
      $arr_option_values[] = array('id' => $option_values['products_options_values_id'],'text' => $option_values['products_options_values_name'] );
    }
?>

<?php
    for($i=0; $i<$_POST['set_size']; $i++){
?>
              <tr>
				<td class="smallText" align=center><?php echo $option_name; ?></td>
				<td align=center><?php echo tep_draw_pull_down_menu('products_options_values_id_'.$i, $arr_option_values);?></td>
				<td align=center><?php echo tep_draw_input_field('price_prefix_'.$i,'+'," size=1 ");?></td>
				<td align=center><?php echo tep_draw_input_field('options_values_price_'.$i,'0'," size=10 ");?></td>
				<td align=center><?php echo tep_draw_input_field('sort_order_'.$i,$i+1," size=3 ");?></td>
              </tr>

<?php
}
?>

              <tr>
                <td colspan=5>
                  <?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?>
                  <?php echo tep_draw_hidden_field('products_options_id', $option_id); ?>
                  <?php echo tep_draw_hidden_field('set_size', $_POST['set_size']); ?>
                  <?php echo tep_draw_hidden_field('action', 'saveAttributeSet'); ?>
                </td>
              </tr>
              <tr>
                <th colspan="2" align=right><?php echo TEXT_SET_NAME ?></th>
                <td colspan="3">
                <?php echo tep_draw_input_field('products_attributes_sets_name');?>
                </td>
              </tr>
             <tr>
                <td colspan="5"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
             <tr>
                <td align="center" colspan=5>
                  <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>  ' ?>
				  <?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '50', '1'); ?>&nbsp;
                  <?php echo tep_image_submit('button_save.gif', IMAGE_SAVE_ATTRIBUTE_SET); ?>
               </td>
              </tr>
         </table></form></td>

<?php
  } elseif ( $action == 'insertNew' ){
?>
          <tr>
            <td><?php echo tep_draw_form('attributeSets', FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=createSets'); ?>

            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
    $arr_attributeSets = array();
    $arr_attributeSets[] = array('id' => '', 'text' => TEXT_SELECT_OPTION);
    $attributeSets_query = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_name");
    while($attributeSets_values = tep_db_fetch_array($attributeSets_query)) {
      $arr_attributeSets[] = array('id' => $attributeSets_values['products_options_id'],'text' => $attributeSets_values['products_options_name'] );
    }
?>
              <tr>
                <td class="main"><?php echo TEXT_CHOOSE_OPTION; ?></td>
                <td><?php echo tep_draw_pull_down_menu('products_options_id', $arr_attributeSets);?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_CHOOSE_SET_SIZE; ?></td>
                <td><?php echo tep_draw_input_field('set_size','', 'size=3');?></td>
              </tr>
              <tr>
                <td colspan="2" class="smallText"><?php echo TEXT_SIZE_NOTE ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right">
                  <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> '; ?>&nbsp;
                  <?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '50', '1'); ?>&nbsp;
                  <?php echo tep_image_submit('button_create.gif', IMAGE_CREATE_ATTRIBUTE_SET); ?>
                </td>
              </tr>
            </table></form></td>
          </tr>

<?php
  } elseif ( $action == 'delete' ){
    $attributeSetsNames_query = tep_db_query("select products_attributes_sets_name from " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " where products_attributes_sets_id = " . (int)$_GET['attset_id']);
?>
<tr><td colspan=2>
  <?php echo TEXT_DELETE_CONFIRM ?>
  <strong>
    <?php $arr_attributeSetsName_value = tep_db_fetch_array($attributeSetsNames_query); ?>
    <?php echo $arr_attributeSetsName_value['products_attributes_sets_name']; ?>
  </strong>
</td></tr>

<tr><td colspan=2><br>&nbsp;
 <?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '150', '1'); ?>&nbsp;
 <?php echo '<a href="' .tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS) . '">'; ?>
 <?php echo tep_image_button('button_cancel.gif', ' Cancel ') . '</a>'; ?>&nbsp;
 <?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '50', '1'); ?>&nbsp;
 <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=confirm&attset_id=' . $_GET['attset_id'], 'NONSSL') . '">'; ?>
 <?php echo tep_image_button('button_confirm.gif', ' confirm delete '); ?></a>
</td></tr>

<?php
  }elseif( $action == 'edit' ){
?>
          <tr>
            <td><?php echo tep_draw_form('attributeSets', FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=updateSets'); ?>

            <table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>

<?php
// GET ATTRIBUTE SET FROM DB - $attribute_set['products_attributes_sets_name']
    $attribute_set_sql = "SELECT pas.products_attributes_sets_id, pas.products_attributes_sets_name, pas.products_options_id, po.products_options_name, pase.products_attributes_sets_elements_id, pase.options_values_id, pase.options_values_price, pase.price_prefix, pase.sort_order FROM " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " pas, " . TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " pase, ". TABLE_PRODUCTS_OPTIONS . " po WHERE pas.products_attributes_sets_id = " . $_GET['attset_id'] . " AND pas.products_attributes_sets_id = pase.products_attributes_sets_id AND pas.products_options_id = po.products_options_id ORDER BY pase.sort_order";
    $attribute_set_query = tep_db_query($attribute_set_sql);
	$set_size = tep_db_num_rows($attribute_set_query);
	$rownum = -1;
    while ($attribute_set = tep_db_fetch_array($attribute_set_query)){
	  $rownum = $rownum +1;
	  if ($rownum == 0) {
	    $option_id = $attribute_set['products_options_id']; // easier migration
		$attribute_set_name = $attribute_set['products_attributes_sets_name'];
		$arr_option_values = array();
	    $options_query_sql = "SELECT pov.products_options_values_name, pov.products_options_values_id FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po where pov2po.products_options_id = '" . $attribute_set['products_options_id'] . "' and pov.products_options_values_id=pov2po.products_options_values_id order by pov.products_options_values_name";
	    $options_query = tep_db_query($options_query_sql);
        
		while($option_values = tep_db_fetch_array($options_query)) {
          $arr_option_values[] = array('id' => $option_values['products_options_values_id'],'text' => $option_values['products_options_values_name'] );
        }
?>
     <?php echo tep_draw_form('attributeSets', FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=saveSets'); ?>
	 <?php echo tep_draw_hidden_field('set_size', $set_size ); ?>
	 <?php echo tep_draw_hidden_field('products_options_id', $option_id ); ?>
	 <?php echo tep_draw_hidden_field('products_attributes_sets_id', $_GET['attset_id'] ); ?>

	 <table border="0"  cellpadding="2" cellspacing="2">
        <tr><td colspan="6"><?php echo tep_black_line(); ?></td></tr>
		<tr class="dataTableHeadingRow">
			<td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_OPTION_NAME; ?> </td>
			<td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_OPTION_VALUE; ?> </td>
			<td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_PRICE_PREFIX; ?> </td> 
            <td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_OPTION_PRICE; ?> </td>
			<td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_SORT_ORDER; ?> </td>
			<td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_REMOVE_SET; ?> </td>
		</tr>
        <tr><td colspan="6"><?php echo tep_black_line(); ?></td></tr>

	<?php
	  } // done table titles now do contents
 
			if( (int)$attribute_set['sort_order'] > 0 ){
			  $sortorder = $attribute_set['sort_order'];
			}else{
			  $sortorder = $rownum;
			}
	?>

	<?php echo tep_draw_hidden_field('products_attributes_sets_elements_id_'.$rownum, $attribute_set['products_attributes_sets_elements_id']); ?>
		<tr>
			<td class="smallText" align=center>
              <?php echo $attribute_set['products_options_name']; ?>
			</td>
			<td class="smallText" align=center>
              <?php echo tep_draw_pull_down_menu('products_options_values_id_'.$rownum, $arr_option_values, $attribute_set['options_values_id']);?>
			</td>
			<td align=center>
              <?php echo tep_draw_input_field('price_prefix_'.$rownum,$attribute_set['price_prefix']," size=1 ");?>
			</td>
			<td align=center>
              <?php echo tep_draw_input_field('options_values_price_'.$rownum,$attribute_set['options_values_price']," size=10 ");?>
			</td>
			<td align=center>
              <?php echo tep_draw_input_field('sort_order_'.$rownum,$sortorder," size=3 ");?>
			</td>
			<td align=center>
              <?php echo tep_draw_checkbox_field('remove_set_element'.$rownum);?>
			</td>
		</tr>

	<?php
//	  } //end else
	} // end while
	?>
        <tr><td colspan="6"><?php echo tep_black_line(); ?></td></tr>
		<tr>
		  <th colspan="3" align=right><?php echo TEXT_SET_NAME; ?></th>
		  <td colspan="3"><?php echo tep_draw_input_field('products_attributes_sets_name',$attribute_set_name); ?></td>
		</tr>
		<tr>
		  <td colspan="6"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
		</tr>
  
        <tr>
		  <th colspan="3" align=right><?php echo TEXT_NEW_SIZE ?></th>
		  <td colspan="3"> <?php echo tep_draw_input_field('newset_size', $set_size ); ?></td>
		</tr>
		<tr>
		  <td colspan="6"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
		</tr>
        <tr><td colspan="6"><?php echo tep_black_line(); ?></td></tr>
		<tr>
		  <td align="center" colspan=6>
		  <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' ?>&nbsp;
		  <?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '50', '1'); ?>&nbsp;
		  <?php echo tep_image_submit('button_save.gif', IMAGE_SAVE_ATTRIBUTE_SET); ?></td>
		</tr>
      </table></form></td>



<?php
  }else{//Default Attribute Set Page
  if( $action == 'confirm' ){
    tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " where products_attributes_sets_id= " . (int)$_GET['attset_id']);
	tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_SETS_ELEMENTS . " where products_attributes_sets_id= " . (int)$_GET['attset_id']);
    tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_SETS_TO_PRODUCTS . " where products_attributes_sets_id= " . (int)$_GET['attset_id']);
  }

    $attributeSetsNames_query = tep_db_query("select products_attributes_sets_id, products_attributes_sets_name  from " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " where 1 order by products_attributes_sets_name");
 ?>
 <tr>
   <td>
     <table border="0" width="50%" cellspacing="0" cellpadding="1">
       <tr><td colspan="2"><?php echo tep_black_line(); ?></td></tr>
       <tr class="dataTableHeadingRow">
         <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SET_NAME ?></td>
         <td class="dataTableHeadingContent"><?php echo tep_draw_separator('pixel_trans.gif', '40', '1'). TABLE_HEADING_ACTIONS; ?></td>
      </tr>
      <tr><td colspan="2"><?php echo tep_black_line(); ?></td></tr>

 <?php
    $rows =0;
    while($arr_attributeSetsName_values = tep_db_fetch_array($attributeSetsNames_query)) {
      $rows++;
 ?>

      <tr class=" <?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?> " >
    	<td class="smallText">
    		<?php echo $arr_attributeSetsName_values['products_attributes_sets_name']; ?>
    	</td>
        <td class="smallText">
        	<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=delete&attset_id=' . $arr_attributeSetsName_values['products_attributes_sets_id'], 'NONSSL') . '">'; ?>
        	<?php echo tep_image_button('button_delete.gif', ' delete '); ?></a>
        	<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=edit&attset_id=' . $arr_attributeSetsName_values['products_attributes_sets_id'], 'NONSSL') . '">'; ?>
        	<?php echo tep_image_button('button_edit.gif', ' edit '); ?></a>
        </td>
    </tr>
 <?php
    }
 ?>
    <tr><td colspan="2"><?php echo tep_black_line(); ?></td></tr>
    <tr>
        <td colspan=2 align=center><?php echo tep_draw_separator('pixel_trans.gif', '80', '1'); ?>
        	<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES_SETS, 'action=insertNew', 'NONSSL') . '">'; ?>
        	<?php echo tep_image_button('button_insert.gif', ' insert new Attribute Set '); ?></a>
        </td>
    </tr>
<tr><td colspan="2"><?php echo tep_black_line(); ?></td></tr>
</table>

  </td>
  </tr>
<?php
  }
?>
<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');