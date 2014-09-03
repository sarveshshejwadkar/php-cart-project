<?php
include "classes/users.php";
$Obj = new Users();

$t_data = array('email');
$emails = $Obj->customSelect($t_data, 'users', 'ASC');

foreach($emails as $email){
    if($_GET['email'] == $email['email']){
        echo "Email already exists!! Please try other email.";
    }
}

?>