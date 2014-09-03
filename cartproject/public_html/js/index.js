$(document).ready(function(){
      
    $val = false;

    $("signup").submit(function(){
    if($val == false){
        alert("Invalid Inputs, Please try again.");
    }
    });

    $("#cpass").keyup(function(){
        var password_len = $("#pass").val().length;
        if((password_len < MIN_PASSWORD_LENGTH) || (password_len > MAX_PASSWORD_LENGTH)){
            $("#passwordMatch").html( "Please enter valid password in above Password field." ).show();
            $val = false;
        }else if($("#cpass").val() != $("#pass").val()){
            $("#passwordMatch").html( "Password Mismatch!" ).show();
            $("#passwordMatchTrue").hide();
            $val = false;
        }else{
            $("#passwordMatch").html( "" ).hide();
            $("#passwordMatchTrue").show();
            $val = true;
        }
    });

    $("#pass").keyup(function(){
        var password_len = $("#pass").val().length;
        if((password_len < MIN_PASSWORD_LENGTH) || (password_len > MAX_PASSWORD_LENGTH)){
            $("#passwordLength").html( "Password length between "+MIN_PASSWORD_LENGTH+"-"+MAX_PASSWORD_LENGTH+" characters!." ).show();
            $val = false;
        }else{
            $("#passwordLength").html( "" ).show();
            $val = true;
        }
    });


    $("#fname").blur(function(){
        if($("#fname").val().length < ONE){
            $("#fnameCheck").html( "Firstname is required!." ).show();
            $val = false;
        }else{
            $("#fnameCheck").html( "" ).show();
        }
    });

    $("#email").blur(function(){
        if($("#email").val().length < ONE){
            $("#email_checker").html( "Email is required!." ).show();
            $val = false;
        }else{
            if(IsEmail($("#email").val()) == true){

                $.ajax({url:"ajax_get_email.php?email="+$("#email").val(),success:function(result){
                    $("#email_checker_ajax").html(result);
                }});

                $("#email_checker").html( "" ).show();
            }else{
                $("#email_checker").html( "Enter valid email." ).show();
                $("#email_checker_ajax").html("").show();
                $val = false;
            }
            
        }
    });

    $("#lname").blur(function(){
        if($("#lname").val().length < ONE){
            $("#lnameCheck").html( "Lastname is required!." ).show();
            $val = false;
        }else{
            $("#lnameCheck").html( "" ).show();
        }
    });

    $("#captcha-form").blur(function(){
        if($("#captcha-form").val().length < ONE){
            $("#captchaError").html( "CAPTCHA is required!." ).show();
            $val = false;
        }else{
            $("#captchaError").html( "" ).show();
            $val = true;
        }
    });

    $("#semail").blur(function(){
        if($("#semail").val().length < ONE){
            $("#siemail").html( "Email is required!." ).show();
            $val = false;
        }else{
            if(IsEmail($("#semail").val()) == true){
                $("#siemail").html( "" ).show();
            }else{
                $("#siemail").html( "Invalid Email." ).show();
                $val = false;
            }
        }
    });

    $("#spass").blur(function(){
        if($("#spass").val().length < ONE){
            $("#sipass").html( "Password is required!." ).show();
            $val = false;
        }else{
            $("#sipass").html( "" ).show();
            $val = true;
        }
    });
      
    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }

    };
	$("input[name='feature']").change(function(){
		featured=NULL;
		if($(this).is(':checked')){
			featured=ONE;
		} 
		
		$.ajax({
			url: 'ajax_update_feature.php',
			type: "POST",
			data: ({featured: featured,pid: this.value})
			
		});   
	});
    
	$("input[name='featureImg']").change(function(){
			
		$.ajax({
			url: 'ajax_featured_image.php',
			type: "POST",
			data: ({arr: this.value})
	
		});   
	});
    
	$("#cat").change(function(){		 
		 
		$.ajax({
			url: 'ajax_load_subcat.php',
			type: "POST",
			data: ({cat: this.value}),
			success:function(result){
						$("#subCategory").html(result);
					}                
		});
	});
	
	
});
	
