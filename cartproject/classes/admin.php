<?php
/**
* Admin class
* Sub class of ../resources/classes/main_controller (Controller)
* 
* purpose: admin login management
* 
* @uses main_controller
* @author Prajyot 
*
* 
*/

include 'resources/classes/main_controller.php';


class Admin extends MainController
{
    
    function __construct() {
        $this->_dbConnect();
    }
    
    /**
     * Function for admin signin
     * */
    public function signIn($data){

        foreach ($data as $each) {
            trim($each);
        }

        if($this->validateSignInUser($data) == true){
            $user = $this->dbAuth($data['email'], md5($data['password']), "admin");
            if($user == null){
                $this->flashData("signin_error", "<span class='error'>Invalid email / password! Please retry again.</span>");
                header("Location: admin.php");
            }else{
                $this->setAdmin($user['id']);
                header("Location: admin_home.php");
            }
        }else{
            $this->flashData("signin_error", "<span class='error'>Invalid email / password! Please retry again.</span>");
            header("Location: admin.php");
        }
    }
    
    /**
     * Function to validate user signup input
     * */
    private function validateSignInUser($data){
        
        foreach($data as $item){
            if($item == null){
                return false;
                break;
            }
        }
        
        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
            break;
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
    
    /**
     * Function to set  sessions
     * */
     public function setAdmin($user_id){
        $_SESSION['user'] = $user_id;
        $_SESSION['isAdmin'] = true;
     }
    
    /**
     * Function to logoff user
     * */
     public function logOffUser(){
        session_destroy();
     } 
    
}
?>
