<?php
/**
* Main controller class
*
* @author: Prajyot
* @uses database.php
* 
* purpose: 
* initiates database connection and project functionallity
*
* 
*/

include_once 'resources/classes/database.php';
include_once 'resources/config/config.php';
include_once 'resources/library/PHPMailer.php';

//Defining flash message timer
if(!defined('FLASH_TIMER')){
    define('FLASH_TIMER', '2');
}

class MainController
{
    private $_config;
    private $_db;
    private $_user_cred;
    private $_SMTP;
    private $_css = array();
    private $_js = array();
    public $URL;
    
    function __construct() {
        
    }    
    
    /**
     * Function to connect to the database
     * */
    protected function _dbConnect(){
        $this->_config = new Configuration();
        $database_cred = $this->_config->getDatabaseConfiguration();
        $this->URL = $this->urlSet();
        $this->_db = new Database($database_cred['Database'], $database_cred['Username'], $database_cred['Password'], $database_cred['Host']);
        $con = $this->_db->connect();
        if(session_id() == '') {
            session_start();
        }
    }
    
    /**
     * Function to add CSS
     * */
     public function addCss($css){
        array_push($this->_css, $css);
     }
     
     /**
     * Function to get all CSS
     * */
     public function getCss(){
        return $this->_css;
     }
     
     /**
     * Function to add JS
     * */
     public function addJs($js){
        array_push($this->_js, $js);
     }
     
     /**
     * Function to get all JS
     * */
     public function getJs(){
        return $this->_js;
     }
     
     /**
     * Function to initialise all CSS
     * */
     public function initCss(){
        $css = $this->getCss();
        foreach($css as $ss){
            echo "<link rel='stylesheet' type='text/css' href='".$this->URL['CSS']."$ss'>";
        }
     }
     
     /**
     * Function to initialise all JS
     * */
     public function initJS(){
        $jss = $this->getJS();
        foreach($jss as $js){
            echo "<script src='".$this->URL['JS']."$js'></script>";
        }
     }
    
    
    /**
     * Function to select query database
     * */
    public function dbSelect($table_name, $order){
        
        return $this->_db->select($table_name, $order);
    }
    
    /**
     * Function to custom field select query database table
     * */
    public function customSelect($data, $table_name, $order){
        
        return $this->_db->cSelect($data, $table_name, $order);
    }
    
    
    /**
     * Function to select by Id to the database
     */
    public function dbSelectById($table_name, $id){
        
        return $this->_db->selectById($table_name, $id);
    }
    
    /**
     * Function to custom select by Id to the database
     */
    public function dbCustomSelectById($table_name, $id, $data){
        
        return $this->_db->cSelectById($table_name, $id, $data);
    }
    
    /**
     * Function to custom select
     * */
    public function dbCustomSelect($select_data, $where_data, $table_name){
        
        return $this->_db->customSelect($select_data, $where_data, $table_name);
    }
    
    /**
     * Funtion to custom select limits record
     * */
    public function dbCustomSelectLimit($select_data, $where_data, $table_name, $order, $limit){
        
        return $this->_db->customSelectLimit($select_data, $where_data, $table_name, $order, $limit);
    }
    
    /**
     * Function to insert user into the database
     */
    public function dbInsert($data , $table){
        
        return $this->_db->insert($data, $table);
    }
    
    /**
     * Function to update
     * */
    public function dbUpdate($data, $id, $table_name){
        
        return $this->_db->update($data, $id, $table_name);
    }
    
    /**
     * Function to delete 
     * */
    public function dbDelete($id, $table_name){
        
        $this->_db->delete($id, $table_name);
    }
    
    /**
     * Function to authenticate user 
     * 
     */
    public function dbAuth($email, $password, $table){
        
        return $this->_db->auth($email, $password, $table);
    }
    
    
    /**
     * Function to get userID by Email
     * */
     public function getUserIdByEmail($email, $table){
        
        return $this->_db->getUserIdByEmail($email, $table);
     }
     
    /**
     * Function to set flash message
     * Uses php sessions and timer
     * Need to enable session before use
     * */
    public function flashData($name, $message){
        
        $_SESSION[$name] = $message;
        $_SESSION['timer'] = time();
    }
    
    /**
     * Function to get flash message
     * Uses php sessions and timer
     * Need to enable session before use
     * */
    public function getFlashData($name){
        
        if(isset($_SESSION[$name])){
            if(time() - $_SESSION['timer'] > constant('FLASH_TIMER')){
                unset($_SESSION[$name]);
            }
            return $_SESSION[$name];
        }
    }
    
    /**
     * Function to check if user is logged in
     * */
    public function isLoggedIn(){
        if(isset($_SESSION['user'])){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Function to search from table
     * */
    public function search($table, $where, $value){
        
        return $this->_db->search($table, $where, $value);
    }
    
    /**
     * Function for custome SQL queries
     */
    public function dbCustomSQL($sql){
    	
    	return $this->_db->customSQL($sql);
    }
    
    /**
     * Funciton for URL set
     * */
    public function urlSet(){
        
        return $this->_config->getUrlSet();
    }

    /**
    *Function to get custome config constants
    **/
    public function getConfigurationConstants(){

        return $this->_config->customConfig();
    }
    
    /**
     * Send SMTP Email
     * */
    public function sendEmail($from, $from_name, $to, $subject, $body){

        $user_cred = $this->_config->getEmailCred();
        
        $this->_SMPT = new PHPMailer();
        $this->_SMPT->isSMTP();                                      // Set mailer to use SMTP
        $this->_SMPT->Host = $user_cred['Host'];  // Specify main and backup SMTP servers
        $this->_SMPT->SMTPAuth = true;                               // Enable SMTP authentication
        $this->_SMPT->Username = $user_cred['Username'];                 // SMTP username
        $this->_SMPT->Password = $user_cred['Password'];      // SMTP password - Please Use Password
        $this->_SMPT->SMTPSecure = 'ssl';     // Enable encryption, 'ssl' also accepted
        
        $this->_SMPT->From = $from;
        $this->_SMPT->FromName = $from_name;
        //$this->_SMPT->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $this->_SMPT->addAddress($to);               // Name is optional
        //$this->_SMPT->addReplyTo($from, 'Information');
        //$this->_SMPT->addCC('cc@example.com');
        //$this->_SMPT->addBCC('bcc@example.com');
        
        $this->_SMPT->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$this->_SMPT->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$this->_SMPT->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $this->_SMPT->isHTML(true);                                  // Set email format to HTML
        
        $this->_SMPT->Subject = $subject;
        $this->_SMPT->Body    = $body;
        //$this->_SMPT->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if(!$this->_SMPT->send()) {
            return true;
        } else {
            return false;
        }
        
    } 
    
}
?>