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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';

$route['supplier/average'] = "suppliers/view/average/true";
$route['supplier/(:any)'] = "suppliers/view/$1";
$route['historical/20([0-9]{2})-q([1-4]){1}'] = "historical/view_quarter/20$1/$2";
$route['charts/historical/20([0-9]{2})-q([1-4]){1}(\.js)?'] = "charts/view_period/20$1/$2";
$route['charts/supplier/(:any).js'] = "charts/view_supplier/$1";
$route['charts/(:any).js'] = "charts/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */