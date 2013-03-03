<?php
// web/index.php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
if (strstr(SILEX_ENV, 'dev')) {
    $app['debug'] = true;
}

// services
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => require(__DIR__ . '/config/' . SILEX_ENV . '.php'),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

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
$app['armchair.category'] = $app->share(function() use ($app) {
    $obj = new Armchair\CategoryService($app['request']);
    return $obj;
});

$app['armchair.model.comment'] = $app->share(function() use ($app) {
    $obj = new Armchair\CommentModel($app['db']);
    return $obj;
});

$app['armchair.comment'] = $app->share(function() use ($app) {
    $obj = new Armchair\CommentService($app['armchair.model.comment']);
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
$app->get('/comment/list/{postSlug}', function($postSlug) use ($app){
    $data = $app['armchair.comment']->getAllByReference($postSlug);

    return $app['twig']->render('comment_list.html', array(
        'data' => $data
    ));
});

// add comment
$app->match('/comment/add/{postSlug}', function($postSlug) use ($app){
    $request = $app['request'];

    $post = $app['armchair.post']->get($postSlug);
    if (!$post) {
        throw new Exception('Post does not exist');
    }

    $data = array(
        'reference' => $postSlug
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('reference', 'hidden')
        ->add('name', 'text', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 2)))
        ))
        ->add('email', 'text', array(
            'constraints' => new Assert\Email()
        ))
        ->add('comment', 'textarea', array(
            'constraints' => array(new Assert\NotBlank())
        ))
        ->getForm();

    if ('POST' == $request->getMethod()) {
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();

            if ($app['armchair.comment']->insert($data)) {
                $app['session']->set('flash', array(
                    'type' => 'success',
                    'title' => 'Ačiū!',
                    'message' => 'Jūsų komentaras paskelbtas.',
                ));
            } else {
                $app['session']->set('flash', array(
                    'type' => 'error',
                    'title' => 'Klaida!',
                    'message' => 'Atsiprašome, bet nepavyko išsaugoti Jūsų komentaro. Bandykite dar kartą.',
                ));
            }

            return $app->redirect('/' . $post->getCategory() . '/' . $post->getSlug());
        }
    }

    return $app['twig']->render('comment_add.html', array(
        'form' => $form->createView(),
        'postSlug' => $postSlug,
    ));
});


// blog entry
$app->match('/{categorySlug}/{postSlug}', function ($categorySlug, $postSlug) use ($app) {
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

