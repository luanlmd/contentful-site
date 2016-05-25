<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    \Exception;


/* Silex */
$app = new Silex\Application();
$app['debug'] = !(getenv('APPLICATION_ENV') == 'production');

/* Twig */
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/views'));

/* Assets */
$app['twig']->addFunction(new \Twig_SimpleFunction('asset',
    function ($asset) {
    $asset =  ltrim($asset,'/');
        $assetPath = __DIR__ . '/public/' . $asset;
        if (file_exists($assetPath)) { $asset .= '?' . filemtime($assetPath); }
        return "/{$asset}";
    }
));

$app['client'] = $app->share(function() use ($app) {
    return new \Contentful\Delivery\Client('51f31da506095359cb5235c40dfcc7f55d16611b48f3370ab9cb59c9cfa8841b', 'wxzmum9gc2wo');
});
