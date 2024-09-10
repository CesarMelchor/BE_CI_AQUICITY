<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// http://localhost:8080/dctmovil/api
$routes->group('v1', ['namespace' => 'App\Controllers\API'], function(
    $routes
){


    //Users

    $routes->get('users', 'User::getAll');
    $routes->post('users/create', 'User::create');
    $routes->post('users/login', 'User::login');
    $routes->get('users/detail/(:num)', 'User::detail/$1');
    $routes->delete('users/delete/(:num)', 'User::delete/$1');
    $routes->post('users/restore', 'User::restorePass');

    //Imagenes anunciante
    
    $routes->post('uploadFile', 'Ad::uploadFile');
    $routes->post('updateFile', 'Ad::updateFile');
    
    // Banners portada
    
    $routes->get('banner', 'BannerControl::getAleatorio');
    $routes->get('banners', 'BannerControl::getAll');
    $routes->post('banners/uploadFile', 'BannerControl::uploadFile');
    $routes->post('banners/delete', 'BannerControl::deleteFile');

    //Anuncios

    $routes->post('ad/create', 'Ad::create');
    $routes->put('ad/update/(:num)', 'Ad::update/$1');
    $routes->post('ad/updateData', 'Ad::updateDataGeneral');
    $routes->get('ad/detail/(:num)', 'Ad::detail/$1');
    $routes->get('ads', 'Ad::getAnuncios');
    $routes->get('ads/portada', 'Ad::getAnunciosPortada');
    $routes->get('ads/search', 'Ad::search');
    $routes->get('ad/(:num)', 'Ad::getAnuncio/$1');

    
    $routes->get('hora', 'Ad::hora');

    //Sucursales

    $routes->post('sucursal/create', 'Sucursal::create');

    //Mapas

    $routes->post('mapa/create', 'Mapa::create');
    $routes->get('mapa/detail/(:num)', 'Mapa::detail/$1');
    $routes->put('mapa/update/(:num)', 'Mapa::update/$1');

    // Códigos
    $routes->post('codigo/update', 'Codigo::updateCode');
    $routes->put('codigo/update/activate/(:num)', 'Codigo::activateCode/$1');
    $routes->put('codigo/update/desactivate/(:num)', 'Codigo::desactivateCode/$1');
    $routes->get('codigo/detail/(:num)', 'Codigo::detail/$1');

    // Galerias
    $routes->get('galeria', 'Galeria::getDataGaleria');

    //Imagenes
    $routes->get('imagenes', 'Imagen::getImagenes');
    $routes->post('imagenes/upload', 'Imagen::uploadFile');

    //free
    $routes->get('free/detail/(:num)', 'Ad::detailFree/$1');    
    $routes->post('free/update', 'Ad::updateFree');

    




    
});
