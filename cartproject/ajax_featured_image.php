<?php 

include "classes/product.php";
$Obj = new Products();

list($url,$pid) = explode(",", $_POST['arr']);
//echo "url= ".$_GET['url']." id= ".$_GET['id'];

//echo "featured= ".$chk;
   
      $tmp=array(
          'featured_image' =>$url
       ); 
$Obj->updateProductFeature($tmp,$pid); 