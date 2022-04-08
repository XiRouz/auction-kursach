$('document').ready(function(){
	//регистрация
	$('#ConfirmRegistration').click(function(){
		var formData = $("#formRegistration").serialize();
	    $.ajax({
	        type: "POST",
	        url: "_registration.php",
	        data: formData,
	        success: function(data) {
	            var error = jQuery.parseJSON(data);

	            //вывод ошибки логина
	            if(error.login != '' && error.loginOk == false){
					$('#infoLogin').html(error.login).css({'display':'list-item'});
	            }else{
	            	$('#infoLogin').css({'display':'none'});
	            }

	            //вывод ошибки пароля
	            if(error.password != '' && error.passwordOk == false){
					$('#infoPassword').html(error.password).css({'display':'list-item'});
	            }else{
	            	$('#infoPassword').css({'display':'none'});
	            }

	            //вывод ошибки повторения пароля
	            if(error.repeatPassword != '' && error.repeatPasswordOk == false){
					$('#infoRepeatPassword').html(error.repeatPassword).css({'display':'list-item'});
	            }else{
	            	$('#infoRepeatPassword').css({'display':'none'});
	            }

	            //вывод ошибки почты
	            if(error.login != '' && error.emailOk == false){
					$('#infoEmail').html(error.email).css({'display':'list-item'});
	            }else{
	            	$('#infoEmail').css({'display':'none'});
	            }

	            //вывод ошибки соглашения с правилами
	            if(error.checkbox != '' && error.checkboxOk == false){
					$('#infoCheck').html(error.checkbox).css({'display':'list-item'});
	            }else{
	            	$('#infoCheck').css({'display':'none'});
	            }

	            if(error.confirmRegistration){
	            	$('#regInfo').html('Вы успешно зарегистрировались').css({'color':'green', 'font-size':'20px', 'background-color':'white'});
	            	$('#inputLogin').val('');
	            	$('#inputPassword').val('');
	            	$('#inputRepeatPassword').val('');
	            	$('#inputEmail').val('');
	            	$("#rulesAgree").prop('checked',false);
	            	setTimeout(function(){
						$("#closeModal").click()
					}, 5000);
	            }
	        }
	    });
	});

	$('#authorization').click(function(){
		var formData = $("#formAuthorization").serialize();
	    $.ajax({
	        type: "POST",
	        url: "_authorization.php",
	        data: formData,
	        success: function(data) {
	            //вывод ошибок
	            if(data != ''){
					$('#loginInfo').html(data).css({'display':'block'});
	            }else{
	            	$('#loginInfo').css({'display':'none'});
	            }
	        }
	    });
	});

	$(".category-ul").hide();

	$(".category-head").click(function(){
		var ch = $(this);
		ch.next().slideToggle();
		if(ch.find(".triangleRotate").hasClass("triangleClose")){
			ch.find(".triangleRotate").removeClass("triangleClose").addClass("triangleOpen");
		}else{
			ch.find(".triangleRotate").removeClass("triangleOpen").addClass("triangleClose");
		}
	});	

	var result=$('#rulesAgree').prop('checked');

	function checkboxValidate(){
		if($('#rulesAgree').prop('checked')){
			$('#registration').prop('disabled', false);
		}else{
			$('#registration').prop('disabled', true);
		};
	};

	$('#rulesAgree').click(function(){
		checkboxValidate();
	});	
});