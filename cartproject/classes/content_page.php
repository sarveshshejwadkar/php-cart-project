<?php
/**
* ContentPage class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose : CRUD operations for admin content pages
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';
class ContentPage extends MainController
{
    function __construct() {
        $this->_dbConnect();
        if($this->checkAdmin() != true){
            header("Location: index.php");
        }
    }
    
    /**
     * Function to add new content page
     * */
    public function addContentPage($data){

        foreach ($data as $each) {
            trim($each);
        }
        
        if(($data['title'] != "") && ($data['content'] != "")){
            
            $t_data = array(
                'title' => $data['title'],
                'content' => $data['content']
            );
            
            if($this->dbInsert($t_data, "content_pages")){
                header("Location: admin_content_pages.php");
                $this->flashData("cerror", "<span class='safe'>Added</span>");
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_content_pages_add.php");
            }
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_content_pages_add.php");
        }
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
    
    /**
     * Function to edit content page
     * */
    public function editContentPage($data){

        foreach ($data as $each) {
            trim($each);
        }

        if(($data['title'] != "") && ($data['content'] != "")){
            
            $t_data = array(
                'title' => $data['title'],
                'content' => $data['content']
            );
            
            if($this->dbUpdate($t_data, $data['id'], "content_pages")){
                header("Location: admin_content_pages_view.php?pid=".$data['id']."");
                $this->flashData("cerror", "<span class='safe'>Updated</span>"); 
            }else{
                $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
                header("Location: admin_content_pages_edit.php?pid=".$data['id']."");
            }
            
        }else{
            $this->flashData("cerror", "<span class='error'>Incorrect input, please try again.</span>");
            header("Location: admin_content_pages_edit.php?pid=".$data['id']."");
        }
    }
      
    /**
     * Function to delete content page by id
     * */
    public function deleteContentPageById($id){
        
        $this->dbDelete($id, "content_pages");
        $this->flashData("cerror", "<span class='safe'>Deleted</span>");
        header("Location: admin_content_pages.php");
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
