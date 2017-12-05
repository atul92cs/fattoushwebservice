<?php
class DbOperation
{
  private $con ;
  function __construct()
  {
    require_once dirname(__FILE__).'/dbconnect.php';
	$db=new DbConnect();
	$this->con=$db->connect();
  }
  function getCategory()
  {
      $stmt=$this->con->prepare("SELECT DISTINCT product_category FROM products");
	  $stmt->execute();
	  $stmt->bind_result($category);
	  $categories=array();
	  while($stmt->fetch())
	  {
	     $temp=array();
		 $temp['name']=$category;
		 array_push($categories,$temp);
	  }
	  return $categories;
  }
  function getProducts($category)
  {
	  $stmt=$this->con->prepare("SELECT product_name,product_cost,product_diet FROM products WHERE product_category=?");
		$stmt->bind_param("s",$category);
		$stmt->execute();
		$stmt->bind_result($name,$cost,$diet);
		$product=array();
		while($stmt->fetch())
		{
			$temp=array();
			
			$temp['name']=$name;
			$temp['cost']=$cost;
			$temp['diet']=$diet;
			
			array_push($product,$temp);
		}
		return $product;
  }
  }
  ?>