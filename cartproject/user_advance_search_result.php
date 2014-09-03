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
$config = $Obj->getConfigurationConstants();
$url = $Obj->urlSet();

$Obj->addCss('style1.css');
$Obj->addCss('bootstrap/bootstrap.css');
$Obj->addCss('video-js.min.css');
$Obj->addCss('pagination.css');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('video.js');
$Obj->addJs('bootstrap/bootstrap.min.js');
$Obj->addJs('script1.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();

$search_products = $product->advanceProductSearch($_GET, "COUNT(id)", "");
if($search_products == null){
	$Obj->flashData("cerror", "<span class='error'>Search is empty!</span>");
	header("Location: user_advance_search.php");
}else{
	$product_count = $search_products[0]['COUNT(id)'];
	$pagination_pages = ceil($product_count / $config['ADVANCE_SEARCH_ITEMS_PER_PAGE']);
	$pagination = "";
	
	if($pagination_pages > $config['ONE'])
	{
		$pagination	= '';
		$pagination	.= '<div class="paginate">';
		for($i = 1; $i<$pagination_pages+1; $i++)
		{
			$pagination .= '<span class="paginate_box"><a href="#" class="paginate_click" id="'.$i.'-page">'.$i.'</a></span>';
		}
		$pagination .= '</div>';
	}
}

include "resources/layout/header.php";
?>

<div class="main" style="height: inherit;">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    <!-- Start of product list -->
    <div class="right_home">
    	<div class="content">
    		<?php echo $Obj->getFlashData("cerror"); ?>
    		<span class="safe">count : <?php echo $product_count; ?></span>
	        <div id="results">
	        </div>
	        <?php echo $pagination; ?>
    	</div>
    </div>
         
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>

<script>
  videojs.options.flash.swf = "public_html/css/video-js.swf";
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#results").load("ajax_user_advance_search.php?search=<?php echo $_GET['search']; ?>&cat=<?php echo $_GET['cat']; ?>&subcat=<?php echo $_GET['subcat']; ?>
			&brand=<?php echo $_GET['brand']; ?>&from=<?php echo $_GET['from']; ?>&to=<?php echo $_GET['to']; ?>", {
		'page':0}, function() {$("#1-page").addClass('active');});  //initial page number to load
	
	$(".paginate_click").click(function (e) {
		
		$("#results").prepend('<div class="loading-indication"><img src="<?php echo $url['IMAGES']; ?>ajax-loader.gif" /> Loading...</div>');
		
		var clicked_id = $(this).attr("id").split("-"); 
		var page_num = parseInt(clicked_id[0]); 
		
		$('.paginate_click').removeClass('active'); 
		$("#results").load("ajax_user_advance_search.php?search=<?php echo $_GET['search']; ?>&cat=<?php echo $_GET['cat']; ?>&subcat=<?php echo $_GET['subcat']; ?>&brand=<?php echo $_GET['brand']; ?>&from=<?php echo $_GET['from']; ?>&to=<?php echo $_GET['to']; ?>", {
			'page':(page_num-1)}, function(){

		});

		$(this).addClass('active'); 
		
		return false; //prevent going to herf link
	});	
});
</script>