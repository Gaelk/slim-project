<?php

namespace app\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use RedBeanPHP\R as R;
class AuthorController
{
    public function index(Request $request, Response $response){
        $data=R::findAll("auteurs");
        $data=R::exportAll($data);
        return $response->withJson($data);
    }

    public function newAction(Request $request, Response $response){
        $data= $request->getParsedBody();
        $auteur=R::dispense("auteurs");//
        $auteur->import($data,"nom, prenom");//
        $id=R::store($auteur);        //$id=R::findOrCreate("auteurs", $data);

        return $response->withJson(["id"=>$id]); //return $response->withJson($auteur->export());
    }


    public function deleteAction(Request $request, Response $response, array $args){
        $id= $request->getParam("id")??null;

        try{
            $affectedRows= R::exec("DELETE FROM auteurs WHERE id=:id",$args);
            $success=$affectedRows==1;
        }catch (\Exception $e){$success=false;}

        return $response->withJson(["id"=>$success]); //return $response->withJson($auteur->export());
    }





}