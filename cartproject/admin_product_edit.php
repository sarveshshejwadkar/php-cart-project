<?php
include "classes/product.php";
$Obj = new Products();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');

include "resources/layout/header.php";
$pid=$_SESSION['pid']=$_GET['id'];
$product=$Obj->selectProductByID("products",$pid); 

if(isset($_GET['cat']))
{
    $catId=$_GET['cat'];
}

if ($_POST)
{
  if (isset($_POST['edit'])) {
               
     $Obj->updateProduct($_POST,$_SESSION['pid'],"products");
     header("location:admin_product.php");            
  }
}
?>

<div class="main">
     <?php 
        include 'admin_menu.php';
    ?>
    <div class="adminProduct">
        <div class="content">
            <h3>Product Table</h3>
            <form name="admin_product" method="POST" action="" enctype="multipart/form-data">
                
                <table>
                    <tr>
                            <td>Categoery : </td>                        
                            <td>
                                <select name="cat" id="cat">
                                  <?php        
                                   
                                        $category=$Obj->getCategory("categories");
                                        foreach ($category as $row){//Array or records stored in $row
                                               ?> <option <?php if($row['id']==$product[0]['category_id'])echo "selected";?> value=<?php echo $row['id'];?>  onchange="showSubCategory(this.value)"><?php echo $row['category_name'];?></option> <?php
                                                    
                                        }
                                        //option filtered by DB query    
                                    ?>
        
                                </select>
                            </td>
                    </tr>
                    <tr>
                            <td>Sub Categoery : </td>
                            
                            <td>            
                           
                              <div id="subCategory">
                                <select name="subcategory" id="subcat">
                                    <b>
                                      <?php     
                                          $catId=$product[0]['category_id'];
                                                         $where_data=array(
                                                        'category_id' =>$catId);
                                         
                                          $sub_category=$Obj->getSubCategoryByCategoryID("*",$where_data,"sub_categories");
                                          foreach ($sub_category as $row){//Array or records stored in $row
                                            ?> <option <?php if($row['id']==$product[0]['sub_category_id'])echo "selected";?> value=<?php echo $row['id'];?>><?php echo $row['name'];?></option> <?php
                                          }
                                    //option filtered by DB query    
                                    ?>
                                    </b>
                                </select>
                             </div>   
                           </td>
                    </tr>
                    <tr>
                            <td>Brand : </td>
                            
                            <td><select name="brand">
                                    <?php
                                        $brand=$Obj->getBrand("brands");
                                        foreach ($brand as $row){//Array or records stored in $row
                                       
                                               ?> <option <?php if($row['id']==$product[0]['brand_id'])echo "selected";?> value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option> <?php
                                                /* Option values are added by looping through the array */ 
                                        }
                                        //option filtered by DB query  
                                       
                                    ?>
                                 </select>
                            </td>
                        </tr>
                    <tr>
                            <td>Product Name : </td>
                            <td><input type="text" name="productName" placeholder="Product Name" value="<?php echo $product[0]['product_name']?>" required /></td>
                    </tr>
                    <tr>
                        <td>Product type : </td>
                        <td>
                            <select name="type">
                                <option <?php if("Media"==$product[0]['type'])echo "selected";?> value="Media">Media</option>
                                <option <?php if("General"==$product[0]['type'])echo "selected";?> value="General">General</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                            <td>Description : </td>
                            <td><input type="text" name="description" placeholder="Description"  value="<?php echo $product[0]['description']?>" required /></td>
                    </tr>
                    <tr>
                            <td>Quantity : </td>
                            <td><input type="text" name="quantity" placeholder="Quantity"  value="<?php echo $product[0]['quantity']?>" required /></td>
                    </tr>
                    <tr>
                            <td>Price : </td>
                                <td><input type="text" name="price" placeholder="Price" value="<?php echo $product[0]['price']?>" required/>    
                            </td>
                    </tr>
                    <tr>
                            <td> Feature:</td>
                            <td>
                            <?php
                                $featured=0;
                                if($product[0]['featured']==1){
                                    $featured=1;
                                }
                             ?>
                                <input type="checkbox" name="editFeature"  <?php if($featured==1) echo "checked";?>/>
                            </td>
                    </tr>                        
                    <tr>
                            <td></td>
                            <td><input class="button button-large" type="submit" value="Edit" name="edit" />
                           </td>
                   </tr>
                </table>   
            </form>
        </div>
    </div>
</div>

<?
include "resources/layout/footer.php";
?>