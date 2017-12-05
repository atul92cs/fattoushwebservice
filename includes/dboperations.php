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
  }
  ?>