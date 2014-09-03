$(document).ready(function(){
    var http_request = new XMLHttpRequest();

    http_request.onreadystatechange = function(){
      if (http_request.readyState == 4  )
      {
        var jsonObj = JSON.parse(http_request.responseText);
        document.getElementById("fname").value =  jsonObj.first_name;
        document.getElementById("lname").value = jsonObj.last_name;
        document.getElementById("contact_no").value = jsonObj.contact_no;
        document.getElementById("mobile").value = jsonObj.mobile;
        document.getElementById("fax_no").value = jsonObj.fax_no;
      }
    }
    http_request.open("GET", "ajax_user_details_json.php", true);
    http_request.send();
    
    //Function to check for password length
    $("#newpassword").blur(function(){
       
    	var pass_length = $("#newpassword").val().length;
        if(pass_length < ONE){
            $("#npassresult").html( "Password is required!." ).show();
        }else if((pass_length < MIN_PASSWORD_LENGTH)||(pass_length > MAX_PASSWORD_LENGTH)){
            $("#npassresult").html( "Password length between "+MIN_PASSWORD_LENGTH+"-"+MAX_PASSWORD_LENGTH+" characters!." ).show();
        }
    });
    
     $("#newpassword").keyup(function(){
       
    	var pass_length = $("#newpassword").val().length;
        if((pass_length < MIN_PASSWORD_LENGTH)||(pass_length > MAX_PASSWORD_LENGTH)){
            $("#npassresult").html( "Password length between "+MIN_PASSWORD_LENGTH+"-"+MAX_PASSWORD_LENGTH+" characters!." ).show();
        }else{
            $("#npassresult").html( "" ).show();
        }
    });
    
    $("#cnewpassword").keyup(function(){
    	
    	var pass_length = $("#cnewpassword").val().length;
        if($("#newpassword").val() == $("#cnewpassword").val()){
            if((pass_length < MIN_PASSWORD_LENGTH)||(pass_length > MAX_PASSWORD_LENGTH)){
                $("#cnpassresult").html( "Password length between "+MIN_PASSWORD_LENGTH+"-"+MAX_PASSWORD_LENGTH+" characters!." ).show();
                $("#cnpassresultsafe").hide();
            }else{
            	$("#cnpassresult").hide();
                $("#cnpassresultsafe").html( "Match!." ).show();
            }
        }else{
            $("#cnpassresult").html( "Password Mismatch!." ).show();
            $("#cnpassresultsafe").hide();
        }
    });
    
    //Ajax call to fill in the Addresses of the user
    $.ajax({url:"ajax_user_address.php", success:function(result){
        $("#addresses").html(result);
    }});
    
    //Function to load user addresses on click of button
    $("#address").click(function(){
        
    	$.ajax({url:"ajax_user_address.php", success:function(result){
            $("#addresses").html(result);
        }});
    });
    
    //Function to load user addresses on click of button
    $("#refresh").click(function(){
        
    	$.ajax({url:"ajax_user_address.php", success:function(result){
            $("#addresses").html(result);
        }});
    });
    
    //Function to load user addresses on click of button
    $("#addressSubmit").click(function(){
        
    	$.ajax({url:"ajax_user_address.php", success:function(result){
            $("#addresses").html(result);
        }});
    });

});


$(function() {
	//Function to submit user information using ajax
    $("#submit").click(function() {
        
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var gender = $("#gender").val();
        var contact_no = $("#contact_no").val();
        var mobile = $("#mobile").val();
        var fax_no = $("#fax_no").val();
        
        var dataString = 'first_name='+ fname + '&last_name=' + lname + '&contact_no=' + contact_no + '&gender=' + gender + '&mobile=' + mobile + '&fax_no=' + fax_no;
        
        if(fname=='' || lname=='' || contact_no=='')
        {
            $("#prof_result_error").html( "Error!! Please check input." ).fadeIn(200).show();
            $("#prof_result_safe").hide();
        }
        else
        {
            $.ajax({
            type: "POST",
            url: "ajax_update_user.php",
            data: dataString,
            success: function(){
                $("#prof_result_safe").html( "Profile updated." ).fadeIn(200).show();
                $("#prof_result_error").hide();
            }
            });
        }
        return false;
    });
    
    //Function to change password using ajax
    $("#changePassword").click(function() {
        
        var newpassword = $("#newpassword").val();
        var cnewpassword = $("#cnewpassword").val();
        
        var dataString = 'password='+ newpassword + '&cpassword=' + cnewpassword;
        
        if(newpassword == '' || cnewpassword == '' || newpassword != cnewpassword)
        {
            $("#pass_result_error").html( "Error!! Please check input." ).fadeIn(200).show();
            $("#pass_result_safe").hide();
        }
        else
        {
            $.ajax({
            type: "POST",
            url: "ajax_update_user.php",
            data: dataString,
            success: function(){
                $("#pass_result_safe").html( "Password Changed." ).fadeIn(200).show();
                $("#pass_result_error").hide();
            }
            });
        }
        return false;
    });
    
    //Function to insert address, uses ajax 
    $("#addressSubmit").click(function() {
        
        var street = $("#street").val();
        var appno = $("#appno").val();
        var zip = $("#zip").val();
        var country = $("#country").val();
        var state = $("#state").val();
        
        var dataString = 'street_add='+ street + '&apt_fl_suit_no=' + appno + '&zip=' + zip + '&country=' + country + '&state=' + state;
        
        if(street=='' || appno=='' || zip=='' || country=='' || state=='')
        {
            $("#add_result_error").html( "Error!! Please check the input." ).fadeIn(200).show();
            $("#add_result_safe").hide();
        }
        else
        {
            $.ajax({
            type: "POST",
            url: "ajax_update_user.php",
            data: dataString,
            success: function(){
                $("#add_result_safe").html( "Address added." ).fadeIn(200).show();
                $("#add_result_error").hide();
            }
            });
        }
        return false;
    });
    
});

//Function to delete address
function deleteAddress(id){
        
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET", "ajax_update_user.php?id="+id, true);
    xmlhttp.send();
    $("#add_result_safe").html( "Address deleted." ).fadeIn(200).show();
    $("#add_result_error").hide();
}
