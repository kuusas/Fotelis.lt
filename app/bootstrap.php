<?php
// web/index.php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

// services
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['armchair.post'] = $app->share(function() {
    $obj = new Armchair\PostService();
    $obj->load(array(
        __DIR__ . '/posts'
    ));

    return $obj;
});

$app['armchair.category'] = $app->share(function() use ($app) {
    $obj = new Armchair\CategoryService($app['request']);

    return $obj;
});

// actions
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array(
        'categorySlug' => 'none',
        'postSlug' => 'none',
        'pageSlug' => ' ',
    ));
});

// menu
$app->get('/menu/{pageSlug}', function($pageSlug) use ($app){
    $menu = array(
        array(
            'name' => 'Pradžia',
            'slug' => ' ',
        ),
        array(
            'name' => 'Apie',
            'slug' => 'apie',
        ),
        array(
            'name' => 'Kontaktai',
            'slug' => 'kontaktai',
        ),
    );
    return $app['twig']->render('menu.html', array(
        'menu' => $menu,
        'pageSlug' => $pageSlug,
    ));
});


$app->get('/list/{categorySlug}', function ($categorySlug) use ($app) {
    $postService = $app['armchair.post'];

    if ($categorySlug == 'none') {
        $posts = $postService->getAll();
    } else {
        $posts = $postService->getAllByCategory($categorySlug);
    }

    return $app['twig']->render('list.html', array(
        'posts' => $posts,
    ));
});

// sidebar
$app->get('/sidebar/{categorySlug}/{postSlug}', function($categorySlug, $postSlug) use ($app){
    $postService = $app['armchair.post'];
    $categoryService = $app['armchair.category'];

    if ($categorySlug == 'none') {
        $posts = $postService->getAll();
    } else {
        $posts = $postService->getAllByCategory($categorySlug);
    }
    $categories = $categoryService->getAll();

    return $app['twig']->render('sidebar.html', array(
        'posts'=> $posts,
        'categories' => $categories,
        'categorySlug' => $categorySlug,
        'postSlug' => $postSlug,
        'pageSlug' => 'none',
    ));
});

// static pages
$app->get('/apie', function() use ($app){
    return $app['twig']->render('static/apie.html', array(
        'categorySlug' => 'none',
        'postSlug' => 'none',
        'pageSlug' => 'apie',
    ));
});

$app->get('/kontaktai', function() use ($app){
    return $app['twig']->render('static/kontaktai.html', array(
        'categorySlug' => 'none',
        'postSlug' => 'none',
        'pageSlug' => 'kontaktai',
    ));
});

// blog entry
$app->get('/{categorySlug}/{postSlug}', function ($categorySlug, $postSlug) use ($app) {
    $service = $app['armchair.post'];

    $post = $service->get($postSlug);

    if (!$post) {
        throw new Exception('Post does not exist');
    }

    return $app['twig']->render('post.html', array(
        'post' => $post,
        'categorySlug' => $categorySlug,
        'postSlug' => $postSlug,
        'pageSlug' => 'none',
    ));
});

// blog category
$app->get('/{categorySlug}', function ($categorySlug) use ($app) {
    $service = $app['armchair.post'];

    return $app['twig']->render('index.html', array(
        'categorySlug' => $categorySlug,
        'postSlug' => 'none',
        'pageSlug' => 'none',
    ));
});



$app->run();

