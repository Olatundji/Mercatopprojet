<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->get('/profile', 'AuthController::profile');
//produit
$routes->post('product/create', 'ProductController::create');
$routes->put('product/update/(:num)', 'ProductController::update/$1');
$routes->delete('product/delete/(:num)', 'ProductController::delete/$1');
$routes->get('products', 'ProductController::index');
//Marque
$routes->get('marques/index', 'MarqueController::index');
$routes->post('marques/create', 'MarqueController::create');
$routes->get('marques/show/(:num)', 'MarqueController::show/$1');
$routes->put('marques/update/(:num)', 'MarqueController::update/$1');
$routes->delete('marques/delete/(:num)', 'MarqueController::delete/$1');
//promotion
$routes->get('promotions/index', 'PromotionController::index');
$routes->get('promotions/show/(:num)', 'PromotionController::show/$1');
$routes->post('promotions/create', 'PromotionController::create');
$routes->put('promotions/update/(:num)', 'PromotionController::update/$1');
$routes->delete('promotions/delete/(:num)', 'PromotionController::delete/$1');
//blog , article
$routes->get('articles/index', 'ArticleController::index');
$routes->get('articles/show/(:num)', 'ArticleController::show/$1');
$routes->post('articles/create', 'ArticleController::create');
$routes->put('articles/update/(:num)', 'ArticleController::update/$1');
$routes->delete('articles/delete/(:num)', 'ArticleController::delete/$1');
//paramettre
$routes->get('parametres/index', 'ParametreController::index');
$routes->put('parametres/update/(:num)', 'ParametreController::update/$1');
//categoriearticle
$routes->get('categoriearticles/index', 'CategorieArticleController::index');
$routes->post('categoriearticles/create', 'CategorieArticleController::create');
$routes->get('categoriearticles/show/(:num)', 'CategorieArticleController::show/$1');
$routes->put('categoriearticles/update/(:num)', 'CategorieArticleController::update/$1');
$routes->delete('categoriearticles/delete/(:num)', 'CategorieArticleController::delete/$1');
//categorie
$routes->get('categories/index', 'CategorieController::index');
$routes->post('categories/create', 'CategorieController::create');
$routes->get('categories/show/(:num)', 'CategorieController::show/$1');
$routes->put('categories/update/(:num)', 'CategorieController::update/$1');
$routes->delete('categories/delete/(:num)', 'CategorieController::delete/$1');

service('auth')->routes($routes);
