<?php
include "classes/users.php";
include "classes/category_pub.php";
include "classes/brand_pub.php";
include "classes/product_pub.php";
include "classes/content_page_pub.php";

$Obj = new Users();
$product = new ProductPub();
$category = new CategoryPub();
$brand = new BrandPub();
$page = new ContentPagePub();

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();
$selected_product = $product->getProductById($_GET['product']);
$product_brand = $brand->getBrandById($selected_product[0]['brand_id']);
$cat_name=$category->getCategoryById($selected_product[0]['category_id']);
$sub_cat_name=$category->getSubCategoryById($selected_product[0]['sub_category_id']);

$images=$product->getAllProductImages($_GET['product']);

$Obj->addCss('style1.css');
$Obj->addCss('sharrre.css');
$Obj->addJs('sharrre.js');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
   <div class="right_home">
   
       <div >   
                <a href="index.php">Home</a> >> 
                <a href='user_category.php?cat=<?php echo $selected_product[0]['category_id']; ?>'> <?php echo $cat_name[0]['category_name']; ?></a> >>  
                <a href='user_sub_category.php?cat=<?php echo $selected_product[0]['category_id']; ?>&subcat=<?php echo $selected_product[0]['category_id']; ?>'> <?php echo $sub_cat_name[0]['name']; ?></a> >> 
                <a href=""> <?php echo $selected_product[0]['product_name']; ?> </a> 
       </div>
       
        <div class="content">

            <form name="user_selected_product" method="POST" action="" >     
                <div class="prod_detail">
                    <img  src=<?php echo "public_html/uploads/".$images[0]['url'] ?> />
                </div>
                <div class="prod_detail">    <div class="content">      
                    <table>
                    
                        <tr>
                            <td> <h3><?php echo $product_brand[0]['name'].":".$selected_product[0]['product_name']; ?></h3>
                            </td>  
                        </tr>                               
                    
                        <tr>
                            <td>Description : </td>
                            <td><?php echo $selected_product[0]['description']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>Instock : </td>
                            <td><?php echo $selected_product[0]['quantity']; ?></td>
                        </tr>
                        
                        <tr>
                            <td>Price : </td>
                                <td><?php echo $selected_product[0]['price']; ?>    
                            </td>
                        </tr>  
                         
                        <tr>
                            <td></td>
                            <td><input class="button button-large" type="submit" value="Add To Cart" name="add" />
                           </td>
                        </tr>
                         
                    </table>
                     <div class="addthis_native_toolbox"></div>
                      </div>
                </div>  
                <!-- Go to www.addthis.com/dashboard to customize your tools -->               
            </form>      
        </div>
    </div>
</div>

<?
    include "resources/layout/user_base.php";
    include "resources/layout/footer.php";
?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e1e286057b57d7"></script>