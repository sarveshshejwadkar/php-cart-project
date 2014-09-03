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

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
        
    <div class="right_home">
        <div class="content">
           <h3>Advance search</h3>
           <?php echo $Obj->getFlashData("cerror"); ?>
           <form action="user_advance_search_result.php" method="GET">
           
           		<div id="searchbox">
           			<input type="text" name="search" class="text-box" style="width:50%;" placeholder="Search Product" required />
           		</div>
           		
           		<div id="select_category">
	           		Category : 
	           		<select name="cat" id="cat" class="select" required>
	           			<?php 
	           				foreach ($categories as $category){
	           			?>
	           				<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
	           			<?php 
	           				}
	           			?>
	           		</select>
           		</div>
           		
           		<div id="sub-category">
           			Sub-Category : 
           		</div>
           		
           		<div id="select_brand">
	           		Brand : 
	           		<select name="brand" id="brand" class="select">
	           			<option value="">All</option>
	           			<?php 
	           				foreach ($brands as $brand){
	           			?>
	           				<option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
	           			<?php 
	           				}
	           			?>
	           		</select>
           		</div>
        		
           		<div id="price-range">
           			Price range : 
           			<input type="number" name="from" class="text-box" style="width:20%" placeholder="Price From"> 
           			- 	
           			<input type="number" name="to" class="text-box" style="width:20%" placeholder="Price From">
           		</div> 
           		
           		<div>
           			<input type="submit" class="button" value="Search">
           		</div>
           			
           
           </form>
        </div>
    </div>  
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>