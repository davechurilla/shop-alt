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
    case 'save':
	  $arr_attributeSetIDs = array();
      for($i=0; $i<$_POST['asRowCount']; $i++){
        if( isset($_POST['attSetId_'.$i]) ){
          $arr_attributeSetIDs[] = $_POST['attSetId_'.$i];
        }
      }
	  jjg_db_attributeSets($arr_attributeSetIDs, $_GET['products_id'], "update_product");
      $messageStack->add_session(SUCCESS_PRODUCT_UPDATE, 'success');
      tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' .$_GET['cPath']));
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
          			<tr><td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            			<td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          			</tr>
        			</table>
        		</td>
      		</tr>
      		<tr>
        		<td>

<?php
//******************************************************************************************
//******************************* Default Attribute Set Page *******************************
//******************************************************************************************

    $arrPAS_IDs = jjg_db_getAttributeSetId($_GET['pID']);



    $product_info_sql = "SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . "
    where products_id = " . (int)$_GET['pID'];
    $product_info_query = tep_db_query($product_info_sql);
    $product_info = tep_db_fetch_array($product_info_query);


    $attributeSetsNames_query = tep_db_query("select products_attributes_sets_id, products_attributes_sets_name  from " . TABLE_PRODUCTS_ATTRIBUTES_SETS . " where 1 order by products_attributes_sets_name");
 ?>
 <tr><td>
 <?php echo tep_draw_form("asEditForm",FILENAME_PRODUCTS_ATTRIBUTES_SETS_EDIT,'action=save&products_id='.$_GET['pID'].'&cPath='.$_GET['cPath']); ?>
 <table border="0" width="80%" cellspacing="0" cellpadding="1">
 <tr><td colspan="3" align=right>

        	<?php echo tep_image_submit('button_save.gif', ' save '); ?>
 </td></tr>
 <tr><td colspan="3"><?php echo tep_black_line(); ?></td></tr>
 <tr class="dataTableHeadingRow">
     <td class="dataTableHeadingContent"> <?php echo TABLE_HEADING_SETS ?></td>
     <td class="dataTableHeadingContent" align=center><?php echo TABLE_HEADING_ASSIGNED ?></td>
     <td class="dataTableHeadingContent">
         <?php echo tep_draw_separator('pixel_trans.gif', '40', '1'). TABLE_HEADING_PRODUCTNAME; ?>
         <font size=+1>
             <?php echo $product_info['products_name']; ?>
         </font>
         </td>
 </tr>
  <tr><td colspan="3"><?php echo tep_black_line(); ?></td></tr>


 <?php
    $rows =-1;
    while($arr_attributeSetsName_values = tep_db_fetch_array($attributeSetsNames_query)) {
    $rows++;
 ?>
    <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
    	<td class="smallText" colspan=3 valign=top>
    		<?php

        if(in_array($arr_attributeSetsName_values['products_attributes_sets_id'],$arrPAS_IDs)){
            $hasAttSet = true;
        }else{
            $hasAttSet = false;
        }

        echo tep_draw_checkbox_field("attSetId_".$rows,
            $arr_attributeSetsName_values['products_attributes_sets_id'],$hasAttSet) .
            tep_draw_separator('pixel_trans.gif', '20', '1') .
            $arr_attributeSetsName_values['products_attributes_sets_name'];


        ?><br><br>
    	</td>
    </tr>
 <?php
    }//end of while loop
 ?>
  <tr><td colspan="3"><?php echo tep_black_line(); ?></td></tr>
</table>
<?php echo tep_draw_hidden_field("asRowCount",++$rows); ?>
</form>
  </td>
  </tr>
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
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
