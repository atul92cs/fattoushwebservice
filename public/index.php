<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once '../includes/dboperations.php';
$app= new \Slim\App(['settings'=>['displayErrorDetails'=>true]]);

$app->get('/categories',function(Request $req,Response $res){
	 $db=new dbOperation();
	 $products=$db->getCategory();
	 $res->getBody()->write(json_encode(array("Categories"=>$products)));
	 
 });
$app->get('/products/{category}',function(Request $req,Response $res){
	 $category=$req->getAttribute('category');
	 $db=new dboperation();
	 $products=$db->getProducts($category);
	 $res->getBody()->write(json_encode(array("Products"=>$products)));
});
$app->run();