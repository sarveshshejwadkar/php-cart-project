<?php 

include "classes/product.php";
$Obj = new Products();

$chk = $_POST['featured'];
$id = $_POST['pid'];

//echo "featured= ".$chk;
   
      $tmp=array(
          'featured' =>$chk
       );

$product=$Obj->selectProductByID("products",$id);

//if($product[0]['featured_image']==null && $chk==1){
      //dont update the featured_image feild
//}
//else{
    $Obj->updateProductFeature($tmp,$id); 
//}

