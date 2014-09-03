<?php
include "classes/category.php";
include "classes/product.php";
include "classes/brand.php";

$Obj = new Category();
$Product = new Products();
$Brand = new Brand();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}

if(isset($_GET['scat_id'])){
    
    $sub_category = $Obj->getSubCategoryById($_GET['scat_id']);
    if($sub_category == null){
        header("Location: admin_product_category.php");
    }
    $category = $Obj->getCategoryById($sub_category[0]['category_id']);
    $products = $Product->getProductBySubCategoryID($_GET['scat_id']);
    $brands = $Brand->getAllBrands();
    
    if($_POST){
        if(count($_POST) == 8){
            $result = $Product->addProduct($_POST, "products");
            header("Location: admin_product_add.php?scat_id=".$sub_category[0]['id']."");
        }
    }
    
    if(isset($_GET['delete'])){
        $Product->deleteProduct($_GET['delete']);
        header("Location: admin_product_add.php?scat_id=".$sub_category[0]['id']."");
    }
}else{
    header("Location: admin_product_category.php");
}
?>


<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    <div class="content">
    
        <p><b><a href="admin_product_category.php">Category</a> > 
              <a href="admin_product_category_view.php?catid=<?php echo $category[0]['id']; ?>"><?php echo $category[0]['category_name']; ?></a>  > 
              <?php echo $sub_category[0]['name']; ?>
           </b>
        </p>
        
        <?php 
            if( (strtolower($sub_category[0]['name']) == "video") || (strtolower($sub_category[0]['name']) == "audio") ){
                }
        ?>
            
            <div>
                <form method="POST">
                    <span id="catname"><?php echo $Obj->getFlashData("cerror"); ?></span>
                    <table>
                        <tr>
                            <td>Product name : </td>
                            <td>
                                <input type="hidden" name="category" value="<?php echo $category[0]['id']; ?>"  required />
                                <input type="hidden" name="subcategory" value="<?php echo $sub_category[0]['id']; ?>"  required />
                                <input type="text" name="productname" placeholder="Product name" required />
                            </td>
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
                            <td>Brand : </td>
                            <td>
                                <select name="brand">
                                    <?php
                                        foreach($brands as $brand){
                                            echo "<option value='".$brand['id']."'>".$brand['name']."</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Description : </td>
                            <td>
                                <textarea name="description" placeholder="Description" required />
                                </textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Quantity : </td>
                            <td><input type="number" name="quantity" placeholder="Quantity" required /></td>
                        </tr>
                        <tr>
                            <td>Price : </td>
                            <td><input type="number" name="price" placeholder="Price" required /></td>
                        </tr>
                        <!--
                        <tr>
                            <td>File : </td>
                            <td><input type="file" name="file[]" required /></td>
                        </tr>
                        -->
                        <tr>
                            <td></td>
                            <td><input type="submit" value="Add Product"/></td>
                        </tr>
                    </table>   
                </form>
            </div>
                  
        <div>
            <table width="100%">
                <?php 
                foreach($products as $product){
                ?>
                <tr>
                    <td style="width: 80%;">
                        <a href="admin_product_image.php?product=<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></a>
                        <hr />
                    </td>
                    <td><a href="admin_product_subcategory_edit.php?scid=<?php echo $product['id']; ?>">Edit</a><hr /></td>
                    <td><a href="admin_product_add.php?scat_id=<?php echo $sub_category[0]['id']; ?>&delete=<?php echo $product['id']; ?>">Delete</a><hr /></td>
                </tr>
                
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
    
</div>
<?
include "resources/layout/footer.php";
?>