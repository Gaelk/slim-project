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
})->add($dateMiddleWare);

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
})->setName("listHello")->add($goodbyeMiddleWare);


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



$app->group("/api", function()use($app){

    $app->get("/livre", function(Request $request, Response $response){
        $sql = "SELECT * FROM livres";
        /** @var \PDO */
        $pdo=$this->get("pdo");
        $data = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $response->withJson($data);

    });


    $app->get("/livre/{id:\d+}", function(Request $request, Response $response) {
        $sql = "SELECT * FROM livres WHERE id=:id";

        /** @var \PDO */
        $pdo = $this->get("pdo");
        $statement = $pdo->prepare($sql);
        $data = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $response->withJson($data);

    });

    $app->group("/auteur", function () use($app){
        $app->get("/", \app\Controller\AuthorController::class.":index"); //namespace : \app\Controller directement sur la linge parce que pas de Use
    });
})->add($apiProtection);