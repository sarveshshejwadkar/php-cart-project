<?php
include "classes/users.php";

$Obj = new Users();    

if($Obj->isLoggedIn() == true){
    
    $addresses = $Obj->getUserAddress($_SESSION['user']['user_id']);
    

    foreach($addresses as $address){
        echo "<div class='address'>
                <p>Street :".$address['street_add']."</p>
                <p>Appartment No :".$address['apt_fl_suit_no']."</p>
                <p>Zip :".$address['zip']."</p>
                <p>Country :".$address['country']."</p>
                <p>State :".$address['state']."</p>
                <p><input type='button' value='Delete' id='delete' onclick='deleteAddress(".$address['id'].")' /></p>
              </div>";
    }

}

?>
