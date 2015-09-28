$(function(){
	$( "form#verify_values_2" ).submit(function( event ) {
	var name = $( this ).find( "input[name=name]" );
	var phone = $( this ).find( "input[name=phone]" );
	var email = $( this ).find( "input[name=email]" );
	var title = $( this ).find( "input[name=title]" ).val();
	
	if (name.val() == "") {
		name.css({border:"1px solid red", backgroundColor: "rgb(255, 236, 236)"});
		name.focus();
		return false;
	}else{
		name.css({border:"1px solid green", backgroundColor: "#fff"});
	}
	 
	if ( !validatePhone(phone.val())){
		phone.css({border:"1px solid red", backgroundColor: "rgb(255, 236, 236)"});
		phone.focus();
		return false;
	}else{
		phone.css({border:"1px solid green", backgroundColor: "#fff"});
	}

	// if (email.val() == "") {
	// 	email.css({border:"1px solid red", backgroundColor: "rgb(255, 236, 236)"});
	// 	email.focus();
	// 	return false;
	// }else{
	// 	email.css({border:"1px solid green", backgroundColor: "#fff"});
	// }


	 
	dataString = {
	  'name' : name.val(),
	  'phone' : phone.val(),
	  'email' : email.val(),
	  'title' : title,
	};
	 
	$.ajax({
		type: "POST",
		url: "/form/form-other/mail.php",
		data: dataString,
		success: function() {
			window.location.replace("/thanks.php");
		}
	});
		return false;
		event.preventDefault();
	});
	
	function validatePhone(phone){
		var phoneReg = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
		if(!phoneReg.test(phone)){
			return false;
		}else{
			return true;
		}
	}
});