<?php
include "classes/product_pub.php";

$product = new ProductPub();
$config = $product->getConfig();
$url = $product->urlSet();

$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
if(!is_numeric($page_number)){die('Invalid page number!');}

$position = ($page_number * $config['ADVANCE_SEARCH_ITEMS_PER_PAGE']);

$limit = "LIMIT ".$position.", ".$config['ADVANCE_SEARCH_ITEMS_PER_PAGE'].""; 
$select = "id, brand_id, product_name, type, price, featured_image";

$products = $product->advanceProductSearch($_GET, $select, $limit);

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