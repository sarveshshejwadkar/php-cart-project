<?php
/**
* Cateogry class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose: peform operations CRUD for admin
* 
* @author Prajyot
* @uses main_controller
*
* 
*/

include 'resources/classes/main_controller.php';
class Category extends MainController
{
    function __construct() {
        $this->_dbConnect();
        if($this->checkAdmin() != true){
            header("Location: index.php");
        }
    }
    
    /**
     * Function to add new category
     * */
    public function addCategory($data){

        foreach ($data as $each) {
            trim($each);
        }
        
        if($data['categoryname'] != ""){
            
            $t_data = array(
                'category_name' => $data['categoryname']
            );
            
            if($this->dbInsert($t_data, "categories")){
                header("Location: admin_product_category.php");
                $this->flashData("cerror", "<span class='safe'>Added</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_product_category.php");
            }
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_product_category.php");
        }
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
     * Function to edit category
     * */
    public function editCategory($data){

        foreach ($data as $each) {
            trim($each);
        }

        if($data['categoryname'] != ""){
            
            $t_data = array(
                'category_name' => $data['categoryname']
            );
            
            if($this->dbUpdate($t_data, $data['id'], "categories")){
                header("Location: admin_product_category.php");
                $this->flashData("cerror", "<span class='safe'>Updated</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_product_category.php");
            }
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_product_category.php");
        }
    }
    
    /**
     * Function to sub edit category
     * */
    public function editSubCategory($data){

        foreach ($data as $each) {
            trim($each);
        }

        if($data['subcategoryname'] != ""){
            
            $t_data = array(
                'name' => $data['subcategoryname']
            );
            
            if($this->dbUpdate($t_data, $data['id'], "sub_categories")){
                header("Location: admin_product_category_view.php?catid=".$data['catid']."");
                $this->flashData("cerror", "<span class='safe'>Updated</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_product_category_view.php?catid=".$data['catid']."");
            }
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_product_category_view.php?catid=".$data['catid']."");
        }
    }
    
    /**
     * Function to delete category by id
     * */
    public function deleteCategoryById($id){
        
        $this->dbDelete($id, "categories");
        $this->flashData("cerror", "<span class='safe'>Deleted</span>");
        header("Location: admin_product_category.php");
    }
    
    /**
     * Function to delete sub category by id
     * */
    public function deleteSubCategoryById($id){
        
        $this->dbDelete($id, "sub_categories");
        $this->flashData("cerror", "<span class='safe'>Deleted</span>");
    }
    
    /**
     * Function to get all sub categories based on id
     * */
    public function getAllSubCategories($id){
        $w_data = array(
            'category_id' => $id
        );
        
        return $this->dbCustomSelect("*", $w_data,"sub_categories");
    }
    
    /**
     * Function to add sub category
     * */
    public function addSubCategory($data){

        foreach ($data as $each) {
            trim($each);
        }
        
        if($data['subcategoryname'] != ""){
            
            $t_data = array(
                'category_id' => $data['category_id'],
                'name' => $data['subcategoryname']
            );
            
             if($this->dbInsert($t_data, "sub_categories")){
                header("Location: admin_product_category_view.php?catid=".$data['category_id']."");
                $this->flashData("cerror", "<span class='safe'>Added</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_product_category_view.php?catid=".$data['category_id']."");
            }
            
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_product_category_view.php?catid=".$data['category_id']."");
        }
    }
    
    
    /**
     * Function to check is user loggedin is admin 
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