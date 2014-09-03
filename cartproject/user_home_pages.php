<?php
include "classes/users.php";
include "classes/category_pub.php";
include "classes/brand_pub.php";
include "classes/content_page_pub.php";

$Obj = new Users();

if(!isset($_GET['page'])){
    header("Location: user_home.php");
}

$category = new CategoryPub();
$brand = new BrandPub();
$page = new ContentPagePub();

$content = $page->getContentPageById($_GET['page']);
if($content == null){
    header("Location: user_home.php");
}

$Obj->addCss('style1.css');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('script1.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    <div class="right_home back-gray">
        <div class="content">
            <?php 
                echo "<h3>".$content[0]['title']."</h3>";
                echo $content[0]['content'];
            ?>
        </div>
    </div>
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>