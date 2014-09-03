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
$Obj->addCss('video-js.min.css');
$Obj->addCss('owl.carousel.css');
$Obj->addCss('owl.theme.css');

$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('bootstrap/bootstrap.min.js');
$Obj->addJs('script1.js');
$Obj->addJs('video.js');
$Obj->addJs('owl.carousel.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

$categories 	= $category->getAllCategories();
$brands 		= $brand->getAllBrands();
$pages 			= $page->getAllContentPages();
$featured_products = $product->getAllFeaturedProducts();
$indicator_count = count($featured_products);
$medias			= $product->getMediaProducts();
$generals		=$product->getGeneralProducts();
$url 			= $Obj->urlSet();

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    <div class="right_home">
    	<div class="sub-title">Featured Products</div>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <?php 
            for($i=0; $i<$indicator_count; $i++){
                echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."'></li>";
            }
            ?>
          </ol>
        
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <?php
                foreach($featured_products as $key => $f_prod){
                    if($key == 0){
            ?>
                <div class="item active">
                  <div style="text-align: center;">
                    <?php 
                        if($f_prod['featured_image'] == null){
                            echo "<img src='".$url['IMAGES']."tmp_product.jpg'>";
                        }else{
                            if (file_exists($url['UPLOADS'].$f_prod['featured_image'])) {
                                echo "<img src='".$url['UPLOADS'].$f_prod['featured_image']."'>";
                            } else {
                                echo "<img src='".$url['IMAGES']."tmp_product.jpg'>";
                            }  
                        }
                    ?>
                  </div>
                  <div class="carousel-caption">
                    <a>
                        <h3><?php echo $f_prod['product_name'] ?></h3>
                        <p><?php echo $f_prod['description'] ?></p>
                    </a>
                  </div>
                </div>
            <?php
                        
                    }else{
            ?>
                <div class="item">
                  <div style="text-align: center;">
                    <?php 
                        if($f_prod['featured_image'] == null){
                            echo "<img src='".$url['IMAGES']."tmp_product.jpg'>";
                        }else{
                            if (file_exists($url['UPLOADS'].$f_prod['featured_image']."")) {
                                echo "<img src='".$url['UPLOADS'].$f_prod['featured_image']."'>";
                            } else {
                                echo "<img src='".$url['IMAGES']."tmp_product.jpg'>";
                            } 
                        }
                    ?>
                  </div>
                  <div class="carousel-caption">
                    <a>
                        <h3><?php echo $f_prod['product_name'] ?></h3>
                        <p><?php echo $f_prod['description'] ?></p>
                    </a>
                  </div>
                </div>
            <?php
                    }
                }
            ?>
          
          </div>
        
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
          </a>
        </div>      
    </div>
    
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
        <div class="content">
            <div class="sub-title">General Products</div>
           <?php 
                //print_r($images);
           ?>
            <?php 
                
                // create a counter
                $counter = 0;
            ?>
            <div class="img_wrapper2" >
                <?php
                    
                    // loop through your images
                    foreach($generals as $general){                      
                        
                        // increment the counter so we know how many images there are so far
                        $counter++;
                    
                        // echo your images to the screen
                        ?>
                        
                        <div class="img_item2">
                        
                         <center>                                                 
                            <a href='user_product_detail.php?product=<?php echo $general['id'];?>'  ><img  src=<?php echo "public_html/uploads/".$general['featured_image'] ?> ></a>
                         </center> 
                         <?php echo "</br>  ".$general['product_name']."</br> Price: ".$general['price'] ?>   
                        </div> 
                        
                        <?php
                        
                        // check if 4 images have gone by
                        if($counter % 2 == 0){?>                            
                           <!--
                            </div>
                            <div class="img_wrapper2" >
                           -->
                            
                        <?php
                        }
                    }
                ?>
            </div>           
        </div>
    </div>
    <div class="right_home">
        <div class="content">
            <div class="sub-title">Media Products</div>
            <?php 
                foreach( $medias as $media ) {
            ?>
                <div class="media">
                    <div class="videoframe">
                        <video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="70%" data-setup='{"example_option":true}'>
                             <source src="<?php echo $url['UPLOADS'].$media['featured_image']; ?>" type='video/mp4' />
                             <source src="<?php echo $url['UPLOADS'].$media['featured_image']; ?>" type='video/webm' />
                             <source src="<?php echo $url['UPLOADS'].$media['featured_image']; ?>" type='video/ogg' />
                             <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                        </video>
                    </div>
                    <a href="user_product_detail.php?product=<?php echo $media['id']; ?>">
                        <p><?php echo $media['product_name']; ?></p>
                        <p>Price : <?php echo $media['price']; ?></p>
                    </a>
                </div>
            <?php
                }
            ?>
        </div>
    </div>    
   
</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>

<script>
  videojs.options.flash.swf = "<?php echo $url['CSS']; ?>video-js.swf"
</script>
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
 
});
</script>