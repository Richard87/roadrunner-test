<?php
/**
 * Created by PhpStorm.
 * User: richard
 * Date: 22.06.18
 * Time: 11:59
 */
ini_set('display_errors', 'stderr');
require __DIR__ . '/vendor/autoload.php';

use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Dotenv\Dotenv;

(new Dotenv())->load(__DIR__.'/.env');

//
$relay = new Spiral\Goridge\StreamRelay(STDIN, STDOUT);
$worker = new Spiral\RoadRunner\Worker($relay);
$psr7 = new Spiral\RoadRunner\PSR7Client($worker);


$kernel = new \App\Kernel("dev", true);
$cacheDir = $kernel->getCacheDir();
while ($req = $psr7->acceptRequest()) {
    try {
        $httpFoundationFactory = new HttpFoundationFactory();
        $request = $httpFoundationFactory->createRequest($req);
        $response = $kernel->handle($request);

        $psr7factory = new DiactorosFactory();
        $psr7response = $psr7factory->createResponse($response);
        $psr7->respond($psr7response);

        $kernel->terminate($request, $response);
        $kernel->reboot($cacheDir);
    } catch (\Throwable $e) {
        $worker->error((string)$e);
    }
}