<?php
include "classes/product.php";
include "classes/category.php";

$Obj = new Products();
$Category = new Category();

$Obj->addCss('style1.css');
$Obj->addCss('video-js.min.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');
$Obj->addJs('video.js');

$url = $Obj->urlSet();

include "resources/layout/header.php";

if($_SESSION['isAdmin'] != true){
    header("Location: index.php");
}
else{
    if(isset($_GET['delete']))
    {
        
        $img_dir = $url['UPLOADS'];
        //$img_thmb = 'thumbnail_directory_name/';// if you had thumbnails
    
        $image_name = $_GET['image_url'];//assume that this is the image_name field from your database
        
    
        //unlink function return bool so you can use it as conditon
        if(unlink($img_dir.$image_name)){
        //assume that variable $image_id is queried from the database where your image record your about to delete is...
         $result=$Obj->deleteProductImage($_GET['delete'],$_GET['product']);
        }     
        //echo "deleted id =".$result;
        
        
        $img_featured=$Obj->selectProductByID("products",$_GET['product']);
        $images = $Obj->getAllProductImages($_GET['product']);    
    }
    
}

if(isset($_GET['product'])){
    
    $img_featured=$Obj->selectProductByID("products",$_GET['product']);
    $images = $Obj->getAllProductImages($_GET['product']);
    $sub_category = $Category->getSubCategoryById($img_featured[0]['sub_category_id']);
    $category = $Category->getCategoryById($img_featured[0]['category_id']);
}
else{
    header("Location: admin_home.php");
}

if(($_POST != null) && ($_FILES != null)){
    
    if($_POST['type'] == "audio"){
        $Obj->updateProductMedia($_POST, $_FILES, "audio", "products");
    }elseif($_POST['type'] == "video"){
        $Obj->updateProductMedia($_POST, $_FILES, "video", "products");
    }else{
        $Obj->addProductImages($_POST, $_FILES);
    }
}

?>

<div class="main">
    <?php 
        include 'admin_menu.php';
    ?>
    
    <div class="content">
        <p>
            <b><a href="admin_product_category.php">Category</a> > 
              <a href="admin_product_category_view.php?catid=<?php echo $category[0]['id']; ?>"><?php echo $category[0]['category_name']; ?></a>  > 
              <a href="admin_product_add.php?scat_id=<?php echo $sub_category[0]['id']; ?>"><?php echo $sub_category[0]['name']; ?></a> > 
              <?php echo $img_featured[0]['product_name']; ?>
           </b>
        </p>
    </div>
    
    <?php 
        if( (strtolower($sub_category[0]['name']) == "video") || (strtolower($sub_category[0]['name']) == "audio") ){
    ?>
        
        
        <div class="content">
            <h2><?php echo "Product Name : ". $img_featured[0]['product_name']; ?></h2>
            <h3>Product Media</h3>
            <div>
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $_GET['product']; ?>" />
                <?php echo $Obj->getFlashData("cerror");  ?>
                    <table>
                        <tr>
                            <td>Upload Media : </td>
                            <?php 
                                if(strtolower($sub_category[0]['name']) == "video"){
                                    echo "<td>
                                            <input type='hidden' name='type' value='video' required />
                                            <input type='file' name='media' required />
                                            <span>Files supported : MP4, WEBM, OGV</span>
                                          </td>";    
                                }else{
                                    echo "<td>
                                            <input type='hidden' name='type' value='audio' required />
                                            <input type='file' name='media' required />
                                            <span>Files supported : MP3, MPG, MPEG</span>
                                          </td>";   
                                }
                            ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="button" value="Upload" /></td>
                        </tr>
                    </table>   
                </form>
            </div>
            
            <div>
                <p>Type : <?php echo $img_featured[0]['type']; ?></p>
                <p>Description : <?php echo $img_featured[0]['description']; ?></p>
                <p>Quantity : <?php echo $img_featured[0]['quantity']; ?></p>
                <p>Price : <?php echo $img_featured[0]['price']; ?></p>
                <div class="videoframe" > 
                    <!--
                    <video id="media" controls="controls" width="420">
                        <source src="public_html/uploads/<?php echo $img_featured[0]['featured_image']; ?>">
                        Your browser does not support HTML5 video.
                    </video>
                    -->
                    <video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="100%" height="70%" data-setup='{"example_option":true}'>
                         <source src="<?php echo $url['UPLOADS'].$img_featured[0]['featured_image']; ?>" type='video/mp4' />
                         <source src="<?php echo $url['UPLOADS'].$img_featured[0]['featured_image']; ?>" type='video/webm' />
                         <source src="<?php echo $url['UPLOADS'].$img_featured[0]['featured_image']; ?>" type='video/ogg' />
                         <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                    </video>
                    <div>
                          
                    </div>
                </div> 
            </div>           
         </div>
     
    <?php        
        }else{
    ?>

        <!-- Hannah -->
        <div class="content">
            <h3>Product Images</h3>
            <div>
                <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $_GET['product']; ?>" />
                <?php echo $Obj->getFlashData("cerror");  ?>
                    <table>
                        <tr>
                            <td>Upload Images : </td>
                            <td><input type="file" name="images[]" multiple="true" required /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="button" value="Add" /></td>
                        </tr>
                    </table>   
                </form>
            </div>
            
            <div>

                <?php 
                    
                    // create a counter
                    $counter = 0;
                ?>
                <div class="img_wrapper" >
                    <?php
                        
                        // loop through your images
                        foreach($images as $item){                      
                            
                            // increment the counter so we know how many images there are so far
                            $counter++;
                        
                            // echo your images to the screen
                            ?>
                            
                            <div class="img_item">
                             <center> 
                             <input type="radio" name="featureImg"  value=<?php echo $item['url'].",".$_GET['product'];?>  <?php if($item['url']==$img_featured[0]['featured_image'])echo "checked";?>  />Featured
                                <img  src=<?php echo $url['UPLOADS'].$item['url'] ?> >;
                                <a href='admin_product_image.php?product=<?php echo $_GET['product'];?>&delete=<?php echo $item['id']; ?>&image_url=<?php echo $item['url']; ?>'  onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                             </center>    
                            </div> 
                            
                            <?php
                            
                            // check if 4 images have gone by
                            if($counter % 2 == 0){?>                            
                                </div>
                                <div class="img_wrapper" >
                                
                            <?php
                            }
                        }
                    ?>
                </div>           
            </div>
        </div>
    <?php
    }
    ?>
    
</div>

<?
include "resources/layout/footer.php";
?>

<script>
  videojs.options.flash.swf = "<?php echo $url['CSS']; ?>video-js.swf"
</script>
