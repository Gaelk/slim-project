<?php
use RedBeanPHP\R as R;
require  __DIR__."/../vendor/autoload.php";

//instanciation de l'application
$app= new Slim\App();

require  __DIR__."/../src/config/dependencies.php";

R::setup(
    $container->get("database")["dsn"],
    $container->get("database")["user"],
    $container->get("database")["password"]
);
require  __DIR__."/../src/config/middlewares.php";
require  __DIR__."/../src/config/routes.php";

//Execution de l'application
$app->run();

