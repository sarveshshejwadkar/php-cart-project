<?php
/**
* Configuration file for database, mailer and URL linking
* @author Prajyot
*
* 
*/
include_once 'constants.php';

class Configuration{
    
    
    
    function __construct() {
       
    }

    /**
     * Function for email credentials
     * */
    public function getEmailCred(){
        return array(
            'Host' => email_host,
            'Username' => email,
            'Password' => email_password
        );
     } 
     
    /**
     * Function for database credentials
     * */
    public function getDatabaseConfiguration(){
        return array(
            'Host' => db_host,
            'Username' => db_username,
            'Password' => db_password,
            'Database' => db_name
        );
     }
     
     /**
     * Function for URLS
     * */
    public function getUrlSet(){
        return array(
            'UPLOADS' => upload_folder,
            'CSS' => css_folder,
            'JS' => javascript_folder,
        	'IMAGES' => image_folder
        );
     }

    /**
    *Function for defining custom configurations
    **/
    public function customConfig(){
        return array(
            'MIN_PASSWORD' => min_password_length,
            'MAX_PASSWORD' => max_password_length,
            'RANDOM_STRING_LIMIT' => random_string_length,
            'FROM_EMAIL' => from_email,
            'FROM_NAME' => from_name,
            'TO_EMAIL' => to_email,
            'TO_NAME' => to_name,
            'MAX_IMAGE_SIZE' => max_image_upload_size, //Bits
            'MAX_AUDIO_SIZE' => max_audio_upload_size, //Bits
            'MAX_VIDEO_SIZE' => max_video_upload_size, //Bits
            'NULL' => '0',
            'ONE' => '1',
        	'ADVANCE_SEARCH_ITEMS_PER_PAGE' => advance_search_items_per_page,
        );
    }
      
}