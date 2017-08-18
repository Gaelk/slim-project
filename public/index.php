<?php
require  __DIR__."/../vendor/autoload.php";
use Slim\Http\Request;
use Slim\Http\Response;

//instanciation de l'application
$app= new Slim\App();
//definnition des routes
$app->get("/hello", function(Request $request, Response $reponse){
    /**
     * recuperation de param ici"name" ajouté dans URL si il n'existe pas
     * la variable $param sera "word"
     */
    $param= $request->getParam("name")??"world";
    return $reponse->getBody()->write("hello $param");
});
//Execution de l'application
$app->run();