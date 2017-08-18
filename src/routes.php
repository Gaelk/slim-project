<?php

use Slim\Http\Request;
use Slim\Http\Response;



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
})->setName("listHello");

$app->get("/list", function(Request $request, Response $reponse){
    $url=$this->get("router")->pathFor("listHello",["name"=>"Alfred","age"=>58]);
    $link="<a href=$url>Lien vers Alfred</a>";
    return $reponse->getBody()->write($link);
});

$app->get("/api/user/list", function(Request $request, Response $reponse){
    $users=[
        ['username'=>'papy', 'email'=>'jk@mail.com','id'=>'1'],
        ['username'=>'arlette', 'email'=>'arlette.bangu@gmail.com','id'=>'2'],
    ];
    return $reponse->withJson($users);
});

$app->get("/livres", function(Request $request, Response $reponse) {
    $sql = "SELECT * FROM livres ";

    /** @var \PDO */
    $pdo = $this->get("pdo");

    $data = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

    return $reponse->withJson($data);

});