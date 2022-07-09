# osCommerce, Open Source E-Commerce Solutions
# http://www.oscommerce.com
#
# Database Backup For Advanced Laser Training
# Copyright (c) 2009 Christopher
#
# Database: shop_advlaser
# Database Server: mysql.advancedlasertraining.com
#
# Backup Date: 03/27/2009 10:31:40

drop table if exists address_book;
create table address_book (
  address_book_id int(11) not null auto_increment,
  customers_id int(11) not null ,
  entry_gender char(1) not null ,
  entry_company varchar(32) ,
  entry_firstname varchar(32) not null ,
  entry_lastname varchar(32) not null ,
  entry_street_address varchar(64) not null ,
  entry_suburb varchar(32) ,
  entry_postcode varchar(10) not null ,
  entry_city varchar(32) not null ,
  entry_state varchar(32) ,
  entry_country_id int(11) default '0' not null ,
  entry_zone_id int(11) default '0' not null ,
  PRIMARY KEY (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
);

insert into address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) values ('1', '1', 'm', 'ACME Inc.', 'John', 'Doe', '1 Way Street', '', '12345', 'NeverNever', '', '223', '12');
insert into address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) values ('2', '2', 'm', '', 'dave', 'churilla', '7600 w manchester', '', '90293', 'Playa del Rey', '', '223', '12');
insert into address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) values ('3', '3', '', NULL, 'dave', 'churilla', '7600 w manchester', NULL, '90293', 'Playa del Rey', '', '223', '12');
insert into address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) values ('4', '4', '', NULL, 'Chris', 'Owens', '25402 Nellie Gail Road', NULL, '92653', 'Laguna Hills', '', '223', '12');
insert into address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) values ('5', '5', '', NULL, 'Florence', 'Ng', '4080 Via Marisol Unit 230', NULL, '90042', 'Los Angeles', '', '223', '12');
drop table if exists address_format;
create table address_format (
  address_format_id int(11) not null auto_increment,
  address_format varchar(128) not null ,
  address_summary varchar(48) not null ,
  PRIMARY KEY (address_format_id)
);

insert into address_format (address_format_id, address_format, address_summary) values ('1', '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country', '$city / $country');
insert into address_format (address_format_id, address_format, address_summary) values ('2', '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country', '$city, $state / $country');
insert into address_format (address_format_id, address_format, address_summary) values ('3', '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country', '$state / $country');
insert into address_format (address_format_id, address_format, address_summary) values ('4', '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
insert into address_format (address_format_id, address_format, address_summary) values ('5', '$firstname $lastname$cr$streets$cr$postcode $city$cr$country', '$city / $country');
drop table if exists administrators;
create table administrators (
  id int(11) not null auto_increment,
  user_name varchar(32) not null ,
  user_password varchar(40) not null ,
  PRIMARY KEY (id)
);

insert into administrators (id, user_name, user_password) values ('1', 'advlaser', 'dae3e56201b8675911a2f24762a61e0a:ca');
insert into administrators (id, user_name, user_password) values ('2', 'cowens', '556c16b9e7a842d8c05f533f0474409a:a5');
drop table if exists banners;
create table banners (
  banners_id int(11) not null auto_increment,
  banners_title varchar(64) not null ,
  banners_url varchar(255) not null ,
  banners_image varchar(64) not null ,
  banners_group varchar(10) not null ,
  banners_html_text text ,
  expires_impressions int(7) default '0' ,
  expires_date datetime ,
  date_scheduled datetime ,
  date_added datetime not null ,
  date_status_change datetime ,
  status int(1) default '1' not null ,
  PRIMARY KEY (banners_id),
  KEY idx_banners_group (banners_group)
);

insert into banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status) values ('1', 'osCommerce', 'http://www.oscommerce.com', 'banners/oscommerce.gif', '468x50', '', '0', NULL, NULL, '2009-03-04 10:56:08', NULL, '1');
drop table if exists banners_history;
create table banners_history (
  banners_history_id int(11) not null auto_increment,
  banners_id int(11) not null ,
  banners_shown int(5) default '0' not null ,
  banners_clicked int(5) default '0' not null ,
  banners_history_date datetime not null ,
  PRIMARY KEY (banners_history_id),
  KEY idx_banners_history_banners_id (banners_id)
);

insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('1', '1', '8', '0', '2009-03-04 10:58:45');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('2', '1', '29', '0', '2009-03-06 02:27:04');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('3', '1', '42', '0', '2009-03-16 00:37:48');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('4', '1', '468', '0', '2009-03-17 00:19:51');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('5', '1', '412', '0', '2009-03-18 00:03:43');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('6', '1', '178', '0', '2009-03-19 05:51:04');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('7', '1', '449', '0', '2009-03-20 00:00:34');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('8', '1', '11', '0', '2009-03-21 19:22:42');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('9', '1', '63', '0', '2009-03-22 01:46:02');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('10', '1', '21', '0', '2009-03-23 08:12:41');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('11', '1', '9', '0', '2009-03-24 18:38:37');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('12', '1', '666', '0', '2009-03-25 00:39:36');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('13', '1', '239', '0', '2009-03-26 00:06:15');
insert into banners_history (banners_history_id, banners_id, banners_shown, banners_clicked, banners_history_date) values ('14', '1', '106', '0', '2009-03-27 08:35:09');
drop table if exists categories;
create table categories (
  categories_id int(11) not null auto_increment,
  categories_image varchar(64) ,
  parent_id int(11) default '0' not null ,
  sort_order int(3) ,
  date_added datetime ,
  last_modified datetime ,
  PRIMARY KEY (categories_id),
  KEY idx_categories_parent_id (parent_id)
);

insert into categories (categories_id, categories_image, parent_id, sort_order, date_added, last_modified) values ('1', 'cat_courses.jpg', '0', '1', '2009-03-04 10:56:08', '2009-03-18 04:49:58');
insert into categories (categories_id, categories_image, parent_id, sort_order, date_added, last_modified) values ('2', 'cat_accessories.jpg', '0', '2', '2009-03-04 10:56:08', '2009-03-18 04:50:19');
insert into categories (categories_id, categories_image, parent_id, sort_order, date_added, last_modified) values ('3', 'cat_brochures.jpg', '0', '3', '2009-03-04 10:56:08', '2009-03-18 02:36:18');
drop table if exists categories_description;
create table categories_description (
  categories_id int(11) default '0' not null ,
  language_id int(11) default '1' not null ,
  categories_name varchar(32) not null ,
  categories_description text ,
  PRIMARY KEY (categories_id, language_id),
  KEY idx_categories_name (categories_name)
);

insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('1', '1', 'Courses', 'Discover the potential benefits of the exciting world of laser dentistry and receive 8 CE credits upon successful completion of each course &mdash; live or online.<br />');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('2', '1', 'Laser Accessories', 'From handpieces to tips, from cleavers to education DVDs, we guarantee the highest quality and lowest prices, allowing you to have accessories at every set up.<br />');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('3', '1', 'Patient Brochures', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients.');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('1', '2', 'Hardware', 'Test description');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('2', '2', 'Software', 'Test description');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('3', '2', 'DVD Filme', '');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('1', '3', 'Hardware', 'Test description');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('2', '3', 'Software', 'Test description');
insert into categories_description (categories_id, language_id, categories_name, categories_description) values ('3', '3', 'Peliculas DVD', '');
drop table if exists configuration;
create table configuration (
  configuration_id int(11) not null auto_increment,
  configuration_title varchar(255) not null ,
  configuration_key varchar(255) not null ,
  configuration_value varchar(255) not null ,
  configuration_description varchar(255) not null ,
  configuration_group_id int(11) not null ,
  sort_order int(5) ,
  last_modified datetime ,
  date_added datetime not null ,
  use_function varchar(255) ,
  set_function varchar(255) ,
  PRIMARY KEY (configuration_id)
);

insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('1', 'Store Name', 'STORE_NAME', 'Advanced Laser Training', 'The name of my store', '1', '1', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('2', 'Store Owner', 'STORE_OWNER', 'Christopher', 'The name of my store owner', '1', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('3', 'E-Mail Address', 'STORE_OWNER_EMAIL_ADDRESS', 'clodds@aol.com', 'The e-mail address of my store owner', '1', '3', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('4', 'E-Mail From', 'EMAIL_FROM', '\"Christopher\" <clodds@aol.com>', 'The e-mail address used in (sent) e-mails', '1', '4', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('5', 'Country', 'STORE_COUNTRY', '223', 'The country my store is located in <br><br><b>Note: Please remember to update the store zone.</b>', '1', '6', NULL, '2009-03-04 10:56:08', 'tep_get_country_name', 'tep_cfg_pull_down_country_list(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('6', 'Zone', 'STORE_ZONE', '18', 'The zone my store is located in', '1', '7', NULL, '2009-03-04 10:56:08', 'tep_cfg_get_zone_name', 'tep_cfg_pull_down_zone_list(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('7', 'Expected Sort Order', 'EXPECTED_PRODUCTS_SORT', 'desc', 'This is the sort order used in the expected products box.', '1', '8', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'asc\', \'desc\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('8', 'Expected Sort Field', 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 'The column to sort by in the expected products box.', '1', '9', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'products_name\', \'date_expected\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('9', 'Switch To Default Language Currency', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 'Automatically switch to the language\'s currency when it is changed', '1', '10', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('10', 'Send Extra Order Emails To', 'SEND_EXTRA_ORDER_EMAILS_TO', '', 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;', '1', '11', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('11', 'Use Search-Engine Safe URLs (still in development)', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 'Use search-engine safe urls for all site links', '1', '12', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('12', 'Display Cart After Adding Product', 'DISPLAY_CART', 'true', 'Display the shopping cart after adding a product (or return back to their origin)', '1', '14', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('13', 'Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'false', 'Allow guests to tell a friend about a product', '1', '15', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('14', 'Default Search Operator', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 'Default search operators', '1', '17', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'and\', \'or\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('15', 'Store Address and Phone', 'STORE_NAME_ADDRESS', 'Store Name
Address
Country
Phone', 'This is the Store Name, Address and Phone used on printable documents and displayed online', '1', '18', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_textarea(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('16', 'Show Category Counts', 'SHOW_COUNTS', 'true', 'Count recursively how many products are in each category', '1', '19', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('17', 'Tax Decimal Places', 'TAX_DECIMAL_PLACES', '0', 'Pad the tax value this amount of decimal places', '1', '20', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('18', 'Display Prices with Tax', 'DISPLAY_PRICE_WITH_TAX', 'false', 'Display prices with tax included (true) or add the tax at the end (false)', '1', '21', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('19', 'First Name', 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 'Minimum length of first name', '2', '1', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('20', 'Last Name', 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 'Minimum length of last name', '2', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('21', 'Date of Birth', 'ENTRY_DOB_MIN_LENGTH', '10', 'Minimum length of date of birth', '2', '3', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('22', 'E-Mail Address', 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 'Minimum length of e-mail address', '2', '4', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('23', 'Street Address', 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 'Minimum length of street address', '2', '5', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('24', 'Company', 'ENTRY_COMPANY_MIN_LENGTH', '2', 'Minimum length of company name', '2', '6', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('25', 'Post Code', 'ENTRY_POSTCODE_MIN_LENGTH', '4', 'Minimum length of post code', '2', '7', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('26', 'City', 'ENTRY_CITY_MIN_LENGTH', '3', 'Minimum length of city', '2', '8', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('27', 'State', 'ENTRY_STATE_MIN_LENGTH', '2', 'Minimum length of state', '2', '9', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('28', 'Telephone Number', 'ENTRY_TELEPHONE_MIN_LENGTH', '3', 'Minimum length of telephone number', '2', '10', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('29', 'Password', 'ENTRY_PASSWORD_MIN_LENGTH', '5', 'Minimum length of password', '2', '11', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('30', 'Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', '2', '12', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('31', 'Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', '2', '13', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('32', 'Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of review text', '2', '14', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('33', 'Best Sellers', 'MIN_DISPLAY_BESTSELLERS', '1', 'Minimum number of best sellers to display', '2', '15', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('34', 'Also Purchased', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 'Minimum number of products to display in the \'This Customer Also Purchased\' box', '2', '16', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('35', 'Address Book Entries', 'MAX_ADDRESS_BOOK_ENTRIES', '5', 'Maximum address book entries a customer is allowed to have', '3', '1', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('36', 'Search Results', 'MAX_DISPLAY_SEARCH_RESULTS', '20', 'Amount of products to list', '3', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('37', 'Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of \'number\' links use for page-sets', '3', '3', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('38', 'Special Products', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 'Maximum number of products on special to display', '3', '4', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('39', 'New Products Module', 'MAX_DISPLAY_NEW_PRODUCTS', '9', 'Maximum number of new products to display in a category', '3', '5', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('40', 'Products Expected', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 'Maximum number of products expected to display', '3', '6', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('41', 'Manufacturers List', 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list', '3', '7', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('42', 'Manufacturers Select Size', 'MAX_MANUFACTURERS_LIST', '1', 'Used in manufacturers box; when this value is \'1\' the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.', '3', '7', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('43', 'Length of Manufacturers Name', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 'Used in manufacturers box; maximum length of manufacturers name to display', '3', '8', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('44', 'New Reviews', 'MAX_DISPLAY_NEW_REVIEWS', '6', 'Maximum number of new reviews to display', '3', '9', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('45', 'Selection of Random Reviews', 'MAX_RANDOM_SELECT_REVIEWS', '10', 'How many records to select from to choose one random product review', '3', '10', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('46', 'Selection of Random New Products', 'MAX_RANDOM_SELECT_NEW', '10', 'How many records to select from to choose one random new product to display', '3', '11', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('47', 'Selection of Products on Special', 'MAX_RANDOM_SELECT_SPECIALS', '10', 'How many records to select from to choose one random product special to display', '3', '12', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('48', 'Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', '3', '13', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('49', 'New Products Listing', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Maximum number of new products to display in new products page', '3', '14', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('50', 'Best Sellers', 'MAX_DISPLAY_BESTSELLERS', '10', 'Maximum number of best sellers to display', '3', '15', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('51', 'Also Purchased', 'MAX_DISPLAY_ALSO_PURCHASED', '6', 'Maximum number of products to display in the \'This Customer Also Purchased\' box', '3', '16', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('52', 'Customer Order History Box', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 'Maximum number of products to display in the customer order history box', '3', '17', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('53', 'Order History', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Maximum number of orders to display in the order history page', '3', '18', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('54', 'Product Quantities In Shopping Cart', 'MAX_QTY_IN_CART', '99', 'Maximum number of product quantities that can be added to the shopping cart (0 for no limit)', '3', '19', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('55', 'Small Image Width', 'SMALL_IMAGE_WIDTH', '100', 'The pixel width of small images', '4', '1', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('56', 'Small Image Height', 'SMALL_IMAGE_HEIGHT', '80', 'The pixel height of small images', '4', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('57', 'Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', '4', '3', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('58', 'Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', '4', '4', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('59', 'Subcategory Image Width', 'SUBCATEGORY_IMAGE_WIDTH', '162', 'The pixel width of subcategory images', '4', '5', '2009-03-18 01:20:08', '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('60', 'Subcategory Image Height', 'SUBCATEGORY_IMAGE_HEIGHT', '120', 'The pixel height of subcategory images', '4', '6', '2009-03-18 01:20:23', '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('61', 'Calculate Image Size', 'CONFIG_CALCULATE_IMAGE_SIZE', 'false', 'Calculate the size of images?', '4', '7', '2009-03-18 01:20:39', '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('62', 'Image Required', 'IMAGE_REQUIRED', 'true', 'Enable to display broken images. Good for development.', '4', '8', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('63', 'Gender', 'ACCOUNT_GENDER', 'false', 'Display gender in the customers account', '5', '1', '2009-03-20 04:05:05', '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('64', 'Date of Birth', 'ACCOUNT_DOB', 'false', 'Display date of birth in the customers account', '5', '2', '2009-03-20 04:05:11', '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('65', 'Company', 'ACCOUNT_COMPANY', 'false', 'Display company in the customers account', '5', '3', '2009-03-20 04:06:45', '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('66', 'Suburb', 'ACCOUNT_SUBURB', 'false', 'Display suburb in the customers account', '5', '4', '2009-03-20 04:06:52', '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('67', 'State', 'ACCOUNT_STATE', 'true', 'Display state in the customers account', '5', '5', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('68', 'Installed Modules', 'MODULE_PAYMENT_INSTALLED', 'authorizenet_cc_aim.php;authorizenet_cc_sim.php;cc.php;cod.php;moneyorder.php', 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)', '6', '0', '2009-03-26 16:58:27', '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('69', 'Installed Modules', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)', '6', '0', '2009-03-25 05:56:34', '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('70', 'Installed Modules', 'MODULE_SHIPPING_INSTALLED', 'flat.php', 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('71', 'Enable Cash On Delivery Module', 'MODULE_PAYMENT_COD_STATUS', 'True', 'Do you want to accept Cash On Delevery payments?', '6', '1', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('72', 'Payment Zone', 'MODULE_PAYMENT_COD_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', NULL, '2009-03-04 10:56:08', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('73', 'Sort order of display.', 'MODULE_PAYMENT_COD_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('74', 'Set Order Status', 'MODULE_PAYMENT_COD_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', NULL, '2009-03-04 10:56:08', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('75', 'Enable Credit Card Module', 'MODULE_PAYMENT_CC_STATUS', 'False', 'Do you want to accept credit card payments?', '6', '0', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('76', 'Split Credit Card E-Mail Address', 'MODULE_PAYMENT_CC_EMAIL', '', 'If an e-mail address is entered, the middle digits of the credit card number will be sent to the e-mail address (the outside digits are stored in the database with the middle digits censored)', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('77', 'Sort order of display.', 'MODULE_PAYMENT_CC_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('78', 'Payment Zone', 'MODULE_PAYMENT_CC_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', NULL, '2009-03-04 10:56:08', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('79', 'Set Order Status', 'MODULE_PAYMENT_CC_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', NULL, '2009-03-04 10:56:08', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('80', 'Enable Flat Shipping', 'MODULE_SHIPPING_FLAT_STATUS', 'True', 'Do you want to offer flat rate shipping?', '6', '0', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('81', 'Shipping Cost', 'MODULE_SHIPPING_FLAT_COST', '0', 'The shipping cost for all orders using this shipping method.', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('82', 'Tax Class', 'MODULE_SHIPPING_FLAT_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', '6', '0', NULL, '2009-03-04 10:56:08', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('83', 'Shipping Zone', 'MODULE_SHIPPING_FLAT_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', '6', '0', NULL, '2009-03-04 10:56:08', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('84', 'Sort Order', 'MODULE_SHIPPING_FLAT_SORT_ORDER', '0', 'Sort order of display.', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('85', 'Default Currency', 'DEFAULT_CURRENCY', 'USD', 'Default Currency', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('86', 'Default Language', 'DEFAULT_LANGUAGE', 'en', 'Default Language', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('87', 'Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', '6', '0', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('88', 'Display Shipping', 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 'Do you want to display the order shipping cost?', '6', '1', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('89', 'Sort Order', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '2', 'Sort order of display.', '6', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('90', 'Allow Free Shipping', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 'Do you want to allow free shipping?', '6', '3', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('91', 'Free Shipping For Orders Over', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 'Provide free shipping for orders over the set amount.', '6', '4', NULL, '2009-03-04 10:56:08', 'currencies->format', NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('92', 'Provide Free Shipping For Orders Made', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 'Provide free shipping for orders sent to the set destination.', '6', '5', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'national\', \'international\', \'both\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('93', 'Display Sub-Total', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 'Do you want to display the order sub-total cost?', '6', '1', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('94', 'Sort Order', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '1', 'Sort order of display.', '6', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('95', 'Display Tax', 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', 'Do you want to display the order tax value?', '6', '1', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('96', 'Sort Order', 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '3', 'Sort order of display.', '6', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('97', 'Display Total', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 'Do you want to display the total order value?', '6', '1', NULL, '2009-03-04 10:56:08', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('98', 'Sort Order', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '4', 'Sort order of display.', '6', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('99', 'Country of Origin', 'SHIPPING_ORIGIN_COUNTRY', '223', 'Select the country of origin to be used in shipping quotes.', '7', '1', NULL, '2009-03-04 10:56:08', 'tep_get_country_name', 'tep_cfg_pull_down_country_list(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('100', 'Postal Code', 'SHIPPING_ORIGIN_ZIP', 'NONE', 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.', '7', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('101', 'Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', '7', '3', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('102', 'Package Tare weight.', 'SHIPPING_BOX_WEIGHT', '3', 'What is the weight of typical packaging of small to medium packages?', '7', '4', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('103', 'Larger packages - percentage increase.', 'SHIPPING_BOX_PADDING', '10', 'For 10% enter 10', '7', '5', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('104', 'Display Product Image', 'PRODUCT_LIST_IMAGE', '1', 'Do you want to display the Product Image?', '8', '1', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('105', 'Display Product Manufaturer Name', 'PRODUCT_LIST_MANUFACTURER', '0', 'Do you want to display the Product Manufacturer Name?', '8', '2', NULL, '2009-03-04 10:56:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('106', 'Display Product Model', 'PRODUCT_LIST_MODEL', '0', 'Do you want to display the Product Model?', '8', '3', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('107', 'Display Product Name', 'PRODUCT_LIST_NAME', '2', 'Do you want to display the Product Name?', '8', '4', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('108', 'Display Product Price', 'PRODUCT_LIST_PRICE', '3', 'Do you want to display the Product Price', '8', '5', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('109', 'Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '0', 'Do you want to display the Product Quantity?', '8', '6', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('110', 'Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', '8', '7', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('111', 'Display Buy Now column', 'PRODUCT_LIST_BUY_NOW', '4', 'Do you want to display the Buy Now column?', '8', '8', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('112', 'Display Category/Manufacturer Filter (0=disable; 1=enable)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', '8', '9', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('113', 'Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '2', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', '8', '10', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('114', 'Check stock level', 'STOCK_CHECK', 'false', 'Check to see if sufficent stock is available', '9', '1', '2009-03-25 03:06:44', '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('115', 'Subtract stock', 'STOCK_LIMITED', 'false', 'Subtract product in stock by product orders', '9', '2', '2009-03-25 03:06:52', '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('116', 'Allow Checkout', 'STOCK_ALLOW_CHECKOUT', 'true', 'Allow customer to checkout even if there is insufficient stock', '9', '3', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('117', 'Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', '9', '4', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('118', 'Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', '9', '5', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('119', 'Store Page Parse Time', 'STORE_PAGE_PARSE_TIME', 'false', 'Store the time it takes to parse a page', '10', '1', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('120', 'Log Destination', 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/tep/page_parse_time.log', 'Directory and filename of the page parse time log', '10', '2', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('121', 'Log Date Format', 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 'The date format', '10', '3', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('122', 'Display The Page Parse Time', 'DISPLAY_PAGE_PARSE_TIME', 'true', 'Display the page parse time (store page parse time must be enabled)', '10', '4', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('123', 'Store Database Queries', 'STORE_DB_TRANSACTIONS', 'false', 'Store the database queries in the page parse time log (PHP4 only)', '10', '5', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('124', 'Use Cache', 'USE_CACHE', 'false', 'Use caching features', '11', '1', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('125', 'Cache Directory', 'DIR_FS_CACHE', '/tmp/', 'The directory where the cached files are saved', '11', '2', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('126', 'E-Mail Transport Method', 'EMAIL_TRANSPORT', 'sendmail', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.', '12', '1', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'sendmail\', \'smtp\'),');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('127', 'E-Mail Linefeeds', 'EMAIL_LINEFEED', 'LF', 'Defines the character sequence used to separate mail headers.', '12', '2', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'LF\', \'CRLF\'),');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('128', 'Use MIME HTML When Sending Emails', 'EMAIL_USE_HTML', 'false', 'Send e-mails in HTML format', '12', '3', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'),');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('129', 'Verify E-Mail Addresses Through DNS', 'ENTRY_EMAIL_ADDRESS_CHECK', 'false', 'Verify e-mail address through a DNS server', '12', '4', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('130', 'Send E-Mails', 'SEND_EMAILS', 'true', 'Send out e-mails', '12', '5', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('131', 'Enable download', 'DOWNLOAD_ENABLED', 'false', 'Enable the products download functions.', '13', '1', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('132', 'Download by redirect', 'DOWNLOAD_BY_REDIRECT', 'false', 'Use browser redirection for download. Disable on non-Unix systems.', '13', '2', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('133', 'Expiry delay (days)', 'DOWNLOAD_MAX_DAYS', '7', 'Set number of days before the download link expires. 0 means no limit.', '13', '3', NULL, '2009-03-04 10:56:09', NULL, '');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('134', 'Maximum number of downloads', 'DOWNLOAD_MAX_COUNT', '5', 'Set the maximum number of downloads. 0 means no download authorized.', '13', '4', NULL, '2009-03-04 10:56:09', NULL, '');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('135', 'Enable GZip Compression', 'GZIP_COMPRESSION', 'false', 'Enable HTTP GZip compression.', '14', '1', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('136', 'Compression Level', 'GZIP_LEVEL', '5', 'Use this compression level 0-9 (0 = minimum, 9 = maximum).', '14', '2', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('137', 'Session Directory', 'SESSION_WRITE_DIRECTORY', '/tmp', 'If sessions are file based, store them in this directory.', '15', '1', NULL, '2009-03-04 10:56:09', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('138', 'Force Cookie Use', 'SESSION_FORCE_COOKIE_USE', 'False', 'Force the use of sessions when cookies are only enabled.', '15', '2', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('139', 'Check SSL Session ID', 'SESSION_CHECK_SSL_SESSION_ID', 'False', 'Validate the SSL_SESSION_ID on every secure HTTPS page request.', '15', '3', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('140', 'Check User Agent', 'SESSION_CHECK_USER_AGENT', 'False', 'Validate the clients browser user agent on every page request.', '15', '4', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('141', 'Check IP Address', 'SESSION_CHECK_IP_ADDRESS', 'False', 'Validate the clients IP address on every page request.', '15', '5', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('142', 'Prevent Spider Sessions', 'SESSION_BLOCK_SPIDERS', 'True', 'Prevent known spiders from starting a session.', '15', '6', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('143', 'Recreate Session', 'SESSION_RECREATE', 'False', 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).', '15', '7', NULL, '2009-03-04 10:56:09', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('144', 'Installed Modules', 'MODULE_STS_INSTALLED', 'sts_default.php;sts_index.php;sts_product_info.php', 'This is automatically updated. No need to edit.', '6', '0', '2009-03-06 03:20:41', '2009-03-06 02:10:25', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('145', 'Use Templates?', 'MODULE_STS_DEFAULT_STATUS', 'true', 'Do you want to use Simple Template System?', '6', '1', NULL, '2009-03-06 02:10:33', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('146', 'Code for debug output', 'MODULE_STS_DEBUG_CODE', 'debug', 'Code to enable debug output from URL (ex: index.php?sts_debug=debug', '6', '2', NULL, '2009-03-06 02:10:33', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('147', 'Files for normal template', 'MODULE_STS_DEFAULT_NORMAL', 'sts_user_code.php', 'Files to include for a normal template, separated by semicolon', '6', '2', NULL, '2009-03-06 02:10:33', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('148', 'Base folder', 'MODULE_STS_TEMPLATES_FOLDER', 'includes/sts_templates/', 'Base folder where the templates folders are located. Relative to your catalog folder. Should end with a slash', '6', '2', NULL, '2009-03-06 02:10:33', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('149', 'Template folder', 'MODULE_STS_TEMPLATE_FOLDER', 'full', 'This is the template folder in use, located inside the previous parameter. Do not start nor end with a slash', '6', '2', NULL, '2009-03-06 02:10:33', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('150', 'Default template file', 'MODULE_STS_TEMPLATE_FILE', 'sts_template.html', 'Name of the default template file', '6', '2', NULL, '2009-03-06 02:10:33', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('151', 'Use template for infoboxes', 'MODULE_STS_INFOBOX_STATUS', 'true', 'Do you want to use templates for infoboxes?', '6', '1', NULL, '2009-03-06 02:10:33', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('152', 'Use template for index page', 'MODULE_STS_INDEX_STATUS', 'true', 'Do you want to use templates for index page?', '6', '1', NULL, '2009-03-06 03:20:34', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('153', 'Files for index.php template', 'MODULE_STS_INDEX_NORMAL', 'sts_user_code.php', 'Files to include for an index.php template, separated by semicolon', '6', '2', NULL, '2009-03-06 03:20:34', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('154', 'Check parent templates', 'MODULE_STS_INDEX_PARENT', 'true', 'Do you want to check for parent categories templates?', '6', '1', NULL, '2009-03-06 03:20:34', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('155', 'Use template for product info page', 'MODULE_STS_PRODUCT_INFO_STATUS', 'true', 'Do you want to use templates for product info pages?', '6', '1', NULL, '2009-03-06 03:20:40', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('156', 'Enable STS3 compatibility mode', 'MODULE_STS_PRODUCT_V3COMPAT', 'false', 'Do you want to enable the STS v3 compatibility mode (only for product info templates made with STS v2 and v3)?', '6', '1', NULL, '2009-03-06 03:20:40', NULL, 'tep_cfg_select_option(array(\'true\', \'false\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('157', 'Files for normal template', 'MODULE_STS_PRODUCT_INFO_NORMAL', 'sts_user_code.php', 'Files to include for a normal template, separated by semicolon', '6', '2', NULL, '2009-03-06 03:20:40', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('158', 'Files for content template', 'MODULE_STS_PRODUCT_INFO_CONTENT', 'sts_user_code.php;product_info.php', 'Files to include for a content template, separated by semicolon', '6', '3', NULL, '2009-03-06 03:20:40', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('159', 'Enable Check/Money Order Module', 'MODULE_PAYMENT_MONEYORDER_STATUS', 'False', 'Do you want to accept Check/Money Order payments?', '6', '1', NULL, '2009-03-25 05:46:08', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('160', 'Make Payable to:', 'MODULE_PAYMENT_MONEYORDER_PAYTO', '', 'Who should payments be made payable to?', '6', '1', NULL, '2009-03-25 05:46:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('161', 'Sort order of display.', 'MODULE_PAYMENT_MONEYORDER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', NULL, '2009-03-25 05:46:08', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('162', 'Payment Zone', 'MODULE_PAYMENT_MONEYORDER_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', NULL, '2009-03-25 05:46:08', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('163', 'Set Order Status', 'MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', NULL, '2009-03-25 05:46:08', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('164', 'Enable Authorize.net Credit Card AIM', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_STATUS', 'True', 'Do you want to accept Authorize.net Credit Card AIM payments?', '6', '0', NULL, '2009-03-26 16:53:12', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('165', 'Login ID', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_LOGIN_ID', 'adlaser53', 'The login ID used for the Authorize.net service', '6', '0', NULL, '2009-03-26 16:53:12', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('166', 'Transaction Key', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_TRANSACTION_KEY', '2Ce3B9wb93U9GDG8', 'Transaction key used for encrypting data', '6', '0', NULL, '2009-03-26 16:53:12', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('167', 'MD5 Hash', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_MD5_HASH', 'advlaser', 'The MD5 hash value to verify transactions with', '6', '0', NULL, '2009-03-26 16:53:12', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('168', 'Transaction Server', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_TRANSACTION_SERVER', 'Live', 'Perform transactions on the live or test server. The test server should only be used by developers with Authorize.net test accounts.', '6', '0', NULL, '2009-03-26 16:53:12', NULL, 'tep_cfg_select_option(array(\'Live\', \'Test\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('169', 'Transaction Mode', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_TRANSACTION_MODE', 'Live', 'Transaction mode used for processing orders', '6', '0', NULL, '2009-03-26 16:53:12', NULL, 'tep_cfg_select_option(array(\'Live\', \'Test\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('170', 'Transaction Method', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_TRANSACTION_METHOD', 'Authorization', 'The processing method to use for each transaction.', '6', '0', NULL, '2009-03-26 16:53:12', NULL, 'tep_cfg_select_option(array(\'Authorization\', \'Capture\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('171', 'Sort order of display.', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', NULL, '2009-03-26 16:53:12', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('172', 'Payment Zone', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', NULL, '2009-03-26 16:53:12', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('173', 'Set Order Status', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', NULL, '2009-03-26 16:53:12', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('174', 'cURL Program Location', 'MODULE_PAYMENT_AUTHORIZENET_CC_AIM_CURL', '/usr/bin/curl', 'The location to the cURL program application.', '6', '0', NULL, '2009-03-26 16:53:12', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('175', 'Enable Authorize.net Credit Card SIM', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_STATUS', 'False', 'Do you want to accept Authorize.net Credit Card SIM payments?', '6', '0', NULL, '2009-03-26 16:58:26', NULL, 'tep_cfg_select_option(array(\'True\', \'False\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('176', 'Login ID', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_LOGIN_ID', '', 'The login ID used for the Authorize.net service', '6', '0', NULL, '2009-03-26 16:58:26', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('177', 'Transaction Key', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_TRANSACTION_KEY', '', 'Transaction key used for encrypting data', '6', '0', NULL, '2009-03-26 16:58:26', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('178', 'MD5 Hash', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_MD5_HASH', '', 'The MD5 hash value to verify transactions with', '6', '0', NULL, '2009-03-26 16:58:26', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('179', 'Transaction Server', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_TRANSACTION_SERVER', 'Live', 'Perform transactions on the live or test server. The test server should only be used by developers with Authorize.net test accounts.', '6', '0', NULL, '2009-03-26 16:58:26', NULL, 'tep_cfg_select_option(array(\'Live\', \'Test\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('180', 'Transaction Mode', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_TRANSACTION_MODE', 'Test', 'Transaction mode used for processing orders', '6', '0', NULL, '2009-03-26 16:58:26', NULL, 'tep_cfg_select_option(array(\'Live\', \'Test\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('181', 'Transaction Method', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_TRANSACTION_METHOD', 'Authorization', 'The processing method to use for each transaction.', '6', '0', NULL, '2009-03-26 16:58:26', NULL, 'tep_cfg_select_option(array(\'Authorization\', \'Capture\'), ');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('182', 'Sort order of display.', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', NULL, '2009-03-26 16:58:26', NULL, NULL);
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('183', 'Payment Zone', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', NULL, '2009-03-26 16:58:26', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(');
insert into configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('184', 'Set Order Status', 'MODULE_PAYMENT_AUTHORIZENET_CC_SIM_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', '6', '0', NULL, '2009-03-26 16:58:26', 'tep_get_order_status_name', 'tep_cfg_pull_down_order_statuses(');
drop table if exists configuration_group;
create table configuration_group (
  configuration_group_id int(11) not null auto_increment,
  configuration_group_title varchar(64) not null ,
  configuration_group_description varchar(255) not null ,
  sort_order int(5) ,
  visible int(1) default '1' ,
  PRIMARY KEY (configuration_group_id)
);

insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('1', 'My Store', 'General information about my store', '1', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('2', 'Minimum Values', 'The minimum values for functions / data', '2', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('3', 'Maximum Values', 'The maximum values for functions / data', '3', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('4', 'Images', 'Image parameters', '4', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('5', 'Customer Details', 'Customer account configuration', '5', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('6', 'Module Options', 'Hidden from configuration', '6', '0');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('7', 'Shipping/Packaging', 'Shipping options available at my store', '7', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('8', 'Product Listing', 'Product Listing    configuration options', '8', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('9', 'Stock', 'Stock configuration options', '9', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('10', 'Logging', 'Logging configuration options', '10', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('11', 'Cache', 'Caching configuration options', '11', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('12', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', '12', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('13', 'Download', 'Downloadable products options', '13', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('14', 'GZip Compression', 'GZip compression options', '14', '1');
insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('15', 'Sessions', 'Session options', '15', '1');
drop table if exists counter;
create table counter (
  startdate char(8) ,
  counter int(12) 
);

insert into counter (startdate, counter) values ('20090304', '2701');
drop table if exists counter_history;
create table counter_history (
  month char(8) ,
  counter int(12) 
);

drop table if exists countries;
create table countries (
  countries_id int(11) not null auto_increment,
  countries_name varchar(64) not null ,
  countries_iso_code_2 char(2) not null ,
  countries_iso_code_3 char(3) not null ,
  address_format_id int(11) not null ,
  PRIMARY KEY (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
);

insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('1', 'Afghanistan', 'AF', 'AFG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('2', 'Albania', 'AL', 'ALB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('3', 'Algeria', 'DZ', 'DZA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('4', 'American Samoa', 'AS', 'ASM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('5', 'Andorra', 'AD', 'AND', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('6', 'Angola', 'AO', 'AGO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('7', 'Anguilla', 'AI', 'AIA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('8', 'Antarctica', 'AQ', 'ATA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('9', 'Antigua and Barbuda', 'AG', 'ATG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('10', 'Argentina', 'AR', 'ARG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('11', 'Armenia', 'AM', 'ARM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('12', 'Aruba', 'AW', 'ABW', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('13', 'Australia', 'AU', 'AUS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('14', 'Austria', 'AT', 'AUT', '5');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('15', 'Azerbaijan', 'AZ', 'AZE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('16', 'Bahamas', 'BS', 'BHS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('17', 'Bahrain', 'BH', 'BHR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('18', 'Bangladesh', 'BD', 'BGD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('19', 'Barbados', 'BB', 'BRB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('20', 'Belarus', 'BY', 'BLR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('21', 'Belgium', 'BE', 'BEL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('22', 'Belize', 'BZ', 'BLZ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('23', 'Benin', 'BJ', 'BEN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('24', 'Bermuda', 'BM', 'BMU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('25', 'Bhutan', 'BT', 'BTN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('26', 'Bolivia', 'BO', 'BOL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('27', 'Bosnia and Herzegowina', 'BA', 'BIH', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('28', 'Botswana', 'BW', 'BWA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('29', 'Bouvet Island', 'BV', 'BVT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('30', 'Brazil', 'BR', 'BRA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('31', 'British Indian Ocean Territory', 'IO', 'IOT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('32', 'Brunei Darussalam', 'BN', 'BRN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('33', 'Bulgaria', 'BG', 'BGR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('34', 'Burkina Faso', 'BF', 'BFA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('35', 'Burundi', 'BI', 'BDI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('36', 'Cambodia', 'KH', 'KHM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('37', 'Cameroon', 'CM', 'CMR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('38', 'Canada', 'CA', 'CAN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('39', 'Cape Verde', 'CV', 'CPV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('40', 'Cayman Islands', 'KY', 'CYM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('41', 'Central African Republic', 'CF', 'CAF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('42', 'Chad', 'TD', 'TCD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('43', 'Chile', 'CL', 'CHL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('44', 'China', 'CN', 'CHN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('45', 'Christmas Island', 'CX', 'CXR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('46', 'Cocos (Keeling) Islands', 'CC', 'CCK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('47', 'Colombia', 'CO', 'COL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('48', 'Comoros', 'KM', 'COM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('49', 'Congo', 'CG', 'COG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('50', 'Cook Islands', 'CK', 'COK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('51', 'Costa Rica', 'CR', 'CRI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('52', 'Cote D\'Ivoire', 'CI', 'CIV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('53', 'Croatia', 'HR', 'HRV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('54', 'Cuba', 'CU', 'CUB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('55', 'Cyprus', 'CY', 'CYP', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('56', 'Czech Republic', 'CZ', 'CZE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('57', 'Denmark', 'DK', 'DNK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('58', 'Djibouti', 'DJ', 'DJI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('59', 'Dominica', 'DM', 'DMA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('60', 'Dominican Republic', 'DO', 'DOM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('61', 'East Timor', 'TP', 'TMP', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('62', 'Ecuador', 'EC', 'ECU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('63', 'Egypt', 'EG', 'EGY', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('64', 'El Salvador', 'SV', 'SLV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('65', 'Equatorial Guinea', 'GQ', 'GNQ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('66', 'Eritrea', 'ER', 'ERI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('67', 'Estonia', 'EE', 'EST', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('68', 'Ethiopia', 'ET', 'ETH', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('69', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('70', 'Faroe Islands', 'FO', 'FRO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('71', 'Fiji', 'FJ', 'FJI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('72', 'Finland', 'FI', 'FIN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('73', 'France', 'FR', 'FRA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('74', 'France, Metropolitan', 'FX', 'FXX', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('75', 'French Guiana', 'GF', 'GUF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('76', 'French Polynesia', 'PF', 'PYF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('77', 'French Southern Territories', 'TF', 'ATF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('78', 'Gabon', 'GA', 'GAB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('79', 'Gambia', 'GM', 'GMB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('80', 'Georgia', 'GE', 'GEO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('81', 'Germany', 'DE', 'DEU', '5');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('82', 'Ghana', 'GH', 'GHA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('83', 'Gibraltar', 'GI', 'GIB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('84', 'Greece', 'GR', 'GRC', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('85', 'Greenland', 'GL', 'GRL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('86', 'Grenada', 'GD', 'GRD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('87', 'Guadeloupe', 'GP', 'GLP', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('88', 'Guam', 'GU', 'GUM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('89', 'Guatemala', 'GT', 'GTM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('90', 'Guinea', 'GN', 'GIN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('91', 'Guinea-bissau', 'GW', 'GNB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('92', 'Guyana', 'GY', 'GUY', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('93', 'Haiti', 'HT', 'HTI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('94', 'Heard and Mc Donald Islands', 'HM', 'HMD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('95', 'Honduras', 'HN', 'HND', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('96', 'Hong Kong', 'HK', 'HKG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('97', 'Hungary', 'HU', 'HUN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('98', 'Iceland', 'IS', 'ISL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('99', 'India', 'IN', 'IND', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('100', 'Indonesia', 'ID', 'IDN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('101', 'Iran (Islamic Republic of)', 'IR', 'IRN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('102', 'Iraq', 'IQ', 'IRQ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('103', 'Ireland', 'IE', 'IRL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('104', 'Israel', 'IL', 'ISR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('105', 'Italy', 'IT', 'ITA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('106', 'Jamaica', 'JM', 'JAM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('107', 'Japan', 'JP', 'JPN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('108', 'Jordan', 'JO', 'JOR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('109', 'Kazakhstan', 'KZ', 'KAZ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('110', 'Kenya', 'KE', 'KEN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('111', 'Kiribati', 'KI', 'KIR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('112', 'Korea, Democratic People\'s Republic of', 'KP', 'PRK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('113', 'Korea, Republic of', 'KR', 'KOR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('114', 'Kuwait', 'KW', 'KWT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('115', 'Kyrgyzstan', 'KG', 'KGZ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('116', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('117', 'Latvia', 'LV', 'LVA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('118', 'Lebanon', 'LB', 'LBN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('119', 'Lesotho', 'LS', 'LSO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('120', 'Liberia', 'LR', 'LBR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('121', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('122', 'Liechtenstein', 'LI', 'LIE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('123', 'Lithuania', 'LT', 'LTU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('124', 'Luxembourg', 'LU', 'LUX', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('125', 'Macau', 'MO', 'MAC', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('126', 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('127', 'Madagascar', 'MG', 'MDG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('128', 'Malawi', 'MW', 'MWI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('129', 'Malaysia', 'MY', 'MYS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('130', 'Maldives', 'MV', 'MDV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('131', 'Mali', 'ML', 'MLI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('132', 'Malta', 'MT', 'MLT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('133', 'Marshall Islands', 'MH', 'MHL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('134', 'Martinique', 'MQ', 'MTQ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('135', 'Mauritania', 'MR', 'MRT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('136', 'Mauritius', 'MU', 'MUS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('137', 'Mayotte', 'YT', 'MYT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('138', 'Mexico', 'MX', 'MEX', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('139', 'Micronesia, Federated States of', 'FM', 'FSM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('140', 'Moldova, Republic of', 'MD', 'MDA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('141', 'Monaco', 'MC', 'MCO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('142', 'Mongolia', 'MN', 'MNG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('143', 'Montserrat', 'MS', 'MSR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('144', 'Morocco', 'MA', 'MAR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('145', 'Mozambique', 'MZ', 'MOZ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('146', 'Myanmar', 'MM', 'MMR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('147', 'Namibia', 'NA', 'NAM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('148', 'Nauru', 'NR', 'NRU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('149', 'Nepal', 'NP', 'NPL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('150', 'Netherlands', 'NL', 'NLD', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('151', 'Netherlands Antilles', 'AN', 'ANT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('152', 'New Caledonia', 'NC', 'NCL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('153', 'New Zealand', 'NZ', 'NZL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('154', 'Nicaragua', 'NI', 'NIC', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('155', 'Niger', 'NE', 'NER', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('156', 'Nigeria', 'NG', 'NGA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('157', 'Niue', 'NU', 'NIU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('158', 'Norfolk Island', 'NF', 'NFK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('159', 'Northern Mariana Islands', 'MP', 'MNP', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('160', 'Norway', 'NO', 'NOR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('161', 'Oman', 'OM', 'OMN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('162', 'Pakistan', 'PK', 'PAK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('163', 'Palau', 'PW', 'PLW', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('164', 'Panama', 'PA', 'PAN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('165', 'Papua New Guinea', 'PG', 'PNG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('166', 'Paraguay', 'PY', 'PRY', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('167', 'Peru', 'PE', 'PER', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('168', 'Philippines', 'PH', 'PHL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('169', 'Pitcairn', 'PN', 'PCN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('170', 'Poland', 'PL', 'POL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('171', 'Portugal', 'PT', 'PRT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('172', 'Puerto Rico', 'PR', 'PRI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('173', 'Qatar', 'QA', 'QAT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('174', 'Reunion', 'RE', 'REU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('175', 'Romania', 'RO', 'ROM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('176', 'Russian Federation', 'RU', 'RUS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('177', 'Rwanda', 'RW', 'RWA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('178', 'Saint Kitts and Nevis', 'KN', 'KNA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('179', 'Saint Lucia', 'LC', 'LCA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('180', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('181', 'Samoa', 'WS', 'WSM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('182', 'San Marino', 'SM', 'SMR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('183', 'Sao Tome and Principe', 'ST', 'STP', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('184', 'Saudi Arabia', 'SA', 'SAU', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('185', 'Senegal', 'SN', 'SEN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('186', 'Seychelles', 'SC', 'SYC', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('187', 'Sierra Leone', 'SL', 'SLE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('188', 'Singapore', 'SG', 'SGP', '4');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('189', 'Slovakia (Slovak Republic)', 'SK', 'SVK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('190', 'Slovenia', 'SI', 'SVN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('191', 'Solomon Islands', 'SB', 'SLB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('192', 'Somalia', 'SO', 'SOM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('193', 'South Africa', 'ZA', 'ZAF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('194', 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('195', 'Spain', 'ES', 'ESP', '3');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('196', 'Sri Lanka', 'LK', 'LKA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('197', 'St. Helena', 'SH', 'SHN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('198', 'St. Pierre and Miquelon', 'PM', 'SPM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('199', 'Sudan', 'SD', 'SDN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('200', 'Suriname', 'SR', 'SUR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('201', 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('202', 'Swaziland', 'SZ', 'SWZ', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('203', 'Sweden', 'SE', 'SWE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('204', 'Switzerland', 'CH', 'CHE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('205', 'Syrian Arab Republic', 'SY', 'SYR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('206', 'Taiwan', 'TW', 'TWN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('207', 'Tajikistan', 'TJ', 'TJK', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('208', 'Tanzania, United Republic of', 'TZ', 'TZA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('209', 'Thailand', 'TH', 'THA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('210', 'Togo', 'TG', 'TGO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('211', 'Tokelau', 'TK', 'TKL', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('212', 'Tonga', 'TO', 'TON', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('213', 'Trinidad and Tobago', 'TT', 'TTO', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('214', 'Tunisia', 'TN', 'TUN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('215', 'Turkey', 'TR', 'TUR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('216', 'Turkmenistan', 'TM', 'TKM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('217', 'Turks and Caicos Islands', 'TC', 'TCA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('218', 'Tuvalu', 'TV', 'TUV', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('219', 'Uganda', 'UG', 'UGA', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('220', 'Ukraine', 'UA', 'UKR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('221', 'United Arab Emirates', 'AE', 'ARE', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('222', 'United Kingdom', 'GB', 'GBR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('223', 'United States', 'US', 'USA', '2');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('224', 'United States Minor Outlying Islands', 'UM', 'UMI', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('225', 'Uruguay', 'UY', 'URY', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('226', 'Uzbekistan', 'UZ', 'UZB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('227', 'Vanuatu', 'VU', 'VUT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('228', 'Vatican City State (Holy See)', 'VA', 'VAT', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('229', 'Venezuela', 'VE', 'VEN', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('230', 'Viet Nam', 'VN', 'VNM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('231', 'Virgin Islands (British)', 'VG', 'VGB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('232', 'Virgin Islands (U.S.)', 'VI', 'VIR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('233', 'Wallis and Futuna Islands', 'WF', 'WLF', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('234', 'Western Sahara', 'EH', 'ESH', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('235', 'Yemen', 'YE', 'YEM', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('236', 'Yugoslavia', 'YU', 'YUG', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('237', 'Zaire', 'ZR', 'ZAR', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('238', 'Zambia', 'ZM', 'ZMB', '1');
insert into countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) values ('239', 'Zimbabwe', 'ZW', 'ZWE', '1');
drop table if exists currencies;
create table currencies (
  currencies_id int(11) not null auto_increment,
  title varchar(32) not null ,
  code char(3) not null ,
  symbol_left varchar(12) ,
  symbol_right varchar(12) ,
  decimal_point char(1) ,
  thousands_point char(1) ,
  decimal_places char(1) ,
  value float(13,8) ,
  last_updated datetime ,
  PRIMARY KEY (currencies_id),
  KEY idx_currencies_code (code)
);

insert into currencies (currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value, last_updated) values ('1', 'US Dollar', 'USD', '$', '', '.', ',', '2', '1.00000000', '2009-03-04 10:56:09');
insert into currencies (currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value, last_updated) values ('2', 'Euro', 'EUR', '', 'EUR', '.', ',', '2', '1.10360003', '2009-03-04 10:56:09');
drop table if exists customers;
create table customers (
  customers_id int(11) not null auto_increment,
  customers_gender char(1) not null ,
  customers_firstname varchar(32) not null ,
  customers_lastname varchar(32) not null ,
  customers_dob datetime default '0000-00-00 00:00:00' not null ,
  customers_email_address varchar(96) not null ,
  customers_default_address_id int(11) ,
  customers_telephone varchar(32) not null ,
  customers_fax varchar(32) ,
  customers_password varchar(40) not null ,
  customers_newsletter char(1) ,
  PRIMARY KEY (customers_id),
  KEY idx_customers_email_address (customers_email_address)
);

insert into customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) values ('1', 'm', 'John', 'doe', '2001-01-01 00:00:00', 'root@localhost', '1', '12345', '', 'd95e8fa7f20a009372eb3477473fcd34:1c', '0');
insert into customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) values ('2', 'm', 'dave', 'churilla', '1971-12-16 00:00:00', 'churilla@gmail.com', '2', '310-910-5914', 'advlaser', 'c55a8fae163dd99f12bf48719735fdb8:9b', '');
insert into customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) values ('3', '', 'dave', 'churilla', '0000-00-00 00:00:00', 'd.churilla@ca.rr.com', '3', '310-910-5914', '', '49041f769e221bc32f89149f28b1eee7:4f', '');
insert into customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) values ('4', '', 'Chris', 'Owens', '0000-00-00 00:00:00', 'CLOdds@aol.com', '4', '949-202-7833', '949-425-1715', '1a8cf4d72c7f1527036716b4f1ffebdf:34', '1');
insert into customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) values ('5', '', 'Florence', 'Ng', '0000-00-00 00:00:00', 'yy_kk@mindspring.com', '5', '323-276-8798', '', 'be7206a6075a04c7f453e324790a8790:c6', '');
drop table if exists customers_basket;
create table customers_basket (
  customers_basket_id int(11) not null auto_increment,
  customers_id int(11) not null ,
  products_id tinytext not null ,
  customers_basket_quantity int(2) not null ,
  final_price decimal(15,4) ,
  customers_basket_date_added char(8) ,
  PRIMARY KEY (customers_basket_id),
  KEY idx_customers_basket_customers_id (customers_id)
);

insert into customers_basket (customers_basket_id, customers_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added) values ('3', '5', '30', '1', NULL, '20090322');
insert into customers_basket (customers_basket_id, customers_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added) values ('8', '5', '46{3}21', '1', NULL, '20090325');
insert into customers_basket (customers_basket_id, customers_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added) values ('10', '4', '46{4}43{3}21', '4', NULL, '20090326');
insert into customers_basket (customers_basket_id, customers_id, products_id, customers_basket_quantity, final_price, customers_basket_date_added) values ('11', '4', '37{1}5', '1', NULL, '20090326');
drop table if exists customers_basket_attributes;
create table customers_basket_attributes (
  customers_basket_attributes_id int(11) not null auto_increment,
  customers_id int(11) not null ,
  products_id tinytext not null ,
  products_options_id int(11) not null ,
  products_options_value_id int(11) not null ,
  PRIMARY KEY (customers_basket_attributes_id),
  KEY idx_customers_basket_att_customers_id (customers_id)
);

insert into customers_basket_attributes (customers_basket_attributes_id, customers_id, products_id, products_options_id, products_options_value_id) values ('6', '5', '46{3}21', '3', '21');
insert into customers_basket_attributes (customers_basket_attributes_id, customers_id, products_id, products_options_id, products_options_value_id) values ('7', '4', '46{4}43{3}21', '4', '43');
insert into customers_basket_attributes (customers_basket_attributes_id, customers_id, products_id, products_options_id, products_options_value_id) values ('8', '4', '46{4}43{3}21', '3', '21');
insert into customers_basket_attributes (customers_basket_attributes_id, customers_id, products_id, products_options_id, products_options_value_id) values ('9', '4', '37{1}5', '1', '5');
drop table if exists customers_info;
create table customers_info (
  customers_info_id int(11) not null ,
  customers_info_date_of_last_logon datetime ,
  customers_info_number_of_logons int(5) ,
  customers_info_date_account_created datetime ,
  customers_info_date_account_last_modified datetime ,
  global_product_notifications int(1) default '0' ,
  PRIMARY KEY (customers_info_id)
);

insert into customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) values ('1', NULL, '0', '2009-03-04 10:56:09', NULL, '0');
insert into customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) values ('2', '2009-03-27 10:13:40', '8', '2009-03-20 03:02:02', '2009-03-20 03:03:39', '0');
insert into customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) values ('3', NULL, '0', '2009-03-20 04:11:39', NULL, '0');
insert into customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) values ('4', '2009-03-26 18:30:18', '3', '2009-03-21 22:55:47', '2009-03-25 19:51:46', '1');
insert into customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) values ('5', '2009-03-25 21:02:49', '1', '2009-03-22 01:47:10', NULL, '0');
drop table if exists geo_zones;
create table geo_zones (
  geo_zone_id int(11) not null auto_increment,
  geo_zone_name varchar(32) not null ,
  geo_zone_description varchar(255) not null ,
  last_modified datetime ,
  date_added datetime not null ,
  PRIMARY KEY (geo_zone_id)
);

insert into geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) values ('1', 'Florida', 'Florida local sales tax zone', NULL, '2009-03-04 10:56:09');
drop table if exists languages;
create table languages (
  languages_id int(11) not null auto_increment,
  name varchar(32) not null ,
  code char(2) not null ,
  image varchar(64) ,
  directory varchar(32) ,
  sort_order int(3) ,
  PRIMARY KEY (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
);

insert into languages (languages_id, name, code, image, directory, sort_order) values ('1', 'English', 'en', 'icon.gif', 'english', '1');
insert into languages (languages_id, name, code, image, directory, sort_order) values ('2', 'Deutsch', 'de', 'icon.gif', 'german', '2');
insert into languages (languages_id, name, code, image, directory, sort_order) values ('3', 'Español', 'es', 'icon.gif', 'espanol', '3');
drop table if exists manufacturers;
create table manufacturers (
  manufacturers_id int(11) not null auto_increment,
  manufacturers_name varchar(32) not null ,
  manufacturers_image varchar(64) ,
  date_added datetime ,
  last_modified datetime ,
  PRIMARY KEY (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
);

insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('1', 'Matrox', 'manufacturer_matrox.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('2', 'Microsoft', 'manufacturer_microsoft.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('3', 'Warner', 'manufacturer_warner.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('4', 'Fox', 'manufacturer_fox.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('5', 'Logitech', 'manufacturer_logitech.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('6', 'Canon', 'manufacturer_canon.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('7', 'Sierra', 'manufacturer_sierra.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('8', 'GT Interactive', 'manufacturer_gt_interactive.gif', '2009-03-04 10:56:09', NULL);
insert into manufacturers (manufacturers_id, manufacturers_name, manufacturers_image, date_added, last_modified) values ('9', 'Hewlett Packard', 'manufacturer_hewlett_packard.gif', '2009-03-04 10:56:09', NULL);
drop table if exists manufacturers_info;
create table manufacturers_info (
  manufacturers_id int(11) not null ,
  languages_id int(11) not null ,
  manufacturers_url varchar(255) not null ,
  url_clicked int(5) default '0' not null ,
  date_last_click datetime ,
  PRIMARY KEY (manufacturers_id, languages_id)
);

insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('1', '1', 'http://www.matrox.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('1', '2', 'http://www.matrox.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('1', '3', 'http://www.matrox.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('2', '1', 'http://www.microsoft.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('2', '2', 'http://www.microsoft.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('2', '3', 'http://www.microsoft.es', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('3', '1', 'http://www.warner.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('3', '2', 'http://www.warner.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('3', '3', 'http://www.warner.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('4', '1', 'http://www.fox.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('4', '2', 'http://www.fox.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('4', '3', 'http://www.fox.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('5', '1', 'http://www.logitech.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('5', '2', 'http://www.logitech.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('5', '3', 'http://www.logitech.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('6', '1', 'http://www.canon.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('6', '2', 'http://www.canon.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('6', '3', 'http://www.canon.es', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('7', '1', 'http://www.sierra.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('7', '2', 'http://www.sierra.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('7', '3', 'http://www.sierra.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('8', '1', 'http://www.infogrames.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('8', '2', 'http://www.infogrames.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('8', '3', 'http://www.infogrames.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('9', '1', 'http://www.hewlettpackard.com', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('9', '2', 'http://www.hewlettpackard.de', '0', NULL);
insert into manufacturers_info (manufacturers_id, languages_id, manufacturers_url, url_clicked, date_last_click) values ('9', '3', 'http://welcome.hp.com/country/es/spa/welcome.htm', '0', NULL);
drop table if exists newsletters;
create table newsletters (
  newsletters_id int(11) not null auto_increment,
  title varchar(255) not null ,
  content text not null ,
  module varchar(255) not null ,
  date_added datetime not null ,
  date_sent datetime ,
  status int(1) ,
  locked int(1) default '0' ,
  PRIMARY KEY (newsletters_id)
);

drop table if exists orders;
create table orders (
  orders_id int(11) not null auto_increment,
  customers_id int(11) not null ,
  customers_name varchar(64) not null ,
  customers_company varchar(32) ,
  customers_street_address varchar(64) not null ,
  customers_suburb varchar(32) ,
  customers_city varchar(32) not null ,
  customers_postcode varchar(10) not null ,
  customers_state varchar(32) ,
  customers_country varchar(32) not null ,
  customers_telephone varchar(32) not null ,
  customers_email_address varchar(96) not null ,
  customers_address_format_id int(5) not null ,
  delivery_name varchar(64) not null ,
  delivery_company varchar(32) ,
  delivery_street_address varchar(64) not null ,
  delivery_suburb varchar(32) ,
  delivery_city varchar(32) not null ,
  delivery_postcode varchar(10) not null ,
  delivery_state varchar(32) ,
  delivery_country varchar(32) not null ,
  delivery_address_format_id int(5) not null ,
  billing_name varchar(64) not null ,
  billing_company varchar(32) ,
  billing_street_address varchar(64) not null ,
  billing_suburb varchar(32) ,
  billing_city varchar(32) not null ,
  billing_postcode varchar(10) not null ,
  billing_state varchar(32) ,
  billing_country varchar(32) not null ,
  billing_address_format_id int(5) not null ,
  payment_method varchar(255) not null ,
  cc_type varchar(20) ,
  cc_owner varchar(64) ,
  cc_number varchar(32) ,
  cc_expires varchar(4) ,
  last_modified datetime ,
  date_purchased datetime ,
  orders_status int(5) not null ,
  orders_date_finished datetime ,
  currency char(3) ,
  currency_value decimal(14,6) ,
  PRIMARY KEY (orders_id),
  KEY idx_orders_customers_id (customers_id)
);

insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('1', '4', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '949-202-7833', 'CLOdds@aol.com', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Credit Card', 'Visa', 'Chris Owens', '4388575220100239', '0314', NULL, '2009-03-25 19:48:10', '1', NULL, 'USD', '1.000000');
insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('2', '4', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '949-202-7833', 'CLOdds@aol.com', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Cash on Delivery', '', '', '', '', NULL, '2009-03-25 19:51:18', '1', NULL, 'USD', '1.000000');
insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('3', '4', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '949-202-7833', 'CLOdds@aol.com', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Cash on Delivery', '', '', '', '', NULL, '2009-03-25 20:30:52', '1', NULL, 'USD', '1.000000');
insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('4', '4', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '949-202-7833', 'CLOdds@aol.com', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Chris Owens', '', '25402 Nellie Gail Road', '', 'Laguna Hills', '92653', 'California', 'United States', '2', 'Cash on Delivery', '', '', '', '', NULL, '2009-03-26 18:30:58', '1', NULL, 'USD', '1.000000');
insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('5', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'Alabama', 'United States', '310-910-5914', 'churilla@gmail.com', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'Alabama', 'United States', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'Alabama', 'United States', '2', 'Credit Card (Processed by Authorize.net)', '', '', '', '', NULL, '2009-03-27 09:10:50', '1', NULL, 'USD', '1.000000');
insert into orders (orders_id, customers_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, last_modified, date_purchased, orders_status, orders_date_finished, currency, currency_value) values ('6', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'California', 'United States', '310-910-5914', 'churilla@gmail.com', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'California', 'United States', '2', 'dave churilla', '', '7600 w manchester', '', 'Playa del Rey', '90293', 'California', 'United States', '2', 'Credit Card (Processed by Authorize.net)', '', '', '', '', NULL, '2009-03-27 10:25:13', '1', NULL, 'USD', '1.000000');
drop table if exists orders_products;
create table orders_products (
  orders_products_id int(11) not null auto_increment,
  orders_id int(11) not null ,
  products_id int(11) not null ,
  products_model varchar(12) ,
  products_name varchar(64) not null ,
  products_price decimal(15,4) not null ,
  final_price decimal(15,4) not null ,
  products_tax decimal(7,4) not null ,
  products_quantity int(2) not null ,
  PRIMARY KEY (orders_products_id),
  KEY idx_orders_products_orders_id (orders_id),
  KEY idx_orders_products_products_id (products_id)
);

insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('1', '1', '46', '', '2009 Ultimate Soft Tissue Laser Certification Course', '395.0000', '695.0000', '0.0000', '1');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('2', '2', '48', '', 'Advanced Diode Surgical Course', '395.0000', '1195.0000', '0.0000', '2');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('3', '3', '46', '', '2009 Ultimate Soft Tissue Laser Certification Course', '395.0000', '695.0000', '0.0000', '1');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('4', '4', '46', '', '2009 Ultimate Soft Tissue Laser Certification Course', '395.0000', '695.0000', '0.0000', '1');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('5', '4', '30', '', 'Autoclavable Cleaver', '180.0000', '180.0000', '0.0000', '1');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('6', '5', '30', '', 'Autoclavable Cleaver', '180.0000', '180.0000', '0.0000', '3');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('7', '5', '35', '', 'Diode Soft Tissue Laser DVD', '495.0000', '495.0000', '0.0000', '1');
insert into orders_products (orders_products_id, orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) values ('8', '6', '50', '', 'test product', '1.0000', '1.0000', '0.0000', '1');
drop table if exists orders_products_attributes;
create table orders_products_attributes (
  orders_products_attributes_id int(11) not null auto_increment,
  orders_id int(11) not null ,
  orders_products_id int(11) not null ,
  products_options varchar(32) not null ,
  products_options_values varchar(32) not null ,
  options_values_price decimal(15,4) not null ,
  price_prefix char(1) not null ,
  PRIMARY KEY (orders_products_attributes_id),
  KEY idx_orders_products_att_orders_id (orders_id)
);

insert into orders_products_attributes (orders_products_attributes_id, orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) values ('1', '1', '1', 'Title', 'Dentist/Hygenist', '695.0000', '');
insert into orders_products_attributes (orders_products_attributes_id, orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) values ('2', '2', '2', 'Select date', '4/18 - Phoenix, AZ', '0.0000', '+');
insert into orders_products_attributes (orders_products_attributes_id, orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) values ('3', '2', '2', 'Title', 'Dentist/Hygenist', '1195.0000', '');
insert into orders_products_attributes (orders_products_attributes_id, orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) values ('4', '3', '3', 'Title', 'Dentist/Hygenist', '695.0000', '');
insert into orders_products_attributes (orders_products_attributes_id, orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) values ('5', '4', '4', 'Title', 'Dentist/Hygenist', '695.0000', '');
drop table if exists orders_products_download;
create table orders_products_download (
  orders_products_download_id int(11) not null auto_increment,
  orders_id int(11) default '0' not null ,
  orders_products_id int(11) default '0' not null ,
  orders_products_filename varchar(255) not null ,
  download_maxdays int(2) default '0' not null ,
  download_count int(2) default '0' not null ,
  PRIMARY KEY (orders_products_download_id),
  KEY idx_orders_products_download_orders_id (orders_id)
);

drop table if exists orders_status;
create table orders_status (
  orders_status_id int(11) default '0' not null ,
  language_id int(11) default '1' not null ,
  orders_status_name varchar(32) not null ,
  public_flag int(11) default '1' ,
  downloads_flag int(11) default '0' ,
  PRIMARY KEY (orders_status_id, language_id),
  KEY idx_orders_status_name (orders_status_name)
);

insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('1', '1', 'Pending', '1', '0');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('1', '2', 'Offen', '1', '0');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('1', '3', 'Pendiente', '1', '0');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('2', '1', 'Processing', '1', '1');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('2', '2', 'In Bearbeitung', '1', '1');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('2', '3', 'Proceso', '1', '1');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('3', '1', 'Delivered', '1', '1');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('3', '2', 'Versendet', '1', '1');
insert into orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) values ('3', '3', 'Entregado', '1', '1');
drop table if exists orders_status_history;
create table orders_status_history (
  orders_status_history_id int(11) not null auto_increment,
  orders_id int(11) not null ,
  orders_status_id int(5) not null ,
  date_added datetime not null ,
  customer_notified int(1) default '0' ,
  comments text ,
  PRIMARY KEY (orders_status_history_id),
  KEY idx_orders_status_history_orders_id (orders_id)
);

insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('1', '1', '1', '2009-03-25 19:48:10', '1', '');
insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('2', '2', '1', '2009-03-25 19:51:18', '1', '');
insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('3', '3', '1', '2009-03-25 20:30:52', '1', '');
insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('4', '4', '1', '2009-03-26 18:30:58', '1', '');
insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('5', '5', '1', '2009-03-27 09:10:50', '1', '');
insert into orders_status_history (orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) values ('6', '6', '1', '2009-03-27 10:25:13', '1', '');
drop table if exists orders_total;
create table orders_total (
  orders_total_id int(10) unsigned not null auto_increment,
  orders_id int(11) not null ,
  title varchar(255) not null ,
  text varchar(255) not null ,
  value decimal(15,4) not null ,
  class varchar(32) not null ,
  sort_order int(11) not null ,
  PRIMARY KEY (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
);

insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('1', '1', 'Sub-Total:', '$695.00', '695.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('2', '1', 'Flat Rate (Best Way):', '$5.00', '5.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('3', '1', 'Total:', '<b>$700.00</b>', '700.0000', 'ot_total', '4');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('4', '2', 'Sub-Total:', '$2,390.00', '2390.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('5', '2', 'Flat Rate (Best Way):', '$5.00', '5.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('6', '2', 'Total:', '<b>$2,395.00</b>', '2395.0000', 'ot_total', '4');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('7', '3', 'Sub-Total:', '$695.00', '695.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('8', '3', 'Flat Rate (Best Way):', '$5.00', '5.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('9', '3', 'Total:', '<b>$700.00</b>', '700.0000', 'ot_total', '4');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('10', '4', 'Sub-Total:', '$875.00', '875.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('11', '4', 'Flat Rate (Best Way):', '$5.00', '5.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('12', '4', 'Total:', '<b>$880.00</b>', '880.0000', 'ot_total', '4');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('13', '5', 'Sub-Total:', '$1,035.00', '1035.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('14', '5', 'Flat Rate (Best Way):', '$5.00', '5.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('15', '5', 'Total:', '<b>$1,040.00</b>', '1040.0000', 'ot_total', '4');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('16', '6', 'Sub-Total:', '$1.00', '1.0000', 'ot_subtotal', '1');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('17', '6', 'Flat Rate (Best Way):', '$0.00', '0.0000', 'ot_shipping', '2');
insert into orders_total (orders_total_id, orders_id, title, text, value, class, sort_order) values ('18', '6', 'Total:', '<b>$1.00</b>', '1.0000', 'ot_total', '4');
drop table if exists products;
create table products (
  products_id int(11) not null auto_increment,
  products_quantity int(4) not null ,
  products_model varchar(12) ,
  products_image varchar(64) ,
  products_price decimal(15,4) not null ,
  products_date_added datetime not null ,
  products_last_modified datetime ,
  products_date_available datetime ,
  products_weight decimal(5,2) not null ,
  products_status tinyint(1) not null ,
  products_tax_class_id int(11) not null ,
  manufacturers_id int(11) ,
  products_ordered int(11) default '0' not null ,
  PRIMARY KEY (products_id),
  KEY idx_products_model (products_model),
  KEY idx_products_date_added (products_date_added)
);

insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('30', '10', '', 'prod_acc_cleaver.jpg', '180.0000', '2009-03-19 06:35:39', NULL, NULL, '0.00', '1', '0', '0', '4');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('31', '10', '', 'prod_acc_fiberstripper.jpg', '150.0000', '2009-03-19 06:39:00', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('32', '0', '', 'prod_acc_fiberwind.jpg', '125.0000', '2009-03-19 06:41:28', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('33', '10', '', 'prod_acc_softtips.jpg', '65.0000', '2009-03-19 06:43:11', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('34', '10', '', 'prod_acc_softtips.jpg', '49.9500', '2009-03-19 06:45:46', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('35', '10', '', 'prod_acc_diodeDVD.jpg', '495.0000', '2009-03-19 06:48:05', NULL, NULL, '0.00', '1', '0', '0', '1');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('36', '10', '', 'prod_acc_gummyDVD.jpg', '495.0000', '2009-03-19 06:49:12', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('37', '10', '', 'prod_acc_laserfiber.jpg', '180.0000', '2009-03-19 06:55:40', '2009-03-25 02:41:28', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('38', '10', '', 'prod_broch_modern.jpg', '50.0000', '2009-03-20 04:47:13', '2009-03-20 04:48:57', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('39', '10', '', 'prod_broch_perio.jpg', '50.0000', '2009-03-20 04:50:15', '2009-03-20 04:50:46', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('40', '10', '', 'prod_broch_hardtissue.jpg', '50.0000', '2009-03-20 04:53:26', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('41', '10', '', 'prod_broch_softtissue.jpg', '50.0000', '2009-03-20 04:54:57', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('42', '10', '', 'prod_broch_cosmetic.jpg', '50.0000', '2009-03-20 04:55:38', '2009-03-20 04:59:01', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('43', '10', '', 'prod_broch_endo.jpg', '50.0000', '2009-03-20 04:56:12', '2009-03-20 04:59:18', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('44', '10', '', 'prod_broch_bacterial.jpg', '50.0000', '2009-03-20 04:56:46', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('45', '10', '', 'prod_broch_ulcers.jpg', '50.0000', '2009-03-20 04:57:27', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('46', '10', '', 'courses_soft_tissue.gif', '395.0000', '2009-03-25 03:46:54', '2009-03-25 15:34:23', NULL, '0.00', '1', '0', '0', '3');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('47', '10', '', 'courses_diode_perio_hygiene.gif', '395.0000', '2009-03-25 03:49:56', '2009-03-25 15:34:35', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('48', '10', '', 'courses_adv_diode_surgical.gif', '395.0000', '2009-03-25 03:55:48', '2009-03-25 15:34:58', NULL, '0.00', '1', '0', '0', '2');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('49', '10', '', 'courses_laser_practice_mgmt.gif', '395.0000', '2009-03-25 03:58:08', '2009-03-25 15:35:08', NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('50', '10', '', 'button_in_cart.gif', '1.0000', '2009-03-27 10:21:23', NULL, NULL, '0.00', '1', '0', '0', '1');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('29', '10', '', 'prod_acc_6mm.jpg', '194.9500', '2009-03-19 06:30:34', NULL, NULL, '0.00', '1', '0', '0', '0');
insert into products (products_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered) values ('28', '10', '', 'prod_acc_10mm.jpg', '194.9500', '2009-03-19 06:11:56', NULL, NULL, '0.00', '1', '0', '0', '0');
drop table if exists products_attributes;
create table products_attributes (
  products_attributes_id int(11) not null auto_increment,
  products_id int(11) not null ,
  options_id int(11) not null ,
  options_values_id int(11) not null ,
  options_values_price decimal(15,4) not null ,
  price_prefix char(1) not null ,
  attribute_sort int(10) unsigned default '0' not null ,
  PRIMARY KEY (products_attributes_id),
  KEY idx_products_attributes_products_id (products_id)
);

insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('42', '37', '1', '14', '275.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('41', '37', '1', '17', '275.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('40', '37', '1', '13', '275.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('39', '37', '1', '12', '275.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('38', '37', '1', '10', '225.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('37', '37', '1', '9', '195.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('36', '37', '1', '4', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('35', '37', '1', '3', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('34', '37', '1', '5', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('33', '37', '1', '2', '310.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('32', '37', '1', '1', '310.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('44', '37', '1', '18', '295.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('43', '37', '1', '16', '325.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('45', '37', '1', '7', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('46', '37', '1', '15', '325.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('47', '37', '1', '8', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('48', '37', '1', '6', '180.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('132', '46', '3', '21', '695.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('131', '46', '3', '22', '395.0000', '', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('336', '47', '3', '22', '395.0000', '', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('335', '47', '3', '21', '1195.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('160', '48', '3', '21', '1195.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('159', '48', '3', '22', '395.0000', '', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('358', '49', '3', '22', '395.0000', '', '2');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('357', '49', '3', '21', '1195.0000', '', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('334', '47', '4', '23', '0.0000', '+', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('333', '47', '4', '24', '0.0000', '+', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('332', '47', '4', '25', '0.0000', '+', '2');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('331', '47', '4', '26', '0.0000', '+', '3');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('330', '47', '4', '27', '0.0000', '+', '4');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('329', '47', '4', '28', '0.0000', '+', '5');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('328', '47', '4', '29', '0.0000', '+', '6');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('327', '47', '4', '30', '0.0000', '+', '7');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('326', '47', '4', '31', '0.0000', '+', '8');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('165', '48', '4', '23', '0.0000', '+', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('166', '48', '4', '24', '0.0000', '+', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('167', '48', '4', '25', '0.0000', '+', '2');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('168', '48', '4', '26', '0.0000', '+', '3');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('169', '48', '4', '27', '0.0000', '+', '4');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('170', '48', '4', '28', '0.0000', '+', '5');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('171', '48', '4', '29', '0.0000', '+', '6');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('172', '48', '4', '30', '0.0000', '+', '7');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('173', '48', '4', '31', '0.0000', '+', '8');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('359', '49', '4', '32', '0.0000', '+', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('367', '49', '4', '40', '0.0000', '+', '8');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('362', '49', '4', '35', '0.0000', '+', '3');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('366', '49', '4', '39', '0.0000', '+', '7');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('365', '49', '4', '38', '0.0000', '+', '6');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('364', '49', '4', '37', '0.0000', '+', '5');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('363', '49', '4', '36', '0.0000', '+', '4');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('361', '49', '4', '34', '0.0000', '+', '2');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('360', '49', '4', '33', '0.0000', '+', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('369', '46', '4', '41', '0.0000', '+', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('370', '46', '4', '42', '0.0000', '+', '1');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('371', '46', '4', '43', '0.0000', '+', '0');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('372', '46', '4', '44', '0.0000', '+', '3');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('373', '46', '4', '45', '0.0000', '+', '4');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('374', '46', '4', '46', '0.0000', '+', '5');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('375', '46', '4', '47', '0.0000', '+', '6');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('376', '46', '4', '48', '0.0000', '+', '7');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('377', '46', '4', '49', '0.0000', '+', '8');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('378', '46', '4', '50', '0.0000', '+', '9');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('379', '46', '4', '51', '0.0000', '+', '10');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('380', '46', '4', '52', '0.0000', '+', '11');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('381', '46', '4', '53', '0.0000', '+', '12');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('382', '46', '4', '54', '0.0000', '+', '13');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('383', '46', '4', '55', '0.0000', '+', '14');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('384', '46', '4', '56', '0.0000', '+', '15');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('385', '46', '4', '57', '0.0000', '+', '16');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('386', '46', '4', '58', '0.0000', '+', '17');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('387', '46', '4', '59', '0.0000', '+', '18');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('388', '46', '4', '60', '0.0000', '+', '19');
insert into products_attributes (products_attributes_id, products_id, options_id, options_values_id, options_values_price, price_prefix, attribute_sort) values ('389', '46', '4', '61', '0.0000', '+', '20');
drop table if exists products_attributes_download;
create table products_attributes_download (
  products_attributes_id int(11) not null ,
  products_attributes_filename varchar(255) not null ,
  products_attributes_maxdays int(2) default '0' ,
  products_attributes_maxcount int(2) default '0' ,
  PRIMARY KEY (products_attributes_id)
);

insert into products_attributes_download (products_attributes_id, products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount) values ('26', 'unreal.zip', '7', '3');
drop table if exists products_description;
create table products_description (
  products_id int(11) not null auto_increment,
  language_id int(11) default '1' not null ,
  products_name varchar(64) not null ,
  products_description text ,
  products_url varchar(255) ,
  products_viewed int(5) default '0' ,
  PRIMARY KEY (products_id, language_id),
  KEY products_name (products_name)
);

insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('48', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('48', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('49', '1', 'Laser Practice Management - Promoting the Dental Laser Practice', '<p>A one-day course for all practices that have a laser, or are thinking about getting one.</p>

<p>This course is designed for every member of the dental team, including dentists, hygienists, auxiliaries, business managers and schedulers. In a program packed with pearls, the entire team will learn how to release the untapped potential of dental lasers. The experienced instructors of Advanced Laser Training will demonstrate how to confidently promote your laser, how to motivate your staff, and how to turn your patients into zealous dental ambassadors for your office. By the end of the program, your team will be energized to begin implementing changes that will build momentum to carry the practice to the next level and beyond.</p>

<p>Doctors who take this course will realize they don\'t need to re-invent the wheel. They appreciate that Advanced Laser Training has already tinkered with it and has it properly aligned and balanced. With twenty years of experience in laser dentistry, we know what works and what doesn\'t. This course, together with our practice promotion materials, is designed to get you up and running right away at full speed right away with your laser. All of our laser continuing education programs will give you the tools to stay ahead of the curve as you become more comfortable with your instrument and fully integrate it into your style of practice.</p>', '', '43');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('49', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('49', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('50', '1', 'test product', 'test for live store', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('50', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('50', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('46', '1', '2009 Ultimate Soft Tissue Laser Certification Course', 'In an informative and entertaining presentation, Dr. Chris Owens, educates participants on the revolutionary field of lasers in dentistry and hygiene. Course topics include laser physics, safety, and tissue interaction, as well as techniques for success with soft tissue surgeries and laser periodontal therapy. Commonly used insurance codes and average fees will also be discussed. Students learn through multi-media slide and video presentations as well as by performing hands-on exercises. By the end of the day, participants will be ready to go back into their practices and institute the most common soft tissue laser procedures and periodontal therapies with confidence.', '', '37');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('29', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('29', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('30', '1', 'Autoclavable Cleaver', 'Now a Fiber Cleaver that holds up in the Autoclave time after time!
<ul>
<li>New interchangeable 6 or 10 mm body design
<li>Effortless cleaving on our most delicate fibers
<li>Protective metal cap standard
<li>Tip grind angle designed for great visibility and clean cuts every time
<li>Easy to change 
<li>Low cost replacement Blades
</ul>', '', '90');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('30', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('30', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('31', '1', 'Fiber Stripper', 'For 200-1000 micron fibers', '', '10');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('31', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('31', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('32', '1', 'Fiber Wind Manager', 'Fiber Winder Safely Stores Your Fiber Until you need it. Stores any Fiber Type. Fits Right on Top of the ADT Diolase.', '', '4');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('32', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('32', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('33', '1', 'Fiber/Laser Clip', 'Tame your unruly Laser Fibers with our Fiber-Clip. Fiber-Clip anchors your Laser Fibers so they stay where they belong. Mounts anywhere you need.', '', '3');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('33', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('33', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('34', '1', 'Soft Tissue Handpiece - Tips', 'For 200-800 micron fibers.
Low thermal transfer reduces melt on the longest procedures.
Transparent for excellent visibility.
Autoclave safe to 500 degrees. 
Solid locking on all fibers without breakage.
(quantity 45 per box)', '', '3');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('34', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('34', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('35', '1', 'Diode Soft Tissue Laser DVD', 'Advanced Laser Training Presents the Diode Soft Tissue Laser DVD, this entertaining, informative DVD includes 22 chapters on the most commonly performed soft tissue procedures. Topics include, fiber preparation, crown lengthening, perio and much more. Watch the procedure to review settings and techniques prior to treating cases.', '', '14');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('35', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('35', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('36', '1', 'Gummy Smile Reduction', 'Shows how to use lasers for bony and soft tissue reduction.', '', '2');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('36', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('36', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('37', '1', 'Laser Fiber', 'Now fibers for your laser that are longer, lower cost and can go in the Autoclave.
Money Back Guarantee.

Available for the following lasers:
<ul>
<li>ADT Diolase ST and Pulsemaster
<li>Biolase Laser Smile, Twilight and Diolase Plus
<li>Promety
<li>Spectralase
<li>Incisive
<li>Millenium
<li>Sirona
<li>Opus 5 or 10
<li>Lares
<li>Premier Aurora (must send connector)
</ul>', '', '54');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('37', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('37', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('38', '1', 'Modern Laser Dentistry', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '3');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('38', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('38', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('39', '1', 'Laser Periodontal Therapy', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '5');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('39', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('39', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('40', '1', 'Laser Hard Tissue Applications', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '2');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('40', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('40', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('41', '1', 'Laser Soft Tissue Applications', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('41', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('41', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('42', '1', 'Laser Cosmetic Procedures', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('42', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('42', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('43', '1', 'Laser Endodontics', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '2');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('43', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('43', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('44', '1', 'Laser Bacterial Reduction', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '6');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('44', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('44', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('45', '1', 'Herpetic and Apthous Ulcers', 'This unique informative set of Laser Patient Education Brochures explains the most common laser dentistry procedures in an easy to understand format designed for patients. The brochures highlight the benefits that laser dentistry offers for various procedures. Whether you offer the full range of laser dental procedures or just a few you will find this series invaluable in explaining treatment options to your patients. With all major laser applications covered this series can save you valuable time and give your patients something to take home to discuss their treatment with family or friends. Each set comes with an area for you to stamp your information so that patients can give them out to family members or friends in order to recommend your services.
<br /><br />
Sold in packages of 50.<br />
<span class=\"blue\"><strong>Buy any 5 brochures and receive your 6th set free.</strong></span>', '', '26');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('45', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('45', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('46', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('46', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('47', '1', 'Advanced Diode Periodontal/ Hygiene Course', '<p>This course consists of a full day of training focusing entirely on advanced soft tissue laser periodontal applications.  Activities include advanced treatment planning modules as well as guidelines for recare appointments and if necessary how and when to reinstitute treatment.</p>

<p>Have you ever wondered how to explain the laser to your patients? It will be covered in this course by role-playing different scenarios while giving laser verbal skills to use in the clinical setting.  Insurance codes and fees are an important aspect in the dental industry to most patients and will also be discussed in this course.</p>

<p>Hands on exercises will go through how to illustrate proper power settings for tissue coagulation in pocketed areas without harm to healthy tissues.  An advanced course treatment planning program will be provided to each participant.  This folder will include informed consent forms and many other useful documents to be utilized when setting up or improving your laser periodontal program.</p>

<p>Periodontal cases will be presented in detail to illustrate the laser treatment protocol recommended.  It is a fun-filled periodontal day!</p>

<p>This course should include all staff, including hygienists, dentists and all other team members that bring unique perspectives to laser hygiene. Expectation will be that by the close of the day each person will expect to feel like an experienced laser user and will be able to go back to your office with more expertise and confidence in your laser procedures.</p>

<p>Suggested Pre Requisite Course is the Ultimate Soft Tissue Laser Certification Course by Dr. Chris Owens at $695 per participant designed for DDS\'s and RDH\'s as well as staff who can attend at a reduced fee of $395.</p>', '', '87');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('47', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('47', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('48', '1', 'Advanced Diode Surgical Course', '<p>The Advanced Diode Surgical Course will be comprised of an introduction to the full range of the clinical applications of the diode laser. The emphasis is not to familiarize course participants with every clinical protocol specific to each procedure, but rather to help the course participants harmonize their expectations with knowledge they are receiving. This exposure is to open their minds to the powerful capabilities of the laser.</p>

<p>Part of the curriculum will be an overview of surgical techniques with the diode laser. Course participants will be motivated to move out of their comfort zones to higher plateaus in dentistry where, from their new perspective, they can see more clearly just what the laser can do to transform their practices. Dr. Hudson will eliminate the fear-factor that new users and even experienced users sometimes associate with their instrument.</p>

<p>Each participant will be given a worksheet that includes anticipated questions and answers, with plenty of space for notes, and for additional questions that may come to the minds of the participants during the presentation. Included in the course syllabus will be clinical descriptions of each procedure, diagnostic rationale, standard operating protocols, and anticipated treatment outcomes.</p>

<p>Cases will not necessarily be presented in an increasing order of difficulty, although emphasis will be on a learning curve that allows course participants to build confidence in their ability to routinely perform an increasingly broad range of procedures.</p>

<p>A selection from the clinical surgical applications of the diode laser will be presented during this module, to allow plenty of time for Dr. Hudson to explain each procedure in detail, and for participant interaction.</p>

<p>Suggested Pre Requisite Course is the Ultimate Soft Tissue Laser Certification Course by Dr. Chris Owens at $695 per participant designed for DDS\'s and RDH\'s as well as staff who can attend at a reduced fee of $395.</p>', '', '52');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('28', '1', 'Soft Tissue Handpiece - 10mm', 'Description:
200-800 Micron Fibers 30-90 Degree Tip Range
Also available in 6 mm body design
Money Back Guarantee if not the best handpiece you have  ever used.
<ul>
<li>Handpiece system works with all your leading Nd:YAG, Argon and Diode laser fibers, saving you big $$$$.</li>
<li>Feather-lite and Compact ergonomic design gives you access like never before to those difficult rear molar and deep pocket areas.</li>
<li>You adjust the tip angle to 90 degrees during treatments. Excellent tactile feel.</li>
<li>Disposable Plastic tips for the sterilization control you demand. Direct replacement for your existing plastic tips.</li>
<li>Gentle Fiber lock technology minimizes fiber breakage and locks your fibers solidly in place. Entire unit goes right in the autoclave for trouble free sterilization.</li>
</ul>', '', '9');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('28', '2', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('28', '3', '', '', '', '0');
insert into products_description (products_id, language_id, products_name, products_description, products_url, products_viewed) values ('29', '1', 'Soft Tissue Handpiece - 6mm', 'Description:
200-800 Micron Fibers 30-90 Degree Tip Range
Also available in 6 mm body design
Money Back Guarantee if not the best handpiece you have  ever used.
<ul>
<li>Handpiece system works with all your leading Nd:YAG, Argon and Diode laser fibers, saving you big $$$$.
<li>Feather-lite and Compact ergonomic design gives you access like never before to those difficult rear molar and deep pocket areas.
<li>You adjust the tip angle to 90 degrees during treatments. Excellent tactile feel.
<li>Disposable Plastic tips for the sterilization control you demand. Direct replacement for your existing plastic tips.
<li>Gentle Fiber lock technology minimizes fiber breakage and locks your fibers solidly in place. Entire unit goes right in the autoclave for trouble free sterilization.
</ul>', '', '2');
drop table if exists products_notifications;
create table products_notifications (
  products_id int(11) not null ,
  customers_id int(11) not null ,
  date_added datetime not null ,
  PRIMARY KEY (products_id, customers_id)
);

insert into products_notifications (products_id, customers_id, date_added) values ('46', '4', '2009-03-25 19:48:27');
insert into products_notifications (products_id, customers_id, date_added) values ('48', '4', '2009-03-25 19:51:25');
drop table if exists products_options;
create table products_options (
  products_options_id int(11) default '0' not null ,
  language_id int(11) default '1' not null ,
  products_options_name varchar(32) not null ,
  PRIMARY KEY (products_options_id, language_id)
);

insert into products_options (products_options_id, language_id, products_options_name) values ('4', '1', 'Select date');
insert into products_options (products_options_id, language_id, products_options_name) values ('3', '3', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('3', '1', 'Title');
insert into products_options (products_options_id, language_id, products_options_name) values ('2', '2', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('2', '3', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('2', '1', 'Live or online');
insert into products_options (products_options_id, language_id, products_options_name) values ('1', '3', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('3', '2', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('1', '2', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('1', '1', 'Your laser model');
insert into products_options (products_options_id, language_id, products_options_name) values ('4', '2', '');
insert into products_options (products_options_id, language_id, products_options_name) values ('4', '3', '');
drop table if exists products_options_values;
create table products_options_values (
  products_options_values_id int(11) default '0' not null ,
  language_id int(11) default '1' not null ,
  products_options_values_name varchar(64) not null ,
  PRIMARY KEY (products_options_values_id, language_id)
);

insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('8', '1', 'Spectralase - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('7', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('6', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('6', '1', 'Zap Softlase - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('4', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('3', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('7', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('7', '1', 'Promety - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('5', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('4', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('4', '1', 'Biolase Twilight - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('3', '1', 'Biolase LaserSmile - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('6', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('5', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('5', '1', 'Biolase Diolase Plus - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('3', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('2', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('2', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('2', '1', 'ADT Pulsemaster - 1064 Nd Yag');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('1', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('1', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('1', '1', 'ADT Diolase ST - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('8', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('8', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('9', '1', 'Hoya Diodent 1 - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('9', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('9', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('10', '1', 'Hoya Diodent 2 - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('10', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('10', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('12', '1', 'Hoya micro 980 - 980 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('12', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('12', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('13', '1', 'Incisive- 1064 Nd Yag');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('13', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('13', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('14', '1', 'Millenium - 1064 Nd Yag');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('14', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('14', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('15', '1', 'Sirona - 980 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('15', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('15', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('16', '1', 'Opus 5 or 10 - 810 Diode');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('16', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('16', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('17', '1', 'Lares - 1064 Nd yag');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('17', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('17', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('18', '1', 'Premier Aurora - 810 Diode*');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('18', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('18', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('19', '1', 'Live Course');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('19', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('19', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('20', '1', 'Online Course');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('20', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('20', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('21', '1', 'Dentist/Hygenist');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('21', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('21', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('22', '1', 'Staff');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('22', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('22', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('23', '1', '4/18 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('23', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('23', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('24', '1', '5/9 - Detroit, MI');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('24', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('24', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('25', '1', '5/30 - Minneapolis, MN');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('25', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('25', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('26', '1', '7/18 - Seattle, WA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('26', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('26', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('27', '1', '8/15 - Newark, NJ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('27', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('27', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('28', '1', '9/19 - San Diego, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('28', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('28', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('29', '1', '10/24 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('29', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('29', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('30', '1', '11/14 - Chicago, IL');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('30', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('30', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('31', '1', '12/5 - Los Angeles, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('31', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('31', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('32', '1', '4/19 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('32', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('32', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('33', '1', '5/10 - Detroit, MI');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('33', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('33', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('34', '1', '5/31 - Minneapolis, MN');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('34', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('34', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('35', '1', '7/19 - Seattle, WA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('35', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('35', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('36', '1', '8/16 - Newark, NJ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('36', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('36', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('37', '1', '9/20 - San Diego, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('37', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('37', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('38', '1', '10/25 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('38', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('38', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('39', '1', '11/15 - Chicago, IL');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('39', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('39', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('40', '1', '12/6 - Los Angeles, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('40', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('40', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('41', '1', '4/17 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('41', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('41', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('42', '1', '5/1 - San Diego, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('42', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('42', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('43', '1', '5/8 - Detroit, MI');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('43', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('43', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('44', '1', '5/22 - Portland, OR');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('44', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('44', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('45', '1', '5/29 - Minneapolis, MN');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('45', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('45', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('46', '1', '6/12 - St. Louis, MO');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('46', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('46', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('47', '1', '6/19 - Cleveland, OH');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('47', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('47', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('48', '1', '6/26 - Vancouver');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('48', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('48', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('49', '1', '7/17 - Seattle, WA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('49', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('49', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('50', '1', '7/24 - Boston, MA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('50', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('50', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('51', '1', '8/14 - Newark, NJ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('51', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('51', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('52', '1', '8/21 - Spokane, WA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('52', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('52', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('53', '1', '8/28 - Washington, DC');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('53', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('53', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('54', '1', '9/11 - San Francisco, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('54', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('54', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('55', '1', '9/18 - San Diego, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('55', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('55', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('56', '1', '9/25 - Orange County, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('56', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('56', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('57', '1', '10/23 - Phoenix, AZ');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('57', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('57', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('58', '1', '10/30 - Detroit, MI');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('58', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('58', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('59', '1', '11/6 - Denver, CO');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('59', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('59', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('60', '1', '11/13 - Chicago, IL');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('60', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('60', '3', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('61', '1', '12/4 - Los Angeles, CA');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('61', '2', '');
insert into products_options_values (products_options_values_id, language_id, products_options_values_name) values ('61', '3', '');
drop table if exists products_options_values_to_products_options;
create table products_options_values_to_products_options (
  products_options_values_to_products_options_id int(11) not null auto_increment,
  products_options_id int(11) not null ,
  products_options_values_id int(11) not null ,
  PRIMARY KEY (products_options_values_to_products_options_id)
);

insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('26', '1', '13');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('23', '1', '10');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('22', '1', '9');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('21', '1', '8');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('20', '1', '7');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('19', '1', '6');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('18', '1', '5');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('17', '1', '4');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('16', '1', '3');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('15', '1', '2');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('14', '1', '1');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('25', '1', '12');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('27', '1', '14');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('28', '1', '15');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('29', '1', '16');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('30', '1', '17');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('31', '1', '18');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('32', '2', '19');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('33', '2', '20');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('34', '3', '21');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('35', '3', '22');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('36', '4', '23');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('37', '4', '24');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('38', '4', '25');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('39', '4', '26');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('40', '4', '27');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('41', '4', '28');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('42', '4', '29');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('43', '4', '30');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('44', '4', '31');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('45', '4', '32');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('46', '4', '33');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('47', '4', '34');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('48', '4', '35');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('49', '4', '36');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('50', '4', '37');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('51', '4', '38');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('52', '4', '39');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('53', '2', '40');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('54', '4', '41');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('55', '4', '42');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('56', '4', '43');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('57', '4', '44');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('58', '4', '45');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('59', '4', '46');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('60', '4', '47');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('61', '4', '48');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('62', '4', '49');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('63', '4', '50');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('64', '4', '51');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('65', '4', '52');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('66', '4', '53');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('67', '4', '54');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('68', '4', '55');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('69', '4', '56');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('70', '4', '57');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('71', '4', '58');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('72', '4', '59');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('73', '4', '60');
insert into products_options_values_to_products_options (products_options_values_to_products_options_id, products_options_id, products_options_values_id) values ('74', '4', '61');
drop table if exists products_to_categories;
create table products_to_categories (
  products_id int(11) not null ,
  categories_id int(11) not null ,
  PRIMARY KEY (products_id, categories_id)
);

insert into products_to_categories (products_id, categories_id) values ('28', '2');
insert into products_to_categories (products_id, categories_id) values ('29', '2');
insert into products_to_categories (products_id, categories_id) values ('30', '2');
insert into products_to_categories (products_id, categories_id) values ('31', '2');
insert into products_to_categories (products_id, categories_id) values ('32', '2');
insert into products_to_categories (products_id, categories_id) values ('33', '2');
insert into products_to_categories (products_id, categories_id) values ('34', '2');
insert into products_to_categories (products_id, categories_id) values ('35', '2');
insert into products_to_categories (products_id, categories_id) values ('36', '2');
insert into products_to_categories (products_id, categories_id) values ('37', '2');
insert into products_to_categories (products_id, categories_id) values ('38', '3');
insert into products_to_categories (products_id, categories_id) values ('39', '3');
insert into products_to_categories (products_id, categories_id) values ('40', '3');
insert into products_to_categories (products_id, categories_id) values ('41', '3');
insert into products_to_categories (products_id, categories_id) values ('42', '3');
insert into products_to_categories (products_id, categories_id) values ('43', '3');
insert into products_to_categories (products_id, categories_id) values ('44', '3');
insert into products_to_categories (products_id, categories_id) values ('45', '3');
insert into products_to_categories (products_id, categories_id) values ('46', '1');
insert into products_to_categories (products_id, categories_id) values ('47', '1');
insert into products_to_categories (products_id, categories_id) values ('48', '1');
insert into products_to_categories (products_id, categories_id) values ('49', '1');
insert into products_to_categories (products_id, categories_id) values ('50', '2');
drop table if exists reviews;
create table reviews (
  reviews_id int(11) not null auto_increment,
  products_id int(11) not null ,
  customers_id int(11) ,
  customers_name varchar(64) not null ,
  reviews_rating int(1) ,
  date_added datetime ,
  last_modified datetime ,
  reviews_read int(5) default '0' not null ,
  PRIMARY KEY (reviews_id),
  KEY idx_reviews_products_id (products_id),
  KEY idx_reviews_customers_id (customers_id)
);

drop table if exists reviews_description;
create table reviews_description (
  reviews_id int(11) not null ,
  languages_id int(11) not null ,
  reviews_text text not null ,
  PRIMARY KEY (reviews_id, languages_id)
);

drop table if exists sessions;
create table sessions (
  sesskey varchar(32) not null ,
  expiry int(11) unsigned not null ,
  value text not null ,
  PRIMARY KEY (sesskey)
);

drop table if exists specials;
create table specials (
  specials_id int(11) not null auto_increment,
  products_id int(11) not null ,
  specials_new_products_price decimal(15,4) not null ,
  specials_date_added datetime ,
  specials_last_modified datetime ,
  expires_date datetime ,
  date_status_change datetime ,
  status int(1) default '1' not null ,
  PRIMARY KEY (specials_id),
  KEY idx_specials_products_id (products_id)
);

drop table if exists tax_class;
create table tax_class (
  tax_class_id int(11) not null auto_increment,
  tax_class_title varchar(32) not null ,
  tax_class_description varchar(255) not null ,
  last_modified datetime ,
  date_added datetime not null ,
  PRIMARY KEY (tax_class_id)
);

insert into tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) values ('1', 'Taxable Goods', 'The following types of products are included non-food, services, etc', '2009-03-04 10:56:09', '2009-03-04 10:56:09');
drop table if exists tax_rates;
create table tax_rates (
  tax_rates_id int(11) not null auto_increment,
  tax_zone_id int(11) not null ,
  tax_class_id int(11) not null ,
  tax_priority int(5) default '1' ,
  tax_rate decimal(7,4) not null ,
  tax_description varchar(255) not null ,
  last_modified datetime ,
  date_added datetime not null ,
  PRIMARY KEY (tax_rates_id)
);

insert into tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) values ('1', '1', '1', '1', '7.0000', 'FL TAX 7.0%', '2009-03-04 10:56:09', '2009-03-04 10:56:09');
drop table if exists whos_online;
create table whos_online (
  customer_id int(11) ,
  full_name varchar(64) not null ,
  session_id varchar(128) not null ,
  ip_address varchar(15) not null ,
  time_entry varchar(14) not null ,
  time_last_click varchar(14) not null ,
  last_page_url text not null 
);

drop table if exists zones;
create table zones (
  zone_id int(11) not null auto_increment,
  zone_country_id int(11) not null ,
  zone_code varchar(32) not null ,
  zone_name varchar(32) not null ,
  PRIMARY KEY (zone_id),
  KEY idx_zones_country_id (zone_country_id)
);

insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('1', '223', 'AL', 'Alabama');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('2', '223', 'AK', 'Alaska');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('3', '223', 'AS', 'American Samoa');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('4', '223', 'AZ', 'Arizona');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('5', '223', 'AR', 'Arkansas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('6', '223', 'AF', 'Armed Forces Africa');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('7', '223', 'AA', 'Armed Forces Americas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('8', '223', 'AC', 'Armed Forces Canada');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('9', '223', 'AE', 'Armed Forces Europe');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('10', '223', 'AM', 'Armed Forces Middle East');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('11', '223', 'AP', 'Armed Forces Pacific');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('12', '223', 'CA', 'California');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('13', '223', 'CO', 'Colorado');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('14', '223', 'CT', 'Connecticut');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('15', '223', 'DE', 'Delaware');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('16', '223', 'DC', 'District of Columbia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('17', '223', 'FM', 'Federated States Of Micronesia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('18', '223', 'FL', 'Florida');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('19', '223', 'GA', 'Georgia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('20', '223', 'GU', 'Guam');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('21', '223', 'HI', 'Hawaii');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('22', '223', 'ID', 'Idaho');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('23', '223', 'IL', 'Illinois');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('24', '223', 'IN', 'Indiana');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('25', '223', 'IA', 'Iowa');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('26', '223', 'KS', 'Kansas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('27', '223', 'KY', 'Kentucky');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('28', '223', 'LA', 'Louisiana');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('29', '223', 'ME', 'Maine');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('30', '223', 'MH', 'Marshall Islands');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('31', '223', 'MD', 'Maryland');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('32', '223', 'MA', 'Massachusetts');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('33', '223', 'MI', 'Michigan');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('34', '223', 'MN', 'Minnesota');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('35', '223', 'MS', 'Mississippi');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('36', '223', 'MO', 'Missouri');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('37', '223', 'MT', 'Montana');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('38', '223', 'NE', 'Nebraska');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('39', '223', 'NV', 'Nevada');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('40', '223', 'NH', 'New Hampshire');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('41', '223', 'NJ', 'New Jersey');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('42', '223', 'NM', 'New Mexico');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('43', '223', 'NY', 'New York');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('44', '223', 'NC', 'North Carolina');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('45', '223', 'ND', 'North Dakota');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('46', '223', 'MP', 'Northern Mariana Islands');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('47', '223', 'OH', 'Ohio');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('48', '223', 'OK', 'Oklahoma');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('49', '223', 'OR', 'Oregon');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('50', '223', 'PW', 'Palau');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('51', '223', 'PA', 'Pennsylvania');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('52', '223', 'PR', 'Puerto Rico');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('53', '223', 'RI', 'Rhode Island');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('54', '223', 'SC', 'South Carolina');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('55', '223', 'SD', 'South Dakota');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('56', '223', 'TN', 'Tennessee');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('57', '223', 'TX', 'Texas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('58', '223', 'UT', 'Utah');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('59', '223', 'VT', 'Vermont');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('60', '223', 'VI', 'Virgin Islands');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('61', '223', 'VA', 'Virginia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('62', '223', 'WA', 'Washington');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('63', '223', 'WV', 'West Virginia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('64', '223', 'WI', 'Wisconsin');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('65', '223', 'WY', 'Wyoming');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('66', '38', 'AB', 'Alberta');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('67', '38', 'BC', 'British Columbia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('68', '38', 'MB', 'Manitoba');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('69', '38', 'NF', 'Newfoundland');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('70', '38', 'NB', 'New Brunswick');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('71', '38', 'NS', 'Nova Scotia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('72', '38', 'NT', 'Northwest Territories');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('73', '38', 'NU', 'Nunavut');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('74', '38', 'ON', 'Ontario');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('75', '38', 'PE', 'Prince Edward Island');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('76', '38', 'QC', 'Quebec');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('77', '38', 'SK', 'Saskatchewan');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('78', '38', 'YT', 'Yukon Territory');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('79', '81', 'NDS', 'Niedersachsen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('80', '81', 'BAW', 'Baden-Württemberg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('81', '81', 'BAY', 'Bayern');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('82', '81', 'BER', 'Berlin');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('83', '81', 'BRG', 'Brandenburg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('84', '81', 'BRE', 'Bremen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('85', '81', 'HAM', 'Hamburg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('86', '81', 'HES', 'Hessen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('87', '81', 'MEC', 'Mecklenburg-Vorpommern');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('88', '81', 'NRW', 'Nordrhein-Westfalen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('89', '81', 'RHE', 'Rheinland-Pfalz');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('90', '81', 'SAR', 'Saarland');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('91', '81', 'SAS', 'Sachsen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('92', '81', 'SAC', 'Sachsen-Anhalt');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('93', '81', 'SCN', 'Schleswig-Holstein');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('94', '81', 'THE', 'Thüringen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('95', '14', 'WI', 'Wien');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('96', '14', 'NO', 'Niederösterreich');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('97', '14', 'OO', 'Oberösterreich');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('98', '14', 'SB', 'Salzburg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('99', '14', 'KN', 'Kärnten');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('100', '14', 'ST', 'Steiermark');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('101', '14', 'TI', 'Tirol');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('102', '14', 'BL', 'Burgenland');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('103', '14', 'VB', 'Voralberg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('104', '204', 'AG', 'Aargau');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('105', '204', 'AI', 'Appenzell Innerrhoden');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('106', '204', 'AR', 'Appenzell Ausserrhoden');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('107', '204', 'BE', 'Bern');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('108', '204', 'BL', 'Basel-Landschaft');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('109', '204', 'BS', 'Basel-Stadt');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('110', '204', 'FR', 'Freiburg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('111', '204', 'GE', 'Genf');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('112', '204', 'GL', 'Glarus');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('113', '204', 'JU', 'Graubünden');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('114', '204', 'JU', 'Jura');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('115', '204', 'LU', 'Luzern');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('116', '204', 'NE', 'Neuenburg');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('117', '204', 'NW', 'Nidwalden');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('118', '204', 'OW', 'Obwalden');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('119', '204', 'SG', 'St. Gallen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('120', '204', 'SH', 'Schaffhausen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('121', '204', 'SO', 'Solothurn');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('122', '204', 'SZ', 'Schwyz');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('123', '204', 'TG', 'Thurgau');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('124', '204', 'TI', 'Tessin');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('125', '204', 'UR', 'Uri');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('126', '204', 'VD', 'Waadt');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('127', '204', 'VS', 'Wallis');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('128', '204', 'ZG', 'Zug');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('129', '204', 'ZH', 'Zürich');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('130', '195', 'A Coruña', 'A Coruña');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('131', '195', 'Alava', 'Alava');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('132', '195', 'Albacete', 'Albacete');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('133', '195', 'Alicante', 'Alicante');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('134', '195', 'Almeria', 'Almeria');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('135', '195', 'Asturias', 'Asturias');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('136', '195', 'Avila', 'Avila');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('137', '195', 'Badajoz', 'Badajoz');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('138', '195', 'Baleares', 'Baleares');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('139', '195', 'Barcelona', 'Barcelona');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('140', '195', 'Burgos', 'Burgos');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('141', '195', 'Caceres', 'Caceres');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('142', '195', 'Cadiz', 'Cadiz');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('143', '195', 'Cantabria', 'Cantabria');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('144', '195', 'Castellon', 'Castellon');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('145', '195', 'Ceuta', 'Ceuta');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('146', '195', 'Ciudad Real', 'Ciudad Real');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('147', '195', 'Cordoba', 'Cordoba');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('148', '195', 'Cuenca', 'Cuenca');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('149', '195', 'Girona', 'Girona');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('150', '195', 'Granada', 'Granada');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('151', '195', 'Guadalajara', 'Guadalajara');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('152', '195', 'Guipuzcoa', 'Guipuzcoa');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('153', '195', 'Huelva', 'Huelva');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('154', '195', 'Huesca', 'Huesca');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('155', '195', 'Jaen', 'Jaen');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('156', '195', 'La Rioja', 'La Rioja');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('157', '195', 'Las Palmas', 'Las Palmas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('158', '195', 'Leon', 'Leon');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('159', '195', 'Lleida', 'Lleida');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('160', '195', 'Lugo', 'Lugo');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('161', '195', 'Madrid', 'Madrid');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('162', '195', 'Malaga', 'Malaga');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('163', '195', 'Melilla', 'Melilla');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('164', '195', 'Murcia', 'Murcia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('165', '195', 'Navarra', 'Navarra');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('166', '195', 'Ourense', 'Ourense');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('167', '195', 'Palencia', 'Palencia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('168', '195', 'Pontevedra', 'Pontevedra');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('169', '195', 'Salamanca', 'Salamanca');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('170', '195', 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('171', '195', 'Segovia', 'Segovia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('172', '195', 'Sevilla', 'Sevilla');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('173', '195', 'Soria', 'Soria');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('174', '195', 'Tarragona', 'Tarragona');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('175', '195', 'Teruel', 'Teruel');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('176', '195', 'Toledo', 'Toledo');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('177', '195', 'Valencia', 'Valencia');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('178', '195', 'Valladolid', 'Valladolid');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('179', '195', 'Vizcaya', 'Vizcaya');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('180', '195', 'Zamora', 'Zamora');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('181', '195', 'Zaragoza', 'Zaragoza');
drop table if exists zones_to_geo_zones;
create table zones_to_geo_zones (
  association_id int(11) not null auto_increment,
  zone_country_id int(11) not null ,
  zone_id int(11) ,
  geo_zone_id int(11) ,
  last_modified datetime ,
  date_added datetime not null ,
  PRIMARY KEY (association_id),
  KEY idx_zones_to_geo_zones_country_id (zone_country_id)
);

insert into zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) values ('1', '223', '18', '1', NULL, '2009-03-04 10:56:09');
