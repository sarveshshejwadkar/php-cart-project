<?php
/**
* ContentPagePublic class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose : read operations for admin content pages for public
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class ContentPagePub extends MainController
{
    function __construct() {
        $this->_dbConnect();
    }
    
    /**
     * Function to get content page by id
     * */
    public function getContentPageById($id){
        return $this->dbSelectById("content_pages", $id);
    }
    
    /**
     * Function to get all content pages
     * */
    public function getAllContentPages(){
        return $this->dbSelect("content_pages", "DESC");
    }
    
}

?>

