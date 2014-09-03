<?php
/**
* User class
* Sub class of ../resources/classes/main_controller (Controller)
* purpose : user managemant operations
* 
* @uses main_controller
* @author Prajyot
*
* 
*/

include 'resources/classes/main_controller.php';

class Users extends MainController
{
    function __construct() {
        $this->_dbConnect();
        $this->_config = $this->getConfigurationConstants();
    }
    
    /**
     * Function to add new user to the database
     * */
    public function addUser($data){
        
        foreach ($data as $each) {
            trim($each);
        }

        if($this->validateAddUser($data) == true){
            $t_data = array(
                'first_name' => $data['fname'],
                'last_name' => $data['lname'],
                'email' => $data['email'],
                'password' => md5($data['cpassword'])
            );
            $this->dbInsert($t_data , "users");
            $this->flashData("cerror", "<span class='safe'>SignUp success! Try logging in.</span>");
            header("Location: index.php");
        }else{
            $this->flashData("cerror", "<span class='error'>Invalid inputs / CAPTCHA to SignUp! Please retry again.</span>");
            header("Location: index.php");
        }
    }
    
    /**
     * Function to validate user signup input
     * */
    private function validateAddUser($data){
        
        foreach($data as $item){
            if($item == null){
                return false;
                break;
            }
        }
        
        if($data['password'] != $data['cpassword']){
            return false;
            break;
        }
        
        if((strlen($data['cpassword']) < $this->_config['MIN_PASSWORD']) || (strlen($data['cpassword']) > $this->_config['MAX_PASSWORD'] )){
            return false;
            break;
        }
        
        if (empty($_SESSION['captcha']) || trim(strtolower($data['captcha'])) != $_SESSION['captcha']) {
            return false;
            break;
        } else {
            return true;
        }
                
        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            return false;
            break;
        }
    }
    
    /**
     * Function for user sign in
     * */
     public function signIn($data){

        foreach ($data as $each) {
            trim($each);
        }

        if($this->validateSignInUser($data) == true){
            $user = $this->dbAuth($data['email'], md5($data['password']), "users");
            if($user == null){
                $this->flashData("signin_error", "<span class='error'>Invalid email / password! Please retry again.</span>");
                header("Location: index.php");
            }else{
                $this->setUser($user['id']);
                header("Location: user_home.php");
            }
        }else{
            $this->flashData("signin_error", "<span class='error'>Invalid email / password! Please retry again.</span>");
            header("Location: index.php");
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
     * Function to generate random password for user
     * Case: forgot password.
     * */
     public function forgotPassword($data){

        foreach ($data as $each) {
            trim($each);
        }

        $new_pass = $this->RandomString();
        
        $user_id = $this->getUserIdByEmail($data['email'], "users");

        if($user_id == null){
            $this->flashData("error", "<span class='error'>Email does not exist! Please try with different email.</span>");
            header("Location: forgot_password.php");
        }else{
            $t_data = array(
                'password' => md5($new_pass)
            );
            if($this->dbUpdate($t_data, $user_id['id'], "users") == true){
                
                $from = $this->_config['FROM_EMAIL'];
                $from_name = $this->_config['FROM_NAME'];
                $to = $data['email'];
                $subject = 'PHP CART - Password Change';
                $body = "Your password has been successfully changed. \nNew Password : ".$new_pass."";
                
                if($this->sendEmail($from, $from_name, $to, $subject, $body) == true){
                    $this->flashData("error", "<span class='error'>Error! Please contact administrator.</span>");
                    header("Location: forgot_password.php");
                }else{
                    $this->flashData("error", "<span class='safe'>Password successfully changed, Please check your email.</span>");
                    header("Location: forgot_password.php");
                }
                
            }else{
                $this->flashData("error", "<span class='error'>Error! Please contact administrator.</span>");
                header("Location: forgot_password.php");
            }
        }
        
        
     }
     
     /**
      * Function to generate ramdom password
      * */
    private function RandomString(){
        $string = "";
        $mixed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()";
        for($i=0; $i<$this->_config['RANDOM_STRING_LIMIT']; $i++){
            $string = $string . $mixed[rand(0, strlen($mixed))];
        }
        return $string;
    }
    
    /**
     * Function to set user sessions
     * */
     public function setUser($user_id){
        $user = array(
            'user_id' => $user_id,
            'logged_in' => true
        );
        
        $_SESSION['user'] = $user;
     }
     
     /**
     * Function to get user on ID
     * */
     public function getUser($table_name, $user_id, $data){
        return $this->dbCustomSelectById($table_name, $user_id, $data);
     }
     
     /**
      * Function to get all addresses of user
      * */
     public function getUserAddress($user_id){
        
        $where_data = array(
            'user_id' => $user_id
        );
        
        return $this->dbCustomSelect("*", $where_data, "addresses");
     }
     
     /**
     * Function to logoff user
     * */
     public function logOffUser(){
        session_destroy();
     }
     
     /**
     * Function to mail contact form
     * */
     public function contactForm($data){

        foreach ($data as $each) {
            trim($each);
        }
                
        $from = $this->_config['TO_EMAIL'];
        $from_name = "PHP_Cart";
        $to = $this->_config['TO_EMAIL'];
        $subject = 'Contact Form :'.$data['sub'];
        $body ="<html>
                    <body>
                        <table style='width:80%;'>
                            <tr>
                                <td style='width:12%;'><b>Subject</b></td>
                                <td style='width:10%;'><b>:</b></td>
                                <td style='width:68%;'>".$data['sub']."</td>
                            </tr>
                            <tr>
                                <td> <b>Name</b></td>
                                <td> <b>:</b></td>
                                <td> ".$data['user_name']."</td>
                            </tr>
                            <tr>
                                <td><b>E-mail</b></td>
                                <td><b>:</b></td>
                                <td>".$data['email']."</td><br><br>
                            </tr>
                            <tr>
                                <td><b>Message</b></td>                                
                            </tr>  
                            <tr>
                                <td colspan='3'><br>".$data['msg']."</td>
                            </tr>
                        </table>
                    </body>
                </html>";
                
        if($this->sendEmail($from, $from_name, $to, $subject, $body) == true){
            $this->flashData("error", "<span class='error'>Error! Please contact administrator.</span>");
            header("Location: user_contact.php");
        }else{
            $this->flashData("error", "<span class='safe'>Thankyou for contacting us.</span>");
            header("Location: user_contact.php");
        }        
        
    }    
}
?>