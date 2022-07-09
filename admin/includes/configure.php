<?php
  define('HTTP_SERVER', 'https://shop.advancedlasertraining.com');
  define('HTTP_CATALOG_SERVER', 'http://shop.advancedlasertraining.com');
  define('HTTPS_CATALOG_SERVER', 'https://shop.advancedlasertraining.com');
  define('ENABLE_SSL_CATALOG', 'true');
  define('DIR_FS_DOCUMENT_ROOT', '/home/churilla/shop.advancedlasertraining.com/');
  define('DIR_WS_ADMIN', '/admin/');
  define('DIR_FS_ADMIN', '/home/churilla/shop.advancedlasertraining.com/admin/');
  define('DIR_WS_CATALOG', '/');
  define('DIR_FS_CATALOG', '/home/churilla/shop.advancedlasertraining.com/');
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');

  define('DB_SERVER', 'mysql.advancedlasertraining.com');
  define('DB_SERVER_USERNAME', 'advlaser');
  define('DB_SERVER_PASSWORD', 'I^uI3JJC');
  define('DB_DATABASE', 'shop_advlaser');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'mysql');
  
// BOF Product Type Option
  define('PRODUCTS_OPTIONS_TYPE_SELECT', 0);
  define('PRODUCTS_OPTIONS_TYPE_TEXT', 1);
  define('PRODUCTS_OPTIONS_TYPE_RADIO', 2);
  define('PRODUCTS_OPTIONS_TYPE_CHECKBOX', 3);
  define('PRODUCTS_OPTIONS_TYPE_TEXTAREA', 4);
  define('TEXT_PREFIX', 'txt_');

  define('PRODUCTS_OPTIONS_VALUE_TEXT_ID', 0);  //Must match id for user defined "TEXT" value in db table TABLE_PRODUCTS_OPTIONS_VALUES

// EOF Product Type Option  
  
?>