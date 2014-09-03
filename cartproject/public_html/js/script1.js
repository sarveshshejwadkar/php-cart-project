function getSubCategory(id)
{
    if (id=="") {
        document.getElementById("subcat").innerHTML="";
        return;
    } 
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        document.getElementById("subcat").innerHTML=xmlhttp.responseText;
    }
    }
    xmlhttp.open("GET","ajax_subcategory.php?catid="+id,true);
    xmlhttp.send();
};

$(document).ready(function(){
	
    $("#user_options").hide();
    
    $("#user").click(function(){
        $("#user_options").toggle("slow");
    });
    
    $("#cat").change(function(){		 
		 
    	$.ajax({url:"ajax_load_subcat_pub.php?cat_id="+$("#cat").val(),success:function(result){
            $("#sub-category").html(result);
        }});
	});
});