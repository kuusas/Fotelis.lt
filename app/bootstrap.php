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
    $obj->load(__DIR__ . '/posts');

    return $obj;
});

// actions
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html');
});

$app->get('/blog/{slug}', function ($slug) use ($app) {
    $service = $app['armchair.post'];

    $post = $service->get($slug);

    if (!$post) {
        throw new Exception('Post does not exist');
    }

    return $app['twig']->render('post.html', array(
        'post' => $post,
    ));
});

$app->get('/menu', function() use ($app){
    return $app['twig']->render('menu.html');
});

$app->get('/sidebar', function() use ($app){
    $service = $app['armchair.post'];

    $data = $service->getAll();

    return $app['twig']->render('sidebar.html', array(
        'posts'=> $data
    ));
});

// static pages
$app->get('/apie', function() use ($app){
    return $app['twig']->render('static/apie.html');
});

$app->get('/kontaktai', function() use ($app){
    return $app['twig']->render('static/kontaktai.html');
});


$app->run();

