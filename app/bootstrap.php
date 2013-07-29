<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use emberlabs\gravatarlib\Gravatar;
$app = new Silex\Application();
if (strstr(SILEX_ENV, 'dev')) {
    $app['debug'] = true;
}

$config = require(__DIR__ . '/config/' . SILEX_ENV . '.php');

// services
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config['db.options'],
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));
$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
     'swiftmailer.options' => $config['swiftmailer.options']
));

// $app['swiftmailer.transport'] = new \Swift_Transport_MailTransport(new \Swift_Transport_SimpleMailInvoker(), $app['swiftmailer.transport.eventdispatcher']);

$app['twig']->addGlobal('gravatar', new Gravatar());
$app->before(function() use ($app) {
    $flash = $app['session']->get('flash');
    $app['session']->set('flash', null);

    if (!empty($flash)) {
        $app[ 'twig' ]->addGlobal('flash', $flash);
    }
});

$app['armchair.post'] = $app->share(function() {
    $obj = new Armchair\PostService();
    $obj->load(array(
        __DIR__ . '/posts'
    ));
    return $obj;
});

$app['armchair.notification'] = $app->share(function() use ($app, $config) {
    $obj = new Armchair\NotificationService($app['armchair.post'], 
        $app['mailer'], 
        $app['twig'],
        $config['armchair.notification.options']);
    return $obj;
});

$app['armchair.category'] = $app->share(function() use ($app) {
    $obj = new Armchair\CategoryService($app['request']);
    return $obj;
});

$app['armchair.comment.model'] = $app->share(function() use ($app) {
    $obj = new Armchair\CommentModel($app['db']);
    return $obj;
});

$app['armchair.comment'] = $app->share(function() use ($app) {
    $obj = new Armchair\CommentService($app['armchair.comment.model'], $app['armchair.notification']);
    return $obj;
});

$app['armchair.comment.form'] = $app->share(function() use ($app) {
    $obj = new Armchair\CommentForm(
        $app['form.factory'],
        $app['session'],
        $app['request'],
        $app['armchair.comment']
    );
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
            'name' => 'Autoriai',
            'slug' => 'autoriai',
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

$app->get('/autoriai', function() use ($app){
    return $app['twig']->render('static/autoriai.html', array(
        'author' => '',
        'categorySlug' => 'none',
        'postSlug' => 'none',
        'pageSlug' => 'autoriai',
    ));
});

$app->get('/autoriai/{author}', function($author) use ($app){
    return $app['twig']->render('static/autoriai.html', array(
        'author' => $author,
        'categorySlug' => 'none',
        'postSlug' => 'none',
        'pageSlug' => 'autoriai',
    ));
});

// rss feed
$app->get('/rss', function() use ($app){
    $postService = $app['armchair.post'];
    $posts = $postService->getAll();

    $date = new DateTime($postService->getLast()->getDate());

    return $app['twig']->render('rss.html', array(
        'posts' => $posts,
        'date' => $date->format(DateTime::RSS),
    ));
});

// comments list
$app->get('/comment/list/{categorySlug}/{postSlug}', function($categorySlug, $postSlug) use ($app){
    $data = $app['armchair.comment']->getAllByReference($postSlug);

    return $app['twig']->render('comment_list.html', array(
        'data' => $data,
    ));
});

// comments activation 
$app->get('/comment/activate/{hash}', function($hash) use ($app){
    $res = $app['armchair.comment']->activate($hash);

    if (!$res) {
        return new Response('Comment not found', 404);
    }

    return new Response(sprintf('Comment %s activated!', $res['id']), 201);
});

// comments trashing
$app->get('/comment/trash/{hash}', function($hash) use ($app){
    $res = $app['armchair.comment']->trash($hash);

    if (!$res) {
        return new Response('Comment not found', 404);
    }

    return new Response(sprintf('Comment %s trashed!', $res['id']), 201);
});

// blog entry
$app->match('/{categorySlug}/{postSlug}', function ($categorySlug, $postSlug) use ($app) {
    $service = $app['armchair.post'];

    $post = $service->get($postSlug);

    if (!$post) {
        throw new Exception('Post does not exist');
    }


    $formService = $app['armchair.comment.form'];
    $form = $formService->getForm($postSlug);
    if ($formService->isSuccess()) {
        return $app->redirect('/' . $post->getCategory() . '/' . $post->getSlug() . '#comment');
    }


    return $app['twig']->render('post.html', array(
        'post' => $post,
        'categorySlug' => $categorySlug,
        'postSlug' => $postSlug,
        'pageSlug' => 'none',
        'form' => $form->createView(),
    ));
});

// blog category
$app->get('/{categorySlug}', function ($categorySlug) use ($app) {
    $service = $app['armchair.post'];

    return $app['twig']->render('category.html', array(
        'categorySlug' => $categorySlug,
        'postSlug' => 'none',
        'pageSlug' => 'none',
    ));
});



$app->run();

