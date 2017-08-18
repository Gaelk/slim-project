<?php
require  __DIR__."/../vendor/autoload.php";
use Slim\Http\Request;
use Slim\Http\Response;

//instanciation de l'application
$app= new Slim\App();
//definnition des routes
$app->get("/hello", function(Request $request, Response $reponse){
    /** route /hello : avc param dans URL ou pas
     * recuperation de param ici"name" ajouté dans URL si il n'existe pas
     * la variable $param sera "word"
     */
    $param= $request->getParam("name")??"world";
    return $reponse->getBody()->write("<h1>hello $param</h1>");
});

/**
 *route: /hello/{name} <= obligatoire
 * [/{age}] <= {}param facultatif à cause du /slash dans les []
 */
$app->get("/hello/{name}[/{age:\d{1,2}}]",function(Request $request, Response $reponse, array $args){
    $html= "<h1>hello ". $args["name"]. "</h1>";
    if(isset($args["age"])){
        $html .="vous avez {$args["age"]} ans";
    }
    return $reponse->getBody()->write($html);
})->setName("list_hello");

$app->get("/list", function(Request $request, Response $reponse){
    $url=$this->get("router")->pathFor("list_hello",["name"=>"Alfred","age"=>58]);
    $link="<a href=$url>Lien vers Alfred</a>";
    return $reponse->getBody()->write($link);
});



//Execution de l'application
$app->run();