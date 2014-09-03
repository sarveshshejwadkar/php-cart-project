<?php
/**
* Brand class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose : CRUD operations for Admin 
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class Brand extends MainController
{
    function __construct() {
        $this->_dbConnect();
        if($this->checkAdmin() != true){
            header("Location: index.php");
        }
    }
    
    /**
     * Function to add new Brand
     * */
    public function addBrand($data){

        foreach ($data as $each) {
            trim($each);
        }
        
        if($data['brandname'] != ""){
            
            $t_data = array(
                'name' => $data['brandname']
            );
            
            if($this->dbInsert($t_data, "brands")){
                header("Location: admin_brand.php");
                $this->flashData("cerror", "<span class='safe'>Added</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_brand.php");
            }
            
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_brand.php");
        }
    }
    
    /**
     * Function to get brand by id
     * */
    public function getBrandById($id){
        return $this->dbSelectById("brands", $id);
    }
    
    /**
     * Function to get all brands
     * */
    public function getAllBrands(){
        return $this->dbSelect("brands", "DESC");
    }
    
    /**
     * Function to edit category
     * */
    public function editBrand($data){

        foreach ($data as $each) {
            trim($each);
        }

        if($data['brandname'] != ""){
            
            $t_data = array(
                'name' => $data['brandname']
            );
            
            if($this->dbUpdate($t_data, $data['id'], "brands")){
                header("Location: admin_brand.php");
                $this->flashData("cerror", "<span class='safe'>Updated</span>"); 
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_brand.php");
            }
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_brand.php");
        }
    }
      
    /**
     * Function to delete brand by id
     * */
    public function deleteBrandById($id){
        
        $this->dbDelete($id, "brands");
        $this->flashData("cerror", "<span class='safe'>Deleted</span>");
        header("Location: admin_brand.php");
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