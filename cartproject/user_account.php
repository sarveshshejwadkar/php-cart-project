<?php
include "classes/users.php";
include "classes/category_pub.php";
include "classes/brand_pub.php";
include "classes/product_pub.php";
include "classes/content_page_pub.php";

$Obj = new Users();

$page = new ContentPagePub();

$Obj->addCss('style1.css');
$Obj->addCss('owl.carousel.css');
$Obj->addCss('owl.theme.css');


$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('script1.js');
$Obj->addJs('owl.carousel.js');
$Obj->addJs('user.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}else{
	header("Location: index.php");
}

$pages = $page->getAllContentPages();

include "resources/layout/header.php";
?>

<div class="main" style="height: 850px;">
    <?php include 'user_home_menu.php'; ?>

    <div id="profile">
        <div class="item">
            <div class="content">
            <h2>User details</h2>
            
            <form id="user_det" method="POST">
                <table>
                    <tr>
                        <td>Firstname :</td>
                        <td><input type="text" id="fname" name="fname" placeholder="First name" /></td>
                    </tr>
                    <tr>
                        <td>Lastname :</td>
                        <td><input type="text" id="lname" name="lname" placeholder="Last name" /></td>
                    </tr>
                    <tr>
                        <td>Gender :</td>
                        <td>
                            <select id="gender" name="gender"> 
                                <option value="">Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Contact number :</td>
                        <td><input type="number" id="contact_no" name="contact_no" placeholder="Contact number" /></td>
                    </tr>
                    <tr>
                        <td>Mobile :</td>
                        <td><input type="number" id="mobile" name="mobile" placeholder="Mobile" /></td>
                    </tr>
                    <tr>
                        <td>Fax :</td>
                        <td><input type="number" id="fax_no" name="fax_no" placeholder="Fax number" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" value="Update" id="submit" /></td>
                    </tr>
                </table>
                
                <span id="prof_result_error" class="error"></span>
                <span id="prof_result_safe" class="safe"></span>
            </form>
           
            
            </div>
            
        </div>
        
        <div class="item" id="address">
            <div class="content">
                <h3>Address</h3>
                
                <form id='user_det' method='POST'>
                    <table>
                        <tr>
                            <td>Street :</td>
                            <td><input type='text' id='street' name='street' placeholder='Street Address' /></td>
                        </tr>
                        <tr>
                            <td>Appartment No :</td>
                            <td><input type='text' id='appno' name='appno' placeholder='Appartment number' /></td>
                        </tr>
                        <tr>
                            <td>Zip :</td>
                            <td><input type='number' id='zip' name='zip' placeholder='Zipcode' /></td>
                        </tr>
                        <tr>
                            <td>Country :</td>
                            <td><input type='text' id='country' name='country' placeholder='Country' /></td>
                        </tr>
                        <tr>
                            <td>State :</td>
                            <td><input type='text' id='state' name='state' placeholder='State' /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type='button' value='Add' id='addressSubmit' /></td>
                        </tr>
                    </table>
                    
                    <span id="add_result_error" class="error"></span>
                    <span id="add_result_safe" class="safe"></span>
                 </form>
                  
                <input type="button" id="refresh" value="Refresh" />
                <div id="addresses"></div>
            </div>
        </div>
        
        <div class="item">
            <div class="content">
                <h2>Change password</h2>
                <form>
                    <table>
                        <!--
                        <tr>
                            <td>Old Password : </td>
                            <td><input type="text" name="oldpassword" id="oldpassword" /></td>
                            <span id="oldpassresult"></span>
                        </tr>
                        -->
                        <tr>
                            <td>New Password : </td>
                            <td><input type="password" name="newpassword" id="newpassword" placeholder="New Password" />
                                <span id="npassresult" class="error"></span>
                            </td>
                            
                        </tr> 
                        <tr>
                            <td>Confirm New Password : </td>
                            <td><input type="password" name="cnewpassword" id="cnewpassword" placeholder="Confirm Password" />
                                <span id="cnpassresult" class="error"></span>
                                <span id="cnpassresultsafe" class='safe'></span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" value="Update" id="changePassword" /></td>
                        </tr>                    
                    </table>
                    <span id="pass_result_error" class="error"></span>
                    <span id="pass_result_safe" class="safe"></span>
                </form>
            </div>
        </div>
    </div>
    

</div>

<?
include "resources/layout/user_base.php";
include "resources/layout/footer.php";
?>
<script>
$(document).ready(function(){
    
    $("#profile").owlCarousel({

      navigation : true,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true

      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false

      });
});
</script>