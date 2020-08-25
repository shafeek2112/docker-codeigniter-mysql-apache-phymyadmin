<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "auth/login";
$route['404_override'] = '';

$route['profile/delete_profile_document/(:any)'] = 'profile/delete_profile_document/$1';
$route['profile/upload_profile_pic/(:any)'] = 'profile/upload_profile_pic/$1';
$route['profile/update_password/(:any)'] = 'profile/update_password/$1';
$route['profile/update_account/(:any)'] = 'profile/update_account/$1';
$route['profile/update_settings'] = 'profile/update_settings';
$route['profile/update_uni_account/(:any)'] = 'profile/update_uni_account/$1';
$route['profile/update_rec_info'] = 'profile/update_rec_info';
$route['profile/rotateImage/(:any)'] = 'profile/rotateImage/$1';
$route['profile/validate_passport_num'] = 'profile/validate_passport_num';
$route['profile/upload_document/(:any)'] = 'profile/upload_document/$1';
$route['profile/add_profile'] = 'profile/add_profile';
$route['profile/view_profile/(:any)'] = 'profile/view_profile/$1';
$route['profile/(:any)'] = 'profile/index/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */