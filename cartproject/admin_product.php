<?php
include "classes/product.php";

$Obj = new Products();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if(isset($_GET['delete'])){
    $result=$Obj->deleteProduct($_GET['delete']);
}

if ($_POST)
{
    if (isset($_POST['add'])) {
        $Obj->addProduct($_POST,"products");  
    }
         
    if (isset($_POST['Update_Feature'])) {
        $Obj->updateProductFeature($_POST) ;
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
                        <td>Category : </td>                    
                        <td><select name="category" id="cat"  >
                             
                                 <?php
                                    $category=$Obj->getCategory("categories");
                                    foreach ($category as $row){//Array or records stored in $row
                                ?> 
                                    <option value="<?php echo $row['id'];?>"> 
                                            <?php echo $row['category_name'];?>
                                    </option> 
                                 <?php       
                                    }
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
                                                $catId=$category[0]['id'];
                                                $where_data=array(
                                                        'category_id' =>$catId
                                                        );
                                                                                   
                                            $sub_category=$Obj->getSubCategoryByCategoryID("*",$where_data,"sub_categories");
                                            
                                            foreach ($sub_category as $row){?> 
                                                <option <?php if($row['category_id']==$category[0]['id'])echo "selected";?> value=<?php echo $row['id'];?>><?php echo $row['name'];?></option> <?php
                                            }   
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
                                   
                                           ?> <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option> <?php
                                            /* Option values are added by looping through the array */ 
                                    }
                                    //option filtered by DB query  
                                   
                                ?>
                             </select>
                        </td>
                    </tr>
                    <tr>
                       <td>Product Name : </td>
                    <td><input type="text" name="productname" placeholder="Product Name" required /></td>
                    </tr>
                    <tr>
                        <td>Product type : </td>
                        <td>
                            <select name="type">
                                <option value="Media">Media</option>
                                <option value="General">General</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Description : </td>
                        <td><input type="text" name="description" placeholder="Description" required /></td>
                    </tr>
                    <tr>
                        <td>Quantity : </td>
                        <td><input type="text" name="quantity" placeholder="Quantity" required /></td>
                    </tr>
                    <tr>
                        <td>Price : </td>
                            <td><input type="text" name="price" placeholder="Price" required/>    
                        </td>
                    </tr>
                      
                    <tr>
                        <td> Feature:</td>
                        <td>
                            <input type="checkbox" name="addFeature" id="addFeature"/>
                        </td>
                    </tr>   
                    <tr>
                        <td></td>
                        <td><input class="button button-large" type="submit" value="Insert" name="add" />
                       </td>
                    </tr>
                </table>
                </form>
                <form name="admin_product_list" method="POST" action="" enctype="multipart/form-data">
                <table>
                    <?php $product=$Obj->selectProduct("products"); 
                         foreach ($product as $row){ //Array or records stored in $row
                    ?> <tr>
                            <td><?php echo $row['id'];?></td>
                            <td><?php echo $row['category_id'];?></td>
                            <td><?php echo $row['sub_category_id'];?></td>
                            <td><?php echo $row['brand_id'];?></td>
                            <td><a href='admin_product_image.php?product=<?php echo $row['id']; ?>'><?php echo $row['product_name'];?></a></td>
                            <td><?php echo $row['description'];?></td>
                            <td><?php echo $row['quantity'];?></td>
                            <td><?php echo $row['price'];?></td>
                            
                            
                            <td ><a href='admin_product_edit.php?id=<?php echo $row['id']; ?>'>Edit</a></td>
                            <td><a href='admin_product.php?delete=<?php echo $row['id']; ?>'  onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> 
                            
                            <td><input type="checkbox" name="feature" value=<?php echo $row['id']?>  <?php if($row['featured']==1)echo "checked";?>  /></td>
                        
                        </tr>
                    <?php
                    /* Option values are added by looping through the array */ 
                        }
                    ?>
                </table>   
               
            </form>
        </div>
    </div>
</div>

<?
include "resources/layout/footer.php";
?>