<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = "auth";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/* Admin Panel */

$route['reset-password-admin/(:any)'] = 'auth/reset_password/$1';
$route['admin'] = "auth/index";
$route['login'] = "auth/index";
$route['recover'] = "auth/recover";
$route['forgot-password'] = "auth/forgot_password";
$route['reset-password/(:any)/(:any)'] = 'auth/reset_password_admin';
$route['reset-password-action'] = "auth/reset_password_action";
$route['verify/(:any)/(:any)'] = 'auth/verify_customer/$1/$2';
$route['logout'] = 'auth/logout';
$route['register'] = 'auth/register';
$route['dashboard'] = 'dashboard/index';
$route['short-code'] = 'dashboard/short_code';
$route['system-log'] = 'dashboard/system_log';
$route['upgrade'] = 'dashboard/upgrade';
$route['paypal-success'] = 'dashboard/paypal_success';
$route['paypal-cancel'] = 'dashboard/paypal_cancel';

$route['checkout/(:num)'] = 'dashboard/checkout/$1';
$route['profile-save'] = 'dashboard/admin_profile_save';
$route['profile-image-save'] = 'dashboard/admin_profile_image_save';
$route['check-supply-admin-email'] = 'dashboard/check_supply_admin_email';
$route['password-change'] = 'dashboard/admin_password_change_form';
$route['password-change'] = 'dashboard/admin_change_password';
$route['backup'] = 'dashboard/backup';
$route['profile'] = 'dashboard/profile';


//manage admin
$route['manage-user'] = 'users/user_list';
$route['add-user'] = 'users/add_user';
$route['delete-user-action'] = 'users/delete_user_action';
$route['update-user/(:num)'] = 'users/update_user/$1';
$route['add-user-action'] = 'users/add_user_action';
$route['update-user-status/(:any)/(:any)'] = 'users/update_user_status/$1/$2';
$route['check-admin-user-email'] = 'users/check_admin_user_email';

//package
$route['transaction'] = 'dashboard/transaction';
$route['manage-package'] = 'dashboard/package_list';
$route['update-package/(:num)'] = 'dashboard/update_package/$1';
$route['add-package-action'] = 'dashboard/add_package_action';

//Manage contact
$route['manage-contacts'] = 'contact/contact_list';
$route['remove-contact-action'] = 'contact/remove_contact_list';
$route['add-contact'] = 'contact/add_contact';
$route['delete-contact-action'] = 'contact/delete_contact_action';
$route['update-contact/(:num)'] = 'contact/update_contact/$1';
$route['add-contact-action'] = 'contact/add_contact_action';
$route['update-contact-status/(:any)/(:any)'] = 'contact/update_contact_status/$1/$2';

//manage client
$route['manage-client'] = 'users/client_list';
$route['manage-subscription/(:num)'] = 'users/subscription/$1';
$route['add-client'] = 'users/add_client';
$route['delete-client-action'] = 'users/delete_client_action';
$route['update-client/(:num)'] = 'users/update_client/$1';
$route['add-client-action'] = 'users/add_client_action';
$route['update-client-status/(:any)/(:any)'] = 'users/update_client_status/$1/$2';
$route['check-client-email'] = 'users/check_client_email';
$route['get-client-server/(:num)'] = 'users/get_client_server/$1';

$route['site-setting'] = 'setting/site_setting';
$route['email-setting'] = 'setting/email_setting';
$route['update-email'] = 'setting/update_email';
$route['update-site'] = 'setting/update_site';
$route['manage-content'] = 'setting/manage_content';
$route['update-content-action'] = 'setting/update_content_action';
$route['update-content/(:num)'] = 'setting/update_content/$1';

/** message * */
$route['obd'] = 'reports/obd';
$route['long-code'] = 'reports/long_code';
$route['sms-all'] = 'reports/sms_all';
$route['download-request'] = 'reports/download_request';
$route['upload-request-file/(:num)'] = 'reports/upload_request_file/$1';
$route['upload-request-file-action'] = 'reports/upload_request_file_action/';
$route['download-report-action'] = 'reports/download_report_action';
$route['import-mobile-action'] = 'reports/import_mobile_action';
$route['download-report'] = 'reports/download_report';
$route['obd-details/(:num)'] = 'reports/obd_details/$1';
$route['sms-api'] = 'reports/sms_api';
$route['summary-report'] = 'reports/summary_report';
$route['import-data'] = 'reports/import_data';
$route['download-import-data'] = 'reports/download_import_data';
