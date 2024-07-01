<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//     $routes->resource('user');

//      $routes->post('/login', 'AuthController::login');
//      $routes->post('/register', 'AuthController::register');
//      $routes->get('/profile', 'AuthController::profile');
//  });
$routes->post('api/login', 'AuthController::login');
$routes->post('api/register', 'AuthController::register');
$routes->get('api/profile/(:num)', 'AuthController::show/$1');
$routes->put('api/users/update/(:num)', 'AuthController::update/$1');
$routes->post('api/forgot-password', 'AuthController::forgotPassword');
//$routes->post('api/reset-password', 'AuthController::resetPassword');
$routes->post('api/change-password', 'AuthController::changePassword');
$routes->get('api/auth/activate/(:segment)', 'AuthController::activate/$1');
$routes->get('reset-password', 'AuthController::resetPasswordForm');
$routes->post('reset-password', 'AuthController::resetPassword');

//produit
// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//     $routes->resource('product');

//     $routes->post('product/create', 'ProductController::create');
//     $routes->put('product/update/(:num)', 'ProductController::update/$1');
//     $routes->delete('product/delete/(:num)', 'ProductController::delete/$1');
//     $routes->get('products', 'ProductController::index');
//     $routes->get('search', 'ProductController::search');
// });
$routes->post('api/product/create', 'ProductController::create');
$routes->put('api/product/update/(:num)', 'ProductController::update/$1');
$routes->delete('api/product/delete/(:num)', 'ProductController::delete/$1');
$routes->get('api/products', 'ProductController::index');
$routes->get('api/product/search', 'ProductController::search');
$routes->get('api/product/detail/(:num)', 'ProductController::detail/$1');
$routes->get('api/limit-products', 'ProductController::getRandomProduit');
$routes->get('api/products/searchFilters', 'ProductController::searchFilters');
$routes->get('api/products/show/(:num)', 'ProductController::show/$1');





//Marque

// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//      $routes->resource('marques');

//      $routes->get('marques/index', 'MarqueController::index');
//$routes->post('marques/create', 'MarqueController::create');
//     $routes->get('marques/show/(:num)', 'MarqueController::show/$1');
//     $routes->put('marques/update/(:num)', 'MarqueController::update/$1');
//     $routes->delete('marques/delete/(:num)', 'MarqueController::delete/$1');
//});
$routes->post('api/marque', 'MarqueController::create');
$routes->get('api/marques/index', 'MarqueController::index');
$routes->get('api/marques/search', 'MarqueController::search');
$routes->put('api/marques/update/(:num)', 'MarqueController::update/$1');
$routes->delete('api/marques/delete/(:num)', 'MarqueController::delete/$1');
//promotion

// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//     // $routes->resource('promotions');

//     $routes->post('promotions/produit/create', 'PromotionController::createProductPromotion');
//     $routes->post('promotions/categorie/create', 'PromotionController::createCategoryPromotion');
//     $routes->post('promotions/montant/create', 'PromotionController::createMontantPromotion');
//     $routes->post('promotions/use', 'PromotionController::usePromoCode');
// });

$routes->post('api/promotions/produit/create', 'PromotionController::createProductPromotion');
$routes->post('api/promotions/categorie/create', 'PromotionController::createCategoryPromotion');
$routes->post('api/promotions/montant/create', 'PromotionController::createMontantPromotion');
$routes->post('api/promotions/use', 'PromotionController::usePromoCode');
$routes->delete('api/promotions/delete/(:num)', 'PromotionController::deletePromotion/$1');
$routes->get('api/promotions', 'PromotionController::getAllPromotions');

// $routes->get('promotions/index', 'PromotionController::index');
// $routes->get('promotions/show/(:num)', 'PromotionController::show/$1');
// $routes->post('promotions/create', 'PromotionController::create');
// $routes->put('promotions/update/(:num)', 'PromotionController::update/$1');
// $routes->delete('promotions/delete/(:num)', 'PromotionController::delete/$1');
//blog , article

$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('article');

    $routes->get('articles/index', 'ArticleController::index');
    $routes->get('articles/search', 'ArticleController::search');
    $routes->post('articles/create', 'ArticleController::create');
    $routes->post('articles/update/(:num)', 'ArticleController::update/$1');
    $routes->delete('articles/delete/(:num)', 'ArticleController::delete/$1');
    $routes->get('articles/show/(:num)', 'ArticleController::show/$1');
});

$routes->get('api/articles/detail/(:num)', 'ArticleController::detail/$1');

// $routes->get('articles/index', 'ArticleController::index');
// $routes->get('articles/show/(:num)', 'ArticleController::show/$1');
// $routes->post('articles/create', 'ArticleController::create');
// $routes->put('articles/update/(:num)', 'ArticleController::update/$1');
// $routes->delete('articles/delete/(:num)', 'ArticleController::delete/$1');
//paramettre

$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('parametre');

    $routes->get('parametres/create', 'ParametreController::create');
    $routes->get('parametres/index', 'ParametreController::index');
    $routes->post('parametres/update/(:num)', 'ParametreController::update/$1');
    $routes->get('parametres/show/(:num)', 'ParametreController::show/$1');
});
//$routes->get('parametres/index', 'ParametreController::index');
//$routes->put('parametres/update/(:num)', 'ParametreController::update/$1');
//categoriearticle

