<?php
include "classes/users.php";
include "classes/category_pub.php";
include "classes/brand_pub.php";
include "classes/product_pub.php";
include "classes/content_page_pub.php";

$Obj = new Users();
$product = new ProductPub();
$category = new CategoryPub();
$brand = new BrandPub();
$page = new ContentPagePub();

$categories = $category->getAllCategories();
$brands = $brand->getAllBrands();
$pages = $page->getAllContentPages();

$Obj->addCss('style1.css');
$Obj->addJs('script1.js');
$Obj->addJs('jquery-2.1.1.js');
$Obj->addJs('index.js');

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

if($Obj->isLoggedIn() == true){
    $data = array('first_name', 'last_name', 'email');
    $user_data = $Obj->getUser('users', intval($_SESSION['user']['user_id']), $data);
}

if($_POST != null){
    if($_POST['form_type'] == "contact_form"){
        $Obj->contactForm($_POST);  
    }
}

include "resources/layout/header.php";
?>

<div class="main">
    <?php include 'user_home_menu.php'; ?>
    <?php include 'user_side_menu.php'; ?>
    
    
    <div class="right_home"> 
        <div class="content">                     
            <div  class="feedback">            
                <h3>Address</h3> 
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3847.3971661874!2d73.92984500000001!3d15.354962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfb7498ba53259%3A0x57b9308f2ff74c24!2sOnline+Productivity+Solutions+Pvt.+Ltd.!5e0!3m2!1sen!2sin!4v1408000732155" width="400" height="300" frameborder="0" style="border:0"></iframe>
                <br />
                <form action="http://maps.google.com/maps" method="get" target="_blank">
                <br />
                   <label for="saddr">Enter your location here</label><br />
                   <input type="text" style="width: 60%;" class="text-box" name="saddr" />
                   <input type="hidden" name="daddr" value="Online Productivity Solutions Pvt.Ltd Verna" />
                   <input type="submit" class="button" value="Get Directions" />
                </form>

            </div>
            
            <div  class="feedback" >
            <h3>Contact Us</h3> 
               
                <form name="contact_form" method="POST" action="" >     
                    <?php echo $Obj->getFlashData("error"); ?>
                    <input type="hidden" name="form_type" value="contact_form" required/>            
                    <table style="width: 90% ;">                            
                        <tr>
                            <td>
                                <input  type = "text" class="text-box" name="user_name"  placeholder="Your Name" value="<?php if($Obj->isLoggedIn() == true) echo $user_data[0]['first_name']." ".$user_data[0]['last_name'];?>"/><br /><br />
                                <input type="email" class="text-box" name="email" placeholder="Email" value="<?php if($Obj->isLoggedIn() == true) echo $user_data[0]['email'];?>" id="email" onkeyup="checkEmail(this.value)" onblur="checkEmail(this.value)" required  />
                                    <span id="email_checker_ajax" class="error"></span>
                                    <span id="email_checker" class="error"></span><br /><br />
                                <input type = "text" class="text-box" name="sub" value="" placeholder="Subject"/><br /><br />
                                <label>Your Suggestion/Feedback</label><br />
                                <textarea id="feedback" name="msg"  class="text-box" placeholder="Type your text here..."></textarea><br /><br />
                                <input type="submit" class="button" name="submit" id="send" value="Send Feedback"/><br />
                           </td>
                       </tr>
                    </table>
                </form>
            </div>    
       </div>     
    </div>
</div>



<!--
<script>
    function checkPass(val){
        var password = document.getElementById("pass").value;
        if(password != val){
            document.getElementById("passwordMatch").innerHTML = "<span class='error'>Password Mismatch!</span>";
        }else{
            document.getElementById("passwordMatch").innerHTML = "<span class='safe'>Password Match!</span>"
        }
    }
</script>
-->

<?
    include "resources/layout/user_base.php";
    include "resources/layout/footer.php";
?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53e1e286057b57d7"></script>