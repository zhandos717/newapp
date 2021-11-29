<?php
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

require_once  '../vendor/autoload.php';
if (!session_id()) @session_start();
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
  Engine::class => function(){
    return new Engine('../app/views/');
  },
  PDO::class => function(){
    $driver =  'mysql';
    $host = '127.0.0.1';
    $database_name = 'marlindev';
    $username = 'root';
    $password =  '';
    return new PDO("$driver:host=$host;dbname=$database_name",$username,$password);
  },
  Auth::class=> function($container){
    return new Auth($container->get('PDO'));
  },
  QueryFactory::class => function(){
    return new QueryFactory('mysql');
  },
]);

$container = $containerBuilder->build();
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
  $r->addRoute('GET', '/', ['App\controllers\MainController', 'index']);

  $r->addRoute('GET', '/posts/[{id:\d+}]', ['App\controllers\MainController', 'posts']);
  $r->addRoute('GET', '/users', ['App\controllers\MainController', 'users']);

  

  $r->addRoute('GET', '/login', ['App\controllers\MainController', 'login']);
  $r->addRoute('GET', '/register', ['App\controllers\MainController', 'registration']);
  $r->addRoute('GET', '/about', ['App\controllers\MainController', 'about']);
  $r->addRoute('GET', '/error', ['App\controllers\MainController', 'error']);

  $r->addRoute('POST', '/login', ['App\controllers\AuthorizationController', 'login']);
  $r->addRoute('POST', '/register', ['App\controllers\AuthorizationController', 'registration']);
  $r->addRoute('GET', '/verification', ['App\controllers\AuthorizationController', 'emailVerification']);
  $r->addRoute('GET', '/logout', ['App\controllers\AuthorizationController', 'logout']);

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    echo 'Нет такой страницы';
    exit;
    \header('Location: /error');
    // ... 404 Not Found
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    echo 'Метод запрещен';
    exit;
    \header('Location: /error');
    // ... 405 Method Not Allowed
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = $routeInfo[2];
    $container->call($handler, [$vars]);
    break;
}