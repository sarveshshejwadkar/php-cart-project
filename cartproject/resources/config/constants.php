<?php

/**
 * Editable Constants by user
 * @author Prajyot
 */

//Database configurations 
define('db_name', 'php_cart_project'); 			//	Database name
define('db_host', '172.16.2.216'); 				//	Database host server 
define('db_username', 'root');					// 	Username
define('db_password', 'sjidb');					//	Password


//Email configuration
define('email_host', 'smtp.gmail.com:465'); 	//	Email host
define('email', 'hannah@sjinnovation.com'); 	//	Email
define('email_password', '');							//	Password
define('from_email', 'prajyot@sjinnovation.com');	//	From email
define('from_name', 'PHP Cart');				//	From name
define('to_email', 'hannah@sjinnovation.com');	//	To email
define('to_name', 'PHP Cart');                  //	To name

//URL Configuration
define('upload_folder', 'public_html/uploads/'); 	//	Upload folder path - saves all uploaded filed
define('css_folder', 'public_html/css/'); 			//	Styles sheet folder
define('javascript_folder', 'public_html/js/');		//	Javascript folder
define('image_folder', 'public_html/img/');			//	Images folder

//Other configurations
define('min_password_length', '6'); 				//	Minimum password length
define('max_password_length', '20'); 				//	Maximum password length
define('random_string_length', '10');				//	Random string length for generated ramdom password
define('max_image_upload_size', '320000000');		//	Size limit for uploading images
define('max_audio_upload_size', '40000000');		//	Size limit for uploading audio
define('max_video_upload_size', '320000000');		//	Size limit for uploading video
define('advance_search_items_per_page', '4');		//	items per page for advance search result AJAX pagination
