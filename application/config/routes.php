<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] 	= 'login';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;


/*
|-------------------------------------------------------------------------
| Custom SEO Friendly URI ROUTING
| -------------------------------------------------------------------------
*/

$route['change-password'] 					= "Profile/change_password";
$route['profile']							= "Profile/user_profile";
$route['forgot-password']					= "Profile/forgot_password";
$route['user']								= "Users/index";
$route['user/add']							= "Users/add";
$route['item-master-upload'] 				= "ScanDetailsUpload/itemMasterUpload";
$route['pre-stock-upload'] 					= "ScanDetailsUpload/preStockUpload";
$route['location-mapping-upload'] 			= "ScanDetailsUpload/locationMappingUpload";
$route['scan-details-upload'] 				= "ScanDetailsUpload/index";
$route['gc-upload'] 						= "ScanDetailsUpload/gcUpload";
$route['user-details-upload'] 				= "ScanDetailsUpload/userDetailsUpload";
$route['variance-register-details-upload']	= "ScanDetailsUpload/varianceReportUpload";
$route['delete-scan-details-item'] 			= "ScanDetailsUpload/deleteScanItem";
$route['delete-item-master'] 				= "ScanDetailsUpload/deleteItemMaster";
$route['scan-details-upload-report'] 		= "Reports/index";
$route['invalid-EAN-report'] 				= "Reports/invalidEANreport";
$route['valid-EAN-report'] 					= "Reports/validEANreport";
$route['without-barcode-report'] 			= "Reports/withoutBarCodeReport";
$route['location-wise-user-details-report'] = "Reports/locationWiseUserDetailsReport";
$route['variance-register-report'] 			= "Reports/varianceRegisterReport";
$route['variance-reconcilation-report'] 	= "Reports/varianceReconcilationReport";
$route['location-wise-print'] 				= "Reports/locationWisePrint";
$route['location-wise-print-details'] 		= "Reports/locationWisePrintDetails";



