<?php
/**
* Brand class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose : read operations for public/user
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class BrandPub extends MainController
{
    function __construct() {
        $this->_dbConnect();
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
    
}

?>