$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('categoriearticle');

    $routes->get('categoriearticles/index', 'CategorieArticleController::index');
    $routes->post('categoriearticles/create', 'CategorieArticleController::create');
    $routes->get('categoriearticles/search', 'CategorieArticleController::search');
    $routes->put('categoriearticles/update/(:num)', 'CategorieArticleController::update/$1');
    $routes->delete('categoriearticles/delete/(:num)', 'CategorieArticleController::delete/$1');
});
// $routes->get('categoriearticles/index', 'CategorieArticleController::index');
// $routes->post('categoriearticles/create', 'CategorieArticleController::create');
// $routes->get('categoriearticles/show/(:num)', 'CategorieArticleController::show/$1');
// $routes->put('categoriearticles/update/(:num)', 'CategorieArticleController::update/$1');
// $routes->delete('categoriearticles/delete/(:num)', 'CategorieArticleController::delete/$1');
//categorie

// $routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
//     $routes->resource('categorie');

//     $routes->get('categories/index', 'CategorieController::index');
// $routes->post('categories/create', 'CategorieController::create');
// $routes->get('categories/show/(:num)', 'CategorieController::show/$1');
// $routes->put('categories/update/(:num)', 'CategorieController::update/$1');
// $routes->delete('categories/delete/(:num)', 'CategorieController::delete/$1');
// $routes->get('produits/categorie/(:num)', 'ControllerProduit::rechercheParCategorie/$1');

// });
$routes->get('api/categories/index', 'CategorieController::index');
$routes->post('api/categories/create', 'CategorieController::create');
$routes->get('/api/categories/search', 'CategorieController::search');
$routes->put('/api/categories/update/(:num)', 'CategorieController::update/$1');
$routes->delete('api/categories/delete/(:num)', 'CategorieController::delete/$1');
//recherche par categorie de produit
$routes->get('api/produits/categorie/(:num)', 'ControllerProduit::rechercheParCategorie/$1');
//panier


$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('panier');

    $routes->post('panier/ajouter', 'PanierController::ajouterProduit');
    $routes->get('panier/consulter', 'PanierController::consulterPanier');
    $routes->put('panier/modifier/(:num)', 'PanierController::modifierProduit/$1');
    $routes->delete('panier/supprimer/(:num)', 'PanierController::supprimerProduit/$1');
    $routes->delete('panier/vider', 'PanierController::viderPanier');
});
// $routes->post('panier/ajouter', 'PanierController::ajouterProduit');
// $routes->get('panier/consulter', 'PanierController::consulterPanier');
// $routes->put('panier/modifier/(:num)', 'PanierController::modifierProduit/$1');
// $routes->delete('panier/supprimer/(:num)', 'PanierController::supprimerProduit/$1');
// $routes->delete('panier/vider', 'PanierController::viderPanier');
//commande

$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('commande');

    $routes->post('commande/create', 'CommandeController::create');
    $routes->post('commande/index', 'CommandeController::index');
    $routes->get('commandes-utilisateur/(:num)', 'CommandeController::commandesUtilisateur/$1');
    $routes->post('admin/valider-commande/(:num)', 'CommandeController::validerCommande/$1');
    $routes->get('commande/index', 'CommandeController::listeToutesCommandes');
    $routes->get('commande/user/(:num)', 'CommandeController::listeCommandesUtilisateur/$1');
});
// $routes->post('commande/nouvelle', 'CommandeController::nouvelleCommande');
// $routes->get('commande/details/(:num)', 'CommandeController::detailsCommande/$1');
// $routes->get('commande/historique', 'CommandeController::historiqueCommandes');
// $routes->get('commande/methodes-paiement', 'CommandeController::listerMethodesPaiement');
// $routes->post('commande/:numCommande/methode-paiement/:numMethode', 'CommandeController::choisirMethodePaiement/$1/$2');
//reduction
$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    // $routes->resource('reduction');

    $routes->get('reductions', 'ReductionController::listerReductions');
    $routes->post('reductions/utiliser', 'ReductionController::utiliserReduction');
});
//$routes->get('reductions', 'ReductionController::listerReductions');
//$routes->post('reductions/utiliser', 'ReductionController::utiliserReduction');

// $routes->get('pa iement/methodes', 'PaiementController::listerMethodesPaiement');
// $routes->post('paiement/commande/:num' , '');

//service('auth')->routes($routes);

//favoris
$routes->post('api/favoris/create', 'FavorisController::create');
$routes->get('api/favoris/user/(:num)', 'FavorisController::index/$1');
$routes->delete('api/favoris/delete/(:num)', 'FavorisController::delete/$1');
$routes->get('api/verify-token', 'AuthController::verifyToken');
//commentaire
$routes->post('api/produitcommentaires/create', 'CommentaireController::createProduitCommentaire');
$routes->post('api/articlecommentaires/create', 'CommentaireController::createArticleCommentaire');

//$routes->get('api/commentaires/index', 'CommentaireController::index');

$routes->delete('api/commentaires/delete/(:num)', 'CommentaireController::delete/$1');


$routes->post('api/upload', 'FileController::uploadFile');

$routes->get('api/reports/sales', 'RepportController::salesReport');
$routes->get('api/reportes/sales', 'RepportController::salesReporte');

$routes->get('api/report/best-selling-products/(:any)/(:any)', 'RepportController::getBestSellingProducts/$1/$2');
$routes->get('api/report/user-report', 'RepportController::getUserReport');
