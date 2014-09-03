<?php
/**
* Brand class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose : CRUD operations for Products and product images 
* 
* @uses main_controller
* @author Hannah, Prajyot 
*
* 
*/

include 'resources/classes/main_controller.php';

class Products extends MainController
{
    private $_iMagic;
    private $_config;
    
    function __construct() {
        $this->_dbConnect();
        if($this->checkAdmin() != true){
            header("Location: index.php");
        }
        $this->_iMagic = new Imagick();
        $this->_config = $this->getConfigurationConstants();
    }
    
    /**
     * Function to upload product images
     * @author Prajyot
     * */
    public function addProductImages($post, $files){
        
        
        if($files["images"]["name"] != null){
        
                $count = count($files["images"]["name"]);
            
                for($i=0; $i<$count; $i++){
                    
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $files["images"]["name"][$i]);
                    $extension = end($temp);
                    
                    
                    if ((($files["images"]["type"][$i] == "image/gif")
                        || ($files["images"]["type"][$i] == "image/jpeg")
                        || ($files["images"]["type"][$i] == "image/jpg")
                        || ($files["images"]["type"][$i] == "image/pjpeg")
                        || ($files["images"]["type"][$i] == "image/x-png")
                        || ($files["images"]["type"][$i] == "image/png"))
                        && ($files["images"]["size"][$i] < $this->_config['MAX_IMAGE_SIZE'] )
                        && in_array($extension, $allowedExts)) {
                          if ($files["images"]["error"][$i] > $this->_config['NULL']) {
                                $this->flashData("cerror", "<span class='error'>Incorrect files, please try again.</span>");
                                header("Location: admin_product_image.php?product=".$post['product_id']."");
                          } else {
                            
                            if (file_exists("public_html/uploads/" . $files["images"]["name"][$i])) {
                                $this->flashData("cerror", "<span class='error'>File already exists. Please retry by changing names.</span>");
                                header("Location: admin_product_image.php?product=".$post['product_id']."");
                            } else {
                                $files["images"]["name"][$i] = md5($files["images"]["name"][$i].time());
                                move_uploaded_file($files["images"]["tmp_name"][$i], "public_html/uploads/" . $files["images"]["name"][$i]);
                                
                                $this->_iMagic->readImage('public_html/uploads/'.$files["images"]["name"][$i].'');
                                $this->_iMagic->resizeImage(0,300,Imagick::FILTER_LANCZOS,1);
                                $this->_iMagic->writeImage('public_html/uploads/'.$files["images"]["name"][$i].'');
                                
                                $t_data = array(
                                    'product_id' => $post['product_id'],
                                    'url' => $files["images"]["name"][$i]
                                );
                                $this->dbInsert($t_data, "product_images");
                                                                
                                $this->flashData("cerror", "<span class='safe'>Successfully uploaded.</span>");
                                header("Location: admin_product_image.php?product=".$post['product_id']."");
                            }
                          }
                    } else {
                        $this->flashData("cerror", "<span class='error'>Incorrect files, please try again.</span>");
                        header("Location: admin_product_image.php?product=".$post['product_id']."");
                    }
                } 
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect files, please try again.</span>");
            header("Location: admin_product_image.php?product=".$post['product_id']."");
        }
    }
    
    /**
     * Function to get all images of product via id
     * @author Prajyot
     * */
    public function getAllProductImages($id){
        $w_data = array(
            'product_id' => $id
        );
        
        return $this->dbCustomSelect("*", $w_data, "product_images");
    }
    
    public function getImageById($id){
        $w_data = array(
            'id' => $id
        );
        
        return $this->dbCustomSelect("*", $w_data, "product_images");
    }
    
       /**
     * Function to delete images of product via image_id
     * */
    public function deleteProductImage($id,$pid){
        $product=$this->selectProductByID("products",$pid);
        $image=$this->getImageById($id);
        $featured_image=$product[0]['featured_image'];
        if($featured_image==$image[0]['url']){
            $data = array(
                'featured_image' => $this->_config['NULL']
            );
            $this->updateProductFeature($data,$pid);
        }       
         
        if($_SESSION['isAdmin'] != true){
            header("Location: index.php");
          
        }
        $result=$this->dbDelete($id,"product_images");
         header("Location: admin_product_image.php?product=".$pid);
    }
    
    
    /**
     * Function to add select Categories
     * */
    
    public function getCategory($t_data){

            $category=$this->dbSelect($t_data , "asc");
             return $category; 
    }
    
    /**
     * Function to select brand names
     * */
     public function getBrand($t_data){

            $brand=$this->dbSelect($t_data , "asc");
             return $brand; 
    }
    
    /**
     * Function to select SubcategoryBY CAtegory id
     * */
    public function getSubCategoryByCategoryID($select_data, $where_data, $table_name){

            $sub_category=$this->dbCustomSelect($select_data, $where_data, $table_name);
            return $sub_category; 
    }
    
     /**
     * Function to select Products
     * */
     public function selectProduct($t_data){
        
        $product=$this->dbSelect($t_data , "asc"); 
            return $product;  
    }
    
    /**
     * Function to select Products by ID
     * */
    public function selectProductByID($table,$id){
        
        $product=$this->dbSelectById($table,$id);
        return $product;  
    }
    
    
    /**
     * Function to add Products
     * @author Hannah
     * Edits Prajyot
     * */    
    public function addProduct($data,$table){
        
        if($this->validateAddProduct($data) == true){
            
            $is_checked = isset($data['addFeature']) && $data['addFeature'] == 'on';
                  
            if($is_checked== $this->_config['ONE']){
                $feature=$this->_config['ONE'];
            } else {
                $feature=$this->_config['NULL'];
            }
              
            $t_data = array(
                'category_id' => trim($data['category']),
                'sub_category_id' => trim($data['subcategory']),
                'brand_id' => trim($data['brand']),
                'product_name' => trim($data['productname']),
                'type' => trim($data['type']),
                'description' => trim($data['description']),
                'quantity' => trim($data['quantity']),
                'price' =>trim($data['price']),
                'featured' =>$feature                
            );
            
            if($this->dbInsert($t_data , $table) == true){
                $this->flashData("cerror", "<span class='safe'>Product Added!!. Please update image/media information.</span>");
                header("Location: admin_product.php");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_product.php");
            }
        }
        
    }
    
    
    function validateAddProduct($data){
        
        return true;
    }
    
    
    /**
     * Function to edit product in the database
     * */
    public function updateProduct($data,$id,$table){
        
        $is_checked = isset($data['editFeature']) &&
          $data['editFeature'] == 'on';
       
          if($is_checked==$this->_config['ONE'])
          {
            $feature=$this->_config['ONE'];
          }
          else{
            $feature=$this->_config['NULL'];
          }
          
        $t_data = array(
            'category_id' => trim($data['cat']),
            'sub_category_id' => trim($data['subcategory']),
            'brand_id' => trim($data['brand']),
            'product_name' => trim($data['productName']),
            'type' => trim($data['type']),
            'description' => trim($data['description']),
            'quantity' => trim($data['quantity']),
            'price' =>trim($data['price']),
            'featured' =>$feature
        );
       $result=$this->dbUpdate($t_data,$id,$table);
    }
    
   
    /**
     * Function to edit product to be featured or not in the database
     * */
    public function updateProductFeature($data,$id){ 
    
        $result=$this->dbUpdate($data,$id,"products");
    }
    
    
    /**
    * Function to delete product from the database
    * @author Hannah
    * Edits : Prajyot
    * */
    public function deleteProduct($id){
         $images = $this->getAllProductImages($id);
         foreach($images as $item){
                $img_dir = 'public_html/uploads/';
                //$img_thmb = 'thumbnail_directory_name/';// if you had thumbnails
        
                $image_name = $item['url'];//assume that this is the image_name field from your database
        
                //unlink function return bool so you can use it as conditon
                if(unlink($img_dir.$image_name)){
                     //assume that variable $image_id is queried from the database where your image record your about to delete is...
                    $result=$this->deleteProductImage($item['id']);
                }else{
                    echo 'ERROR: unable to delete image file!';
                }
                                 
          }
            
          $result=$this->dbDelete($id,"products");
          $this->flashData("cerror", "<span class='safe'>Product Deleted!!.</span>");          
          header("Location: admin_product.php");
    }
    
    /**
     * Function to upload media for the product
     * @author Prajyot
     * */
    public function updateProductMedia($data, $file, $type, $table){
        
        if( $this->_validateMedia($file, $type) == true ){
            
            $file_type = explode("/", $file['media']['type']);
            
            $file["media"]["name"] = md5($file["media"]["name"].time()).'.'.$file_type[1];
            move_uploaded_file($file["media"]["tmp_name"], "public_html/uploads/" . $file["media"]["name"]);
            
            $t_data = array(
                'featured_image' => $file["media"]["name"]
            );
            $product = $this->dbSelectById("products", $data['product_id']);
            
            if($product[0]['featured_image'] != ""){
                echo unlink('public_html/uploads/'.$product[0]['featured_image']);
            }
            $this->dbUpdate($t_data, $data['product_id'], "products");
                                            
            $this->flashData("cerror", "<span class='safe'>Successfully uploaded.</span>");
            header("Location: admin_product_image.php?product=".$data['product_id']."");
            
        }else{
            $this->flashData("cerror", "<span class='error'>Invalid media file!! Please try again with different file!!.</span>");
            header("Location: admin_product_image.php?product=".$data['product_id']."");
        }
    }
    
    /**
     * Function to validated video/audio file type
     * @author Prajyot
     * */
    private function _validateMedia($file, $type){
        
        if($type == "audio"){
            $allowedExts = array("mp3", "mpeg", "mpg");
            $temp = explode(".", $file["media"]["name"]);
            $extension = end($temp);
        
            
            if ((($file["media"]["type"] == "audio/mp3")
                || ($file["media"]["type"] == "audio/mpeg")
                || ($file["media"]["type"] == "audio/mpg"))
                && ($file["media"]["size"] < $this->_config['MAX_AUDIO_SIZE'] )
                && in_array($extension, $allowedExts)) {
                  if ($file["media"]["error"] > $this->_config['NULL']) {
                        return false;
                        break;
                  } else {
                    
                    return true;
                  }
            } else {
                return false;
                break;
            }  
        }elseif($type == "video"){
            $allowedExts = array("webm", "mp4", "ogv");
            $temp = explode(".", $file["media"]["name"]);
            $extension = end($temp);
        
            if ((($file["media"]["type"] == "video/mp4")
                || ($file["media"]["type"] == "video/webm")
                || ($file["media"]["type"] == "video/ogv"))
                && ($file["media"]["size"] < $this->_config['MAX_VIDEO_SIZE'] )
                && in_array($extension, $allowedExts)) {
                  if ($file["media"]["error"] > $this->_config['NULL']) {
                        return false;
                        break;
                  } else {
                    
                    return true;
                  }
            } else {
                return false;
                break;
            }  
        }
    }
    
    
    
    /**
     * Function to get all products based on sub category id
     * @author Prajyot
     * */
    public function getProductBySubCategoryID($scat_id){
        
        $w_data = array(
            'sub_category_id' => $scat_id
        );
        return $this->dbCustomSelect("*", $w_data, "products");
    }
    
    
    /**
     * Function to check is user loggedin is admin 
     * @author Prajyot
     * */
    private function checkAdmin(){
        if($_SESSION['isAdmin'] == true){
            return true;
        }else{
            return false;
        }
    }
  
    
}
?>