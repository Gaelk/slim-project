<?php
require  __DIR__."/../vendor/autoload.php";


//instanciation de l'application
$app= new Slim\App();

//injection de dependances
$container=$app->getContainer();
$container["appConfig"]=["appName"=>"Slim API"];
$container["database"]=[
    "host"=>"localhost",
    "dbName"=>"bibliotheque",
    "user"=>"root",
    "passeword"=>""
];


$container["pdo"]=function ($container){
    $host=$container->get("database")["host"];
    $dbName=$container->get("database")["dbName"];
  $dsn="mysql:host={$host};dbname={$dbName};charset=utf8";

  return new\PDO ($dsn,
      $container->get("database")["user"],
      $container->get("database")["password"]);
};
require  __DIR__."/../src/routes.php";

//Execution de l'application
$app->run();

