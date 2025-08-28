<?php
namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
$routes->get('/tasks', 'TaskController::index');
$routes->get('/tasks/create', 'TaskController::create');
$routes->post('/tasks/store', 'TaskController::store');
$routes->get('/tasks/edit/(:num)', 'TaskController::edit/$1');
$routes->post('/tasks/update/(:num)', 'TaskController::update/$1');
$routes->get('/tasks/delete/(:num)', 'TaskController::deleteView/$1');
$routes->get('/tasks/show/(:num)', 'TaskController::show/$1');

//api

$routes->post('api/tasks/delete/(:num)', 'TaskApiController::delete/$1');
$routes->get('api/tasks', 'TaskApiController::getTasks');
$routes->get('api//tasks/store', 'TaskApiController::storeTasks');
$routes->get('api//tasks/delete/(:num)', 'TaskApiController::deleteTasks');
$routes->get('api/tasks/show/(:num)', 'TaskApiController::showTasks/$1');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'WelcomeController::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
