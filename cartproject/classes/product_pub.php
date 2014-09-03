<?php
/**
* Product class for public and normal user
* Sub class of ../resources/classes/main_controller (Controller)
* purpose : read operations for public/user
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class ProductPub extends MainController
{
	private $_config;
	
    function __construct() {
        $this->_dbConnect();
        $this->_config = $this->getConfigurationConstants();
    }
    
    /**
     * Function to get product by id
     * @author Prajyot
     * */
    public function getProductById($id){
        return $this->dbSelectById("products", $id);
    }
    
    /**
     * Function to get all products
     * @author Prajyot
     * */
    public function getAllProducts(){
        return $this->dbSelect("products", "DESC");
    }
    
    /**
     * Function to get all media products
     * @author Prajyot
     * */
    public function getMediaProducts(){
        
        $w_data = array(
            'type' => '"Media"'
        );
        return $this->dbCustomSelectLimit("*", $w_data, "products", "DESC", "6");
    }
    
    /**
     * Function to get all products where products are featured
     * @author Prajyot
     * */
    public function getAllFeaturedProducts(){
        
        $w_data = array(
            'featured' => true
        );
        return $this->dbCustomSelect("*", $w_data,"products");
    }
    
    /**
     * Function to get all products by category id
     * @author Prajyot
     * */
    public function getProductsByCategoryId($cat_id){
    
    	$w_data = array(
    			'category_id' => $cat_id
    	);
    	
    	$select = array('id', 'category_id', 'sub_category_id', 'brand_id', 'product_name', 'type', 'price', 'featured_image');
    	
    	return $this->dbCustomSelect("*", $w_data,"products");
    }
    
    /**
     * Function to get all products by sub category id
     * @author Prajyot
     * */
    public function getProductsBySubCategoryId($sub_cat){
    
    	$w_data = array(
    			'sub_category_id' => $sub_cat
    	);
    	 
    	$select = array('id', 'category_id', 'sub_category_id', 'brand_id', 'product_name', 'type', 'price', 'featured_image');
    	 
    	return $this->dbCustomSelect("*", $w_data,"products");
    }
       
     /**
     * Function to select Recent General Products
     * */
    public function getGeneralProducts(){
                
        $w_data = array(
            'type' => '"General"'
        );
         return $product=$this->dbCustomSelectLimit('*', $w_data, "products", "DESC", 10);
    }  
    
    /**
     * Function to get all images of product via id
     * */
    public function getAllProductImages($id){
    	
        $w_data = array(
            'product_id' => $id
        );
        return $this->dbCustomSelect("*", $w_data, "product_images");
    }
    
    /**
     * @author Prajyot
     * Function to advance search products
     * parapmetes - $_GET array
     * $select - select row values from table
     */
    public function advanceProductSearch($data, $select, $limit){
    	
    	$search 		= $data['search'];
    	$category 		= $data['cat'];
    	$subcategory 	= $data['subcat'];
    	$brand 			= $data['brand'];
    	$price_from 	= $data['from'];
    	$price_to 		= $data['to'];
    	$sql = "";
    	
    	if( ($search == null) || ($category == null) ){
    		$this->flashData("cerror", "<span class='error'>Search is empty!</span>");
            header("Location: user_advance_search.php");
    	}
    	
    	if( ($subcategory == null) && ($brand == null) && ($price_from == null) && ($price_to == null)  ){
		
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND product_name LIKE '%".$search."%' ORDER BY id ASC ".$limit.""; 
		}elseif ( ($subcategory != null) && ($brand == null) && ($price_from == null) && ($price_to == null) ){
		
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND product_name LIKE '%".$search."%' ORDER BY id ASC ".$limit."";
		}elseif ( ($subcategory == null) && ($brand != null) && ($price_from == null) && ($price_to == null) ){
		
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND brand_id = ".$brand." AND product_name LIKE '%".$search."%' ORDER BY id ASC ".$limit."";
		}elseif ( ($subcategory != null) && ($brand != null) && ($price_from == null) && ($price_to == null) ){
		
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND brand_id = ".$brand." AND product_name LIKE '%".$search."%' ".$limit."";
		}
		//From and to prices
		elseif ( ($subcategory != null) && ($brand != null) && ($price_from == null) && ($price_to != null) ){
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND brand_id = ".$brand." AND product_name LIKE '%".$search."%' AND price <= '".$price_to."' ".$limit."";
		}elseif ( ($subcategory != null) && ($brand != null) && ($price_from != null) && ($price_to == null) ){
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND brand_id = ".$brand." AND product_name LIKE '%".$search."%' AND price >= '".$price_from."' ".$limit."";
		}elseif ( ($subcategory != null) && ($brand == null) && ($price_from == null) && ($price_to != null) ){
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND product_name LIKE '%".$search."%' AND price <= '".$price_to."' ".$limit."";
		}elseif ( ($subcategory != null) && ($brand == null) && ($price_from != null) && ($price_to == null) ){
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND product_name LIKE '%".$search."%' AND price >= '".$price_from."' ".$limit."";
		}
		//IF all fields are not null
		else{
			$sql = "SELECT ".$select."
					FROM products
					WHERE category_id = ".$category." AND sub_category_id = ".$subcategory." AND brand_id = ".$brand." AND price BETWEEN ".$price_from." AND ".$price_to." AND product_name LIKE '%".$search."%' ORDER BY id ASC ".$limit."";
		}
    	$this->flashData("cerror", "<span class='safe'>Search result </span>");
    	return $this->dbCustomSQL($sql);
    }
    
    /**
     * @author Prajyot
     * Function to select Subcategory BY Category id
     * */
    public function getSubCategoryByCategoryID($select_data, $where_data, $table_name){
    
    	$sub_category=$this->dbCustomSelect($select_data, $where_data, $table_name);
    	return $sub_category;
    }
    
    /**
     * @author Prajyot
     * Function to get config
     */
    public function getConfig(){
    	return $this->_config;
    }
}

?>