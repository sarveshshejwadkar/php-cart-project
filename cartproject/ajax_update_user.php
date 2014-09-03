<?php
include "classes/users.php";

$Obj = new Users();    

if($Obj->isLoggedIn() == true){
    if($_POST){
        if(count($_POST) == 6){
            $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'gender' => $_POST['gender'],
                'contact_no' => $_POST['contact_no'],
                'mobile' => $_POST['mobile'],
                'fax_no' => $_POST['fax_no']
            );
            
            $Obj->dbUpdate($data, $_SESSION['user']['user_id'], "users");
        }
        
        if(count($_POST) == 2){
            
            if($_POST['password'] == $_POST['cpassword']){
                $data = array(
                'password' => md5($_POST['cpassword'])
            );
            
            $Obj->dbUpdate($data, $_SESSION['user']['user_id'], "users");
            }
        }
        
        if(count($_POST) == 5){
            $data = array(
                'user_id' => $_SESSION['user']['user_id'],
                'street_add' => $_POST['street_add'],
                'apt_fl_suit_no' => $_POST['apt_fl_suit_no'],
                'zip' => $_POST['zip'],
                'country' => $_POST['country'],
                'state' => $_POST['state']
            );
            
            $Obj->dbInsert($data, "addresses");
        }
        
    }
    
    if($_GET){
        //Deleting adderess
        if($_GET['id']){
            $Obj->dbDelete($_GET['id'], "addresses");
        }
    }
}

?>