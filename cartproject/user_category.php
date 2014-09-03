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
$Obj->addCss('bootstrap/bootstrap.css');
$Obj->addCss('owl.carousel.css');
$Obj->addCss('owl.theme.css');

$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('bootstrap/bootstrap.min.js');
$Obj->addJs('script1.js');
$Obj->addJs('owl.carousel.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();
$url = $Obj->urlSet();

$products;
if(isset($_GET['sub_cat'])){
	$products = $product->getProductsBySubCategoryId($_GET['sub_cat']);
}else{
	$products = $product->getProductsByCategoryId($_GET['cat_id']);
}
$sub_categories = $category->getAllSubCategories($_GET['cat_id']);

$owl_key = 0;
foreach ($categories as $key => $cat){
	if($cat['id'] == $_GET['cat_id']){
		$owl_key = $key;
	} 
}

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    <div class="right_home">
    	 <div class="content">
            <div class="sub-title">Categories</div>
	    	<div id="owl-demo" class="owl-carousel owl-theme">
 			<?php foreach ($categories as $category) { ?>
 				<a href="user_category.php?cat_id=<?php echo $category['id']; ?>">
			  	<div class="item" style="text-align: center; height: 200px;">
			  		<?php echo $category['category_name']; ?>
			  	</div>
			  	</a>
		  	<?php } ?>
			</div>
		</div>
    </div>

    <div class="right_home"> 
      <div class="content" style="border:1px solid #0047B2;">
		<?php 
		foreach ($sub_categories as $sub_cat) {
			if(isset($_GET['sub_cat'])){
				if($_GET['sub_cat'] == $sub_cat['id']){
					echo "<a href='user_category.php?cat_id=".$_GET['cat_id']."&sub_cat=".$sub_cat['id']."' class='tag-active'>".$sub_cat['name']."</a>";
				}else{
					echo "<a href='user_category.php?cat_id=".$_GET['cat_id']."&sub_cat=".$sub_cat['id']."' class='tag'>".$sub_cat['name']."</a>";
				}
			}else{
				echo "<a href='user_category.php?cat_id=".$_GET['cat_id']."&sub_cat=".$sub_cat['id']."' class='tag'>".$sub_cat['name']."</a>";
			}
		}
        ?>
      </div>
    </div>
    
    <div class="right_home">
    <?php 
    	echo '<div class="img_wrapper2">';
		foreach ($products as $product)
		{
			if($product['type'] == "Media"){
		?>
			<div class="media_item">
				<div class="videoframe">
					<video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="80%" data-setup='{"example_option":true}'>
						<source src="<?php echo $url["UPLOADS"].$product['featured_image']; ?>" type='video/mp4' />
				        <source src="<?php echo $url["UPLOADS"].$product['featured_image']; ?>" type='video/webm' />
				        <source src="<?php echo $url["UPLOADS"].$product['featured_image']; ?>" type='video/ogg' />
				        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
			        </video>
			    </div>
			    <a href="user_product_detail.php?product=<?php echo $product["id"]; ?>">
					<?php echo $product["product_name"]; ?></br>
					Price: <?php echo $product["price"]; ?></br>
					Product Type : <?php echo $product["type"]; ?>
				</a>
		    </div>
		<?php 
			}else {
		?>
			<a class="img_item2" href="user_product_detail.php?product=<?php echo $product["id"]; ?>">
				<?php
				if (file_exists($url["UPLOADS"].$product['featured_image'])) {
					echo "<img src='".$url["UPLOADS"].$product['featured_image']."'>";
				} else {
					echo "<img src='".$url['IMAGES']."tmp_product.jpg'>";
				}
				?>
				<?php echo $product["product_name"]; ?></br>
				Price: <?php echo $product["price"]; ?></br>
				Product Type : <?php echo $product["type"]; ?>
			</a>
		<?php	
			}
		}
		echo '</div>';
		?>
    </div>
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>
<script>
$(document).ready(function() {
	 
  $("#owl-demo").owlCarousel({
 
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });

 	$(".owl-carousel").owlCarousel()

	//get carousel instance data and store it in variable owl
	var owl = $(".owl-carousel").data('owlCarousel');
	owl.jumpTo(<?php echo $owl_key; ?>)  //
});
</script>
