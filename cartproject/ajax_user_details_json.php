<?php

include "classes/users.php";

$Obj = new Users();

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'gender', 'email', 'contact_no', 'mobile', 'fax_no');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
    
    
    $user['first_name'] = $user_data[0]['first_name'];
    $user['last_name'] = $user_data[0]['last_name'];
    $user['gender'] = $user_data[0]['gender'];
    $user['email'] = $user_data[0]['email'];
    $user['contact_no'] = $user_data[0]['contact_no'];
    $user['mobile'] = $user_data[0]['mobile'];
    $user['fax_no'] = $user_data[0]['fax_no'];
    
    echo json_encode($user);
}

?>