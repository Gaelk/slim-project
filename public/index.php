<?php
require  __DIR__."/../vendor/autoload.php";
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

//instanciation de l'application
$app= new Slim\App();

//injection de dependances
$container=$app->getContainer();
$container["appConfig"]=["appName"=>"Slim API", "maintenance"=>true];
$container["database"]=[
    "host"=>"localhost",
    "dbName"=>"bibliotheque",
    "user"=>"root",
    "passeword"=>""
];


$container["pdo"]=function (ContainerInterface $container){
    $host=$container->get("database")["host"];
    $dbName=$container->get("database")["dbName"];
    $dsn="mysql:host={$host};dbname={$dbName};charset=utf8";

  return new\PDO ($dsn,
      $container->get("database")["user"],
      $container->get("database")["password"]);
};



/**
 * Middlewares: capture une methode  ici getBody() à chaque fois quelle sera evoquée,
 * le Middlewares
 * */
$dateMiddleWare=function (Request $request, Response $response, Callable $next) {
    $response->getBody()->write("Nous sommes le " . date("d/m/Y"));
    return $next($request, $response);
};



$goodbyeMiddleWare=function (Request $request, Response $response, Callable $next) {
    $response = $next($request, $response);
    $response->getBody()->write("god bye");
    return $response;
};



$maintenanceMiddleWare=function (Request $request, Response $response, Callable $next){
    $maintenance = $this->get("appConfig")["maintenance"]??false;
    if($maintenance){
        $message = "Le site est en maintenance, revenez plus tard";
        $response->getBody()->write($message);
    } else {
        $next($request, $response);
    }
    return $response;
};

$apiProtection= function(Request $request, Reponse $response, callable $next){
    $apiKey="123";
    $requestApi=$request->getParam("API_KEY")??null;
    if($apiKey==$requestApi){
        $newResponse=$next($request,$response);
    }else{
        $message="Acces Non Autorisé";
        $newResponse=$response->wthiStatus(403);
            $newResponse->getBody()->write($message);
    }
    return $newResponse;
};


require  __DIR__."/../src/routes.php";

//Execution de l'application
$app->run();

