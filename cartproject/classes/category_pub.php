<?php
/**
* Cateogry class for public and normal user
* Sub class of ../resources/classes/main_controller (Controller)
* purpose : read operations for public/user
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class CategoryPub extends MainController
{
    function __construct() {
        $this->_dbConnect();
    }
    
    /**
     * Function to get category by id
     * */
    public function getCategoryById($id){
        return $this->dbSelectById("categories", $id);
    }
    
    /**
     * Function to get sub category by id
     * */
    public function getSubCategoryById($id){
        return $this->dbSelectById("sub_categories", $id);
    }
    
    
    
    /**
     * Function to get all categories
     * */
    public function getAllCategories(){
        return $this->dbSelect("categories", "DESC");
    }
    
    /**
     * Function to get all sub categories based on category id
     * */
    public function getAllSubCategories($id){
        $w_data = array(
            'category_id' => $id
        );
        
        return $this->dbCustomSelect("*", $w_data,"sub_categories");
    }
       
}
?>