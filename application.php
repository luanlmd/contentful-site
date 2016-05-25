<?php
include('../bootstrap.php');

$app->before(function() use ($app) {
    $app['twig']->addGlobal('title', 'Contentful Site');
});

/* Home */
$app->get('/', function (Silex\Application $app) {
    $query = new \Contentful\Delivery\Query;
    $query->where('content_type', '2wKn6yEnZewu2SCCkus4as');
    $entries = $app['client']->getEntries($query);
    return $app['twig']->render('index.twig', array('entries'=>$entries));
})->bind('index');


$app->get('/post/{slug}/', function (Silex\Application $app, $slug) {
    $query = new \Contentful\Delivery\Query;
    $query->where('content_type', '2wKn6yEnZewu2SCCkus4as');
    $query->where('fields.slug', $slug);
    $entries = $app['client']->getEntries($query);
    return $app['twig']->render('post.twig', array('entries'=>$entries));
})->bind('post');

$app->error(function (\Exception $e) use ($app) {
    if ($e instanceof NotFoundHttpException) {
        if (isset($app['twig']->getGlobals()['menu'])) {
            return $app['twig']->render('error/error.twig', array('exception'=>$e));
        }
    }
    return $app['twig']->render('error/panic.twig', array('exception'=>$e));
});

return $app;
