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
			
			$temp['Name']=$name;
			$temp['cost']=$cost;
			$temp['diet']=$diet;
			
			array_push($product,$temp);
		}
		return $product;
  }
  function createOrder($summary,$cost,$date,$contact,$name,$address,$status)
  {
	  $stmt=$this->con->prepare("INSERT INTO orders (order_summary,order_cost,order_date,user_contact,user_name,order_address,order_status)VALUES (?,?,?,?,?,?,?);");
	  $stmt->bind_param("sssssss",$summary,$cost,$date,$contact,$name,$address,$status);
	   if($stmt->execute())
		     return true;
		    return false;
	  
   }
   function getorderDetails($contact)
   {
	   $stmt=$this->con->prepare("SELECT MAX(order_id) FROM orders WHERE user_contact =?");
	   $stmt->bind_param("s",$contact);
	   $stmt->execute();
	   $stmt->bind_result($id);
	   $stmt->fetch();
	   $order['no']=$id;
	   return $order;
	   
   }
   function getOrderStatus($id)
   {
	   $stmt=$this->con->prepare("SELECT order_status FROM orders WHERE order_id=?");
	   $stmt->bind_param("s",$id);
	   $stmt->execute();
	   $stmt->bind_result($status);
	   $order['status']=$status;
	   return $order;
   }
  }
  ?>