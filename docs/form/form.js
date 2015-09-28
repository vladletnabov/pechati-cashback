$(function(){
	$( "form.verify_values" ).submit(function( event ) {
	var name = $( this ).find( "input[name=name]" );
	var phone = $( this ).find( "input[name=phone]" );
	var email = $( this ).find( "input[name=email]" );
	var title = $( this ).find( "input[name=title]" ).val();
	var osnastka = $( this ).find( "input[name=osnastka]" );
	var total_sum = $( this ).find( "input[name=total_sum]" );
	var type = $( this ).find( "input[name=type]" );
	var messages = $( this ).find( "input[name=messages]" );
	
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
	 
	// dataString = {
	//   'name' : name.val(),
	//   'phone' : phone.val(),
	//   'osnastka' : osnastka.val(),
	//   'total_sum' : total_sum.val(),
	//   'type' : type.val(),
	//   'title' : title,
	//   'messages' : messages.val()
	// };
	

	makeOrder();
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

	function showProgress() {
		$(".loading").show();
	}
	function hideProgress() {
		$(".loading").hide();
	}

	function makeOrder() {
		console.log("Подождите, идет оправка...");
		var form;
		showProgress(); 
		if ($("#modOrder").css('visibility') == 'hidden') {
			form = document.forms["first-form"];
		}
		else {
			form = document.forms["modal-form"];
		}
		var formData = new FormData(form); 
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "/form/make_order.php");
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					hideProgress();
					data = JSON.parse(xhr.responseText);
					if(data.result) {
						window.location.replace("/thanks.php");
					} else {
						alert("Ошибка на сервере: "+data.err);
					}
				}
				else {
					hideProgress();
					alert("Произошла неизвестная ошибка");
				}
			}
		};
		xhr.send(formData);
	}
});

