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
$app->get('/order/{contact}',function(Request $req,Response $res){
	$contact=$req->getAttribute('contact');
	$db=new dbOperation();
	$order_id=$db->getOrderDetails($contact);
	$res->getBody()->write(json_encode($order_id));
});
$app->post('/createOrder',function(Request $req,Response $res){
	if(isTheseParametersAvailable(array('summary','cost','date','contact','name','address')))
	{
		$requestedData=$req->getParsedBody();
		$summary=$requestedData['summary'];
		$cost=$requestedData['cost'];
		$date=$requestedData['date'];
		$contact=$requestedData['contact'];
		$name=$requestedData['name'];
		$address=$requestedData['address'];
		$status="placed";
		$db=new dboperation();
		$result=$db->createOrder($summary,$cost,$date,$contact,$name,$address,$status);
		$responeData=array();
		if($result==true)
		{
			$responeData['error']=false;
			$responeData['Message']='Order Placed sucessfully';
			$responeData['Orderno']=getorderDetails($contact);
		}
		else
		{
			$responeData['error']=true;
			$responeData['Message']='error occured';
		}
		  
		$response->getBody()->write(json_encode($responeData));
		}
});
  function isTheseParametersAvailable($requiredfields)
  {
	  $error=false;
	  $error_fields="";
	  $request_params=$_REQUEST;
	  foreach($requiredfields as $field)
	  {
		  if(!isset($request_params[$field])||strlen(trim($request_params[$field]))<=0)
		  {
			  $error=true;
			  $error_fields=$field.',';
			  
		  }
	  }
	  if($error)
	  {
		  $response=array();
		  $response["error"]=true;
		  $response["message"]='Required Field(s)'.substr($error_fields,0,-2).'is missing or empty';
		  echo json_encode($response);
		  return false;
	  }
	  return true;
  }
$app->run();
