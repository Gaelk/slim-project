<?php
use Psr\Container\ContainerInterface;
use Slim\App;

//injection de dependances
$container = $app->getContainer();
$container["appConfig"] = ["appName" => "Slim API", "maintenance" => true];
$container["database"] = [
    "user" => "root",
    "password" => "",
    "dsn" => "mysql:host=localhost;dbname=bibliotheque;charset=utf8"
];

$container["pdo"] = function (ContainerInterface $container) {

    return new\PDO ($container->get("database")["dsn"],
        $container->get("database")["user"],
        $container->get("database")["password"]
    );
};
