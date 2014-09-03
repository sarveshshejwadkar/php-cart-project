<?php
include "classes/users.php";
include "classes/category_pub.php";
include "classes/brand_pub.php";
include "classes/product_pub.php";
include "classes/content_page_pub.php";

$Obj = new Users();

$category = new CategoryPub();
$brand = new BrandPub();
$page = new ContentPagePub();
$product = new ProductPub();

$Obj->addCss('style1.css');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('script1.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

if(isset($_GET['search'])){
    $products = $product->search("products", "product_name", $_GET['search']);
    $search = true;
}

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    <div class="right_home">
        <?php
            if($search == true){
                if($products != null){
                    print_r($products);
                }else{
                    echo "No search results found!!";
                }
            }
        
        ?>
    </div>
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>
<script>
$(document).ready(function(){
    $("#user_options").hide();
    $("#user").click(function(){
        $("#user_options").toggle("slow");
    });
});
</script>