<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
$route['tags/get_pictures(\/?(:any))?'] = "tags/get_pictures/$2";
$route['tags/index/(:num)'] = "tags/index/$1";
$route['tags/search'] = "tags/search";
$route['tags/(:any)'] = "tags/index/$1";

$route['pictures/index/(:num)'] = "pictures/index/$1";
$route['pictures/set_score'] = "pictures/set_score";
$route['pictures/delete_picture'] = "pictures/delete_picture";
$route['pictures/delete_comment'] = "pictures/delete_comment";
$route['pictures/fetch_star_details'] = "pictures/fetch_star_details";
$route['pictures/submit_comment'] = "pictures/submit_comment";
$route['pictures/get_comments'] = "pictures/get_comments";
$route['pictures/(:any)'] = "pictures/index/$1";

$route['users/get_pictures'] = "users/get_pictures";
$route['users/set_follow'] = "users/set_follow";
$route['users/get_actives'] = "users/get_actives";
$route['users/(:any)/pictures'] = "users/pictures/$1";
$route['users/(:any)'] = "users/index/$1";

$route['default_controller'] = "main";
$route['admin'] = "admin/main";
$route['404_override'] = '';

// $route['units/map'] = "units/map";
// $route['units/(:num)'] = "units/id/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */