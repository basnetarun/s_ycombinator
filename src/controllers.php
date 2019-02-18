<?php
namespace SilexHackerNews;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Controllers\ClientController;
use GuzzleHttp\Client as HttpClient;

$appClient = new ClientController(new HttpClient());
$app['client'] = $appClient;


//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    
    return $app['twig']->render('index.html.twig', array(
        'bodyclass' => 'news',
        'navactive' => ''
    ));
})
->bind('homepage')
;

$app->get('/topstories/{start}/{stop}', function ($start, $stop) use ($app) {

    if (! preg_match('/^\d+$/',$start) || ! preg_match('/^\d+$/', $stop)) {
        $app->abort(404, "One of given parameters is not a number");
    }
    if($stop>$start)  {
        $news = $app['client']->getTopStories($start,$stop);
        return $app->json($news);
    } else {
        $app->abort(404, "Variable start must be smaller than stop");
    }
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
